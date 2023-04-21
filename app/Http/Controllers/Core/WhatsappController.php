<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use App\Models\Core\Whatsapp as Obj;
use App\Models\College\College;
use Illuminate\Http\Request;
use App\Mail\EmailForQueuing;
use App\Mail\Welcome;
use Mail;

class WhatsappController extends Controller
{
    /*
     * Create the component instance.
     *
     * @param  string  $type
     * @param  string  $message
     * @return void
     */
    public function __construct()
    {
        $this->app      =   'Core';
        $this->module   =   'Whatsapp';
        $this->componentName = componentName('agency');
    }

    public function whatsapp(){

        $client_id = request()->get('client.id');
        if($client_id==12)
            $objs = Obj::orderBy('id','desc')->paginate(10);
        else
            $objs = Obj::where('client_id',$client_id)->orderBy('id','desc')->paginate(10);

        $colleges = Obj::select('college')->get()->groupBy('college');
        $colls = Obj::select('college')->distinct()->pluck('college')->toArray();
        $colldata = College::whereIn('name',$colls)->get();

        $zone = request()->get('zone');
        if($zone)
            $coll_list = College::where('zone',$zone)->get()->keyBy('name');
        else
            $coll_list = College::get()->keyBy('name');

        $all_zones = $coll_list->unique('zone')->pluck('zone');

        $zcolleges =array();
        foreach($colldata as $college =>$d){
            if(!isset($zones[$d->zone]) && $d->zone)
                $zones[$d->zone] = 0;
            if(isset($colleges[$d->name]) && $d->zone)
                $zones[$d->zone] += count($colleges[$d->name]);
            if($zone==$d->zone )
                if(isset($colleges[$d->name]) && $d->name!='-Not in List-'){
                    $zcolleges[$d->name] = $colleges[$d->name];
                }
        }

        if(count($zcolleges)){
            $colleges = $zcolleges;
        }

        if($zone){
            $ycolleges = array();
            foreach($coll_list as $c){
                if(isset($colleges[$c->name]))
                    $ycolleges[$c->name] = $colleges[$c->name];
                else
                    $ycolleges[$c->name] = [];
            }
            $colleges = $ycolleges;
        }

        $new_zones = [];
        foreach($all_zones as $k=>$az){
            if(isset($zones[$az]))
                $new_zones[$az] = $zones[$az];
            else
               $new_zones[$az]  =0; 
        }

        return view('apps.Core.Whatsapp.whatsapp')
            ->with('app',$this)
            ->with('objs',$objs)
            ->with('colleges',$colleges)
            ->with('zones',$new_zones)
            ->with('coll_list',$coll_list)
            ->with('componentName',$this->componentName);
    }


