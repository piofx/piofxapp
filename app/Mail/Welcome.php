<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Welcome extends Mailable
{
    use Queueable, SerializesModels;
    public $details;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {       
    
        if(isset($this->details['from']))
            $from = $this->details['from'];
        else
            $from = 'noreply@customerka.com';
        return $this->from($from, $this->details['client_name'])
            ->subject($this->details['subject'])
            ->view('apps.Mailer.MailView.default');

        
    }
}
