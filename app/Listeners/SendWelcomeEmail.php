<?php

namespace App\Listeners;
use Mail;
use App\Events\UserCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Mailer\MailTemplate;

class SendWelcomeEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserCreated  $event
     * @return void
     */
    public function handle(UserCreated $event)
    {
        $user = $event->user;
        $template = MailTemplate::where('name','Welcome Mail')->first();
        $data = array('name'=>$user->name, 'email'=>$user->email , 'content'=>$template->message);
        Mail::send('apps.Mailer.MailView.newuser' , $data, function($message) use ($user) {
            $message->to('piofxdev3@gmail.com');
            $message->subject('New User Registered');
        });
    }
}
