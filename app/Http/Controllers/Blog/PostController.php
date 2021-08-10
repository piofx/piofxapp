<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Mailer\MailSubscriber;
use App\Models\Blog\Post as Obj;
use App\Models\Blog\Category;
use App\Models\Blog\Tag;
use App\Models\Blog\BlogSettings;
use App\Models\User;
use App\Providers\EventServiceProvider;
use App\Events\UserCreated;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

use Browser;

class PostController extends Controller
{
    /**
     * Define the app and module object variables and component name 
     *
     */
    public function __construct(){
        // load the app, module and component name to object params
        $this->app      =   'Blog';
        $this->module   =   'Post';
        $this->componentName = componentName('agency');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {        
        // default objects
        $obj = new Obj();
        $category = new Category();
        $tag = new Tag();
        $user = new User();
        $blogSettings = new BlogSettings();

        //deletes cache data
        if($request->input('refresh')){
            Cache::forget('posts_'.request()->get('client.id'));
            Cache::forget('featured_'.request()->get('client.id'));
            Cache::forget('popular_'.request()->get('client.id'));
            Cache::forget('categories_'.request()->get('client.id'));
            Cache::forget('tags_'.request()->get('client.id'));
            Cache::forget('blogSettings_'.request()->get('client.id'));

            // Update View Count
            // Retrieve all posts
            $slugs = $obj->where('agency_id', request()->get('agency.id'))->where('client_id', request()->get('client.id'))->get('slug');
            foreach($slugs as $slug){
                $slug = $slug['slug'];
                $postViews = Cache::get('postViews_'.request()->get('client.id').'_'.$slug);
                if($postViews){
                    $obj->where("slug", $slug)->update(["views" => $postViews]);
                }
            }
        }

        // Check if pagination is clicked 
        if(!empty($request->query()['page']) && $request->query()['page'] > 1){
            // Retrieve all posts
            $objs = $obj->where('agency_id', request()->get('agency.id'))->where('client_id', request()->get('client.id'))->with("category")->with("tags")->with("user")->orderBy("id", 'desc')->paginate('5');
        }else{
            $objs = Cache::get('posts_'.request()->get('client.id'));
            if(!$objs){
                // Retrieve all posts
                $objs = $obj->where('agency_id', request()->get('agency.id'))->where('client_id', request()->get('client.id'))->with("category")->with("tags")->with("user")->orderBy("id", 'desc')->paginate('5');
                Cache::forever('posts_'.request()->get('client.id'), $objs);
            }
        }

        // Cached Featured data
        $featured = Cache::get('featured_'.request()->get('client.id'));
        if(!$featured){
            // Retrieve Featured Posts
            $featured = $obj->where('agency_id', request()->get('agency.id'))->where('client_id', request()->get('client.id'))->with('category')->with("user")->where('featured', 'on')->orderBy("id", 'desc')->get();
            // add to cache
            Cache::forever('featured_'.request()->get('client.id'), $featured);
        }

        // cached popular data
        $popular = Cache::get('popular_'.request()->get('client.id'));
        if(!$popular){
            // Retrieve Popular Posts
            $popular = $obj->where('agency_id', request()->get('agency.id'))->where('client_id', request()->get('client.id'))->where('status', '1')->orderBy("views", 'desc')->limit(3)->get();
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
        
        // Check if scheduled date is in the past. if true, change status to  1
        foreach($objs as $obj){
            if(!is_null($obj->published_at)){
                $published_at = Carbon::parse($obj->published_at);
                if($published_at->isPast()){
                    $obj->status = 1;
                    $obj->save();
                }
            }
        }
        
        // change the componentname from admin to client 
        $this->componentName = componentName('client');

        return view("apps.".$this->app.".".$this->module.".homeLayouts.".$settings->home_layout)
                ->with("app", $this)
                ->with("objs", $objs)
                ->with("categories", $categories)
                ->with("tags", $tags)
                ->with("featured", $featured)
                ->with("popular", $popular)
                ->with("settings", $settings);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Obj $obj, Category $category, Tag $tag, Request $request, blogSettings $blogSettings)
    {
        // Authorize the request
        $this->authorize('create', $obj);
        // Retrieve all categories
        $categories = $category->where('agency_id', request()->get('agency.id'))->where('client_id', request()->get('client.id'))->orderBy("name", "asc")->get();
        // Retrieve all tags
        $tags = $tag->where('agency_id', request()->get('agency.id'))->where('client_id', request()->get('client.id'))->orderBy("name", "asc")->get();

        // Retrieve Settings
        $settings = $blogSettings->getSettings();

        $template_name = $request->input("template");

        $template = '';
        if($template_name != 'none'){
            $template = stripslashes(json_decode($settings->$template_name));
        }

        // Get users search console data
        $searchConsoleData = '';
        if(Storage::disk('s3')->exists("searchConsole/consoleData_".request()->get('client.id').".json")){
            $searchConsoleData = json_decode(Storage::disk('s3')->get("searchConsole/consoleData_".request()->get('client.id').".json"), 'true');
        }

        return view("apps.".$this->app.".".$this->module.".createEdit")
                ->with("stub", "create")
                ->with("app", $this)
                ->with("obj", $obj)
                ->with("categories", $categories)
                ->with("tags", $tags)
                ->with("template", $template)
                ->with("searchConsoleData", $searchConsoleData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Obj $obj, Request $request, Tag $tag)
    {
        // Authorize the request
        $this->authorize('create', $obj);

        $validated = $request->validate([
            'title' => 'required|unique:posts',
            'slug' => 'required|unique:posts',
            'content' => 'required|min:50',
        ]);

        // Check status and change it to boolean
        if($request->input("status")){
            if($request->input("status") == "on"){
                $request->request->add(['status' => 1]);
            }
        }
        else{
            $request->request->add(['status' => 0]);
        }
        
        // Check for when to publish
        if(!empty($request->input('published_at'))){
            $published_at = Carbon::parse($request->input('published_at'));
            if($published_at->isPast()){
                $request->merge(["status" => 1]);
            }
        }
        else{
            if($request->input('publish') == "save_as_draft"){
                $request->merge(["status" => 0]);
            } 
            else if($request->input('publish') == "preview"){
                $request->merge(["status" => 0]);
            }  
        }   

        // Check if visibility is private and that group is not empty
        if($request->visibility == "private"){
            if(empty($request->group)){
                $request->merge(["visibility" => "public"]);
            }
        }

        // Change the images from base 64 to jpg and add to request
        $content = blog_image_upload(auth()->user()->id, $request->content);
        $request->merge(["content" => $content]);

        // Store the records
        $obj = $obj->create($request->all() + ['client_id' => request()->get('client.id'), 'agency_id' => request()->get('agency.id'), 'user_id' => auth()->user()->id]);
        
        if($request->input('tag_ids')){
            foreach($request->input('tag_ids') as $tag_id){
                if(is_numeric($tag_id)){
                    if(!$obj->tags->contains($tag_id)){
                        $obj->tags()->attach($tag_id);
                    }
                }
                else{
                    $tag_id = $tag->new_tag($tag_id);
                    $obj->tags()->attach($tag_id);
                }
            }
        }

        // Redirect to show if preview is clicked
        if($request->input('publish') == "preview"){
            return redirect()->route($this->module.'.show', ['slug' =>  $request->input('slug')]);
        }
        
        // Redirect if SEO is refreshed
        if($request->input('publish') == "seoRefresh"){
            return redirect()->route($this->module.'.edit', ['slug' =>  $request->input('slug')]);
        } 

        return redirect()->route($this->module.'.list');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($slug, $blog_url=null)
    {
        if($blog_url != 'direct'){
            $client_settings = json_decode(request()->get('client.settings'));
            if(isset($client_settings->blog_url) && $client_settings->blog_url == 'direct'){
                abort(404,'Page not found');
            }
        }

        $obj = new Obj();
        $category = new Category();
        $tag = new Tag();
        $user = new User();
        $blogSettings = new BlogSettings();
        $request = new Request();
        //deletes cache data
        if($request->input('refresh')){
            Cache::forget('post_'.request()->get('client.id').'_'.$slug);
            Cache::forget('categories_'.request()->get('client.id'));
            Cache::forget('tags_'.request()->get('client.id'));
            Cache::forget('author_'.request()->get('client.id').'_'.$slug);
            Cache::forget('blogSettings_'.request()->get('client.id'));
            Cache::forget('popular_'.request()->get('client.id'));
            Cache::forget('related_'.request()->get('client.id').'_'.$slug);
            Cache::forget('postCategory_'.request()->get('client.id').'_'.$slug);
            Cache::forget('postTags_'.request()->get('client.id').'_'.$slug);

            // Update View Count
            $postViews = Cache::get('postViews_'.request()->get('client.id').'_'.$slug);
            $obj->where("slug", $slug)->update(["views" => $postViews]);
            Cache::forget('postViews_'.request()->get('client.id').'_'.$slug);
        }
        
        // Update post Views
        $postViews = Cache::get('postViews_'.request()->get('client.id').'_'.$slug);
        Cache::forever('postViews_'.request()->get('client.id').'_'.$slug, $postViews+1);
        $postViews = Cache::get('postViews_'.request()->get('client.id').'_'.$slug);

        // Cached Post Data
        $post = Cache::get('post_'.request()->get('client.id').'_'.$slug);
        if(!$post){
            // Retrieve specific record views
            $post = $obj->where("slug", $slug)->first();
            // Retrieving post views
            $postViews = $post->views;
            // Update View Count
            $obj->where("slug", $slug)->update(["views" => $postViews+1]);
            // Retrieve specific Record
            $post = $obj->where("slug", $slug)->with('category')->with('tags')->first();
            // Retrieving post views
            $postViews = $post->views;

            // Add tp cache
            Cache::forever('post_'.request()->get('client.id').'_'.$slug, $post);
            Cache::forever('postViews_'.request()->get('client.id').'_'.$slug, $postViews);
        }

        // Cached categories data
        $categories = Cache::get('categories_'.request()->get('client.id'));
        if(!$categories){
            // Retrieve all categories
            $categories = $category->where('agency_id', request()->get('agency.id'))->where('client_id', request()->get('client.id'))->orderBy("name", "asc")->get();
            // Add to cache 
            Cache::forever('categories_'.request()->get('client.id'), $categories);
        }

        // Cached tags data
        $tags = Cache::get('tags_'.request()->get('client.id'));
        if(!$tags){
            //  Retrieve all tags
            $tags = $tag->where('agency_id', request()->get('agency.id'))->where('client_id', request()->get('client.id'))->orderBy("name", "asc")->get();
            // Add to cache
            Cache::forever('tags_'.request()->get('client.id'), $tags);
        }

        // Cached author data
        $author = Cache::get('author_'.request()->get('client.id').'_'.$slug);
        if(!$author){
            // Retrieve Author data
            $author = $user->where("id", $post->user_id)->first();
            // add to cache
            Cache::forever('author_'.request()->get('client.id').'_'.$slug, $author);
        }

        // cached settings data
        $settings = Cache::get('blogSettings_'.request()->get('client.id'));
        if(!$settings){
            // Retrieve Settings
            $settings = $blogSettings->getSettings();
            // add to cache
            Cache::forever('blogSettings_'.request()->get('client.id'), $settings);
        }

        // cached popular data
        $popular = Cache::get('popular_'.request()->get('client.id'));
        if(!$popular){
            // Retrieve Popular Posts
            $popular = $obj->where('agency_id', request()->get('agency.id'))->where('client_id', request()->get('client.id'))->where('status', '1')->orderBy("views", 'desc')->limit(3)->get();
            // add to cache
            Cache::forever('popular_'.request()->get('client.id'), $popular);
        }

        // cached related data
        $related = Cache::get('related_'.request()->get('client.id').'_'.$slug);
        if(!$related){
            // Retrieve related posts
            if(!empty($post->category) && $post->category->posts->count() > 0){
                $related = $post->category->posts->where('status', '1')->take(3);
            }
            // add to cache
            Cache::forever('related_'.request()->get('client.id').'_'.$slug, $related);
        }

        // cached postCategory data
        $postCategory = Cache::get('postCategory_'.request()->get('client.id').'_'.$slug);
        if(!$postCategory){
            // Retrieve category of the post
            $postCategory = $post->category;
            // add to cache
            Cache::forever('postCategory_'.request()->get('client.id').'_'.$slug, $postCategory);
        }

        // cached postTags data
        $postTags = Cache::get('postTags_'.request()->get('client.id').'_'.$slug);
        if(!$postTags){
            // Get tags related to the post
            $postTags = $post->tags;
            // add to cache
            Cache::forever('postTags_'.request()->get('client.id').'_'.$slug, $postTags);
        }

        // reassigning post variable
        $obj = $post;

        // Check if scheduled date is in the past. if true, change status to 1
        if(!empty($obj->published_at)){
            $published_at = Carbon::parse($obj->published_at);
            if($published_at->isPast()){
                $obj->status = 1;
                $obj->save();
            }
        }
    
        // Check if post status is inactive and user is not authenticated ot if role is user then redirect to homepage
        // Useful if post is accessed through link
        if($obj->status == 0){
            if(!(auth()->user()) || auth()->user()->role == "user"){
                return redirect()->route($this->module.'.index');
            }
        }

        // change the componentname from admin to client 
        $this->componentName = componentName('client');

        return view("apps.".$this->app.".".$this->module.".show")
                ->with("app", $this)
                ->with("tags", $tags)
                ->with("settings", $settings)
                ->with("author", $author)
                ->with("popular", $popular)
                ->with("related", $related)
                ->with("postCategory", $postCategory)
                ->with("postTags", $postTags)
                ->with("obj", $obj);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blog\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($slug, Obj $obj, Category $category, Tag $tag)
    {
        // Retrieve Specific record
        $obj = $obj->where('agency_id', request()->get('agency.id'))->where('client_id', request()->get('client.id'))->where("slug", $slug)->first();
        // Authorize the request
        $this->authorize('edit', $obj);
        // Retrieve all categories
        $categories = $category->where('agency_id', request()->get('agency.id'))->where('client_id', request()->get('client.id'))->get();
        // Retrieve all tags
        $tags = $tag->where('agency_id', request()->get('agency.id'))->where('client_id', request()->get('client.id'))->get();

        // Get users search console data
        $searchConsoleData = '';
        if(Storage::disk('s3')->exists("searchConsole/consoleData_".request()->get('client.id').".json")){
            $searchConsoleData = json_decode(Storage::disk('s3')->get("searchConsole/consoleData_".request()->get('client.id').".json"), 'true');
        }

        return view("apps.".$this->app.".".$this->module.".createEdit")
                ->with("stub", "update")
                ->with("app", $this)
                ->with("obj", $obj)
                ->with("categories", $categories)
                ->with("tags", $tags)
                ->with("searchConsoleData", $searchConsoleData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blog\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Obj $obj, $id, Tag $tag)
    {
        // load the resource
        $obj = Obj::where('id',$id)->first();
        // authorize the app
        $this->authorize('update', $obj);

        if(!$request->input('featured')){
            $request->request->add(['featured' => null]);
        }

        // Check status and change it to boolean
        if($request->input("status")){
            if($request->input("status") == "on"){
                $request->request->add(['status' => 1]);
            }
        }
        else{
            $request->request->add(['status' => 0]);
        }

        // Check for when to publish
        if(!empty($request->input('published_at'))){
            $published_at = Carbon::parse($request->input('published_at'));
            if($published_at->isPast()){
                $request->merge(["status" => 1]);
            }
        }
        else{
            if($request->input('publish') == "save_as_draft"){
                ddd('here');
                $request->merge(["status" => 0]);
            } 
            else if($request->input('publish') == "preview"){
                $request->merge(["status" => 0]);
            }  
        }   
        
        // Check if visibility is private and group is not empty
        if($request->visibility == "private"){
            if(empty($request->group)){
                $request->merge(["visibility" => "public"]);
            }
        }

        // Change the images from base 64 to jpg and add to request
        $content = blog_image_upload(auth()->user()->id, $request->content);
        $request->merge(["content" => $content]);

        // Delete Images from inside of the post if they are not in the update
        $dom1 = new \DomDocument();
        libxml_use_internal_errors(true);
        $dom1->loadHtml(mb_convert_encoding($obj->content, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);    
        $database_images = $dom1->getElementsByTagName('img');

        $dom2 = new \DomDocument();
        libxml_use_internal_errors(true);
        $dom2->loadHtml(mb_convert_encoding($request->content, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);    
        $request_images = $dom2->getElementsByTagName('img');

        $database_srcs = array();
        $request_srcs = array();

        foreach($database_images as $img){
            array_push($database_srcs, $img->getAttribute('src'));           
        }

        foreach($request_images as $img){
            array_push($request_srcs, $img->getAttribute('src'));           
        }

        foreach($database_srcs as $src){
            if(!in_array($src, $request_srcs)){
                $path = parse_url($src, PHP_URL_PATH);
                Storage::disk("s3")->delete($path); 
            }
        }

        // Check and delete featured image from storage if it is changed
        if(!($request->image == $obj->image)){
            Storage::disk("s3")->delete($obj->image);

            // Delete resized images if exists
            $filename = explode(".jpg", $obj->name);
            $filename = $filename[0]; 
            if(Storage::disk('s3')->exists('resized_images/'.$filename.'_resized.jpg')){
                Storage::disk("s3")->delete('resized_images/'.$filename.'_resized.jpg');
            }
            if(Storage::disk('s3')->exists('resized_images/'.$filename.'mobile.jpg')){
                Storage::disk("s3")->delete('resized_images/'.$filename.'mobile.jpg');
            }
        }

        //update the resource
        $obj->update($request->all() + ['client_id' => request()->get('client.id'), 'agency_id' => request()->get('agency.id'), 'user_id' => auth()->user()->id]);

        $obj->tags()->detach();

        if($request->input('tag_ids')){
            foreach($request->input('tag_ids') as $tag_id){
                if(is_numeric($tag_id)){
                    if(!$obj->tags->contains($tag_id)){
                        $obj->tags()->attach($tag_id);
                    }
                }
                else{
                    $tag_id = $tag->new_tag($tag_id);
                    $obj->tags()->attach($tag_id);
                }
            }
        }

        // Redirect to show if preview is clicked
        if($request->input('publish') == "preview"){
            return redirect()->route($this->module.'.show', ['slug' =>  $request->input('slug')]);
        }

        // Redirect if SEO is refreshed
        if($request->input('publish') == "seoRefresh"){
            return redirect()->route($this->module.'.edit', ['slug' =>  $request->input('slug')]);
        } 
        
        return redirect()->route($this->module.'.list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        // load the resource
        $obj = Obj::where('id',$id)->first();
        $featured_image = $obj->image;

        // Delete Images from inside of the post
        $dom = new \DomDocument();
        libxml_use_internal_errors(true);
        $dom->loadHtml(mb_convert_encoding($obj->content, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);    
        $images = $dom->getElementsByTagName('img');

        foreach($images as $k => $img){

            $data = $img->getAttribute('src');
            $path = parse_url($data, PHP_URL_PATH);

            $path = explode("/storage/", $path);
            if(Storage::disk("s3")->exists($path[0])){
                Storage::disk("s3")->delete($path[0]);            
            }
        }
        
        // Check and delete image from storage
        if(!is_null($featured_image)){
            Storage::disk("s3")->delete($featured_image);
        }
        // authorize
        $this->authorize('delete', $obj);
        // delete the resource
        $obj->delete();

        return redirect()->route($this->module.'.list');
    }

    // Search for blog posts
    public function search(Obj $obj, Request $request, BlogSettings $blogSettings){
        // Get the search query
        $query = $request->query()['query'];

        if(request()->get('refresh')){
            Cache::forget('blogSettings_'.request()->get('client.id'));
        }

        // Cached Data
        $settings = Cache::get('blogSettings_'.request()->get('client.id'));

        if(!$settings){
            // Retrieve Settings
            $settings = $blogSettings->getSettings();

            Cache::forever('blogSettings_'.request()->get('client.id'), $settings);
        }

        // Retrieve ids of all posts which match title with the query string
        $title_ids = $obj->where('agency_id', request()->get('agency.id'))->where('client_id', request()->get('client.id'))->where("title", "LIKE", "%".$query."%")->get("id")->pluck("id")->toArray();
        // Retrieve ids of all posts which match category name with the query string
        $category_ids = Category::where('agency_id', request()->get('agency.id'))->where('client_id', request()->get('client.id'))->where("name", "LIKE", "%".$query."%")->get("id")->pluck("id")->toArray();
        $category_ids = Obj::whereIn("category_id", $category_ids)->get("id")->pluck("id")->toArray();
        // Retrieve ids of all posts which match tag name with the query string
        $tag_ids = Tag::where('agency_id', request()->get('agency.id'))->where('client_id', request()->get('client.id'))->where("name", "LIKE", "%".$query."%")->get("id")->pluck("id")->toArray();
        $tag_ids = Obj::whereIn("category_id", $tag_ids)->get("id")->pluck("id")->toArray();
        
        // Remove duplicates from the ids list and create a new array
        $post_ids = array_unique(array_merge($title_ids,$category_ids, $tag_ids), SORT_REGULAR);
        // Retrieve posts which match the given title query
        $objs = $obj->whereIn("id", $post_ids)->where('status', 1)->with('category')->with('tags')->paginate(6);

        // change the componentname from admin to client 
        $this->componentName = componentName('client');

        return view("apps.".$this->app.".".$this->module.".search")
                ->with("app", $this)
                ->with("objs", $objs)
                ->with("settings", $settings);
    }

    // List all Posts
    public function list(Request $request, blogSettings $blogSettings){
        //default obj
        $obj = new Obj();
        // If search query exists
        $query = $request->input('query');
        
        // Retrieve all records
        $objs = $obj->where('agency_id', auth()->user()->agency_id)->where('client_id', auth()->user()->client_id)->where("title", "LIKE", "%".$query."%")->with('category')->with('tags')->orderBy("id", 'desc')->paginate(10);
        
        // Check if scheduled date is in the past. if true, change status to  1
        foreach($objs as $obj){
            if(!is_null($obj->published_at)){
                $published_at = Carbon::parse($obj->published_at);
                if($published_at->isPast()){
                    $obj->status = 1;
                    $obj->save();
                }
            }
        }

        // Retrieve Settings
        $settings = $blogSettings->getSettings();

        $templates = array();

        foreach($settings as $key=>$setting){
            $template = explode("_", $key);
            if($template[0] == 'template'){
                array_push($templates, $key);
            }
        }

        return view("apps.".$this->app.".".$this->module.".posts")
                ->with("app", $this)
                ->with("objs", $objs)
                ->with("templates", $templates);    
    }

    // List out all posts by a author
    public function author(Obj $obj, $id, User $user, BlogSettings $blogSettings, Request $request){
        // delete cache data
        if(!empty($request->query()['refresh']) && $request->query()['refresh']){
            Cache::forget('authorPosts_'.request()->get('client.id').'_'.$id);
            Cache::forget('blogSettings_'.request()->get('client.id'));
        }

        // Check if pagination is clicked 
        if(!empty($request->query()['page']) && $request->query()['page'] > 1){
            // Retrieve all records
            $objs = $obj->where('agency_id', request()->get('agency.id'))->where('client_id', request()->get('client.id'))->where("user_id", $id)->with('category')->with('tags')->orderBy("id", 'desc')->paginate('12');

            Cache::forever('authorPosts_'.request()->get('client.id').'_'.$id, $objs);
        }else{
            $objs = Cache::get('authorPosts_'.request()->get('client.id')."_".$id);
            if(!$objs){
                // Retrieve all records
                $objs = $obj->where('agency_id', request()->get('agency.id'))->where('client_id', request()->get('client.id'))->where("user_id", $id)->with('category')->with('tags')->orderBy("id", 'desc')->paginate('12');

                Cache::forever('authorPosts_'.request()->get('client.id').'_'.$id, $objs);
            }
        }

        // Cached Author Data
        $author = Cache::get('author_'.request()->get('client.id').'_'.$id);
        if(!$author){
            // Get author data
            $author = $user->where("id", $id)->first();
            // add to cache
            Cache::forever('author_'.request()->get('client.id').'_'.$id, $author);
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

        return view("apps.".$this->app.".".$this->module.".author")
                ->with("app", $this)
                ->with("author", $author)
                ->with("objs", $objs)
                ->with("settings", $settings);    
    }


    // Api to retrieve popular post
    public function popularPost(Request $request){
        // Initialize Object
        $obj = new Obj();

        // Retrieve the post
        $post = $obj->where('agency_id', request()->get('agency.id'))->where('client_id', request()->get('client.id'))->orderBy("views", "desc")->limit('1')->where('status', '1')->get();

        if(!empty($post)){
            return response()->json($post, "200");
        }
        else{
            return response()->json(["Error" => "No post found"], 404);
        }
    }

    public function subscribe(Obj $obj, Request $request){
        $validate_email = debounce_valid_email($request->email);
        $request->merge(['agency_id'=>request()->get('agency.id')])->merge(['client_id'=>request()->get('client.id')])->merge(['app'=>$this->app])->merge(['info'=>$request->name])->merge(['valid_email'=>$validate_email])->merge(['status'=> 1 ]);
        
        $obj = MailSubscriber::create($request->all());

        event(new UserCreated($obj,$request));

        return redirect()->route($this->module.'.index');
    }

    // Miscellenious
    public function addContent(Obj $obj){
        $objs = $obj->get();
        foreach($objs as $obj){
            $body = $obj->body;
            $conclusion = $obj->conclusion;

            if(!empty($obj->test)){
                $test = '<div class=“my-4”>
                            <div class="test-container ' . $obj->test . '" data-container="' . $obj->test . '" ></div>
                        </div>';
                $content = $body . " " .$test . " " . $conclusion;
            }
            else{
                $content = $body . " " . $conclusion;
            }            

            $obj->update(["content" => $content]);
        }
    }
    
    // public function searchConsole(Request $request){
    //     $fromDate = date('Y-m-d', strtotime('-3 months'));
    //     $toDate = date('Y-m-d', strtotime('-1 day'));

    //     $client_id = '611622056329-a9sc8cab7etimqqr0uhuvi1ou0a0m25s.apps.googleusercontent.com';
    //     $client_secret = '4pJ9Si64HP-4wEF5CIqAFpxy';
    //     $redirect_uri = 'http://localhost:8000/admin/blog/searchConsole';

    //     $client = new Google_Client();
    //     $client->setClientId($client_id);
    //     $client->setClientSecret($client_secret);
    //     $client->setRedirectUri($redirect_uri);
    //     $client->addScope("https://www.googleapis.com/auth/webmasters");

    //     $client->setAccessType('offline');
    //     $client->setIncludeGrantedScopes(true);   

    //     if($request->input("code")){
    //         $authCode = $request->input('code');
    //         // Exchange authorization code for an access token.
    //         $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);

    //         // Check to see if there was an error.
    //         if (array_key_exists('error', $accessToken)) {
    //             throw new Exception(join(', ', $accessToken));
    //         }

    //         $request->session()->put('searchConsoleToken', $accessToken);
    //     }
        
    //     if ($request->session()->has('searchConsoleToken')) {
    //         $accessToken = $request->session()->get('searchConsoleToken');
    //         $client->setAccessToken($accessToken);
    //     }
    //     else{
    //         // Refresh the token if possible, else fetch a new one.
    //         if ($client->getRefreshToken()) {
    //             $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
    //         } else {
    //             // Request authorization from the user.
    //             $authUrl = $client->createAuthUrl();
                
    //             header("Location: ". $authUrl);
    //         }
    //     }

    //     if ($client->getAccessToken()) {

    //         $obj = new \Google_Service_Webmasters_SearchAnalyticsQueryRequest();

    //         $obj->setStartDate($fromDate);
    //         $obj->setEndDate($toDate);

    //         $obj->setDimensions(['query']);
    //         // $obj->setSearchType('web');
    //         try {
    //             $service = new Google_Service_Webmasters($client);
    //             $queryData = $service->searchanalytics->query('https://packetprep.com', $obj);
    //         } 
    //         catch(\Exception $e ) {
    //             echo $e->getMessage();
    //         }  

    //         $obj->setDimensions(['page']);
    //         // $obj->setSearchType('web');
    //         try {
    //             $service = new Google_Service_Webmasters($client);
    //             $pageData = $service->searchanalytics->query('https://packetprep.com', $obj);
    //         } 
    //         catch(\Exception $e ) {
    //             echo $e->getMessage();
    //         }  

    //         return view("apps.".$this->app.".".$this->module.".searchConsole")
    //                     ->with("app", $this)
    //                     ->with("queryData", $queryData)
    //                     ->with("pageData", $pageData);
    //     }
    // }

    
}

