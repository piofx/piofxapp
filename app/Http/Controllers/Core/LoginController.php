<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller{
    public function authenticate(Request $request){
        $phone = $request->get('phone');
        $email = $request->get('email');
        $otp = trim($request->get('otp'));
        $generate_otp = trim($request->get('generate_otp'));
        $client_id = trim($request->get('client_id'));
        $code = request()->session()->get('phone_code');

        if($generate_otp){
            

            $data = $this->otp();
            echo $data;
            exit();
            return 1;
        }
        else if($email){
            // Retrive Input
            $credentials = $request->only('email', 'password','client_id');
            if (Auth::attempt($credentials)) {
                // if success login
                return redirect('/admin');
            }
            $alert = 'Invalid Email or Password';
            // if failed login
            return redirect('login')->with('alert',$alert);
        }else if($phone){

            $u = User::where('phone',$phone)->where('client_id',$client_id)->first();


            if($otp!=$code){
                $alert = 'Invalid OTP - '.$otp;
                // if failed login
                return redirect('login_phone')->with('alert',$alert);
            }
            if(!$u){
                $alert = 'User with phone number('.$phone.') not found. Kindly register and then login';
                // if failed login
                return redirect('login_phone')->with('alert',$alert);
            }

            $request->merge(["password"=>$u->password]);

            if (Auth::loginUsingId($u->id)) {
                // if success login
                return redirect('/admin');
            }
            $alert = 'Invalid attempt. Try again!';
            // if failed login
            return redirect('login_phone')->with('alert',$alert);

        }else{
            $alert = 'Enter all details.';
            // if failed login
            return redirect('login_phone')->with('alert',$alert);
        }
        
    }


     /**
     * Send the otp code for the request
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function otp()
    {
       
        //get client id
        $client_id = request()->get('client.id');
        // get the user phone number
        $phone = request()->get('phone');

        // load the token
        $data['code'] = request()->session()->get('phone_code');
        $validated = false;


        if($phone){
            
             $u = User::where('phone',$phone)->where('client_id',$client_id)->first();



             if(!$u){
                $message['error'] = 'User does not exist with phone number ('.$phone.') Kindly register and then login.';

                    return json_encode($message);
             }
            //validate data
            if (strpos($phone, '+') !== false){
                $validated=true;
            }else{
                if(strlen($phone)==10)
                {
                    $phone = '+91'.$phone;
                }else{
                    $message['error'] = 'Invalid Phone number format. Kindly enter a valid phone number with international calling extension (eg: For india +918888888888) for OTP verification.';
                    return json_encode($message);
                }
                    
            }
            //send otp on phone
            $this->sendOTP($phone,$data['code']);

        }

        

        //display token in json format
        return json_encode($data);
        

    }

    /**
     * Function to send OTP code
     *
     */
    public function sendOTP($phone,$code){

        $apikey = env('SMS_APIKEY');
        $url = "https://2factor.in/API/V1/".$apikey."/SMS/".$phone."/".$code;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        $data = curl_exec($ch);
        curl_close($ch);
    }
}