    public function zonedetails(){
        //zones
        // $data['Hyderabad'] = array('Kukatpally','Ameerpet','Hyderabad','Chevella','Dilshuknagar','Filmcity','Ibrahimpatnam','Kompally','Mehdipatnam','Narayanaguda','Sangareddy','Secunderabad','Shamshabad','Uppal-Ghatkesar','Nizamabad','Medak','Mahbubnagar','Nalgonda','Kurnool','Anantapur');
        // $data['Vijayawada'] = array('Vijayawada');
        // $data['Guntur'] = array('Guntur','Ongole');
        // $data['Visakhapatnam'] = array('Visakhapatnam','Srikakulam','Vizianagaram');
        // $data['Kakinada'] = array('Kakinada');
        // $data['Warangal'] = array('Warangal','Karimnagar','Khammam');
        // $data['Tirupati'] = array('Tirupati','Kadapa','Nellore');
        $data['zones'] = array('Hyderabad','Vijayawada','Guntur','Visakhapatnam','Kakinada','Warangal','Tirupati');
        $data['zone'] = array(
            "Kukatpally"=>"Hyderabad",
            "Ameerpet" =>"Hyderabad",
            "Hyderabad"=>"Hyderabad",
            "Chevella"=>"Hyderabad",
            "Dilshuknagar"=>"Hyderabad",
            "Filmcity"=>"Hyderabad",
            "Ibrahimpatnam"=>"Hyderabad",
            "Kompally"=>"Hyderabad",
            "Mehdipatnam"=>"Hyderabad",
            "Narayanaguda"=>"Hyderabad",
            "Sangareddy"=>"Hyderabad",
            "Secunderabad"=>"Hyderabad",
            "Shamshabad"=>"Hyderabad",
            "Uppal-Ghatkesar"=>"Hyderabad",
            "Nizamabad"=>"Hyderabad",
            "Medak"=>"Hyderabad",
            "Mahbubnagar"=>"Hyderabad",
            "Nalgonda"=>"Hyderabad",
            "Kurnool"=>"Hyderabad",
            "Anantapur"=>"Hyderabad",
            "Vijayawada"=>"Vijayawada",
            "Guntur"=>"Guntur",
            "Ongole"=>"Guntur",
            "Visakhapatnam"=>"Visakhapatnam",
            "Srikakulam"=>"Visakhapatnam",
            "Vizianagaram"=>"Visakhapatnam",
            "Kakinada"=>"Kakinada",
            "Warangal"=>"Warangal",
            "Karimnagar"=>"Warangal",
            "Khammam"=>"Warangal",
            "Tirupati"=>"Tirupati",
            "Kadapa"=>"Tirupati",
            "Nellore"=>"Tirupati"
        );
        
        $objs = Obj::orderBy('id','desc')->paginate(10);
        $colleges = Obj::select('college')->get()->groupBy('college');
        $colls = Obj::select('college')->distinct()->pluck('college')->toArray();
        $colldata = College::whereIn('name',$colls)->get();
        $zone = request()->get('zone');
        if($zone)
            $coll_list = College::where('zone',$zone)->get()->keyBy('name');
        else
            $coll_list = College::get()->keyBy('name');

        $all_zones = $coll_list->unique('zone')->pluck('zone');
        $zcolleges =array();
        foreach($colldata as $college =>$d){
            if(!isset($zones[$d->zone]) && $d->zone)
                $zones[$d->zone] = 0;
            if(isset($colleges[$d->name]) && $d->zone)
                $zones[$d->zone] += count($colleges[$d->name]);
            if($zone==$d->zone )
                if(isset($colleges[$d->name]) && $d->name!='-Not in List-'){
                    $zcolleges[$d->name] = $colleges[$d->name];
                }
        }

        if(count($zcolleges)){
            $colleges = $zcolleges;
        }

        if($zone){
            $ycolleges = array();
            foreach($coll_list as $c){
                if(isset($colleges[$c->name]))
                    $ycolleges[$c->name] = $colleges[$c->name];
                else
                    $ycolleges[$c->name] = [];
            }
            $colleges = $ycolleges;
        }

        $new_zones = [];
        //$data['my_zones']=
        foreach($all_zones as $k=>$az){
            if(isset($zones[$az])){
                $new_zones[$az] = $zones[$az];
            }
            else
               $new_zones[$az]  =0; 
        }

        return view('apps.Core.Whatsapp.zonedetails')
            ->with('app',$this)
            ->with('data',$data)
            ->with('objs',$objs)
            ->with('colleges',$colleges)
            ->with('zones',$new_zones)
            ->with('coll_list',$coll_list)
            ->with('componentName',$this->componentName);
    }


