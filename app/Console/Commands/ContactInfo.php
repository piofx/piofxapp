<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mail;
use Illuminate\Http\Request;
use App\Models\Mailer\MailLog;
use App\Models\Mailer\MailTemplate;
class ContactInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ContactInfo {counter} {email} {client_id} {agency_id}';

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
    public function handle(Request $request)
    {   
        \Log::info("working fine!");
        
        //$request->merge(['reference_id'=> $obj->id])->merge(['app'=> $this->app])->merge(['subject'=> $template->subject])->merge(['message'=> $template->message])->merge(['status'=> '0'])->merge(['email'=> $em])->merge(['agency_id'=> $obj->agency_id])->merge(['client_id'=> $obj->client_id]);
        $template = MailTemplate::where('name','Admin Notification Mail')->first();
        //\Log::info($template);
         $maillog = MailLog::create(['agency_id' => $this->argument('agency_id'),'client_id' => $this->argument('client_id') ,'email' => $this->argument('email') , 'app' => 'contact' ,'mail_template_id' => $template->id, 'subject' => $template->subject,'message' => $template->message , 'status'=> 0]);
         
        Mail::send('apps.Mailer.MailView.ContactList', ['count'=> $this->argument('counter')] , function($message) {
            $message->to($this->argument('email'));
            $message->subject('New Contacts');
        });
        
        $obj = MailLog::where('id',$maillog->id)->first();
        if( count(Mail::failures()) == 0 ) {
            $obj->status = 1;
            $obj->save();
        }
        else
        {
            $obj->status = 2;
             $obj->save();
        }
    }
}
