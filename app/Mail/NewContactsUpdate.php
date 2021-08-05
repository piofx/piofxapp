<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewContactsUpdate extends Mailable
{
    use Queueable, SerializesModels;
    public $details;
    public $counter;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details,$counter)
    {
        $this->details = $details;
        $this->counter = $counter;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   
        
        return $this->from('mail@example.com', 'Mailtrap')
            ->subject('Contacts Update')
            ->view('apps.Mailer.MailView.newcontact');
        
    }
}
