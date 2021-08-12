<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Mailer\MailLog;
use App\Mail\EmailForQueuing;
use Mail;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $details;
    public $identity;
    public $data;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details,$identity,$data)
    {
        $this->details = $details;
        $this->identity = $identity;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //$email = new EmailForQueuing($this->details);
        Mail::to($this->details['email'])->send(new EmailForQueuing($this->details));
        $obj = MailLog::where('id',$this->identity)->first();
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


