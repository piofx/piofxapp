<?php

namespace App\Models\Template;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateCategory extends Model
{
    use HasFactory;
    
    protected $fillable = ["id", "name" , "slug"];

    public function templates()
    {
        return $this->hasMany(Template::class);
    }

    public function getRecord($slug){
        return $this->where("slug", $slug)->first();
    }
}
