<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Storage;

class BlogSettings extends Model
{
    use HasFactory;

    public function getSettings(){
        // Get Settings
        $client_id = request()->get('client.id');
        $settingsfilename = 'settings/blog_settings_'.$client_id.'.json';
        if(Storage::disk("s3")->exists($settingsfilename)){
            // Retrieve settings
            $settings = json_decode(Storage::disk("s3")->get($settingsfilename), true);
            // check if anything is missing in default structure
            if(!isset($settings['home_layout']) || !isset($settings['post_layout']) || !isset($settings['comments']) || !isset($settings['language'])){
                $settings = json_encode(array(
                "home_layout" => "default",
                "post_layout" => "right",
                "comments" => 'false',
                "language" => "english",
                ), JSON_PRETTY_PRINT);
                Storage::disk("s3")->put($settingsfilename, $settings);
            }
            $settings = json_decode(Storage::disk("s3")->get($settingsfilename));
        }
        else{
            // Default Settings
            $settings = json_encode(array(
                "home_layout" => "default",
                "post_layout" => "right",
                "comments" => 'false',
                "language" => 'english',
                "ads" => [
                       array(
                            "content" => "<a href='#'><img src='https://imgur.com/zIAYYIL.png' class='img-fluid rounded-lg'></a>",
                            "position" => "sidebar-top"
                        ),
                       array(
                            "content" => "<a href='#'><img src='https://imgur.com/zIAYYIL.png' class='img-fluid rounded-lg'></a>",
                            "position" => "sidebar-bottom"
                        ),
                       array(
                            "content" => "<a href='#'><img src='https://imgur.com/1TTEC4U.png' class='img-fluid w-100'></a>",
                            "position" => "before-body"
                        ),
                       array(
                            "content" => "<a href='#'><img src='https://imgur.com/1TTEC4U.png' class='img-fluid w-100'></a>",
                            "position" => "after-body"
                        ),
                       array(
                            "content" => "<a href='#'><img src='https://imgur.com/1TTEC4U.png' class='img-fluid w-100'></a>",
                            "position" => "before-content"
                        ),
                       array(
                            "content" => "<a href='#'><img src='https://imgur.com/1TTEC4U.png' class='img-fluid w-100'></a>",
                            "position" => "after-content"
                        )
                    ],
            ), JSON_PRETTY_PRINT);
            Storage::disk("s3")->put($settingsfilename, $settings);
            $settings = json_decode($settings);
        }
      
        return $settings;
    }

}
