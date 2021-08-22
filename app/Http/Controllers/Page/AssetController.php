<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page\Asset as Obj;
use App\Models\Core\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AssetController extends Controller
{
     /**
     * Define the app and module object variables and component name 
     *
     */
    public function __construct(){
        // load the app, module and component name to object params
        $this->id       =   request()->route('theme');
        $this->app      =   'Page';
        $this->module   =   'Asset';
        $this->componentName = componentName('agency');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($theme_id,Obj $obj,Request $request)
    {


        // check for search string
        $item = $request->item;
        // load alerts if any
        $alert = session()->get('alert');

        //remove html data in request params (as its clashing with pagination)
        $request->request->remove('app.theme.prefix');
        $request->request->remove('app.theme.suffix');

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
        $data =null;
        // load alerts if any
        $alert = session()->get('alert');

        return view('apps.'.$this->app.'.'.$this->module.'.createedit')
                ->with('stub','Create')
                ->with('obj',$obj)
                ->with('clients',$clients)
                ->with('data',$data)
                ->with('alert',$alert)
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
            
            if(isset($request->all()['file'])){
                $obj->uploadFile($theme_id,$request);
                /* create a new entry */
                $obj = $obj->create($request->all());
            }
            else
                $obj->uploadMultipleFiles($theme_id,$request);


            $alert = 'A new ('.$this->app.'/'.$this->module.') item is created!';
            return redirect()->route($this->module.'.index',$theme_id)->with('alert',$alert);
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
    public function edit($theme_id,$id)
    {
        // load the resource
        $obj = Obj::where('id',$id)->first();
        // authorize the app
        $this->authorize('view', $obj);
        // get the clients
        $clients = Client::where('id',request()->get('client.id'))->get();

        // load alerts if any
        $alert = session()->get('alert');

        $data=null;
        if($obj->type=='css' || $obj->type=='js'){
            $data = Storage::disk('s3')->get($obj->path);
        }

        if($obj)
            return view('apps.'.$this->app.'.'.$this->module.'.createedit')
                ->with('stub','Update')
                ->with('obj',$obj)
                ->with('clients',$clients)
                ->with('alert',$alert)
                ->with('data',$data)
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

            $obj->uploadFile($theme_id,$request);
            //update the resource
            $obj->update($request->all()); 

            if($request->get('data')){
                $data = $request->get('data');
                Storage::disk('s3')->put($obj->path,$data);
            }
            
            // flash message and redirect to controller index page
            $alert = 'A new ('.$this->app.'/'.$this->module.'/'.$id.') item is updated!';
            return redirect()->route($this->module.'.edit',[$theme_id,$id])->with('alert',$alert);
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
