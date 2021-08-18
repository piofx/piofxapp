<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Mailer\MailLog;
use App\Models\Mailer\MailTemplate;
use App\Mail\NewContactsUpdate;
use Mail;

class NotifyAdmin implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $details;
    public $content;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details,$content)
    {
        $this->details = $details;
        $this->content = $content;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {   
        if($this->details['email1_To'] != NULL)
        {
            Mail::to($this->details['email1_To'])->send(new NewContactsUpdate($this->details,$this->content));
            
            $obj = MailLog::where('id',$this->details['log_id'])->first();
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

        if($this->details['email2_To'] != NULL)
        {
            Mail::to($this->details['email2_To'])->send(new NewContactsUpdate($this->details,$this->content));
            
            $obj = MailLog::where('id',$this->details['log_id'])->first();
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
