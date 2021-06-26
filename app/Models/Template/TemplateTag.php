<?php

namespace App\Models\Template;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class TemplateTag extends Model
{
    use HasFactory;
    protected $fillable = ["id", "name" , "slug"];
    
    public function templates()
    {   
        return $this->belongsToMany(Template::class);
    }
    
     // Retrieve specific record based on slug
     public function getRecord($slug){
        return $this->where("slug", $slug)->first();
    }

    public function new_tag($name){
        // Store the records
        $this->create([
            'name'=> $name,
            'slug' => Str::of($name)->slug('-'),
        ]);   
        
        return $this->where('name', $name)->first()->id ;
    }
}
