<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page\Module as Obj;
use App\Models\Core\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use App\Models\Page\Theme;

class ModuleController extends Controller
{
     /**
     * Define the app and module object variables and component name 
     *
     */
    public function __construct(){
        // load the app, module and component name to object params
        $this->id       =   request()->route('theme');
        $this->app      =   'Page';
        $this->module   =   'Module';
        $this->componentName = componentName('agency');
        $this->theme = Theme::where('id',$this->id)->first();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($theme_id,Obj $obj,Request $request)
    {

        //update page meta title
        adminMetaTitle('Modules - '.$this->theme->name);

        // check for search string
        $item = $request->item;
        // load alerts if any
        $alert = session()->get('alert');


        // authorize the app
        $this->authorize('viewAny', $obj);
        //load user for personal listing
        $user = Auth::user();
        // retrive the listing
        $objs = $obj->getRecords($item,30,$theme_id);

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
    public function create($theme_id,Obj $obj)
    {
        // authorize the app
        $this->authorize('create', $obj);
        // get the clients
        $clients = Client::where('id',request()->get('client.id'))->get();


        return view('apps.'.$this->app.'.'.$this->module.'.createedit')
                ->with('stub','Create')
                ->with('obj',$obj)
                ->with('clients',$clients)
                ->with('editor',true)
                ->with('app',$this);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($theme_id,Obj $obj,Request $request)
    {
        try{
            
            /* create a new entry */
            $obj = $obj->create($request->all());

            $obj->processHtml($theme_id);
            //reload cache and session data
            $obj->refreshCache();

            $alert = 'A new ('.$this->app.'/'.$this->module.') item is created!';
            return redirect()->route($this->module.'.show',[$theme_id,$obj->id])->with('alert',$alert);
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
    public function show($theme_id,$id)
    {
        // load the resource
        $obj = Obj::where('id',$id)->first();
   
        // load alerts if any
        $alert = session()->get('alert');
        // authorize the app
        $this->authorize('update', $obj);

        //update page meta title
        adminMetaTitle($obj->name.' - '.$this->theme->name);

        //save settings if any
        $obj->saveSettings();

        //load settings
        $settings = json_decode($obj->settings);

        if($obj)
            return view('apps.'.$this->app.'.'.$this->module.'.show')
                    ->with('obj',$obj)->with('app',$this)->with('settings',$settings)->with('alert',$alert);
        else
            abort(404);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($theme_id,$id)
    {
        // load the resource
        $obj = Obj::where('id',$id)->first();
        // authorize the app
        $this->authorize('view', $obj);

        //update page meta title
        adminMetaTitle($obj->name.' [edit] - '.$this->theme->name);
        // get the clients
        $clients = Client::where('id',request()->get('client.id'))->get();

        if($obj)
            return view('apps.'.$this->app.'.'.$this->module.'.createedit')
                ->with('stub','Update')
                ->with('obj',$obj)
                ->with('clients',$clients)
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
    public function update($theme_id,Request $request, $id)
    {
        try{
            
            // load the resource
            $obj = Obj::where('id',$id)->first();
            // authorize the app
            $this->authorize('update', $obj);
            //update the resource
            $obj->update($request->all()); 
            //process the  html load by updating variables
            $obj->processHtml($theme_id);
            //reload cache and session data
            $obj->refreshCache();

            

            // flash message and redirect to controller index page
            $alert = 'A new ('.$this->app.'/'.$this->module.'/'.$id.') item is updated!';
            return redirect()->route($this->module.'.show',[$theme_id,$id])->with('alert',$alert);
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
    public function destroy($theme_id,$id)
    {
        // load the resource
        $obj = Obj::where('id',$id)->first();
        // authorize
        $this->authorize('update', $obj);
        // delete the resource
        $obj->delete();

        // flash message and redirect to controller index page
        $alert = '('.$this->app.'/'.$this->module.'/'.$id.') item  Successfully deleted!';
        return redirect()->route($this->module.'.index',$theme_id)->with('alert',$alert);
    }
}
