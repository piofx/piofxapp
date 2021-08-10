<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Mail\EmailForQueuing;
use Illuminate\Support\Facades\Mail;

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
        $this->componentName = componentName('agency');
    }

    //sample test email
    public function sampletestemail(){
        Mail::to('packetcode@gmail.com')
            ->send(new EmailForQueuing('heloo all'));
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
        $total_clicks = '';
        $total_impressions = '';
        $average_ctr = '';
        $average_position = '';
        if(Storage::disk('s3')->exists("searchConsole/consoleData_".request()->get('client.id').".json")){
            $searchConsoleData = json_decode(Storage::disk('s3')->get("searchConsole/consoleData_".request()->get('client.id').".json"), 'true');
            foreach($searchConsoleData as $key => $values){
                if($key == '3Months'){
                    foreach($values as $k => $v){
                        if($k == 'fullData'){
                            $total_clicks = format_number($v[0]['clicks']);
                            $total_impressions = format_number($v[0]['impressions']);
                            $average_ctr = round($v[0]['ctr'] * 100);
                            $average_position = round($v[0]['position']);
                        }
                    }
                }
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
                    ->with('average_position', $average_position);
        }
    }

    public function profile(Request $request){
        $record = \Auth::user();
        $this->module = 'User';
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
