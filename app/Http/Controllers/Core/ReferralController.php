<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Core\Referral;

class ReferralController extends Controller
{
     /**
     * Define the app and module object variables and component name 
     *
     */
    public function __construct(){
        // load the app, module and component name to object params
        $this->app      =   'Core';
        $this->module   =   'Referral';
        $this->componentName = componentName('client');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $client_id=request()->get('client.id');

        $referral_id = \Auth::user()->id;

        $referrals = Referral::where('client_id',$client_id)->where('referral_id',$referral_id)->orderBy('id')->get();
        return view('apps.Core.Referral.index')->with('referrals',$referrals)->with('app',$this);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        $user = \Auth::user();
        if($user->role=='user')
            abort(403,'Unauthorized Access');

        $client_id=request()->get('client.id');
        $referrals = Referral::where('client_id',$client_id)->orderBy('id')->get()->groupBy('referral_id');
        return view('apps.Core.Referral.all')->with('referrals',$referrals)->with('app',$this);
    }
}
