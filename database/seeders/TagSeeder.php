<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("tags")->insert([
            'user_id' => '1',
            'agency_id' => '1',
            'client_id' => '1',
            'name' => "Python",
            'slug' => "python"
        ]);

        DB::table("tags")->insert([
            'user_id' => '1',
            'agency_id' => '1',
            'client_id' => '1',
            'name' => "PHP",
            'slug' => "php"
        ]);

        DB::table("tags")->insert([
            'user_id' => '1',
            'agency_id' => '1',
            'client_id' => '1',
            'name' => "Javascript",
            'slug' => "javascript"
        ]);

        DB::table("tags")->insert([
            'user_id' => '1',
            'agency_id' => '1',
            'client_id' => '1',
            'name' => "HTML",
            'slug' => "html"
        ]);

        DB::table("tags")->insert([
            'user_id' => '1',
            'agency_id' => '1',
            'client_id' => '1',
            'name' => "Laravel",
            'slug' => "laravel"
        ]);
    }
}
