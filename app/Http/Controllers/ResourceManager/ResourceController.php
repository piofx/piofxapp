<?php
namespace App\Http\Controllers\ResourceManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Image;
use App\DB;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\URL;
use App\Models\User;
use App\Models\ResourceManager\Resource as Obj;
use Illuminate\Support\Str;
class ResourceController extends Controller
{
    
      public function __construct(){
        // load the app, module and component name to object params
        $this->app      =   'ResourceManager';
        $this->module   =   'Resource';
        $theme = session()->get('theme');
        $this->componentName = 'themes.'.$theme.'.layouts.app';
      }
  
       /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

      public function index(Obj $objs,Request $request){
        
        $item = $request->item;
        if($item == NULL)
        {
          $objs=obj::all();
          return view("apps.".$this->app.".".$this->module.".index")
          ->with("app", $this)
          ->with("objs", $objs); 
        }
        else{ 
        $objs = obj::sortable()->where('title','LIKE',"%$item%")->get();
        return view("apps.".$this->app.".".$this->module.".index")
                ->with("app", $this)
                ->with("objs", $objs); 
        }     
          
      }
        /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog\Post  $post
     * @return \Illuminate\Http\Response
     */
      public function show($id){
        $objs = obj::find($id);
        $url = Storage::url($objs->file); 
        return view("apps.".$this->app.".".$this->module.".show")
                  ->with("app", $this)
                  ->with("objs", $objs) 
                  ->with("url", $url);

      }

    
      public function create(Obj $obj){
        return view("apps.".$this->app.".".$this->module.".createEdit")
              ->with('stub', "create")
              ->with("app", $this)
              ->with("obj", $obj);         
      }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
       
     public function store(Request $request,Obj $obj){

      $request->validate(['file' => 'required|mimes:pdf,xlx,csv,jpeg,jpg,png,txt,xls,doc,docx,html,htm,odt,pdf,xls,xlsx,ppt,pptx,txt,cpp,']);
 
      if($request->hasFile("file")){
               $opt = $request->input("optimize");
               $file = $request->file('file');
               $extension = $file->getClientOriginalExtension();
               $filename=time().'.'.$extension;
               $user_name = Str::of(Auth::user()->name)->snake();
 
               $types = array(
                 'images' => ['jpeg','gif','png','bmp','jpg'],
                 'css' => ['css'],
                 'js' => ['js'],
                 'documents' => ['doc','docx','html','htm','odt','pdf','xls','xlsx','ppt','pptx','txt'],
               );
 
               foreach($types as $key=>$type){
                   if(in_array($extension, $type)){
                     if($key == 'images'){
                       $file = Image::make($file->getRealPath());
                       // ddd($file);
                       if($opt!=NULL){
                         $file = (string) $file->encode('webp', 75);
                       }
                       else{
                         $file = (string) $file->encode('jpg');
                       }
                     
                     Storage::disk("public")->put($user_name.'/'.$key.'/'.$filename, $file);
                     $obj->create([
                       "title" => $request->input("title"),
                       "description" => $request->input("description"),
                       "file" => $user_name.'/'.$key.'/'.$filename, $file,
                     ]);
                   }
                   else{
                   //$path = $file->store($user_name.'/'.$key);
                   
                    //$file = $file->getRealPath();
                    Storage::disk("public")->put($user_name.'/'.$key, $file);
                    $obj->create([
                      "title" => $request->input("title"),
                      "description" => $request->input("description"),
                      //"file" => $path,
                      "file" => $user_name.'/'.$key.'/'.$filename, $file,
                      ]);
                   }
               } 
             }
            }
       return redirect()->route($this->module.'.index')
                       ->with('success', 'Data Your files has been successfully added');
     }
 
   public function edit($id, Obj $obj)
    {
      // Retrieve Specific record
      $obj = $obj->getRecord($id);

      return view("apps.".$this->app.".".$this->module.".createEdit")
              ->with("stub", "update")
              ->with("app", $this)
              ->with("obj", $obj);
    }

    public function update($id, Request $request)
    {
        // load the resource
        $obj = Obj::where('id',$id)->first();
        // authorize the app
        
        //update the resource
        $obj = $obj->update($request->all());
        return redirect()->route($this->module.'.index'); 
    }
    //download the file
    public function download($id){
        $objs = obj::find($id);
        return response()->download('storage/'.$objs->file);
    }
    // delete files
    public function destroy($id){
  ;
    $obj = Obj::where('id',$id)->first();
    $file = $obj->file;
    Storage::disk('public')->delete($file);
    $obj->delete();
    return redirect()->back();
    }

}
