<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User as Obj;
use App\Models\Core\Client;
use App\Models\Core\Referral;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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


        //update page meta title
        adminMetaTitle('Users');

        // authorize the app
         // only admin can access
        \Auth::user()->onlyAdminAccess();
        //load user for personal listing
        $user = Auth::user();
        // retrive the listing
        //$objs = $obj->getRecords($item,30,$user);
        $total = $obj->where('agency_id', request()->get('agency.id'))->where('client_id', request()->get('client.id'))->orderBy("name", "asc")->count();
        $objs = $obj->where('agency_id', request()->get('agency.id'))->where('client_id', request()->get('client.id'))->orderBy("created_at", "desc")->paginate(30);

        

        return view('apps.'.$this->app.'.'.$this->module.'.index')
                ->with('app',$this)
                ->with('alert',$alert)
                ->with('total',$total)
                ->with('objs',$objs);
    }

    /**
     * Api Login
     *
     * @return \Illuminate\Http\Response
     */
    public function api_user(Obj $obj)
    {   
        
        //load client id
        $client_id = request()->get('client.id');
        $u = Auth::user();
        if($u)
        {
            $message['user']="1";
            $message['message'] = "Logged in!";
            echo json_encode($message);
        }else{
            $message['user']="0";
            $message['message'] = "Not Logged in!";
            echo json_encode($message);
        }            
       
    }

    /**
     * Api Login
     *
     * @return \Illuminate\Http\Response
     */
    public function api_login(Obj $obj)
    {   
        
        //load client id
        $client_id = request()->get('client.id');
        $email = request()->get('email');
        $password = request()->get('password');



        //check validity
        if(Auth::attempt(['email' => $email, 'password' => $password,'client_id'=>$client_id]))
        {
            $message['login']="1";
            $message['message'] = "Successfully Logged in!";
            //update user login timestamp
            $user = Auth::user();
            $lastlogindate = Cache::get('lastlogind_'.$user->id);
            if($lastlogindate != Carbon::now()->toDateString()){
                $date = Carbon::now()->toDateString();
                $user = \Auth::user();
                $user->remember_token= substr(md5(mt_rand()), 0, 7);
                $user->save(); 
                Cache::put('lastlogind_'.$user->id,$date,43200);
            }
            echo json_encode($message);
        }else{
            $message['login']="0";
            $message['message'] = "Invalid Credentials!";
            echo json_encode($message);
        }            
       
    }

    /**
     * Api Register
     *
     * @return \Illuminate\Http\Response
     */
    public function api_register(Obj $obj,Request $request)
    {   

        
        //load client id
        $client_id = request()->get('client.id');
        $email = request()->get('email');
        $password = request()->get('password');
        $name = request()->get('name');
        $phone = request()->get('phone');
        $password = request()->get('password');
        $agency_id = request()->get('agency.id');
        $generate_otp = request()->get('generate_otp');


        $u = Obj::where('email',$email)->where('client_id',$client_id)->first();
        $u1 = Obj::where('phone',$phone)->where('client_id',$client_id)->first();

        // $message['login']="1";
        //     $message['message'] = "Successfully Logged in!";
        //     echo json_encode($message);
        //     dd();

        if($generate_otp){
            $data = $this->otp($u,$u1);
            echo $data;
            exit();
            return 1;
        }

        if(!$password){
            $password = $phone;
        }

        if(!$u && !$u1){
            $user = Obj::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'phone' => $phone,
                'client_id'=>$client_id,
                'agency_id'=>$agency_id,
                'status'=>1
            ]);
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

            
            $user->data = $data;
            $user->json = $json;
            $user->save();

            if($request->get('settings_utm_referral')){
                $referral_id = $request->get('settings_utm_referral');
                $redirect = $request->get('redirect');
                if(!$redirect)
                    $redirect = $request->get('curr_url');
                
                Referral::insert($referral_id,$user,$redirect);
            }

            Auth::attempt(['email' => $email, 'password' => $password,'client_id'=>$client_id]);
            $message['login']="1";
            $message['message'] = "Successfully Logged in!";
            echo json_encode($message);
            dd();
        }else if($u){
            $message['login']="0";
            $message['message'] = "User account with email (".$email.") already exists in our database, Kindly use forgot password to reset!";
            echo json_encode($message);
            dd();
        }else{
            $message['login']="0";
            $message['message'] = "User account with phone (".$phone.") already exists in our database, Kindly use forgot password to reset!";
            echo json_encode($message);
            dd();
        }
                   
       
    }

     /**
     * Send the otp code for the request
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function otp($u,$u1)
    {
       
        //get client id
        $client_id = request()->get('client.id');
        // get the user phone number
        $phone = request()->get('phone');
        $whatsapp = request()->get('whatsapp');

        // load the token
        $data['code'] = request()->session()->get('code');
        $validated = false;


        if($u){
            $message['error'] = 'User account exists with email id ('.$u->email.') Kindly use forgot password to login.';
            return json_encode($message);
        }
        if($u1){
            $message['error'] = 'User account exists with phone ('.$u1->phone.') Kindly use forgot password to login.';
            return json_encode($message);
        }
        if($phone && $whatsapp){
            $template = 'requestotp';
            if(strlen($phone)==10)
                    $phone = '91'.$phone;
            $otp = $data['code'];
            $rem_str = 'rem_'.$phone.'_status';
            Cache::remember($rem_str, 1800, function () {
                return 1;
            });
            Cache::remember('code_'.$phone, 1800, function () use ($otp) {
                return $otp;
            });
            sendWhatsApp($phone,$template,[]);
        }
        elseif($phone){
            
            //validate data
            if (strpos($phone, '+') !== false){
                $validated=true;
            }else{
                if(strlen($phone)==10)
                {
                    $phone = '+91'.$phone;
                }else{
                    $message['error'] = 'Invalid Phone number format. Kindly enter a valid phone number with international calling extension (eg: For india +918888888888) for OTP verification.';
                    return json_encode($message);
                }
                    
            }
            //send otp on phone
            $this->sendOTP($phone,$data['code']);

        }

        

        //display token in json format
        return json_encode($data);
        

    }

    /**
     * Function to send OTP code
     *
     */
    public function sendOTP($phone,$code){

        $apikey = env('SMS_APIKEY');
        $url = "https://2factor.in/API/V1/".$apikey."/SMS/".$phone."/".$code;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        $data = curl_exec($ch);
        curl_close($ch);
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
        $this->authorize('view', $obj);
        $this->componentName = componentName('agency','plain');
    
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
        $this->componentName = componentName('agency','plain');
        $this->authorize('view', $obj);
        //update the resource
        $obj->update($request->all()); 
        
        // flash message and redirect to controller index page
        $alert = 'A new ('.$this->app.'/'.$this->module.'/'.$id.') item is updated!';
        return redirect()->route('profile.show',$id)->with('alert',$alert);
    }

    public function profile_show(Request $request,$id){

        // load the resource
        $record = Obj::where('id',$id)->first();
        $this->componentName = componentName('agency','plain');
        $this->authorize('view', $record);
        
        $this->module = 'User';
        return view("apps.Core.User.general")->with('app',$this)->with('record',$record);
    }

    public function public_show($id){

       // load the resource
       $obj = Obj::where('id',$id)->first();
       $this->componentName = componentName('agency','plain');
       $this->authorize('view', $obj);

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
        $obj = $obj->where('id',$id)->first();

        // authorize the app
        $this->authorize('update', $obj);

        $phone = $obj->phone? $obj->phone : '8989898989';
        
        //Hashing the phone number
        $obj->password = Hash::make($phone);
       
        $obj->save();
        
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


        //update page meta title
        adminMetaTitle('User settings ');

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

    /**
     * Stastics of the users
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function statistics(Request $request){
        $client_id = $request->get('client.id');
        
        $data = Cache::get('user_stat_data_'.$client_id);
        if($request->get('refresh'))
        {
            Cache::forget('user_stat_data_'.$client_id);
        }


        //update page meta title
        adminMetaTitle('User Statistics ');

        if(!$data){
             //some dates
            $now = Carbon::now();
            $weekStartDate = $now->startOfWeek()->format('Y-m-d H:i');
            $weekEndDate = $now->endOfWeek()->format('Y-m-d H:i');
            $last_year = (new \Carbon\Carbon('first day of last year'))->year;
            $this_year = (new \Carbon\Carbon('first day of this year'))->year;
            $last_year_first_day = (new \Carbon\Carbon('first day of January '.$last_year))->startofMonth()->toDateTimeString();
            $this_year_first_day = (new \Carbon\Carbon('first day of January '.$this_year))->startofMonth()->toDateTimeString();

            // all data stats
            $data['all']['total'] = Obj::select('id')->where('client_id',$client_id)->count();
            $data['all']['this_week'] = Obj::select('id')->where('client_id',$client_id)->where('created_at','>', $weekStartDate)->where('created_at','<', $weekEndDate)->count();
            $data['all']['this_month'] = Obj::select('id')->where('client_id',$client_id)->whereMonth('created_at', Carbon::now()->month)->count();
            $data['all']['last_month'] = Obj::select('id')->where('client_id',$client_id)->whereMonth('created_at', Carbon::now()->subMonth()->month)->count();
            $data['all']['this_year'] = Obj::select('id')->where('client_id',$client_id)->where(DB::raw('YEAR(created_at)'), '=', $this_year)->count();
            $data['all']['last_year'] = Obj::select('id')->where('client_id',$client_id)->where('created_at','>', $last_year_first_day)->where('created_at','<', $this_year_first_day)->count();

            // active data stats
            $data['active']['this_week'] = Obj::select('id')->where('client_id',$client_id)->where('updated_at','>', $weekStartDate)->where('updated_at','<', $weekEndDate)->count();
            $data['active']['this_month'] = Obj::select('id')->where('client_id',$client_id)->whereMonth('updated_at', Carbon::now()->month)->count();
            $data['active']['past_30'] = Obj::select('id')->where('client_id',$client_id)->where('created_at', '>', now()->subDays(30)->endOfDay())->count();
            $data['active']['past_60'] = Obj::select('id')->where('client_id',$client_id)->where('created_at', '>', now()->subDays(60)->endOfDay())->count();
            $data['active']['past_90'] = Obj::select('id')->where('client_id',$client_id)->where('created_at', '>', now()->subDays(90)->endOfDay())->count();
            $data['active']['past_180'] = Obj::select('id')->where('client_id',$client_id)->where('created_at', '>', now()->subDays(180)->endOfDay())->count();
            

            //settings params
            $settings = '';
            if(Storage::disk('s3')->exists('settings/user/'.$client_id.'.json' ))
                $settings = json_decode(json_decode(Storage::disk('s3')->get('settings/user/'.$client_id.'.json' )));
            
            if(isset($settings->form)){
                $form = $settings->form;
                $fields = processForm($form);
                foreach($fields as $f){

                    if ($f['type']=='radio') {
                        foreach($f['values'] as $v){
                            $data['other'][$f['name']][$v] =  Obj::select('id')->where('client_id',$client_id)->where('data','LIKE',"%{$v}%")->count();
                        }
                    }
                }
           
            }

            Cache::forever('user_stat_data_'.$client_id,$data);

        }
       

        return view('apps.'.$this->app.'.'.$this->module.'.statistics')
                ->with('data',$data)
                ->with('app',$this);
      
    }

    public function download(Obj $obj , $fileName = 'file.csv')
    {

        // Retrieve all the records
        $objs = $obj->where('agency_id', request()->get('agency.id'))->where('client_id', request()->get('client.id'))->get();
        
        // Retrieve all the records
        $cols = $obj->where('agency_id', request()->get('agency.id'))->where('client_id', request()->get('client.id'))->get('json');
        
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );
        $columns = ['name','email','client'];
        $file = fopen('php://output', 'w');
        foreach($cols as $col)
        {
            if(!empty($col->json)){
            $columns = array_unique(array_merge($columns, array_keys(json_decode($col->json, true))));
            break;  
            }  
            else{
                continue;
            } 
        }
        fputcsv($file, $columns);
        fclose($file);
        $callback = function() use($objs) {
            $file = fopen('php://output', 'w');
                foreach($objs as $obj){
                    $row = [$obj->name,$obj->email,$obj->client->name];
                    if(!empty($obj->json)){
                        $data = array_merge($row, array_values(json_decode($obj->json, true)));   
                        fputcsv($file ,$data);
                    }
                    else{
                        fputcsv($file, $row);
                    }
                }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
      
    }

    public function samplecsv(Obj $obj, Request $request , $fileName = '.csv')
    {   
        // authorize the app
        //$this->authorize('view', $obj);
        
        $columns = array("email","name","phoneNo","group","subgroup");
        $rows = array(
            array(
                "email" => "peterwilson@gmail.com",
                "name"  => "Peter Wilson",
                "phoneNo" => "36985214789",
                "group" => "Science",
                "subgroup" => "Biology,Physics",
            ),
            array(
                "email" => "helen@gmail.com",
                "name"  => "helen",
                "phoneNo" => "36985214789",
                "group" => "Web Technologies",
                "subgroup" => "HTML,CSS,JavaScript.",
            ),
        );
        return getCsv($columns, $rows, 'data_'.request()->get('client.name').'_'.strtotime("now").'_sample.csv');     
    }


    public function upload(Obj $obj, Request $request)
    {    
        // authorize the app
        //$this->authorize('upload', $obj); 
        
        $objs = $obj->all('email');
        foreach($objs as $obj)
        {   
            $existing_emails[] = $obj->email;
        }
        if($file = $request->file('file'))
        {
   
            // File Details 
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $tempPath = $file->getRealPath();
            $fileSize = $file->getSize();
            $mimeType = $file->getMimeType();

            // Valid File Extensions
            $valid_extension = array("csv");

            // 2MB in Bytes
            $maxFileSize = 2097152; 

            // Check file extension
            if(in_array(strtolower($extension),$valid_extension))
            {

                    // Check file size
                if($fileSize <= $maxFileSize)
                {
                    // File upload location
                    $location = 'uploads';
                    // Upload file
                    $file->move($location,$filename);
                    // Import CSV to Database
                    $filepath = public_path($location."/".$filename);
                    // Reading file
                    $file = fopen($filepath,"r");
                    $importData_arr = array();
                    $i = 0;
                    while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE)
                    {
                        $num = count($filedata );
                        // Skip first row
                        if($i == 0){
                            $i++;
                            continue; 
                        }
                        for ($c=0; $c < $num; $c++) {
                            $importData_arr[$i][] = $filedata [$c];
                        }
                        $i++;
                    }
                    fclose($file);
                    //unset($importData_arr[0]);
                    foreach($importData_arr as $importData)
                    {   
                        //ddd($importData[0]);
                        $subscriber = $obj->where('email', '=', $importData[0])->first();
                        if ($subscriber === null)
                        {
                            $objs = $obj->create(['email' => $importData[0],'name' => $importData[1],'phone' => $importData[2] ,'group' => $importData[3] ,'subgroup' => $importData[4],'client_id' => $request->client_id, 'agency_id' => $request->agency_id , 'status' => 1 , 'role' => 'user', 'password' => Hash::make($importData[2])]);   
                        }
                        else
                        {
                            $subscriber->name = $importData[1];
                            $subscriber->phone = $importData[2];
                            $subscriber->group = $importData[3];
                            $subscriber->subgroup = $importData[4];
                            $subscriber->save();
                        }
                    }
                    $alert = '('.$this->app.'/'.$this->module.') Imported Successfully ';
                }
                else
                {
                $alert = '('.$this->app.'/'.$this->module.') File too large. File must be less than 2MB. ';
                }

            }

        }
        else
        {
            $alert = '('.$this->app.'/'.$this->module.') Select a File ';
        }

        return redirect()->route($this->module.'.index')->with('alert',$alert);

    }

}