    public function webhookget(Request $r){
        $verify_token = 'fa';
        $mode = $r->get('hub_mode');
        $token = $r->get('hub_verify_token');
        $challenge = $r->get('hub_challenge');
        $showed = $r->get('showed');
        $show = $r->get('show');
        $show_2 = $r->get('show_2');
        $phone = $r->get('phone');
        $data = $r->all();

        if($mode && $token){
            if($token == $verify_token){
                echo $challenge;
                exit();
            }else if(!$token){
                $mode = $r->get('mode');
                $token = $r->get('verify_token');
                $challenge = $r->get('challenge');
                if($token == $verify_token){
                    echo $challenge;
                    exit();
                }else{
                    abort(403);
                }
            }else{
                abort(403);
            }
        }


        if($showed){
            $path = Storage::disk('public')->put('wadata/sample.json', json_encode($data));
            dd($path);
        }else if($show){
            $d = Storage::disk('public')->get('wadata/sample.json');
            $d = json_encode(json_decode($d),JSON_PRETTY_PRINT);
            echo "<pre><code>";
            echo $d;
            echo "</code></pre>";
            return exit();
            $phone = $d['entry'][0]['changes'][0]['value']['contacts'][0]['wa_id'];
            $text = $d['entry'][0]['changes'][0]['value']['messages'][0]['button']['text'];
            
        }else if($show_2){
            $d = Storage::disk('public')->get('wadata/sample_2.json');
            $d = json_encode(json_decode($d),JSON_PRETTY_PRINT);
            echo "<pre><code>";
            echo $d;
            echo "</code></pre>";
            return exit();
        }
        else if($phone){
            $status['rem_str'] = Cache::get('rem_'.$phone.'_status');
            dd($status);
        }

    }

