<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class AuthenticatedSessionController extends Controller
{

     /**
     * Define the app and module object variables and component name 
     *
     */
    public function __construct(){
        $this->componentName = componentName('agency','plainmini');
        $this->module   =   'User';
        
    }

    /**
     * Display the login view for phone.
     *
     * @return \Illuminate\View\View
     */
    public function phone()
    {
        // load alerts if any
        $alert = session()->get('alert');

        // generate 4 digit code
        if(!request()->session()->get('phone_code')){
            $code = mt_rand(1000, 9999);
            request()->session()->put('phone_code',$code);
        }else{
            $code = request()->session()->get('phone_code');
        }

         //register the redirect
        if(request()->get('redirect'))
        request()->session()->put('redirect',request()->get('redirect'));


        //update page meta title
        adminMetaTitle('Login');
        return view('auth.login_phone')->with('app',$this)->with('alert',$alert)->with('code',$code);
    }

    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // load alerts if any
        $alert = session()->get('alert');
        //load client settings
        $phone_login = false;
        $client_settings = json_decode(request()->get('client.settings'));
        if(isset($client_settings->phone_otp_login)){
            if($client_settings->phone_otp_login){
                $phone_login = true;;
            }
        }
        //register the redirect
        if(request()->get('redirect'))
        request()->session()->put('redirect',request()->get('redirect'));
        //update page meta title
        adminMetaTitle('Login');
        return view('auth.login')->with('app',$this)->with('alert',$alert)->with('phone_login',$phone_login);
    }

    

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();
        $request->session()->regenerate();
        return redirect(RouteServiceProvider::HOME);
        
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    

}
