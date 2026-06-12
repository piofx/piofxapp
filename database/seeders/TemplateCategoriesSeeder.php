<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TemplateCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("template_categories")->insert([
            'id' => '1',
            'name' => 'cat1',
            'slug' => 'slug1',
        ]);
        DB::table("template_categories")->insert([
            'id' => '2',
            'name' => 'cat2',
            'slug' => 'slug3',
        ]);
        DB::table("template_categories")->insert([
            'id' => '3',
            'name' => 'cat3',
            'slug' => 'slug3',
        ]);
        DB::table("template_categories")->insert([
            'id' => '4',
            'name' => 'cat4',
            'slug' => 'slug4',
        ]);
        DB::table("template_categories")->insert([
            'id' => '5',
            'name' => 'cat5',
            'slug' => 'slug5',
        ]);

    }
}
