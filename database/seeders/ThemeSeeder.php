<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('themes')->insert([
            'name' => 'Default',
            'slug' => 'default',
            'client_id'=>1,
            'agency_id'=>1,
            'settings' => '{"meta_title":"Default Templates"}'
        ]);

        // DB::table('themes')->insert([
        //     'name' => 'Default',
        //     'slug' => 'default',
        //     'client_id'=>2,
        //     'agency_id'=>2,
        //     'settings' => '{"meta_title":"Default Templates"}'
        // ]);

        // DB::table('themes')->insert([
        //     'name' => 'Default',
        //     'slug' => 'default',
        //     'client_id'=>3,
        //     'agency_id'=>1,
        //     'settings' => '{"meta_title":"Default Templates"}'
        // ]);

        //  DB::table('themes')->insert([
        //     'name' => 'Default',
        //     'slug' => 'default',
        //     'client_id'=>4,
        //     'agency_id'=>1,
        //     'settings' => '{"meta_title":"Default Templates"}'
        // ]);

        //  DB::table('themes')->insert([
        //     'name' => 'Default',
        //     'slug' => 'default',
        //     'client_id'=>5,
        //     'agency_id'=>2,
        //     'settings' => '{"meta_title":"Default Templates"}'
        // ]);

        // DB::table('themes')->insert([
        //     'name' => 'Default',
        //     'slug' => 'default',
        //     'client_id'=>6,
        //     'agency_id'=>2,
        //     'settings' => '{"meta_title":"Default Templates"}'
        // ]);

    }
}