<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page\Theme as Obj;
use App\Models\Page\Page;
use App\Models\Page\Module;
use App\Models\Page\Asset;

use App\Models\Core\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use File;
use ZipArchive;
use Illuminate\Support\Facades\Storage;

class ThemeController extends Controller
{
     /**
     * Define the app and module object variables and component name 
     *
     */
    public function __construct(){
        // load the app, module and component name to object params
        $this->id       =   request()->route('theme');
        $this->app      =   'Page';
        $this->module   =   'Theme';
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
        $objs = $obj->getRecords($item,30,$user);

        //current theme
        $this->current_theme_id = $obj->getCurrentThemeID();


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
    public function store(Obj $obj,Request $request)
    {
        try{
            
            /* create a new entry */
            $obj = $obj->create($request->all());

            /*update current theme */
            $obj->updateCurrentTheme();

            //reload cache and session data
            $obj->refreshCache();

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
     * Download the theme
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function download($id,Request $r){
        

        //dump the theme data
        $obj = Obj::where('id',$id)->first();
        $filename = 'theme_'.$obj->slug.'.json';
        Storage::disk('private')->put('themes/'.$id.'/'.$filename, json_encode($obj,JSON_PRETTY_PRINT));

        //dump the pages
        $pages = Page::where('theme_id',$id)->get();
        foreach($pages as $page){
            if($page->slug=='/')
                $filename = 'page_root.json';
            else
                $filename = 'page_'.$page->slug.'.json';
            Storage::disk('private')->put('themes/'.$id.'/'.$filename, json_encode($page,JSON_PRETTY_PRINT)); 
        }

        //dump the modules
        $modules = Module::where('theme_id',$id)->get();
        foreach($modules as $module){
            $filename = 'module_'.$module->slug.'.json';
            Storage::disk('private')->put('themes/'.$id.'/'.$filename, json_encode($module,JSON_PRETTY_PRINT)); 
        }

        //dump the assets
        $assets = Asset::where('theme_id',$id)->get();
        foreach($assets as $asset){
            $filename = 'asset_'.$asset->slug.'.json';
            Storage::disk('private')->put('themes/'.$id.'/'.$filename, json_encode($asset,JSON_PRETTY_PRINT)); 
        }

        //download assets
        $zip = new ZipArchive;
        
   
        $fileName = 'theme_'.$obj->slug.'.zip';
   
        if ($zip->open(storage_path($fileName), ZipArchive::CREATE) === TRUE)
        {
            //assets
            $files = File::files(storage_path('app/public/themes/'.$id));
            foreach ($files as $key => $value) {
                $relativeNameInZipFile = basename($value);
                $zip->addFile($value, $relativeNameInZipFile);
            }

            //sql data
            $files = File::files(storage_path('app/private/themes/'.$id));
            foreach ($files as $key => $value) {
                $relativeNameInZipFile = basename($value);
                $zip->addFile($value, $relativeNameInZipFile);
            }
             
            $zip->close();
        }
    
        return response()->download(storage_path($fileName));
    }

    /**
     * Upload the theme
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function upload(Obj $obj,Request $request){
        $file      = $request->all()['file'];
        $extension = strtolower($file->getClientOriginalExtension());
        $fname = $file->getClientOriginalName();
        $client_id = $request->get('client_id');
        
            if(!in_array($extension, ['zip']))
                {
                    $alert = 'You are allowed to upload only zip file';
                    return redirect()->back()->withInput()->with('alert',$alert);

                }
                
        $filename = 'zip_'.$client_id.'_'.$fname;

        $path = Storage::disk('public')->putFileAs('zips/'.$client_id, $request->file('file'),$filename,'public');
        //dd(storage_path('app/public/'.$path));
        $zip = new ZipArchive; 
  
        // Zip File Name 
        if ($zip->open(storage_path('app/public/'.$path)) === TRUE) { 
          
            // Unzip Path 
            $zip->extractTo(storage_path('app/private/extracts/'.$filename)); 
            $zip->close(); 
            echo 'Unzipped Process Successful!'; 

            $dir = storage_path('app/private/extracts').'/'.$filename;

            // Open a directory, and read its contents
            if (is_dir($dir)){
              if ($dh = opendir($dir)){
                //identify  thee theme
                while (($file = readdir($dh)) !== false){
                    echo $file.' <br>';
                    if($file !='..' && $file !='.'){
                       $filename = $file;
                       $theme = $obj->identifyTheme($obj,$dir,$filename);

                       if($theme)
                        break;
                    } 
                }

                closedir($dh);
              }

              if ($d = opendir($dir)){
                //identify  thee theme
                 while (($f = readdir($d)) !== false){
                    echo $f.' -- <br>';
                    if($f !='..' && $f !='.'){
                        $filename = $f;
                       $obj->processFile($theme,$dir,$filename);
                    
                    }
                }

                closedir($d);
              }

             
                
            }
            $theme->processHtml();
            
            // flash message and redirect to controller index page
            $alert = 'Theme ('.$theme->name.') is uploaded';

        } else { 
            // flash message and redirect to controller index page
            $alert = 'Theme upload failed';
        } 


        return redirect()->route($this->module.'.index')->with('alert',$alert);

    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function library(Obj $obj)
    {
        // load the resource
        $objs = Obj::where('admin',1)->paginate(30);

        // load alerts if any
        $alert = session()->get('alert');

         // authorize the app
        $this->authorize('viewAny', $obj);
        

        if($objs)
            return view('apps.'.$this->app.'.'.$this->module.'.library')
                    ->with('objs',$objs)
                    ->with('app',$this)->with('alert',$alert);
        else
            abort(404);
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

        //save settings if any
        $obj->saveSettings();

        //load settings
        $settings = json_decode($obj->settings);
        

        if($obj)
            return view('apps.'.$this->app.'.'.$this->module.'.show')
                    ->with('settings',$settings)->with('obj',$obj)->with('app',$this)->with('alert',$alert);
        else
            abort(404);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function preview($id)
    {
        // load the resource
        $obj = Obj::where('id',$id)->first();
        // authorize the app
        $this->authorize('view', $obj);

        $page = Page::where('theme_id',$obj->id)->where('slug','/')->first();

        if($page)
            return redirect()->route('Page.theme',[$id,$page->id]);
        else{
            $page = Page::where('theme_id',$obj->id)->first();

            if($page)
                return redirect()->route('Page.theme',[$id,$page->id]);
            else
                abort('404','No preview pages found');
        }
        
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
    public function update(Request $request, $id)
    {
        try{
            
            // load the resource
            $obj = Obj::where('id',$id)->first();
            // authorize the app
            $this->authorize('update', $obj);
            //update the resource
            $obj->update($request->all()); 

            /*update current theme */
            $obj->updateCurrentTheme();

            $obj->settings = json_encode(json_decode($obj->settings),JSON_PRETTY_PRINT);
            $obj->save();
            //reload cache and session data
            $obj->refreshCache();


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
}
