<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("templates")->insert([
            'id' => '1',
            'name' => 'Template1',
            'slug' => 'template1',
            'template_category_id' => '1',
            'preview_path' => 'https://source.unsplash.com/random/1920x1080',
            'download_path' => 'https://source.unsplash.com/random/1920x1080',
            'status' => "1",
            'index_screenshot' => 'https://drive.google.com/file/d/1sMvs2Fxgozd2IN2P9WH7B4X_9uaStYau/view?usp=sharing',
            'screens' => '{"screen_1":"https://source.unsplash.com/random/1920x1080","screen_2":"https://source.unsplash.com/random/1920x1080", "screen_3":"https://source.unsplash.com/random/1920x1080"}'
        ]);

        DB::table("templates")->insert([
            'id' => '2',
            'name' => 'template2',
            'slug' => 'slug2',
            'template_category_id' => '2',
            'preview_path' => 'https://source.unsplash.com/random/1920x1080',
            'download_path' => 'https://source.unsplash.com/random/1920x1080',
            'status' => "1",
            'index_screenshot' => 'https://source.unsplash.com/random/1920x1080',
            'screens' => '{"screen_1":"https://source.unsplash.com/random/1920x1080","screen_2":"https://source.unsplash.com/random/1920x1080", "screen_3":"https://source.unsplash.com/random/1920x1080"}'
        ]);

        DB::table("templates")->insert([
            'id' => '3',
            'name' => 'template3',
            'slug' => 'slug3',
            'template_category_id' => '1',
            'preview_path' => 'https://source.unsplash.com/random/1920x1080',
            'download_path' => 'https://source.unsplash.com/random/1920x1080',
            'status' => "1",
            'index_screenshot' => 'https://source.unsplash.com/random/1920x1080',
            'screens' => '{"screen_1":"https://source.unsplash.com/random/1920x1080","screen_2":"https://source.unsplash.com/random/1920x1080", "screen_3":"https://source.unsplash.com/random/1920x1080"}'
        ]);

        DB::table("templates")->insert([
            'id' => '4',
            'name' => 'template4',
            'slug' => 'slug4',
            'template_category_id' => '2',
            'preview_path' => 'https://source.unsplash.com/random/1920x1080',
            'download_path' => 'https://source.unsplash.com/random/1920x1080',
            'status' => "1",
            'index_screenshot' => 'https://source.unsplash.com/random/1920x1080',
            'screens' => '{"screen_1":"https://source.unsplash.com/random/1920x1080","screen_2":"https://source.unsplash.com/random/1920x1080", "screen_3":"https://source.unsplash.com/random/1920x1080"}'
        ]);

        DB::table("templates")->insert([
            'id' => '5',
            'name' => 'template5',
            'slug' => 'slug5',
            'template_category_id' => '2',
            'preview_path' => 'https://source.unsplash.com/random/1920x1080',
            'download_path' => 'https://source.unsplash.com/random/1920x1080',
            'status' => "1",
            'index_screenshot' => 'https://source.unsplash.com/random/1920x1080',
            'screens' => '{"screen_1":"https://source.unsplash.com/random/1920x1080","screen_2":"https://source.unsplash.com/random/1920x1080", "screen_3":"https://source.unsplash.com/random/1920x1080"}'
        ]);

    }
}
