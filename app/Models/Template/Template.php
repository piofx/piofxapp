<?php

namespace App\Models\Template;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Template\TemplateCategory;
use App\Models\Template\TemplateTag;


class Template extends Model
{
    use HasFactory;
    protected $fillable = ["id", "name", "slug","template_category_id","template_tag_id", "preview_path", "download_path", "status","index_screenshot", "screens"];

    public function template_category()
    {
        return $this->belongsTo(TemplateCategory::class);
    }

    /**
     * The tags that belong to the particular post.
     */
    public function template_tags()
    {
        return $this->belongsToMany(TemplateTag::class);
    }

}
