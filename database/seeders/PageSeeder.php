<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pages')->insert([
            'name' => 'home',
            'slug' => 'home',
            'user_id'=>1,
            'client_id'=>3,
            'html' => '<h1>Hello from home</h1>'
        ]);

        DB::table('pages')->insert([
            'name' => 'about',
            'slug' => 'about',
            'user_id'=>1,
            'client_id'=>3,
            'html' => '<h1>Hello from About</h1>'
        ]);

        DB::table('pages')->insert([
            'name' => 'terms',
            'slug' => 'terms',
            'user_id'=>1,
            'client_id'=>3,
            'html' => '<h1>Hello from terms</h1>'
        ]);
    }
}