     public function webhookpost(Request $r){

        $file = 'sample.json';
        $data = $r->all();
        $show = $r->get('show');
        $show_2 = $r->get('show_2');
        $client_settings = json_decode(request()->get('client.settings'));

       
        $d = json_decode(json_encode($data),true);
      
        $phone=$text=$name=null;
        if(isset($d['entry'][0]['changes'][0]['value']['contacts'][0]['wa_id']))
        $phone = $d['entry'][0]['changes'][0]['value']['contacts'][0]['wa_id'];
        if(isset($d['entry'][0]['changes'][0]['value']['contacts'][0]['profile']['name']))
        $name = $d['entry'][0]['changes'][0]['value']['contacts'][0]['profile']['name'];
        if(isset($d['entry'][0]['changes'][0]['value']['messages'][0]['button']['text']))
        $text = $d['entry'][0]['changes'][0]['value']['messages'][0]['button']['text'];
        if(isset($d['entry'][0]['changes'][0]['value']['messages'][0]['text']['body']))
        $text = $d['entry'][0]['changes'][0]['value']['messages'][0]['text']['body'];
        $d['otp'] = -1;
        $d['entry'][0]['text'] = $text;
        $d['entry'][0]['name'] = $name;
        $entry = Obj::getEntry($phone);


        $rem_str = 'rem_'.$phone.'_status';
        $status_str = Cache::get($rem_str);
        $code = Cache::get("code_".$phone);
        if($status_str)
        $d['str'] = $status_str;
        $path = Storage::disk('public')->put('wadata/sample_2.json', json_encode($d));

        $d['entry'][0]['email'] = -1;
        if($text)
        $path = Storage::disk('public')->put('wadata/sample.json', json_encode($d['entry']));
        $d['entry'][0]['text'] = $text;
        if($text){
            $d['entry'][0]['email'] = 6;
           // $this->sendEmail('krishnatejags@gmail.com','Teja');
            $path = Storage::disk('public')->put('wadata/sample.json', json_encode($d));

        }

        $text = strtolower(str_replace(" ","",$text));
        if($text =='generateotp' && $status_str){
            $template = 'otp';
            if($code)
                $otp = $code;
            else
                $otp = substr($phone,-4);
            sendWhatsApp($phone,$template,[$otp]);
            $d['otp'] = 1;
            $path = Storage::disk('public')->put('wadata/sample_2.json', json_encode($d));
        
        }else if($text =='activateyouraccount' && $status_str){
            $template = 'activateyouraccount';
            sendWhatsApp($phone,$template);
            $d['wactivate'] = 1;
            $path = Storage::disk('public')->put('wadata/sample_2.json', json_encode($d));
        
        }

        else if($text =='hi'){
            $template = 'mail';
            sendWhatsApp($phone,$template,[]);
            $d['entry'][0]['otp'] = 'hi';
            $path = Storage::disk('public')->put('wadata/sample_2.json', json_encode($d['entry']));
            $entry->setPhone($phone,$name);
        }
        
        else if($text =='register'){
            $template = 'welcome';
            sendWhatsApp($phone,$template,['student']);
            $path = Storage::disk('public')->put('wadata/sample_2.json', json_encode($d['entry']));
        }
        else if($text =='instagram'){
            $template = 'social';
            if(isset($client_settings->instagram_url))
                sendWhatsApp($phone,$template,[$name,$client_settings->instagram_url]);
            $path = Storage::disk('public')->put('wadata/sample_2.json', json_encode($d['entry']));

            $d['entry'][0]['email'] = 10;
            $path = Storage::disk('public')->put('wadata/sample.json', json_encode($d['entry']));
            $entry->setInstagram(1);
        }
        else if($text =='youtube'){
            $template = 'social';
            if(isset($client_settings->youtube_url))
                sendWhatsApp($phone,$template,[$name,$client_settings->youtube_url]);
            $d['entry'][0]['otp'] = "youtube";
            $path = Storage::disk('public')->put('wadata/sample_2.json', json_encode($d['entry']));

            $entry->setYoutube(1);
        }
        else if($text =='accesscode'){
            $template = 'getcode';
            sendWhatsApp($phone,$template,[$name]);
            $d['entry'][0]['otp'] = "youtube";
            $path = Storage::disk('public')->put('wadata/sample_2.json', json_encode($d['entry']));
        }
        else if(is_numeric($text)){
            $template = 'autoresponse';
            sendWhatsApp($phone,$template,[]);
            $d['entry'][0]['otp'] = "youtube";
            $path = Storage::disk('public')->put('wadata/sample_2.json', json_encode($d['entry']));

            $entry->setCode($text);
        }
        else if($this->isValidMail($text,$d)){
            
            $ecounter = Cache::get($phone.'_email');
            if(!$ecounter)
                $ecounter = 1;
            else
                $ecounter = intval($ecounter);

            $template = 'welcome';
            if($ecounter==1)
            sendWhatsApp($phone,$template,[$name]);
            Cache::put($phone.'_email', $ecounter+1, 1200);
            $d['entry'][0]['email'] = 1;
            $path = Storage::disk('public')->put('wadata/sample.json', json_encode($d['entry']));
            
            //send email
            $this->sendEmail($text,$name);

            $entry->setEmail($text);
            
        }
        else{
            //$template = 'welcome';
            //sendWhatsApp($phone,$template,['student']);
            $d['entry'][0]['otp'] = $text;
            $path = Storage::disk('public')->put('wadata/sample_2.json', json_encode($d));
            $path = Storage::disk('public')->put('wadata/sample.json', json_encode($d['entry']));
        }
        Cache::forget($rem_str);
        Cache::forget("code_".$phone);
       // $d['entry'][0]['email'] = 5;
        //$path = Storage::disk('public')->put('wadata/sample.json', json_encode($d));
    }

    

    public static function sendEmail($email,$name){
        //client settings
        $settings = json_decode(request()->get('client.settings'));
        $client_name = request()->get('client.name');
        $subject = 'Welcome to '.$client_name;
        $details = array('name'=>$name,'email' => $email , 'count'=>1, 'content' => "hi",'client_name'=>$client_name,'subject'=>$subject);
       
        if(isset($settings->mailgunfrom))
            $details['from'] = $settings->mailgunfrom;
        else
           $details['from'] = 'noreply@customerka.com';
          
        if(isset($settings->mailgunclient)){
             Mail::mailer($settings->mailgunclient)->to($email)->send(new welcome($details));
        }
        else
        {
             Mail::to($email)->send(new welcome($details));
        }
    }

    public static function isValidMail($email,$d){ 
        $d['entry'][0]['email'] = 6;
        $path = Storage::disk('public')->put('wadata/sample.json', json_encode($d));

        if((strpos($email, '@') !== false) && (strpos($email, '.') !== false))
            return true;
        else
            return false;
    }
}
