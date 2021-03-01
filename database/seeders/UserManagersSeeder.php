<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserManagersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_managers')->insert([
            'firstname' => 'Kamal',
            'email' => 'kamaltejag@gmail.com',
            'password' => Hash::make('kamal@955'),
            'phone' => '9550184196',
            'date_of_birth' => '2000-06-15',
            'address' => 'testing...',
            'city' => 'Hyderabad',
            'state' => 'Telangana',
            'zip' => '500081'
        ]);
        DB::table('user_managers')->insert([
            'firstname' => 'Teja',
            'email' => 'teja@gmail.com',
            'password' => Hash::make('teja@123'),
            'phone' => '8688079590',
            'date_of_birth' => '2000-06-15',
            'address' => 'testing...',
            'city' => 'Hyderabad',
            'state' => 'Telangana',
            'zip' => '500081'
        ]);
        DB::table('user_managers')->insert([
            'firstname' => 'Testing',
            'email' => 'testing@gmail.com',
            'password' => Hash::make('testing@123'),
            'phone' => '1234567890',
            'date_of_birth' => '2000-06-15',
            'address' => 'testing...',
            'city' => 'Hyderabad',
            'state' => 'Telangana',
            'zip' => '500081'
        ]);
    }
}
