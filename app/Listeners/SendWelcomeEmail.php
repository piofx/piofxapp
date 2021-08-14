<?php

namespace App\Listeners;
use Mail;
use App\Events\UserCreated;
use App\Models\Mailer\MailLog;
use App\Models\Mailer\MailTemplate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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
        $request = $event->request;
        $user = $event->user;
        //ddd($user);
        $template = MailTemplate::where('name','subscriber_update')->first();
        if($template != NULL)
        {
            $request->merge(['agency_id'=>request()->get('agency.id')])->merge(['client_id'=>request()->get('client.id')])->merge(['status'=> 1 ])->merge(['mail_template_id' => $template->id])->merge(['mail_template_id' => $template->id])->merge(['subject'=> $template->subject])->merge(['message'=> $template->message]);
            $log = MailLog::create($request->all());
            
            if (str_contains($template->message, '{{$name}}')) {
                $template->message = str_replace('{{$name}}',$this->details['name'],$template->message);
            }
            if (str_contains($template->message, '{{$email}}')) { 
               $template->message = str_replace('{{$email}}',$this->details['email'],$template->message);
            }
            //$data = array('name'=>$user->info, 'email'=>$user->email , 'content'=>$template->message);
            $data = array('content' => $template->message);
            Mail::send('apps.Mailer.MailView.newSubscriber' , $data, function($message) use ($user) {
                $message->to('piofxdev3@gmail.com');
                $message->subject('New Subscriber');
            });
        }
    }
}
