<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $request = request();
        // get the url path excluding domain name
        $slug = request()->path();

        // get the client id & domain
        $client_id = request()->get('client.id');
        $theme_id = request()->get('client.theme.id');
        $domain = request()->get('domain.name');

        $agency_settings = request()->get('agency.settings');
        $client_settings = json_decode(request()->get('client.settings'));

        //dd($agency_settings);

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
            ->with('componentName',$this->componentName);
        }
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

   

}
