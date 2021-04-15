<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Core\Contact as Obj;
use App\Models\Core\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use DateTime;

use App\Exports\ContactsExport;
use Maatwebsite\Excel\Facades\Excel;

class ContactController extends Controller
{
     /**
     * Define the app and module object variables and component name 
     *
     */
    public function __construct(){
        // load the app, module and component name to object params
        $this->app      =   'Core';
        $this->module   =   'Contact';
        $this->componentName = componentName('agency');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Obj $obj,Request $request)
    {

        // check for search string
        $item = $request->item;
        //get the status filter
        $status = $request->status;
        // load alerts if any
        $alert = session()->get('alert');
        //client id
        $client_id = request()->get('client.id');


        // authorize the app
        $this->authorize('viewAny', $obj);
        //load user for personal listing
        $user = Auth::user();
        //remove html data in request params (as its clashing with pagination)
        $request->request->remove('app.theme.prefix');
        $request->request->remove('app.theme.suffix');
        // retrive the listing
        $objs = $obj->getRecords($item,30,$user,$status);
        //get data metrics
        if(!request()->get('export'))
            $data = $obj->getData($item,30,$user,$status);
        else
            return $obj->getData($item,30,$user,$status);
        

        

        //get the users of the client
        $users = Auth::user()->where('client_id',$client_id)->get();

        return view('apps.'.$this->app.'.'.$this->module.'.index')
                ->with('app',$this)
                ->with('alert',$alert)
                ->with('users',$users)
                ->with('data',$data)
                ->with('obj',$obj)
                ->with('objs',$objs);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Obj $obj)
    {
        // load alerts if any
        $alert = session()->get('alert');
        // change the componentname from admin to client 
        $this->componentName = componentName('client');

        //load client id
        $client_id = request()->get('client.id');

        //load the form elements if its defined in the settings
        $form = null;
        $prefix = null;
        $suffix = null;
        if(Storage::disk('s3')->exists('settings/contact/'.$client_id.'.json' )){
            $data = json_decode(json_decode(Storage::disk('s3')->get('settings/contact/'.$client_id.'.json' ),true));

            if(request()->get('category')){
                $category = request()->get('category');
                $prefix_name = request()->get('category').'_prefix';
                if(isset($data->$prefix_name))
                    $prefix = $data->$prefix_name;
                $suffix_name = request()->get('category').'_suffix';
                if(isset($data->$suffix_name))
                    $suffix= $data->$suffix_name;
            }
            else
                $category = 'contact';
            $field_name = $category.'_form';

            if(isset($data->$field_name)){
                $form = $obj->processForm($data->$field_name);

            }
            else if($field_name=='contact_form'){

            }
            else{
                abort('404','No form');
            }
        }
        else
            $data = '';
        

        //dd($form);

        return view('apps.'.$this->app.'.'.$this->module.'.createedit')
                ->with('stub','Create')
                ->with('obj',$obj)
                ->with('form',$form)
                ->with('alert',$alert)
                ->with('settings',$data)
                ->with('prefix',$prefix)
                ->with('suffix',$suffix)
                ->with('editor',true)
                ->with('app',$this);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Obj $obj,Request $request)
    {
        try{

            /* check for closest duplicates */
            $email = $request->get('email');

            // allow duplicate only if the previous one is atleast 10 min old
            $date = new DateTime();
            $date->modify('-10 minutes');
            $formatted_date = $date->format('Y-m-d H:i:s');
            $entry = $obj->where('email',$email)->where('created_at','>=',$formatted_date)->first();
            if($entry){
                $alert = 'Your message has been saved recently.';
                if(request()->get('api')){
                    echo $alert;
                    dd();
                }
                return redirect()->back()->with('alert',$alert);
            }
            
            /* create a new entry */
            $data = '';
            $json = [];
            if(!$request->get('message')){
                // save all the extra form fields into message
                foreach($request->all() as $k=>$v){
                    if (strpos($k, 'settings_') !== false){
                        //check for files
                        if($request->hasFile($k)){
                            $pieces = explode('settings_',$k);
                            $file =  $request->all()[$k];
                            $file_data = $obj->uploadFile($file);
                            $data = $data.$pieces[1].' : <a href="'.$file_data[0].'">'.$file_data[1].'</a><br>'; 
                            $json[$pieces[1]] = '<a href="'.$file_data[0].'">'.$file_data[1].'</a>';
                        }else{
                           $pieces = explode('settings_',$k);
                            if(is_array($v)){
                                $v = implode(',',$v);
                            }
                            $data = $data.$pieces[1].' : '.$v.'<br>'; 
                            $json[$pieces[1]] = $v;
                        }
                        
                        //$data[$pieces[1]] = $v;
                    }
                }
                $request->merge(['message' => $data]);
                $request->merge(['json' => json_encode($json)]);
            }

            //validate emails
            $valid_email = $obj->debounce_valid_email($request->get('email'));
            $request->merge(['valid_email' => $valid_email]);

            // store the data
            $obj = $obj->create($request->all());

            //update alert and return back
            $alert = 'Thank you! Your message has been posted to the Admin team. We will reach out to you soon.';

            // if the call is api, return the url
            if(request()->get('api')){
                echo $alert;
                dd();
            }

            return redirect()->back()->with('alert',$alert);
        }
        catch (QueryException $e){
            // if there is any error return with error message
           $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                $alert = 'Some error in updating the record';
                return redirect()->back()->withInput()->with('alert',$alert);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // load the resource
        $obj = Obj::where('id',$id)->first();

        // load related resources
        $objs = Obj::where('email',$obj->email)->where('id','!=',$obj->id)->get();
        // load alerts if any
        $alert = session()->get('alert');
        // authorize the app
        $this->authorize('view', $obj);

        if($obj)
            return view('apps.'.$this->app.'.'.$this->module.'.show')
                    ->with('obj',$obj)->with('objs',$objs)->with('app',$this)->with('alert',$alert);
        else
            abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function settings()
    {
        // load client id
        $client_id = request()->get('client.id');
         // load alerts if any
        $alert = session()->get('alert');

        $data = null;
        if(request()->get('store')){
            //save the settings files in aws
            $data = str_replace(array("\n", "\r"), '', request()->get('settings'));
            Storage::disk('s3')->put('settings/contact/'.$client_id.'.json' ,json_encode($data,JSON_PRETTY_PRINT),'public');
            $alert = 'Successfully saved the settings file';

        }else{
            //load the settings
            if(Storage::disk('s3')->exists('settings/contact/'.$client_id.'.json' ))
            $data = json_decode(Storage::disk('s3')->get('settings/contact/'.$client_id.'.json' ));
            else
                $data = '';
        }

        if($client_id)
            return view('apps.'.$this->app.'.'.$this->module.'.settings')
                ->with('stub','Update')
                ->with('data',$data)
                ->with('alert',$alert)
                ->with('editor',true)
                ->with('app',$this);
        else
            abort(404);
    }


    /**
     * Show the form for sharing api the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function api()
    {
        //get client id
        $client_id = request()->get('client.id');

        $data['token'] = csrf_token();

        echo json_encode($data);
        dd();

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // load the resource
        $obj = Obj::where('id',$id)->first();
        // load alerts if any
        $alert = session()->get('alert');
        // authorize the app
        $this->authorize('view', $obj);


        
        if($obj)
            return view('apps.'.$this->app.'.'.$this->module.'.createedit')
                ->with('stub','Update')
                ->with('obj',$obj)
                ->with('alert',$alert)
                ->with('editor',true)
                ->with('app',$this);
        else
            abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            
            // load the resource
            $obj = Obj::where('id',$id)->first();
            // authorize the app
            $this->authorize('update', $obj);

            //update tags
            if($request->get('tags')){
                $tags = implode(',', $request->get('tags'));
                $request->merge(['tags' => $tags]);
            }
            //update the resource
            $obj->update($request->all()); 

            // flash message and redirect to controller index page
            $alert = 'A new ('.$this->app.'/'.$this->module.'/'.$id.') item is updated!';
            return redirect()->route($this->module.'.show',$id)->with('alert',$alert);
        }
        catch (QueryException $e){
           $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                 $alert = 'Some error in updating the record';
                 return redirect()->back()->withInput()->with('alert',$alert);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // load the resource
        $obj = Obj::where('id',$id)->first();
        // authorize
        $this->authorize('delete', $obj);
        // delete the resource
        $obj->delete();

        // flash message and redirect to controller index page
        $alert = '('.$this->app.'/'.$this->module.'/'.$id.') item  Successfully deleted!';
        return redirect()->route($this->module.'.index')->with('alert',$alert);
    }
}
