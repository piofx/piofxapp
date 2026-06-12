<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $this->call([
	        AgencySeeder::class,
	        ClientSeeder::class,
	        UserSeeder::class,
	        ThemeSeeder::class,
	        PageSeeder::class,
	        // CustomerSeeder::class,
	        // RewardSeeder::class,
            // MailCampaignSeeder::class,
            // MailSubscriberSeeder::class,
            // MailTemplateSeeder::class,
            // CategorySeeder::class,
            // PostSeeder::class,
            // TagSeeder::class,
            // PostTagSeeder::class,
            // TemplateSeeder::class,
            // TemplateTagsSeeder::class,
            // TemplateCategoriesSeeder::class,
            // TemplateTemplateTagSeeder::class,
	    ]);
    }
}
