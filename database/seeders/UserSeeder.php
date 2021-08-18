<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* Super users data */
        DB::table('users')->insert([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('superadmin@123'),
            'client_id'=>1,
            'agency_id'=>1,
            'role'=>'superadmin'
        ]);
        DB::table('users')->insert([
            'name' => 'Super Dev',
            'email' => 'superdev@gmail.com',
            'password' => Hash::make('superdev@123'),
            'client_id'=>1,
            'agency_id'=>1,
            'role'=>'superdeveloper'
        ]);

        DB::table('users')->insert([
            'name' => 'Super Manager',
            'email' => 'supermanager@gmail.com',
            'password' => Hash::make('supermanager@123'),
            'client_id'=>1,
            'agency_id'=>1,
            'role'=>'supermanager'
        ]);

        DB::table('users')->insert([
            'name' => 'Super Moderator',
            'email' => 'supermoderator@gmail.com',
            'password' => Hash::make('supermoderator@123'),
            'client_id'=>1,
            'agency_id'=>1,
            'role'=>'supermoderator'
        ]);
        
        // /* Agency users data */

        // //piofx agency
        // DB::table('users')->insert([
        //     'name' => 'Piofx Admin',
        //     'email' => 'piofxadmin@gmail.com',
        //     'password' => Hash::make('@12345'),
        //     'client_id'=>1,
        //     'agency_id'=>1,
        //     'role'=>'agencyadmin'
        // ]);

        // DB::table('users')->insert([
        //     'name' => 'Piofx Dev',
        //     'email' => 'piofxdev@gmail.com',
        //     'password' => Hash::make('@12345'),
        //     'client_id'=>1,
        //     'agency_id'=>1,
        //     'role'=>'agencydeveloper'
        // ]);

        // DB::table('users')->insert([
        //     'name' => 'Piofx Manager',
        //     'email' => 'piofxman@gmail.com',
        //     'password' => Hash::make('@12345'),
        //     'client_id'=>1,
        //     'agency_id'=>1,
        //     'role'=>'agencymanager'
        // ]);

        // DB::table('users')->insert([
        //     'name' => 'Piofx Moderator',
        //     'email' => 'piofxmod@gmail.com',
        //     'password' => Hash::make('@12345'),
        //     'client_id'=>1,
        //     'agency_id'=>1,
        //     'role'=>'agencymoderator'
        // ]);

        // // quedb agency
		// DB::table('users')->insert([
        //     'name' => 'Quedb Admin',
        //     'email' => 'quedbadmin@gmail.com',
        //     'password' => Hash::make('@12345'),
        //     'client_id'=>2,
        //     'agency_id'=>2,
        //     'role'=>'agencyadmin'
        // ]);

        // DB::table('users')->insert([
        //     'name' => 'Quedb Dev',
        //     'email' => 'quedbdev@gmail.com',
        //     'password' => Hash::make('@12345'),
        //     'client_id'=>2,
        //     'agency_id'=>2,
        //     'role'=>'agencydeveloper'
        // ]);

        // DB::table('users')->insert([
        //     'name' => 'Quedb Manager',
        //     'email' => 'quedbman@gmail.com',
        //     'password' => Hash::make('@12345'),
        //     'client_id'=>2,
        //     'agency_id'=>2,
        //     'role'=>'agencymanager'
        // ]);

        // DB::table('users')->insert([
        //     'name' => 'Quedb Moderator',
        //     'email' => 'quedbmod@gmail.com',
        //     'password' => Hash::make('@12345'),
        //     'client_id'=>2,
        //     'agency_id'=>2,
        //     'role'=>'agencymoderator'
        // ]);

        // /* Client users data */

        // // FA Client
        // DB::table('users')->insert([
        //     'name' => 'FA Admin',
        //     'email' => 'faadmin@gmail.com',
        //     'password' => Hash::make('@12345'),
        //     'client_id'=>3,
        //     'agency_id'=>1,
        //     'role'=>'clientadmin'
        // ]);

        // DB::table('users')->insert([
        //     'name' => 'FA Dev',
        //     'email' => 'fadev@gmail.com',
        //     'password' => Hash::make('@12345'),
        //     'client_id'=>3,
        //     'agency_id'=>1,
        //     'role'=>'clientdeveloper'
        // ]);

        // DB::table('users')->insert([
        //     'name' => 'FA Manager',
        //     'email' => 'faman@gmail.com',
        //     'password' => Hash::make('@12345'),
        //     'client_id'=>3,
        //     'agency_id'=>1,
        //     'role'=>'clientmanager'
        // ]);

        // DB::table('users')->insert([
        //     'name' => 'FA Moderator',
        //     'email' => 'famod@gmail.com',
        //     'password' => Hash::make('@12345'),
        //     'client_id'=>3,
        //     'agency_id'=>1,
        //     'role'=>'clientmoderator'
        // ]);

        // // PREP FA Client
        // DB::table('users')->insert([
        //     'name' => 'PREP FA Admin',
        //     'email' => 'prepfaadmin@gmail.com',
        //     'password' => Hash::make('@12345'),
        //     'client_id'=>4,
        //     'agency_id'=>1,
        //     'role'=>'clientadmin'
        // ]);

        // DB::table('users')->insert([
        //     'name' => 'PREP FA Dev',
        //     'email' => 'prepfadev@gmail.com',
        //     'password' => Hash::make('@12345'),
        //     'client_id'=>4,
        //     'agency_id'=>1,
        //     'role'=>'clientdeveloper'
        // ]);

        // DB::table('users')->insert([
        //     'name' => 'PREP FA Manager',
        //     'email' => 'prepfaman@gmail.com',
        //     'password' => Hash::make('@12345'),
        //     'client_id'=>4,
        //     'agency_id'=>1,
        //     'role'=>'clientmanager'
        // ]);

        // DB::table('users')->insert([
        //     'name' => 'PREPFA Moderator',
        //     'email' => 'prepfamod@gmail.com',
        //     'password' => Hash::make('@12345'),
        //     'client_id'=>4,
        //     'agency_id'=>1,
        //     'role'=>'clientmoderator'
        // ]);

        // // PP Client
        // DB::table('users')->insert([
        //     'name' => 'PP Admin',
        //     'email' => 'ppadmin@gmail.com',
        //     'password' => Hash::make('@12345'),
        //     'client_id'=>5,
        //     'agency_id'=>2,
        //     'role'=>'clientadmin'
        // ]);

        // DB::table('users')->insert([
        //     'name' => 'PP Dev',
        //     'email' => 'ppdev@gmail.com',
        //     'password' => Hash::make('@12345'),
        //     'client_id'=>5,
        //     'agency_id'=>2,
        //     'role'=>'clientdeveloper'
        // ]);

        // DB::table('users')->insert([
        //     'name' => 'PP Manager',
        //     'email' => 'ppman@gmail.com',
        //     'password' => Hash::make('@12345'),
        //     'client_id'=>5,
        //     'agency_id'=>2,
        //     'role'=>'clientmanager'
        // ]);

        // DB::table('users')->insert([
        //     'name' => 'PP Moderator',
        //     'email' => 'ppmod@gmail.com',
        //     'password' => Hash::make('@12345'),
        //     'client_id'=>5,
        //     'agency_id'=>2,
        //     'role'=>'clientmoderator'
        // ]);

        //  // CODE PP Client
        // DB::table('users')->insert([
        //     'name' => 'Code PP Admin',
        //     'email' => 'codeppadmin@gmail.com',
        //     'password' => Hash::make('@12345'),
        //     'client_id'=>6,
        //     'agency_id'=>2,
        //     'role'=>'clientadmin'
        // ]);

        // DB::table('users')->insert([
        //     'name' => 'Code PP Dev',
        //     'email' => 'codeppdev@gmail.com',
        //     'password' => Hash::make('@12345'),
        //     'client_id'=>6,
        //     'agency_id'=>2,
        //     'role'=>'clientdeveloper'
        // ]);

        // DB::table('users')->insert([
        //     'name' => 'Code PP Manager',
        //     'email' => 'codeppman@gmail.com',
        //     'password' => Hash::make('@12345'),
        //     'client_id'=>6,
        //     'agency_id'=>2,
        //     'role'=>'clientmanager'
        // ]);

        // DB::table('users')->insert([
        //     'name' => 'Code PP Moderator',
        //     'email' => 'codeppmod@gmail.com',
        //     'password' => Hash::make('@12345'),
        //     'client_id'=>6,
        //     'agency_id'=>2,
        //     'role'=>'clientmoderator'
        // ]);


        // /* General User data */

		// DB::table('users')->insert([
        //     'name' => 'Generic User FA',
        //     'email' => 'userfa@gmail.com',
        //     'password' => Hash::make('@12345'),
        //     'client_id'=>3,
        //     'agency_id'=>1,
        //     'role'=>'user'
        // ]);

        // DB::table('users')->insert([
        //     'name' => 'Generic User PREPFA',
        //     'email' => 'userprepfa@gmail.com',
        //     'password' => Hash::make('@12345'),
        //     'client_id'=>4,
        //     'agency_id'=>1,
        //     'role'=>'user'
        // ]);

        // DB::table('users')->insert([
        //     'name' => 'Generic User PP',
        //     'email' => 'userpp@gmail.com',
        //     'password' => Hash::make('@12345'),
        //     'client_id'=>5,
        //     'agency_id'=>1,
        //     'role'=>'user'
        // ]);

        // DB::table('users')->insert([
        //     'name' => 'Generic User CODEPP',
        //     'email' => 'usercodepp@gmail.com',
        //     'password' => Hash::make('@12345'),
        //     'client_id'=>6,
        //     'agency_id'=>1,
        //     'role'=>'user'
        // ]);

       
    }
}
