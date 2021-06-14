<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User as Obj;
use App\Models\Core\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{
     /**
     * Define the app and module object variables and component name 
     *
     */
    public function __construct(){
        // load the app, module and component name to object params
        $this->app      =   'Core';
        $this->module   =   'User';
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
        // load alerts if any
        $alert = session()->get('alert');

        // authorize the app
        $this->authorize('viewAny', $obj);
        //load user for personal listing
        $user = Auth::user();
        // retrive the listing
        //$objs = $obj->getRecords($item,30,$user);

        $objs = $obj->where('agency_id', request()->get('agency.id'))->where('client_id', request()->get('client.id'))->orderBy("name", "asc")->get();

        return view('apps.'.$this->app.'.'.$this->module.'.index')
                ->with('app',$this)
                ->with('alert',$alert)
                ->with('objs',$objs);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Obj $obj)
    {   
        //$this->module = 'User';
    	// list of clients
    	if(\Auth::user()->checkRole(['superadmin']))
        	$clients = Client::all();
        else
        	$clients = Client::where('id',request()->get('client.id'))->get();
            
        return view('apps.'.$this->app.'.'.$this->module.'.createedit')
                ->with('stub','create')
                ->with('obj',$obj)
                ->with('clients',$clients)
                ->with('editor',true)
                ->with('app',$this)
                ->with('form', $form);
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
            
        	$phone = $request->phone? $request->phone : '8989898989';

        	$request->merge(['password'=>Hash::make($phone)])->merge(['client_id'=>$request->client_id]);
            
            /* create a new entry */
            $obj = $obj->create($request->all());
            $alert = 'A new ('.$this->app.'/'.$this->module.') item is created!';
            return redirect()->route($this->module.'.index')->with('alert',$alert);
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // load the resource
        $obj = Obj::where('id',$id)->first();

        // load alerts if any
        $alert = session()->get('alert');
        // authorize the app
        $this->authorize('view', $obj);

        if($obj)
            return view('apps.'.$this->app.'.'.$this->module.'.show')
                    ->with('obj',$obj)->with('app',$this)->with('alert',$alert);
        else
            abort(404);
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
        // authorize the app
        $this->authorize('view', $obj);
        
        // list of clients
    	if(\Auth::user()->checkRole(['superadmin']))
        	$clients = Client::all();
        else
        	$clients = Client::where('id',request()->get('client.id'))->get();

        //load client id
        $client_id = request()->get('client.id');

        //load the form elements if its defined in the settings i.e. stored in aws
        $form = null;
        if(Storage::disk('s3')->exists('settings/user/'.$client_id.'.json' )){
            //open the client specific settings
            $data = json_decode(json_decode(Storage::disk('s3')->get('settings/user/'.$client_id.'.json' ),true));
            if(isset($data->form))
                $form = $obj->processForm($data->form);
        }
        else
            $data = '';
        
        $form_data = null;
        if(!empty($obj->json)){
            $form_data = json_decode($obj->json, true);
        }

        // ddd($form_data);

        if($obj)
            return view('apps.'.$this->app.'.'.$this->module.'.createedit')
                ->with('stub','update')
                ->with('obj',$obj)
                ->with('clients',$clients)
                ->with('editor',true)
                ->with('app',$this)
                ->with('form', $form)
                ->with('form_data', $form_data);
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

            // save all the extra form fields into message
            $data = '';
            $json = [];
            foreach($request->all() as $k=>$v){
                if (strpos($k, 'settings_') !== false){
                    //check for files and upload to aws
                    if($request->hasFile($k)){
                        $pieces = explode('settings_',$k);
                        $file =  $request->all()[$k];
                        //upload
                        $file_data = $obj->uploadFile($file);
                        //link the file url
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
                    
                }
            }
            // store the concatinated form fileds into message
            $request->merge(['data' => $data]);
            // store the form fileds data in json, inorder to used in excel download
            $request->merge(['json' => json_encode($json)]);

            // ddd($request->all());

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
        $this->authorize('update', $obj);
        // delete the resource
        $obj->delete();

        // flash message and redirect to controller index page
        $alert = '('.$this->app.'/'.$this->module.'/'.$id.') item  Successfully deleted!';
        return redirect()->route($this->module.'.index')->with('alert',$alert);
    }

    public function profile_edit($id){
        // load the resource
        $obj = Obj::where('id',$id)->first();
    
        if($obj)
            return view('apps.'.$this->app.'.'.$this->module.'.profile_edit')
                    ->with('obj',$obj)
                    ->with('editor',true)
                    ->with('app',$this);
        else
            abort(404);
    }

    public function profile_update($id , Request $request){
        
        // load the resource
        $obj = Obj::where('id',$id)->first();
    
        //update the resource
        $obj->update($request->all()); 
        
        // flash message and redirect to controller index page
        $alert = 'A new ('.$this->app.'/'.$this->module.'/'.$id.') item is updated!';
        return redirect()->route('profile.show',$id)->with('alert',$alert);
    }

    public function profile_show(Request $request,$id){

        // load the resource
        $record = Obj::where('id',$id)->first();
        
        $this->module = 'User';
        return view("apps.Core.User.general")->with('app',$this)->with('record',$record);
    }

    public function public_show($id){

       // load the resource
       $obj = Obj::where('id',$id)->first();

       // load alerts if any
       $alert = session()->get('alert');
       // authorize the app
       $this->authorize('viewAny', $obj);

       if($obj)
           return view('apps.'.$this->app.'.'.$this->module.'.show')
                   ->with('obj',$obj)->with('app',$this)->with('alert',$alert);
       else
           abort(404);
    }

    public function search(Obj $obj, Request $request){

        // load alerts if any
        $alert = session()->get('alert');

        // Get the search query
        if($request->input("item"))
        {
            $query = $request->input("item");

            
            //$r = $obj->where('agency_id', request()->get('agency.id'))->where('client_id', request()->get('client.id'));
            //$name = $r->where("name", "LIKE", "%".$query."%")->get("id")->pluck("id")->toArray();
            //$em =$r->where("email", "LIKE", "%".$query."%")->get("id")->pluck("id")->toArray();
            //$phone =$r->where("phone", "LIKE", "%".$query."%")->get("id")->pluck("id")->toArray();
            //ddd($em);

            $name = $obj->where('agency_id', request()->get('agency.id'))->where('client_id', request()->get('client.id'))->where("name", "LIKE", "%".$query."%")->get("id")->pluck("id")->toArray();
            $email =$obj->where('agency_id', request()->get('agency.id'))->where('client_id', request()->get('client.id'))->where("email", "LIKE", "%".$query."%")->get("id")->pluck("id")->toArray();
            $phone =$obj->where('agency_id', request()->get('agency.id'))->where('client_id', request()->get('client.id'))->where("phone", "LIKE", "%".$query."%")->get("id")->pluck("id")->toArray();
            $records = array_unique(array_merge($name,$email, $phone), SORT_REGULAR);
            // Retrieve posts which match the given title query
            $objs = $obj->whereIn("id", $records)->get();
        }
        else
        {
            $grp = $request->input("group");
            $sgrp = $request->input("subgroup");
            $Group = $obj->where('agency_id', request()->get('agency.id'))->where('client_id', request()->get('client.id'))->where("group", "LIKE", "%".$grp."%")->get("id")->pluck("id")->toArray();
            $Subgroup =$obj->where('agency_id', request()->get('agency.id'))->where('client_id', request()->get('client.id'))->where("subgroup", "LIKE", "%".$sgrp."%")->get("id")->pluck("id")->toArray();
            
            $records = array_unique(array_intersect($Group,$Subgroup), SORT_REGULAR);
            //ddd($records);
            // Retrieve posts which match the given title query
            $objs = $obj->whereIn("id", $records)->get();

        }
        return view('apps.'.$this->app.'.'.$this->module.'.index')
                ->with('app',$this)
                ->with('alert',$alert)
                ->with('objs',$objs);
    }

    public function resetpassword(Obj $obj, Request $request ,$id){

        // load the resource
        $objs = $obj->where('id',$id)->first();

        // authorize the app
        $this->authorize('update', $obj);

        $phone = $objs->phone? $objs->phone : '8989898989';
        
        //Hashing the phone number
        $objs->password = Hash::make($phone);
       
        
        // flash message and redirect to controller index page
        $alert = ' ('.$this->app.'/'.$this->module.'/'.$id.') Password  is updated!';
        return redirect()->route($this->module.'.show',$id)->with('alert',$alert);
        
    }

    /**
     * Show the settings files & store the data into the file
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
            // ddd($data);
            Storage::disk('s3')->put('settings/user/'.$client_id.'.json' ,json_encode($data,JSON_PRETTY_PRINT),'public');
            $alert = 'Successfully saved the settings file';

        }else{
            //load the settings
            if(Storage::disk('s3')->exists('settings/user/'.$client_id.'.json' ))
            $data = json_decode(Storage::disk('s3')->get('settings/user/'.$client_id.'.json' ));
            else
                $data = '';
        }

        if($client_id)
            return view('apps.'.$this->app.'.'.$this->module.'.settings')
                ->with('stub','update')
                ->with('data',$data)
                ->with('alert',$alert)
                ->with('editor',true)
                ->with('app',$this);
        else
            abort(404);
    }

    public function download(Obj $obj){

        // Retrieve all the records
        $objs = $obj->where('agency_id', request()->get('agency.id'))->where('client_id', request()->get('client.id'))->get('json');

        // Initialize empty arrays
        $columns = [];
        $content = [];
        $data = [];

        // Get all the unique columns and content from the json data 
        foreach($objs as $obj){
            if(!empty($obj->json)){
                $columns = array_unique(array_merge($columns, array_keys(json_decode($obj->json, true))));
                $data = array_merge($content, array_values(json_decode($obj->json, true)));
                array_push($content, $data);
            }
        }
        
        // Call helper function for creating and downloading csv
        return getCsv($columns, $content, 'data_'.request()->get('client.name').'_'.strtotime("now").'_form_data.csv');
    }

}
