<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Blog\Category;
use App\Models\Blog\Tag;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Support\Facades\Cache;

class Post extends Model
{
    use HasFactory, Sortable;

    // The attributes that are mass assignable
	protected $fillable = ["user_id", "client_id", "title", "slug", "top_head", "category_id", "tag_id","agency_id", "image", "featured", "excerpt", "content", "visibility", "group", "views", "meta_title", "meta_description", "status", "published_at","top_head","link","link_title","image_post_hide"];
	
	public $sortable = ["id", "title", "created_at"];
    
    /**
	 * Get the user that owns the page.
	 *
	 */
	public function user()
	{
	    return $this->belongsTo(User::class);
	}
    
    /**
	 * Get the client that owns the page.
	 *
	 */
	public function category()
	{
	    return $this->belongsTo(Category::class);
	}

	/**
     * The tags that belong to the particular post.
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Refresh all cache data
     */
    public function cacheRefresh(){
    	$client_id = request()->get('client.id');

    	// posts index
    	 	Cache::forget('posts_'.request()->get('client.id'));
            Cache::forget('featured_'.request()->get('client.id'));
            Cache::forget('featured_section_'.request()->get('client.id'));
            Cache::forget('popular_'.request()->get('client.id'));
            Cache::forget('categories_'.request()->get('client.id'));
            Cache::forget('tags_'.request()->get('client.id'));
            Cache::forget('blogSettings_'.request()->get('client.id'));

         $slug = $this->slug;
        // post 
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
            $this->where("slug", $slug)->update(["views" => $postViews]);
            Cache::forget('postViews_'.request()->get('client.id').'_'.$slug);

        // category refresh
        if($this->category){
        	$slug = $this->category->slug;
    		Cache::forget('categoryPosts_'.request()->get('client.id')."_".$slug);
          Cache::forget('category_'.request()->get('client.id')."_".$slug);
          Cache::forget('featured_'.request()->get('client.id'));
          Cache::forget('popular_'.request()->get('client.id'));
          Cache::forget('categories_'.request()->get('client.id'));
          Cache::forget('tags_'.request()->get('client.id'));
          Cache::forget('blogSettings_'.request()->get('client.id'));
        }
    	

         //tag refresh
          $tags = $this->tags;
          if(count($tags)){
          	foreach($tags as $t){
	          	$slug = $t->slug;
	          		Cache::forget('tagPosts_'.request()->get('client.id')."_".$slug);
		          Cache::forget('tag_'.request()->get('client.id')."_".$slug);
		          Cache::forget('featured_'.request()->get('client.id'));
		          Cache::forget('popular_'.request()->get('client.id'));
		          Cache::forget('categories_'.request()->get('client.id'));
		          Cache::forget('tags_'.request()->get('client.id'));
		          Cache::forget('blogSettings_'.request()->get('client.id'));
	          }
          }
          
          
    	
    }

}
