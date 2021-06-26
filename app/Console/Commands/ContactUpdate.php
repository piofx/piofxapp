<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use Mail;
use App\Models\Core\Contact;
class ContactUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ContactUpdate:contact {contacts}';

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
        $details = $this->argument('contacts');
        //$data = array('name'=>$details);
        //$contacts = Contact::all();
        $data = array('name'=> $details);
            Mail::send('apps.Mailer.MailView.newcontact' , $data, function($message) {
                $message->to('superadmin@gmail.com');
                $message->subject('New Contacts');
            });
       
    }
}
