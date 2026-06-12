<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MailCampaignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("mail_campaigns")->insert([
            'id' => '1',
            'agency_id' => '1',
            'client_id' => '1',
            'user_id' => '1',
            'mail_template_id' => '1',
            'name' => 'sample1',
            'description' => 'some sample text',
            'emails' => 'dummy@gmail.com,dummy1@gmail.com',
            'scheduled_at' => '2021-06-04 00:00:00',
            'status' => "1",
        ]);

        DB::table("mail_campaigns")->insert([
            'id' => '2',
            'agency_id' => '1',
            'client_id' => '1',
            'user_id' => '1',
            'mail_template_id' => '2',
            'name' => 'sample2',
            'description' => 'some sample text',
            'emails' => 'dummy@gmail.com,dummy1@gmail.com',
            'scheduled_at' => '2021-06-04 00:00:00',
            'status' => "1",
        ]);

        DB::table("mail_campaigns")->insert([
            'id' => '3',
            'agency_id' => '1',
            'client_id' => '1',
            'user_id' => '1',
            'mail_template_id' => '1',
            'name' => 'sample3',
            'description' => 'some sample text',
            'emails' => 'dummy@gmail.com,dummy1@gmail.com',
            'scheduled_at' => '2021-06-04 00:00:00',
            'status' => "1",
        ]);

        DB::table("mail_campaigns")->insert([
            'id' => '4',
            'agency_id' => '1',
            'client_id' => '1',
            'user_id' => '1',
            'mail_template_id' => '2',
            'name' => 'sample4',
            'description' => 'some sample text',
            'emails' => 'dummy@gmail.com,dummy1@gmail.com',
            'scheduled_at' => '2021-06-04 00:00:00',
            'status' => "1",
        ]);

        DB::table("mail_campaigns")->insert([
            'id' => '5',
            'agency_id' => '1',
            'client_id' => '1',
            'user_id' => '1',
            'mail_template_id' => '1',
            'name' => 'sample5',
            'description' => 'some sample text',
            'emails' => 'dummy@gmail.com,dummy1@gmail.com',
            'scheduled_at' => '2021-06-04 00:00:00',
            'status' => "1",
        ]);

    }
}
