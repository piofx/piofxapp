<?php

namespace App\Http\Controllers\Core;
use App\Models\Mailer\MailTemplate;
use App\Models\Mailer\MailLog;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Jobs\NotifyAdmin;
use App\Models\Core\Contact as Obj;
use App\Models\Core\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use DateTime;
use Carbon\Carbon;
use App\Exports\ContactsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

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
        //get data metrics or export data
        if(!request()->get('export'))
            $data = $obj->getData($item,30,$user,$status);
        else
            return $obj->getData($item,30,$user,$status);
        
        //url_suffix - to ensure filter are applied to the data processed 
        $url_suffix = $obj->urlSuffix();

        //get the users of the client
        $users = Auth::user()->where('client_id',$client_id)->get();

        return view('apps.'.$this->app.'.'.$this->module.'.index')
                ->with('app',$this)
                ->with('alert',$alert)
                ->with('users',$users)
                ->with('data',$data)
                ->with('url_suffix',$url_suffix)
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



        //load the form elements if its defined in the settings i.e. stored in aws
        $form = $prefix = $suffix = null;
        if(Storage::disk('s3')->exists('settings/contact/'.$client_id.'.json' )){
            //open the client specific settings
            $data = json_decode(Storage::disk('s3')->get('settings/contact/'.$client_id.'.json' ),true);

            //get form fields based on category
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


            $data = json_decode(json_encode($data));

            if(isset($data->$field_name))
                $form = $obj->processForm($data->$field_name);
            // elseif(isset($data[$field_name]))
            //     $form = $obj->processForm($data[$field_name]);
            else if($field_name=='contact_form'){

            }
            else{
                abort('404','No form');
            }
        }
        else
            $data = '';
        

       

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

            //if request is for otp
            if($request->get('otp')){
                echo $this->otp();
                dd();
            }
            
            /* create a new entry */
            $data = '';
            $json = [];
            if(!$request->get('message')){
                // save all the extra form fields into message
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
                $request->merge(['message' => $data]);
                // store the form fileds data in json, inorder to used in excel download
                $request->merge(['json' => json_encode($json)]);
            }

            //validate emails
            $valid_email = $obj->debounce_valid_email($request->get('email'));
            $request->merge(['valid_email' => $valid_email]);

            //update client id and agency id
            if(!$request->get('client_id')){
                $request->merge(['client_id' => request()->get('client.id')]);
                $request->merge(['agency_id' => request()->get('agency.id')]);
            }
            // store the data
            $obj = $obj->create($request->all());

            //update alert and return back
            $alert = 'Thank you! Your message has been posted to the Admin team. We will reach out to you soon.';

            
            
            $client_id = request()->get('client.id');
            if(Storage::disk('s3')->exists('settings/contact/'.$client_id.'.json' ))
            {   
                //Fletching the template 
                $template = MailTemplate::where('name','contacts_update')->first();
                //open the client specific settings
                $data = json_decode(Storage::disk('s3')->get('settings/contact/'.$client_id.'.json' ));
                //$data = json_decode($data);
                if($template != NULL)
                {
                    if(isset($data->digest ))
                    if ($data->digest == 'rightaway')
                        {   
                            if($data->primary_email && $data->secondary_email)
                            {
                                $email1_to = $data->primary_email; 
                                $email2_to = $data->secondary_email;
                            }
                            elseif($data->primary_email)
                            {
                                $email1_to = $data->primary_email;
                                $email2_to = '';
                            }
                            elseif($data->secondary_email)
                            {
                                $email1_to = $data->secondary_email;
                                $email2_to = '';
                            }
                            
                            $template = MailTemplate::where('name','contacts_update')->first();
                            
                            $maillog = MailLog::create(['agency_id' => request()->get('agency.id') ,'client_id' => request()->get('client.id') ,'email' => $obj->email , 'app' => 'contact' ,'mail_template_id' => $template->id, 'subject' => $template->subject,'message' => $template->message , 'status'=> 0]);

                            $details = array('name' => $obj->name ,'email' => $obj->email ,'message' => $obj->message ,'counter'=> 1 ,'email1_To' => $email1_to ,'email2_To' => $email2_to,'log_id' => $maillog->id );
                            $content = $template->message;
                            

                            NotifyAdmin::dispatch($details,$content);
                        }
                }
            }

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
                $alert = 'Some error in updating the record. Retry!';
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
     * Show the settings files & store the data into the file
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function settings(Request $request)
    {
        // load client id
        $client_id = request()->get('client.id');
         // load alerts if any
        $alert = session()->get('alert');

        $editor = false;
        $settings = null;

        if(request()->get('store')){
            if($request->input('mode') == 'normal'){
                $settings = dev_normal_mode($request->all());
            }
            else if($request->input('mode') == 'dev'){
                if(validJson(request()->get('settings'))){
                    $settings = json_encode(json_decode(str_replace(array("\n", "\r"), '', request()->get('settings'))), JSON_PRETTY_PRINT);
                }
                else{
                    $alert = 'JSON is invalid, Please try again';
                    return redirect()->back()->withInput()->with('alert',$alert);
                }
            }
            // Save settings in s3
            Storage::disk('s3')->put('settings/contact/'.$client_id.'.json' ,$settings,'public');
            $alert = 'Successfully saved the settings file';
        }

        if($request->input('mode') == 'dev'){
            $editor = true;
            //load the settings
            if(Storage::disk('s3')->exists('settings/contact/'.$client_id.'.json' ))
                $settings = Storage::disk('s3')->get('settings/contact/'.$client_id.'.json');
        }
        else{
            //load the settings
            if(Storage::disk('s3')->exists('settings/contact/'.$client_id.'.json' ))
                $settings = json_decode(Storage::disk('s3')->get('settings/contact/'.$client_id.'.json' ), true);
        }

        if($client_id)
            return view('apps.'.$this->app.'.'.$this->module.'.settings')
                ->with('stub','Update')
                ->with('settings',$settings)
                ->with('alert',$alert)
                ->with('editor',$editor)
                ->with('app',$this);
        else
            abort(404);
    }


    /**
     * Send the token in api request
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function api()
    {
        //get client id
        $client_id = request()->get('client.id');
        // load the token
        $data['token'] = csrf_token();
        //display token in json format
        echo json_encode($data);
        dd();

    }

     /**
     * Send the otp code for the request
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function otp()
    {
        //get client id
        $client_id = request()->get('client.id');
        // get the user phone number
        $phone = request()->get('phone');

        // load the token
        $data['otp'] = rand ( 1000 , 9999);

        //send otp
        $this->sendOTP($phone,$data['otp']);

        //display token in json format
        return json_encode($data);
    }

    /**
     * Function to send OTP code
     *
     */
    public function sendOTP($phone,$code){
        $url = "https://2factor.in/API/V1/b2122bd6-9856-11ea-9fa5-0200cd936042/SMS/+91".$phone."/".$code;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        $data = curl_exec($ch);
        curl_close($ch);
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




