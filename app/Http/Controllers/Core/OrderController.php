<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Core\Order as Obj;
use Instamojo as Instamojo;

class OrderController extends Controller
{
    /*
        Order Controller
    */
    public function __construct(){
        $this->app      =   'product';
        $this->module   =   'order';
    }

     /**
     * To handle instamojo return request
     *
     */
    public function instamojo_return(Request $request){
      
      try {
        $id = $request->get('payment_request_id');
        $order = Obj::where('order_id',$id)->first();
        $payment_status = $request->get('payment_status');

        if($order){
            if ($payment_status=='Credit') {
            $order->status = 1;
            }else{
                $order->status = 2;
            }
            $order->save(); 
        }
            return redirect($order->redirect_url);
            
        }
        catch (Exception $e) {
            print('Error: ' . $e->getMessage());
        }


    }



     /**
     * Redirect the user to the Payment Gateway.
     *
     * @return Response
     */
    public function order(Request $request)
    {
        $client_id = request()->get('client.id');
        $instamojo_client_id= client('instamojo_client_id');
        $instamojo_secret = client('instamojo_secret');
        $instamojo_domain = client('instamojo_domain');
        $purpose = $request->get('product');

        $user = \Auth::user();

        if(!$user)
            abort('403','User login required to make payment');
        if($request->txn_amount<10)
            abort('403','Transaction ammount cannot be < Rs.10');

        try {

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://api.instamojo.com/oauth2/token/');     
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);

            $payload = Array(
                'grant_type' => 'client_credentials',
                'client_id' => $instamojo_client_id,
                'client_secret' => $instamojo_secret
              );

            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
            $response = curl_exec($ch);
            curl_close($ch); 

            $token = json_decode($response)->access_token;

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://api.instamojo.com/v2/payment_requests/');
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            curl_setopt($ch, CURLOPT_HTTPHEADER,array('Authorization: Bearer '.$token));

            $payload = Array(
              "buyer_name" => $user->name,
              "purpose" => $purpose,
              "amount" =>  $request->txn_amount,
              "send_email" => false,
              "email" => $user->email,
              "redirect_url" => $instamojo_domain."/order_payment",
              "allow_repeated_payments" => "False",
              "send_sms" => "False"
            );
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
            $response = json_decode(curl_exec($ch));
        

            $order = new Obj();
            $order->order_id = $response->id;

            $o_check = Obj::where('order_id',$order->order_id)->first();
            while($o_check){
                $payload = Array(
                  "buyer_name" => $user->name,
                  "purpose" => $purpose,
                  "amount" =>  $request->txn_amount,
                  "send_email" => false,
                  "email" => $user->email,
                  "redirect_url" => $instamojo_domain."/order_payment",
                  "allow_repeated_payments" => "False",
                  "send_sms" => "False"
                );
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
                $response = json_decode(curl_exec($ch));

                $order->order_id = $response->id;
                $o_check = Obj::where('order_id',$order->order_id)->first();
                if(!$o_check)
                  break;
            }

            curl_close($ch); 

            $order->user_id = $user->id;
            $order->txn_amount = $request->txn_amount;
            $order->product = $request->product;

            $order->redirect_url = $request->redirect_url;
            if(!$request->validity)
                $validity = 12;
            else
                $validity = $request->validity;
            $order->expiry  = date('Y-m-d H:i:s', strtotime(date("Y-m-d H:i:s") .' + '.($validity*31).' days'));
            $order->status=0;
            $order->agency_id = $request->get('agency.id');
            $order->client_id = $request->get('client.id');
            $order->save();
            $order->payment_status = 'Pending';

            return redirect($response->longurl);


          }
          catch (Exception $e) {
              print('Error: ' . $e->getMessage());
          }

    }

  /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Obj $obj,Request $request)
    {


        $this->authorize('view', $obj);

        $search = $request->search;
        $item = $request->item;
        
        if($request->get('coupon'))
        {
          $coupon = strtoupper($request->get('coupon'));
          $objs = $obj->where('txn_id',$coupon)
                    ->orderBy('created_at','desc')
                    ->paginate(config('global.no_of_records')); 
        }else if($request->get('product_id')){
             $objs = $obj->where('product_id',$request->get('product_id'))
                    ->orderBy('created_at','desc')
                    ->paginate(config('global.no_of_records')); 
        }
        else{
            $objs = $obj->where('order_id','LIKE',"%{$item}%")
                    ->orderBy('created_at','desc')
                    ->paginate(config('global.no_of_records')); 
        }


          
        $view = $search ? 'list': 'index';

        return view('appl.'.$this->app.'.'.$this->module.'.'.$view)
                ->with('objs',$objs)
                ->with('obj',$obj)
                ->with('app',$this);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function myorders(Obj $obj,Request $request)
    {
        $search = $request->search;
        $item = $request->item;
        
        $objs = $obj->where('order_id','LIKE',"%{$item}%")
                    ->where('user_id',\auth::user()->id)
                    ->orderBy('created_at','desc')
                    ->paginate(config('global.no_of_records'));   
        $view = $search ? 'mylist': 'myorders';

        return view('appl.'.$this->app.'.'.$this->module.'.'.$view)
                ->with('objs',$objs)
                ->with('obj',$obj)
                ->with('app',$this);
    }
}
