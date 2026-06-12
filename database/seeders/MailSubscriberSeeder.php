<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MailSubscriberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("mail_subscribers")->insert([
            'id' => '1',
            'agency_id' => '1',
            'client_id' => '1',
            'email' => 'dummy1@gmail.com',
            'info' => 'some sample text',
            'valid_email' => '0',
            'status' => "1",
        ]);

        DB::table("mail_subscribers")->insert([
            'id' => '2',
            'agency_id' => '1',
            'client_id' => '1',
            'email' => 'dummy2@gmail.com',
            'info' => 'some sample text',
            'valid_email' => '0',
            'status' => "1",
        ]);

        DB::table("mail_subscribers")->insert([
            'id' => '3',
            'agency_id' => '1',
            'client_id' => '1',
            'email' => 'dummy3@gmail.com',
            'info' => 'some sample text',
            'valid_email' => '0',
            'status' => "1",
        ]);

        DB::table("mail_subscribers")->insert([
            'id' => '4',
            'agency_id' => '1',
            'client_id' => '1',
            'email' => 'dummy4@gmail.com',
            'info' => 'some sample text',
            'valid_email' => '0',
            'status' => "1",
        ]);

        DB::table("mail_subscribers")->insert([
            'id' => '5',
            'agency_id' => '1',
            'client_id' => '1',
            'email' => 'dummy5@gmail.com',
            'info' => 'some sample text',
            'valid_email' => '0',
            'status' => "1",
        ]);
    }
}
