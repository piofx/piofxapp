<?php

namespace App\Http\Controllers\Blog;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DB;

use App\Models\Blog\Category as Obj;
use App\Models\Blog\Post;
use App\Models\Blog\Tag;
use App\Models\Blog\BlogSettings;

use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{
    /**
     * Define the app and module object variables and component name 
     *
     */
    public function __construct(){
      // load the app, module and component name to object params
      $this->app      =   'Blog';
      $this->module   =   'Category';
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

    public function show($slug, Obj $obj, Post $post, Tag $tag, BlogSettings $blogSettings, Request $request)
    {    
        //deletes cache data
        if($request->input('refresh')){
          Cache::forget('categoryPosts_'.request()->get('client.id')."_".$slug);
          Cache::forget('category_'.request()->get('client.id')."_".$slug);
          Cache::forget('featured_'.request()->get('client.id'));
          Cache::forget('popular_'.request()->get('client.id'));
          Cache::forget('categories_'.request()->get('client.id'));
          Cache::forget('tags_'.request()->get('client.id'));
          Cache::forget('blogSettings_'.request()->get('client.id'));
        }

		// Retrieve specific Record based on slug
		$category = Cache::get("category_".request()->get('client.id')."_".$slug);
        //ddd($category);
		if(!$category){
            //$category = $obj->where('agency_id', request()->get('agency.id'))->where('client_id', request()->get('client.id'))->get();
			$category = $obj->where('agency_id', request()->get('agency.id'))->where('client_id', request()->get('client.id'))->where("slug", $slug)->first();
            //ddd($category);
			Cache::forever('category_'.request()->get('client.id')."_".$slug, $category);
            //ddd($category);
		}

        // Check if pagination is clicked 
        if(!empty($request->query()['page']) && $request->query()['page'] > 1){
            // Retrieve all posts
            $posts = $post->where('agency_id', request()->get('agency.id'))->where('client_id', request()->get('client.id'))->with("category")->with("tags")->where("category_id", $category->id)->orderBy("id", 'desc')->paginate(5);
            
        }else{
            $posts = Cache::get('categoryPosts_'.request()->get('client.id')."_".$slug);
            if(!$posts){
                // Retrieve all posts 
                $posts = $post->where('agency_id', request()->get('agency.id'))->where('client_id', request()->get('client.id'))->with("category")->with("tags")->where("category_id", $category->id)->orderBy("id", 'desc')->paginate(5);
               
                Cache::forever('categoryPosts_'.request()->get('client.id')."_".$slug, $posts);
            }
        }

		// Cached categories Data
        $objs = Cache::get('categories_'.request()->get('client.id'));
        if(!$objs){
            // Retrieve all categories
			$objs = $obj->where('agency_id', request()->get('agency.id'))->where('client_id', request()->get('client.id'))->with('posts')->paginate('10');
            // add to cache
            Cache::forever('categories_'.request()->get('client.id'), $objs);
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

        // Cached tags data
        $tags = Cache::get('tags_'.request()->get('client.id'));
        if(!$tags){
            //  Retrieve all tags
            $tags = $tag->where('agency_id', request()->get('agency.id'))->where('client_id', request()->get('client.id'))->orderBy("name", "asc")->get();
            // Add to cache
            Cache::forever('tags_'.request()->get('client.id'), $tags);
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
              ->with("category", $category)
              ->with("posts", $posts)
              ->with("tags", $tags)
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
        $obj = $obj->update($request->all() + ['client_id' => request()->get('client.id'), 'agency_id' => request()->get('agency.id'), 'user_id' => auth()->user()->id]);
        return redirect()->route($this->module.'.index'); 
    }
    
     public function destroy($id)
     {
        // load the resource
        $obj = Obj::where('id',$id)->first();
        $img = $obj->image;

        // Check and delete image from storage
        if(!is_null($img)){
            Storage::delete($img_name);
        }
        // authorize
        $this->authorize('delete', $obj);
        // delete the resource
        $obj->delete();

        return redirect()->route($this->module.'.index');

    }

}


