<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('clients')->insert([
            'name' => 'Piofx',
            'domain' => 'piofx.test',
            'agency_id'=>1,
            'settings' => '{ "theme": "default","name": "Piofx"}'
        ]);

        DB::table('clients')->insert([
            'name' => 'Quedb',
            'domain' => 'quedb.test',
            'agency_id'=>2,
            'settings' => '{ "theme": "default","name": "Quedb"}'
        ]);

        DB::table('clients')->insert([
            'name' => 'First Academy',
            'domain' => 'fa.test',
            'agency_id'=>1,
            'settings' => '{ "theme": "default","name": "First Academy","logo": "https:\/\/i.pinimg.com\/originals\/26\/16\/26\/261626808dc2a3d342e61c4ef377e709.png"}'
        ]);

        DB::table('clients')->insert([
            'name' => 'PREP FA',
            'domain' => 'prepfa.test',
            'agency_id'=>1,
            'settings' => '{"theme":"default"}'
        ]);

        DB::table('clients')->insert([
            'name' => 'PacketPrep',
            'domain' => 'pp.test',
            'agency_id'=>2,
            'settings' => '{"theme":"default"}'
        ]);

        DB::table('clients')->insert([
            'name' => 'Code PP',
            'domain' => 'codepp.test',
            'agency_id'=>2,
            'settings' => '{"theme":"default"}'
        ]);

        
    }
}
