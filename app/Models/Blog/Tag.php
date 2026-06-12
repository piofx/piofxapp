<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Blog\Post;
use Kyslik\ColumnSortable\Sortable;

use Illuminate\Support\Str;

class Tag extends Model
{
    use HasFactory, Sortable;

    protected $fillable = ["user_id", "client_id", "agency_id", "name", "slug"];

    /**
     * The posts that belong to the particular tag.
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

    public function new_tag($name){
        // Store the records
        $this->insert([
            'user_id' => auth()->user()->id,
            'agency_id' =>auth()->user()->agency_id,
            'client_id' =>auth()->user()->client_id,
            'name'=> $name,
            'slug' => Str::of($name)->slug('-'),
        ]);   
        
        return $this->where('name', $name)->first()->id ;
    }

}
