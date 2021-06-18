<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use App\Models\Blog\BlogSettings;

class BlogSettingsController extends Controller
{

    /**
     * Define the app and module object variables and component name 
     *
     */
    public function __construct(){
        // load the app, module and component name to object params
        $this->app      =   'Blog';
        $this->module   =   'Settings';
        $this->componentName = componentName('agency');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BlogSettings $settings)
    {
        // Retrieve Settings
        $settings = $settings->getSettings();

        //dd(json_decode($settings));

        return view("apps.".$this->app.".".$this->module.".index")
                ->with("app", $this)
                ->with("settings", $settings);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $client_id = request()->get('client.id');
        $settingsfilename = 'settings/blog_settings_'.$client_id.'.json';
        $settings = Storage::disk("s3")->get($settingsfilename);
        // ddd(json_decode($settings));

        return view("apps.".$this->app.".".$this->module.".createedit")
                ->with("app", $this)
                ->with("settings", $settings)
                ->with("stub", "update");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $settings = array();
        $names = [];
        if($request->input('mode') == 'normal'){

            foreach($request->all() as $k => $value){
                $keys = explode('-', $k);
                if($keys[0] == 'settings' && $keys[1] != 'array'){
                    $settings[$keys[1]] = $value;
                }
                elseif($keys[0] == 'settings' && $keys[1] == 'array'){
                    $t = $keys[2];
                    if(!in_array($keys[2], $names)){
                        array_push($names, $keys[2]);
                    }
                }
            }

            foreach($names as $name){
                $new_keys = [];
                $temp = [];
                foreach($request->all() as $k => $value){
                    $keys = explode('-', $k);
                    if(sizeof($keys) > 2 && $keys[2] == $name && $keys[4] == 'key'){
                        foreach($value as $v ){
                            array_push($new_keys, $v);
                        }
                    }
                    elseif(sizeof($keys) > 2 && $keys[2] == $name && $keys[4] == 'value'){
                        $t = array();
                        foreach($value as $k => $v){
                            $t[$new_keys[$k]] = $v;
                        }
                        array_push($temp, $t);
                    }
                }
                $settings[$name] = $temp;

            }
            $settings = json_encode($settings, JSON_PRETTY_PRINT);
        }
        else{
            $settings = $request->input('settings');
            $settings = str_replace("\r", "", $settings);
            $settings = str_replace("\t", "", $settings);
        }

        $client_id = request()->get('client.id');
        $settingsfilename = 'settings/blog_settings_'.$client_id.'.json';

        Storage::disk("s3")->put($settingsfilename, $settings);
        
        return redirect()->route($this->module.'.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
