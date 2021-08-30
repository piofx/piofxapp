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
    protected $signature = 'ContactInfo {counter}  {email1} {email2} {client_id} {agency_id} {term}';

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
        $template = MailTemplate::where('slug','slug4')->first();

        $counter = $this->argument('counter');
        $term = $this->argument('term');
        if (str_contains($template->message, '{{$count}}')) { 
           $template->message = str_replace('{{$count}}',$counter,$template->message);
        }
        if (str_contains($template->message, '{{$term}}')) { 
           $template->message = str_replace('{{$term}}',$counter,$template->message);
        }

        if($this->argument('email1') != NULL)
        {
            $maillog = MailLog::create(['agency_id' => $this->argument('agency_id'),'client_id' => $this->argument('client_id') ,'email' => $this->argument('email1') , 'app' => 'contact' ,'mail_template_id' => $template->id, 'subject' => $template->subject,'message' => $template->message , 'status'=> 0]);

            Mail::send('apps.Mailer.MailView.ContactList', ['count'=> $this->argument('counter'), 'content' => $template->message] , function($message) {
                $message->to($this->argument('email1'));
                $message->subject($template->subject);
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

        if($this->argument('email2') != NULL)
        {
            $maillog = MailLog::create(['agency_id' => $this->argument('agency_id'),'client_id' => $this->argument('client_id') ,'email' => $this->argument('email2') , 'app' => 'contact' ,'mail_template_id' => $template->id, 'subject' => $template->subject,'message' => $template->message , 'status'=> 0]);

            Mail::send('apps.Mailer.MailView.ContactList', ['count'=> $this->argument('counter'), 'content' => $template->message] , function($message) {
                $message->to($this->argument('email2'));
                $message->subject($template->subject);
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
}
