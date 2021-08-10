<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mail;
class ContactInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ContactInfo {counter} {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Contacts Update To Admin';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {   
        \Log::info("working fine!");
        Mail::send('apps.Mailer.MailView.ContactList', ['count'=> $this->argument('counter')] , function($message) {
            $message->to($email);
            $message->subject('New Contacts');
        });
    }
}
