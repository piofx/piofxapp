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
	protected $fillable = ["user_id", "client_id", "title", "slug", "top_head", "category_id", "tag_id","agency_id", "image", "featured", "excerpt", "content", "visibility", "group", "views", "meta_title", "meta_description", "status", "published_at","top_head","link","link_title"];
	
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

}
