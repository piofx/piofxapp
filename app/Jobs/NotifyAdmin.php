<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Mailer\MailLog;
use App\Mail\NewContactsUpdate;
use Mail;

class NotifyAdmin implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $details;
    public $counter;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details,$counter)
    {
        $this->details = $details;
        $this->counter = $counter;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to('superadmin@gmail.com')->send(new NewContactsUpdate($this->details,$this->counter));
        
    }
}
