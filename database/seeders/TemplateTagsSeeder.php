<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TemplateTagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("template_tags")->insert([
            'id' => '1',
            'name' => 'tag1',
            'slug' => 'slug1',
        ]);
        DB::table("template_tags")->insert([
            'id' => '2',
            'name' => 'tag2',
            'slug' => 'slug3',
        ]);
        DB::table("template_tags")->insert([
            'id' => '3',
            'name' => 'tag3',
            'slug' => 'slug3',
        ]);
        DB::table("template_tags")->insert([
            'id' => '4',
            'name' => 'tag4',
            'slug' => 'slug4',
        ]);
        DB::table("template_tags")->insert([
            'id' => '5',
            'name' => 'tag5',
            'slug' => 'slug5',
        ]);

    }
}
