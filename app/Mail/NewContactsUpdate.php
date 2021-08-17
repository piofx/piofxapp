<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use App\Models\Mailer\MailLog;
use App\Models\Mailer\MailTemplate;
use Illuminate\Queue\SerializesModels;

class NewContactsUpdate extends Mailable
{
    use Queueable, SerializesModels;
    public $details;
    public $content;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details,$content)
    {
        $this->details = $details;
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {          
        if (str_contains($this->content, '{{$count}}')) {
            $this->content = str_replace('{{$count}}',$this->details['counter'],$this->content);   
        }
        if (str_contains($this->content, '{{$name}}')) {
            $this->content = str_replace('{{$name}}',$this->details['name'],$this->content);
        }
        if (str_contains($this->content, '{{$email}}')) { 
           $this->content = str_replace('{{$email}}',$this->details['email'],$this->content);
        }
        if (str_contains($this->content, '{{$message}}')) { 
            $this->content = str_replace('{{$message}}',$this->details['message'],$this->content);
        }
    
        return $this->from('mail@example.com', 'Mailtrap')
            ->subject('Contacts Update')
            ->view('apps.Mailer.MailView.ContactList');
        
    }
}
