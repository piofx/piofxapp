<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

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

        if(request()->get('send')==1){
            
            $phone = '919515125110';
            $template = 'requestotp';
            $rem_str = 'rem_'.$phone.'_status';

            Cache::remember($rem_str, 1800, function () {
                return 1;
            });

            sendWhatsApp($phone,$template,[]);

        }
        return view('apps.Core.Admin.whatsapp')
            ->with('app',$this)
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
            dd($d);
            $phone = $d['entry'][0]['changes'][0]['value']['contacts'][0]['wa_id'];
            $text = $d['entry'][0]['changes'][0]['value']['messages'][0]['button']['text'];
            
        }else if($show_2){
            $d = Storage::disk('public')->get('wadata/sample_2.json');
            dd($d);
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

       $path = Storage::disk('public')->put('wadata/samplea.json', json_encode($data));
       if($show){
        $d = Storage::disk('public')->get('wadata/sample.json');

        dd($d);
       }else  if($show_2){
        $d = Storage::disk('public')->get('wadata/sample_2.json');

        dd($d);
       }else{
        $path = Storage::disk('public')->put('wadata/sample.json', json_encode($data));
        $path = Storage::disk('public')->put('wadata/sample_2.json', json_encode($data));
        $d = json_decode(json_encode($data),true);
      
        $phone=$text=null;
        if(isset($d['entry'][0]['changes'][0]['value']['contacts'][0]['wa_id']))
        $phone = $d['entry'][0]['changes'][0]['value']['contacts'][0]['wa_id'];
        if(isset($d['entry'][0]['changes'][0]['value']['messages'][0]['button']['text']))
        $text = $d['entry'][0]['changes'][0]['value']['messages'][0]['button']['text'];
        if(isset($d['entry'][0]['changes'][0]['value']['messages'][0]['text']['body']))
        $text = $d['entry'][0]['changes'][0]['value']['messages'][0]['text']['body'];
        $d['otp'] = -1;
        $d['text'] = $text;

        $rem_str = 'rem_'.$phone.'_status';
        $status_str = Cache::get($rem_str);
        if($status_str)
        $d['str'] = $status_str;
        $path = Storage::disk('public')->put('wadata/sample_2.json', json_encode($d));

        if($text =='Generate OTP' && $status_str){
            $template = 'otp';
            $otp = substr($phone,-4);
            sendWhatsApp($phone,$template,[$otp]);
            $d['otp'] = 1;
            $path = Storage::disk('public')->put('wadata/sample_2.json', json_encode($d));
        
        }else if($text =='hello' && $status_str){
            $template = 'hello_world';
            sendWhatsApp($phone,$template,[]);
            $d['otp'] = 2;
            $path = Storage::disk('public')->put('wadata/sample_2.json', json_encode($d));
        }
        else{
            $d['otp'] = 0;
            $d['rem_Str'] = $rem_str;
            $d['status_str'] = $status_str;
        }
        Cache::forget($rem_str);
        $path = Storage::disk('public')->put('wadata/sample_2.json', json_encode($d));
       }

    }
}
