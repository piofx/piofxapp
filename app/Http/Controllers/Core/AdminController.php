<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Mail\EmailForQueuing;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use App\Models\Admin\Tracker;
use Carbon\Carbon;

class AdminController extends Controller
{
   

    /*
     * Create the component instance.
     *
     * @param  string  $type
     * @param  string  $message
     * @return void
     */
    public function __construct()
    {
        $this->app      =   'Core';
        $this->module   =   'Tracker';
        $this->componentName = componentName('agency');
    }

    //sample test email
    public function sampletestemail(){
        $details=array("email"=>"packetcode@gmail.com","count"=>234,"client_name"=>"packetprep","subject"=>"s sample subject","content"=>"some content new","from"=>"noreply@mail.packetprep.com");
        Mail::mailer('pp_smtp')->to('packetcode@gmail.com')
            ->send(new EmailForQueuing($details));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
        //check if the user is not admin
        $user = \Auth::user();

        //update page meta title
        adminMetaTitle('Admin Dashboard');



        //update user login timestamp
        $lastlogindate = Cache::get('lastlogine_'.$user->id);
        if($lastlogindate != Carbon::now()->toDateString()){

            $date = Carbon::now()->toDateString();
            $user = \Auth::user();
            $user->remember_token= substr(md5(mt_rand()), 0, 7);
            $user->save(); 
            Cache::put('lastlogine_'.$user->id,$date,43200);
        }

        if($user->role=='user'){
            
            return redirect()->route('profile');
        }
        $request = request();
        // get the url path excluding domain name
        $slug = request()->path();

        // get the client id & domain
        $client_id = request()->get('client.id');
        $theme_id = request()->get('client.theme.id');
        $domain = request()->get('domain.name');

        $agency_settings = request()->get('agency.settings');
        $client_settings = json_decode(request()->get('client.settings'));

      

        // Get user search console data
        $total_clicks = null;
        $total_impressions = null;
        $average_ctr = null;
        $average_position = null;
        $oneMonthDateData = null;
        if(Storage::disk('s3')->exists("searchConsole/consoleData_".request()->get('client.id').".json")){
            $searchConsoleData = json_decode(Storage::disk('s3')->get("searchConsole/consoleData_".request()->get('client.id').".json"), 'true');
            
            $fullData = $searchConsoleData['3Months']['fullData'];
            if(!empty($fullData)){
                foreach($fullData as $data){
                    $total_clicks = format_number($data['clicks']);
                    $total_impressions = format_number($data['impressions']);
                    $average_ctr = round($data['ctr'] * 100, 1);
                    $average_position = round($data['position'], 1);
                }
            }

            $oneMonthDateData = $searchConsoleData['1Month']['dateData'];
            if(!empty($oneMonthDateData)){
                $dates = array();
                $clicks = array();
                $impressions = array();
                for($i=count($oneMonthDateData)-1; $i>count($oneMonthDateData)-11; $i--){
                    array_push($dates, $oneMonthDateData[$i]['keys'][0]);
                    array_push($clicks, $oneMonthDateData[$i]['clicks']);
                    array_push($impressions, $oneMonthDateData[$i]['impressions']);
                }
                $oneMonthDateData = array();
                $oneMonthDateData['dates'] = array_reverse($dates);
                $oneMonthDateData['clicks'] = array_reverse($clicks);
                $oneMonthDateData['impressions'] = array_reverse($impressions);
            }      
        }

        // load the  app mentioned in the client or agency settings
        if(isset($client_settings->admin_controller) && $slug=='admin'){
            $app = $client_settings->app;
            $controller = $client_settings->admin_controller;
            $method = $client_settings->admin_method;

            $controller_path = 'App\Http\Controllers\\'.$app.'\\'.$controller;
            return app($controller_path)->$method($request);

        }else if(isset($agency_settings->admin_controller) && $slug=='admin'){
            $app = $agency_settings->app;
            $controller = $agency_settings->admin_controller;
            $method = $agency_settings->admin_method;

            $controller_path =  'App\Http\Controllers\\'.$app.'\\'.$controller;
            return app($controller_path)->$method($request);

        }else{

            return view('apps.Core.Admin.index')
                    ->with('title',"hello")
                    ->with('componentName',$this->componentName)
                    ->with('total_clicks', $total_clicks)
                    ->with('total_impressions', $total_impressions)
                    ->with('average_ctr', $average_ctr)
                    ->with('average_position', $average_position)
                    ->with('oneMonthDateData', json_encode($oneMonthDateData));
        }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tracker(Tracker $obj)
    {  
        //check if the user is not admin
        $user = \Auth::user();

        //update page meta title
        adminMetaTitle('Tracker Admin');


        $request = request();
        // get the url path excluding domain name
        $slug = request()->path();

        // get the client id & domain
        $client_id = request()->get('client.id');
        $theme_id = request()->get('client.theme.id');
        $domain = request()->get('domain.name');

        $agency_settings = request()->get('agency.settings');
        $client_settings = json_decode(request()->get('client.settings'));

        if($request->get('api')){
            // store the data
            $url = request()->get('url');
            $uid = request()->get('user_id');
            $exists = $obj->where('url',$url)->where('user_id',$uid)->where('client_id',$client_id)->first();
            if(!$exists)
                $obj = $obj->create($request->all());
            dd('1');
        }
        
        // get tracker data
        $trackers  = Tracker::where('client_id',$client_id)->get();
        $data['campaign'] = $trackers->groupBy('utm_campaign');
        $data['source'] = $trackers->groupBy('utm_source');
        $data['medium'] = $trackers->groupBy('utm_medium');
        $data['term'] = $trackers->groupBy('utm_term');
        $data['content'] = $trackers->groupBy('utm_content');

        return view('apps.Core.Tracker.index')
                    ->with('app',$this)
                    ->with('componentName',$this->componentName)
                    ->with('data',$data);
    }


     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function user($u,Tracker $obj)
    {  
        //check if the user is not admin
        $user = \Auth::user()->where('id',$u)->first();

        //update page meta title
        adminMetaTitle('User Tracker Admin');


        $request = request();
        // get the url path excluding domain name
        $slug = request()->path();

        // get the client id & domain
        $client_id = request()->get('client.id');
        $theme_id = request()->get('client.theme.id');
        $domain = request()->get('domain.name');

        $agency_settings = request()->get('agency.settings');
        $client_settings = json_decode(request()->get('client.settings'));

        
        
        // get tracker data
        $trackers  = Tracker::where('client_id',$client_id)->where('user_id',$u)->paginate(30);



        return view('apps.Core.Tracker.user')
                    ->with('app',$this)
                    ->with('componentName',$this->componentName)
                    ->with('user',$user)
                    ->with('objs',$trackers);
    }

    public function profile(Request $request){
        $record = \Auth::user();
        $this->module = 'User';
        $this->componentName = componentName('agency','plain');
        return view("apps.Core.User.general")->with('app',$this)->with('record',$record);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function apps()
    {
        return view('apps.Core.Admin.apps')
            ->with('componentName',$this->componentName);
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dropzone(Request $request)
    {
        if(request()->get('foo')){
            $file = $request->all()['file'];
            $fname = $file->getClientOriginalName();
            $extension = strtolower($file->getClientOriginalExtension());
            $filename = 'post_'.time().'_'.auth()->user()->id.'_'.rand().'_'.$fname;
            
            $path = Storage::disk('s3')->putFileAs('images', $request->file('file'), $filename, 'public');
            image_resize($request->file('file'), "800", $filename);
            image_resize($request->file('file'), "400", $filename);

            echo $path;
        }
    }
   
    public function gsettings(Request $request){

        if($request->input('save')){
                        
        }

        return view('apps.Core.Admin.settings')
            ->with('componentName',$this->componentName);
    }

}
