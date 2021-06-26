<?php

namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailForQueuing extends Mailable
{
    use Queueable, SerializesModels;
    
    public $details;
    /**
     * Create a new content instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
        
    }

    /**
     * Build the content.
     *
     * @return $this
     */
    public function build()
    {
        
        return $this->from('mail@example.com', 'Mailtrap')
            ->subject('Test Queued Email 1')
            ->view('apps.Mailer.MailView.test');
    }

}