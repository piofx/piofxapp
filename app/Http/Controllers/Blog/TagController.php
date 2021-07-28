<?php

namespace App\Http\Controllers\Blog;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Blog\Tag as Obj;
use App\Models\Blog\Post;
use App\Models\Blog\Category;
use App\Models\Blog\BlogSettings;

use Illuminate\Support\Facades\Cache;

class TagController extends Controller
{
    
    /**
     * Define the app and module object variables and component name 
     *
     */
    public function __construct(){
        // load the app, module and component name to object params
        $this->app      =   'Blog';
        $this->module   =   'Tag';
        $this->componentName = componentName('agency');
    }
    
    public function index(Obj $obj, Request $request)
    {
        // If search query exists
        $query = $request->input('query');
        // Authorize the request
        $this->authorize('view', $obj);
        // Retrieve all records
        $objs = $obj->where('agency_id', request()->get('agency.id'))->where('client_id', request()->get('client.id'))->where("name", "LIKE", "%".$query."%")->orderBy("name", 'asc')->paginate(10);

        return view("apps.".$this->app.".".$this->module.".index")
                ->with("app", $this)
                ->with("objs", $objs);    
    }

    public function show($slug, Obj $obj, Post $post, Category $category, BlogSettings $blogSettings, Request $request)
    {    
        //deletes cache data
        if($request->input('refresh')){
          Cache::forget('tagPosts_'.request()->get('client.id')."_".$slug);
          Cache::forget('tag_'.request()->get('client.id')."_".$slug);
          Cache::forget('featured_'.request()->get('client.id'));
          Cache::forget('popular_'.request()->get('client.id'));
          Cache::forget('categories_'.request()->get('client.id'));
          Cache::forget('tags_'.request()->get('client.id'));
          Cache::forget('blogSettings_'.request()->get('client.id'));
        }

		// Retrieve specific Record based on slug
		$tag = Cache::get("tag_".request()->get('client.id')."_".$slug);
		if(!$tag){
            // Retrieve specific Record based on slug
            $tag = $obj->where('agency_id', request()->get('agency.id'))->where('client_id', request()->get('client.id'))->where("slug", $slug)->first();
			Cache::forever('tag_'.request()->get('client.id')."_".$slug, $tag);
		}

        // Check if pagination is clicked 
        if(!empty($request->query()['page']) && $request->query()['page'] > 1){
            // Retrieve records for that particular tag
            $posts = $tag->posts()->with('category')->with('tags')->paginate(5);
        }else{
            $posts = Cache::get('tagPosts_'.request()->get('client.id')."_".$slug);
            if(!$posts){
                // Retrieve all posts
                $posts = $tag->posts()->with('category')->with('tags')->paginate(5);
                Cache::forever('tagPosts_'.request()->get('client.id')."_".$slug, $posts);
            }
        }

		// Cached Tags Data
        $objs = Cache::get('tags_'.request()->get('client.id'));
        if(!$objs){
            // Retrieve all tags
            $objs = $obj->where('agency_id', request()->get('agency.id'))->where('client_id', request()->get('client.id'))->get();
            // add to cache
            Cache::forever('tags_'.request()->get('client.id'), $objs);
        }

        // Cached Featured data
        $featured = Cache::get('featured_'.request()->get('client.id'));
        if(!$featured){
            // Retrieve Featured Posts
            $featured = $post->where('agency_id', request()->get('agency.id'))->where('client_id', request()->get('client.id'))->with('category')->with("user")->where('featured', 'on')->orderBy("id", 'desc')->get();
            // add to cache
            Cache::forever('featured_'.request()->get('client.id'), $featured);
        }

        // cached popular data
        $popular = Cache::get('popular_'.request()->get('client.id'));
        if(!$popular){
            // Retrieve Popular Posts
            $popular = $post->where('agency_id', request()->get('agency.id'))->where('client_id', request()->get('client.id'))->orderBy("views", 'desc')->limit(3)->get();
            // add to cache
            Cache::forever('popular_'.request()->get('client.id'), $popular);
        }

        // Cached categories data
        $categories = Cache::get('categories_'.request()->get('client.id'));
        if(!$categories){
            // Retrieve all categories
            $categories = $category->where('agency_id', request()->get('agency.id'))->where('client_id', request()->get('client.id'))->orderBy("name", "asc")->get();
            // Add to cache 
            Cache::forever('categories_'.request()->get('client.id'), $categories);
        }

        // cached settings data
        $settings = Cache::get('blogSettings_'.request()->get('client.id'));
        if(!$settings){
            // Retrieve Settings
            $settings = $blogSettings->getSettings();
            // add to cache
            Cache::forever('blogSettings_'.request()->get('client.id'), $settings);
        }
                        
        // change the componentname from admin to client 
        $this->componentName = componentName('client');

        return view("apps.".$this->app.".".$this->module.".show")
                ->with("app", $this)
                ->with("objs", $objs)
                ->with("tag", $tag->name)
                ->with("posts", $posts)
                ->with("categories", $categories)
                ->with("featured", $featured)
                ->with("popular", $popular)
                ->with("settings", $settings);
    }

    public function create(Obj $obj)
    {
        // authorize the app
        $this->authorize('create', $obj);

        return view("apps.".$this->app.".".$this->module.".createEdit")
                ->with('stub', "create")
                ->with("app", $this)
                ->with("obj", $obj);
    }

    public function store(Request $request, Obj $obj)
    {
        // Authorize the request
        $this->authorize('create', $obj);
        // Store the records
        $obj = $obj->create($request->all() + ['client_id' => request()->get('client.id'), 'agency_id' => request()->get('agency.id'), 'user_id' => auth()->user()->id]);

        return redirect()->route($this->module.'.index');
    }

    public function edit($slug, Obj $obj)
    {
        // Retrieve Specific record
        $obj = $obj->where('agency_id', request()->get('agency.id'))->where('client_id', request()->get('client.id'))->where("slug", $slug)->first();

        // Authorize the request
        $this->authorize('edit', $obj);

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
        $this->authorize('update', $obj);
        //update the resource
        $obj = $obj->update($request->all());

        return redirect()->route($this->module.'.index'); 
    }
    
    public function destroy($id)
    {
        // load the resource
        $obj = Obj::where('id',$id)->first();
        // authorize
        $this->authorize('delete', $obj);
        // delete the resource
        $obj->delete();

        return redirect()->route($this->module.'.index');
    }

}
