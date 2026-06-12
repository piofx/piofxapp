<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TemplateTemplateTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("template_template_tag")->insert([
            'id' => '1',
            'template_id' => '1',
            'template_tag_id' => '1',
        ]);

        DB::table("template_template_tag")->insert([
            'id' => '2',
            'template_id' => '1',
            'template_tag_id' => '2',
        ]);

        DB::table("template_template_tag")->insert([
            'id' => '3',
            'template_id' => '1',
            'template_tag_id' => '3',
        ]);

        DB::table("template_template_tag")->insert([
            'id' => '4',
            'template_id' => '2',
            'template_tag_id' => '1',
        ]);

        DB::table("template_template_tag")->insert([
            'id' => '5',
            'template_id' => '2',
            'template_tag_id' => '2',
        ]);

        DB::table("template_template_tag")->insert([
            'id' => '6',
            'template_id' => '2',
            'template_tag_id' => '3',
        ]);
    }
}
