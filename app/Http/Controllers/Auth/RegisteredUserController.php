<?php

namespace App\Http\Controllers\Auth;
use Event;
use App\Events\UserCreated;
use App\Http\Controllers\Controller;

use App\Models\Mailer\MailTemplate;
use App\Models\Mailer\MailLog;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Providers\EventServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Mail\EmailForQueuing;
use App\Mail\DefaultMail;
use Mail;


class RegisteredUserController extends Controller
{   
    /**
     * Define the app and module object variables and component name 
     *
     */
    public function __construct(){
        $this->componentName = componentName('agency','plain');
    }

    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        //update page meta title
        adminMetaTitle('Register');
        
        if(request()->get('dump2')){
            //client settings
        $settings = json_decode(request()->get('client.settings'));
        if(isset($settings->mailgunkey))
            $mailgunKey = $settings->mailgunkey;
        else
            $mailgunKey = env('MAIL_MAILGUNKEY');

        if(isset($settings->mailgundomain))
            $mailgunDomain = $settings->mailgundomain;
        else
            $mailgunDomain = env('MAIL_MAILGUNDOMAIN');


        //load mail template
        $template = MailTemplate::where('slug','mail_verification')->first();

        $email = 'krishnatejags@gmail.com';
        $code  = 1234;
        $subject = $template->subject;

        $client_name = request()->get('client.name');
        //update the mail log


        $maillog = MailLog::create(['agency_id' => request()->get('agency.id') ,'client_id' => request()->get('client.id') ,'email' => $email , 'app' => 'user' ,'mail_template_id' => $template->id, 'subject' => $subject,'message' => $template->message , 'status'=> 1]);


        
        // notify the admins via mail
        $details = array('email' => $email , 'count'=>$code, 'content' => $template->message,'log_id' => $maillog->id,'client_name'=>$client_name,'subject'=>$subject);

      

        Mail::setConfig($mailgunKey, $mailgunDomain)->to($details['email'])->send(new EmailForQueuing($details));
            dd('here');
            return 1;
        }

        if(!request()->session()->get('code')){
            $code = mt_rand(1000, 9999);
            request()->session()->put('code',$code);
        }else{
            $code = request()->session()->get('code');
        }

        if(request()->get('sendotp'))
        {
            $this->sendEmailOTP(request()->get('email'),$code);
            echo 1;
            dd();
        }
        //load client id
        $client_id = request()->get('client.id');
         //load the form elements if its defined in the settings i.e. stored in aws
        $form = null;
        if(Storage::disk('s3')->exists('settings/user/'.$client_id.'.json' )){
            //open the client specific settings
            $data = json_decode(json_decode(Storage::disk('s3')->get('settings/user/'.$client_id.'.json' ),true));
            if(isset($data->form))
                $form = processForm($data->form);
        }
        else
            $data = '';

        return view('auth.register')->with('app',$this)->with('code',$code)->with('form',$form);
    }

    /**
     * Function to send OTP code
     *
     */
    public function sendEmailOTP($email,$code){

        //client settings
        $settings = json_decode(request()->get('client.settings'));
        if(isset($settings->mailgunkey))
            $mailgunkey = $settings->mailgunkey;
        else
            $mailgunkey = env('MAIL_MAILGUNKEY');

        if(isset($settings->mailgundomain))
            $mailgunDomain = $settings->mailgundomain;
        else
            $mailgundomain = env('MAIL_MAILGUNDOMAIN');

        //load mail template
        $template = MailTemplate::where('slug','mail_verification')->first();


        $subject = $template->subject;

        $client_name = request()->get('client.name');
        //update the mail log



        $maillog = MailLog::create(['agency_id' => request()->get('agency.id') ,'client_id' => request()->get('client.id') ,'email' => $email , 'app' => 'user' ,'mail_template_id' => $template->id, 'subject' => $subject,'message' => $template->message , 'status'=> 1]);


        
        // notify the admins via mail
        $details = array('email' => $email , 'count'=>$code, 'content' => $template->message,'log_id' => $maillog->id,'client_name'=>$client_name,'subject'=>$subject);

        if (str_contains($details['content'], '{{$count}}')) {
            $details['content'] = str_replace('{{$count}}',$details['count'],$details['content']);   
        }
        if (str_contains($details['content'], '{{$email}}')) { 
           $details['content'] = str_replace('{{$email}}',$details['email'],$details['content']);
        }
        if (str_contains($details['content'], '{{$client}}')) { 
            $details['content'] = str_replace('{{$client}}',$details['client_name'],$details['content']);
        }
        

        // send email
        // $mailgunKey = 
        // $mailgunDomain = 
        Mail::to($details['email'])->send(new EmailForQueuing($details));

      
    }
    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'phone' => 'required|digits:10',
        ]);

        Auth::login($user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'client_id'=>$request->client_id,
            'agency_id'=>$request->agency_id,
            'status'=>1
        ]));


        event(new Registered($user));

        event(new UserCreated($user,$request));
        
        return redirect(RouteServiceProvider::HOME);
    }

    
    

}
