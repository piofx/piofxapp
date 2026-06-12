<?php

namespace App\Http\Controllers\Template;

use App\Http\Controllers\Controller;
use App\Models\Template\Template;
use App\Models\Template\TemplateCategory;
use App\Models\Template\TemplateTag;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Template\Template as Obj;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class TemplateController extends Controller
{
    public function __construct(){
        // load the app, module and component name to object params
        $this->app      =   'Template';
        $this->module   =   'Template';
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
        $query = $request->input('query');
        
        $objs = $obj->where("name", "LIKE", "%".$query."%")->orderBy('name', 'asc')->paginate(10); 
        $tags = TemplateTag::all();
        $categories = TemplateCategory::all();
        
        // authorize the app
        $this->authorize('view', $obj);
        
        return view('apps.'.$this->app.'.'.$this->module.'.index')
                ->with('app',$this)
                ->with('objs',$objs)
                ->with('tags',$tags)
                ->with('categories',$categories);
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

        $tags = TemplateTag::all();
        $categories = TemplateCategory::all();
    
        return view('apps.'.$this->app.'.'.$this->module.'.createedit')
                ->with('stub','create')
                ->with('obj',$obj)
                ->with('app',$this)
                ->with('tags',$tags)
                ->with('categories',$categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Obj $obj,Request $request,TemplateTag $tag)
    {   
        //Validating the fields
        $request->validate([
        'name' => 'required|max:255',
        'slug' => 'required',   
         ]);

        $obj = $obj->create($request->all());

        if($request->input('tag_ids')){
            foreach($request->input('tag_ids') as $tag_id){
                if(is_numeric($tag_id)){
                    if(!$obj->template_tags->contains($tag_id)){
                        $obj->template_tags()->attach($tag_id);
                    }
                }
                else{
                    // ddd("here");
                    $tag_id = $tag->new_tag($tag_id);
                    $obj->template_tags()->attach($tag_id);
                }
            }
        }
        
        $tags = TemplateTag::all();
        $categories = TemplateCategory::all();

        $alert = 'A new ('.$this->app.'/'.$this->module.') item is created!';
        return redirect()->route($this->module.'.index')
                            ->with('alert',$alert)
                            ->with('tags',$tags)
                            ->with('categories',$categories);
        
        
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {    
        // load the resource
        $obj = Obj::where('slug',$slug)->first();
        $template = Template::all();
        $tags = TemplateTag::all();
        $categories = TemplateCategory::all();
        // authorize the app
        $this->authorize('edit', $obj);

        if($obj)
            return view('apps.'.$this->app.'.'.$this->module.'.createedit')
                ->with('stub','Update')
                ->with('obj',$obj)
                ->with('tempalte',$template)
                ->with('app',$this)
                ->with('tags',$tags)
                ->with('categories',$categories);
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
    public function update(Request $request, $slug, TemplateTag $tag)
    {
        // load the resource
        $obj = Obj::where('slug',$slug)->first();

        // authorize the app
        $this->authorize('update', $obj);

        //update the resource
        $obj->update($request->all());

        $obj->template_tags()->detach();
        //ddd($obj->template_tags);
        if($request->input('tag_ids')){
            foreach($request->input('tag_ids') as $tag_id){
                if(is_numeric($tag_id)){
                    if(!$obj->template_tags->contains($tag_id)){
                        $obj->template_tags()->attach($tag_id);
                    }
                }
                else{
                     $tag_id = $tag->new_tag($tag_id);
                     $obj->template_tags()->attach($tag_id);
                }
            }
        }

        //ddd($obj->template_category_id);
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
        // load the resource
        $obj = Obj::where('id',$id)->first();
        // authorize the app
        $this->authorize('delete', $obj);
        // delete the resource
        $obj->delete();

        // flash message and redirect to controller index page
        $alert = '('.$this->app.'/'.$this->module.'/'.$id.') item  Successfully deleted!';
        return redirect()->route($this->module.'.index')->with('alert',$alert);
    }

    public function public_index(Request $request ,Obj $obj, TemplateTag $templateTag)
    {
        // change the componentname from admin to client 
        $this->componentName = componentName('client');
        
        if(!is_null($request->tag_id)){   
            $obj = $templateTag->where('id',$request->tag_id)->first();
            
            $objs = $obj->templates()->paginate(10);
        
            $tags = TemplateTag::all();
            $categories = TemplateCategory::all();
            return view('apps.'.$this->app.'.'.$this->module.'.public_index')
                ->with('app',$this)->with('objs',$objs)
                ->with('tags',$tags)->with('categories',$categories);
        }
        elseif(!is_null($request->category_id)){
            $objs = $obj->where('template_category_id',$request->category_id)->paginate(10);
            $tags = TemplateTag::all();
            $categories = TemplateCategory::all();

            // Retrieve Category 
            $category = TemplateCategory::where("id", $request->category_id)->first();

            return view('apps.'.$this->app.'.'.$this->module.'.public_index')
                ->with('app',$this)->with('objs',$objs)
                ->with('tags',$tags)->with('categories',$categories)->with("category", $category);
        }
        else{
            $objs = $obj->paginate(10);
            $tags = TemplateTag::all();
            $categories = TemplateCategory::all();
            
            return view('apps.'.$this->app.'.'.$this->module.'.public_index')
                    ->with('app',$this)->with('objs',$objs)
                    ->with('tags',$tags)->with('categories',$categories);
        }
    }

    public function search(Obj $obj, Request $request){
        // Get the search query
        $query = $request->input("query");
 
        // Retrieve posts which match the given title query
        $objs = $obj->where("name", "LIKE", "%".$query."%")->where('status', 1)->paginate(5);
        
        $tags = TemplateTag::all();
        $categories = TemplateCategory::all();

        // change the componentname from admin to client 
        $this->componentName = componentName('client');
      
        return view('apps.'.$this->app.'.'.$this->module.'.public_index')
                ->with('app',$this)
                ->with('tags',$tags)
                ->with('categories',$categories)
                ->with('objs',$objs);
    }

    public function public_show(Request $request , $slug , Obj $obj, TemplateTag $templateTag){
        
        $obj = $obj->where('slug',$slug)->first();
       
        $screen_shots = json_decode($obj->screens);
       
        // change the componentname from admin to client 
        $this->componentName = componentName('client');

       
        return view('apps.'.$this->app.'.'.$this->module.'.public_show')
            ->with('app',$this)
            ->with('obj',$obj)
            ->with('screen_shots',$screen_shots);
    }
}
