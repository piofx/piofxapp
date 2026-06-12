<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customers')->insert([
            'name' => 'Kamal',
            'phone' => '9550184196',
            'email' => 'kamal@gmail.com',
            'address' => 'F-303, Lakshman Kuteer Apartment, Jaihind Enclave, VIP Hills, Madhapur, 500081',
            'agency_id' => 1,
            'client_id' => 1,
            'created_at' => '2021-01-01 16:37:03',
        ]);

        DB::table('customers')->insert([
            'name' => 'Teja',
            'phone' => '8688079590',
            'email' => 'teja@gmail.com',
            'address' => 'F-303, Lakshman Kuteer Apartment, Jaihind Enclave, VIP Hills, Madhapur, 500081',
            'agency_id' => 1,
            'client_id' => 1,
            'created_at' => '2021-01-02 16:37:03',
        ]);

        DB::table('customers')->insert([
            'name' => 'Sabiha',
            'phone' => '8247354466',
            'email' => 'sabiha@gmail.com',
            'address' => 'F-303, Lakshman Kuteer Apartment, Jaihind Enclave, VIP Hills, Madhapur, 500081',
            'agency_id' => 1,
            'client_id' => 1,
            'created_at' => '2021-01-02 16:37:03',
        ]);

        DB::table('customers')->insert([
            'name' => 'Testing 1',
            'phone' => '1234567891',
            'email' => 'testing@gmail.com',
            'address' => 'F-303, Lakshman Kuteer Apartment, Jaihind Enclave, VIP Hills, Madhapur, 500081',
            'agency_id' => 1,
            'client_id' => 1,
            'created_at' => '2021-01-06 16:37:03',
        ]);

        DB::table('customers')->insert([
            'name' => 'Testing 2',
            'phone' => '1234567892',
            'email' => 'testing@gmail.com',
            'address' => 'F-303, Lakshman Kuteer Apartment, Jaihind Enclave, VIP Hills, Madhapur, 500081',
            'agency_id' => 1,
            'client_id' => 1,
            'created_at' => '2021-01-08 16:37:03',
        ]);

        DB::table('customers')->insert([
            'name' => 'Testing 3',
            'phone' => '1234567893',
            'email' => 'testing@gmail.com',
            'address' => 'F-303, Lakshman Kuteer Apartment, Jaihind Enclave, VIP Hills, Madhapur, 500081',
            'agency_id' => 1,
            'client_id' => 1,
            'created_at' => '2021-01-15 16:37:03',
        ]);

        DB::table('customers')->insert([
            'name' => 'Testing 4',
            'phone' => '1234567894',
            'email' => 'testing@gmail.com',
            'address' => 'F-303, Lakshman Kuteer Apartment, Jaihind Enclave, VIP Hills, Madhapur, 500081',
            'agency_id' => 1,
            'client_id' => 1,
            'created_at' => '2021-01-16 16:37:03',
        ]);

        DB::table('customers')->insert([
            'name' => 'Testing 5',
            'phone' => '1234567895',
            'email' => 'testing@gmail.com',
            'address' => 'F-303, Lakshman Kuteer Apartment, Jaihind Enclave, VIP Hills, Madhapur, 500081',
            'agency_id' => 1,
            'client_id' => 1,
            'created_at' => '2021-01-20 16:37:03',
        ]);

        DB::table('customers')->insert([
            'name' => 'Testing 6',
            'phone' => '1234567896',
            'email' => 'testing@gmail.com',
            'address' => 'F-303, Lakshman Kuteer Apartment, Jaihind Enclave, VIP Hills, Madhapur, 500081',
            'agency_id' => 1,
            'client_id' => 1,
            'created_at' => '2021-01-23 16:37:03',
        ]);
        
        DB::table('customers')->insert([
            'name' => 'Testing 7',
            'phone' => '1234567897',
            'email' => 'testing@gmail.com',
            'address' => 'F-303, Lakshman Kuteer Apartment, Jaihind Enclave, VIP Hills, Madhapur, 500081',
            'agency_id' => 1,
            'client_id' => 1,
            'created_at' => '2021-02-1 16:37:03',
        ]);


        DB::table('customers')->insert([
            'name' => 'Testing 8',
            'phone' => '1234567898',
            'email' => 'testing@gmail.com',
            'address' => 'F-303, Lakshman Kuteer Apartment, Jaihind Enclave, VIP Hills, Madhapur, 500081',
            'agency_id' => 1,
            'client_id' => 1,
            'created_at' => '2021-02-3 16:37:03',
        ]);

        DB::table('customers')->insert([
            'name' => 'Testing 9',
            'phone' => '1234567899',
            'email' => 'testing@gmail.com',
            'address' => 'F-303, Lakshman Kuteer Apartment, Jaihind Enclave, VIP Hills, Madhapur, 500081',
            'agency_id' => 1,
            'client_id' => 1,
            'created_at' => '2021-02-6 16:37:03',
        ]);

        DB::table('customers')->insert([
            'name' => 'Testing 10',
            'phone' => '1234567890',
            'email' => 'testing@gmail.com',
            'address' => 'F-303, Lakshman Kuteer Apartment, Jaihind Enclave, VIP Hills, Madhapur, 500081',
            'agency_id' => 1,
            'client_id' => 1,
            'created_at' => '2021-02-8 16:37:03',
        ]);
    }
}
