<?php

namespace App\Http\Controllers\Loyalty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Loyalty\Customer as Obj;
use App\Models\Loyalty\Reward;
use App\Models\Loyalty\LoyaltySetting;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class CustomerController extends Controller
{
    /**
     * Define the app and module object variables and component name 
     *
     */
    public function __construct(){
        // load the app, module and component name to object params
        $this->app      =   'Loyalty';
        $this->module   =   'Customer';
        $this->componentName = componentName('agency');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Obj $obj, $filter, Request $request)
    {
        // authorize the app
        $this->authorize('viewAny', $obj);
     
        // Initialize required variables
        $year = date("Y");
        $month = date("m");

        // Today's date
        $date = Carbon::now();
        $current_date = $date->toDateString();

        // Retrieve Search Query Param if present
        $search_query = $request->input("search_query");

        // Retrieve records based on filter
        if($filter == 'today'){
            // Retrieve records
            $objs = $obj->where("client_id", $request->get('client.id'))->where('created_at', "LIKE", "%{$current_date}%")->where("phone", "LIKE", "%{$search_query}%")->orderBy('id', 'desc')->paginate(10);

        }
        else if($filter == 'this_week'){
            // Retrieve records 
            $objs = $obj->where("client_id", $request->get('client.id'))->where('created_at', '>=', $date->subDays(7))->where("phone", "LIKE", "%{$search_query}%")->orderBy('id', 'desc')->paginate(10);
        }
        else if($filter == 'this_month'){
            // Retrieve records
            $objs = $obj->where("client_id", $request->get('client.id'))->whereMonth('created_at', $month)->where("phone", "LIKE", "%{$search_query}%")->orderBy('id', 'desc')->paginate(10);
        }
        else if ($filter == "this_year"){
            // Retrieve records 
            $objs = $obj->where("client_id", $request->get('client.id'))->whereYear('created_at', $year)->where("phone", "LIKE", "%{$search_query}%")->orderBy('id', 'desc')->paginate(10);
        }
        else if($filter == 'all_data'){
            // Retrieve records 
            $objs = $obj->where("client_id", $request->get('client.id'))->where("phone", "LIKE", "%{$search_query}%")->orderBy('id', 'desc')->paginate(10);
        }

        return view("apps.".$this->app.".".$this->module.".index")
                ->with("app", $this)
                ->with("objs", $objs)
                ->with("filter", $filter);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Obj $obj, Request $request, LoyaltySetting $setting)
    {
        // Authorize the request
        $this->authorize('create', $obj);

        // Retrieve Settings
        $setting = $setting->where('client_id', $request->get('client.id'))->first();
        if(empty($setting)){
            $settings = json_decode(json_encode(array(
                "mode" => 'generic',
                "min_redeem" => '100',
                "max_redeem" => '500',
            )));
        }
        else{
            $settings = json_decode($setting->settings);
        }

        return view("apps.".$this->app.".".$this->module.".createedit")
                ->with("stub", "create")
                ->with("app", $this)
                ->with("objs", $obj)
                ->with("settings", $settings);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Obj $obj, Request $request, Reward $reward, LoyaltySetting $setting)
    {
        // Authorize the request
        $this->authorize('create', $obj);  

        // Validate the request object
        $validated = $request->validate([
            "name" => 'required',
            "phone" => 'required|digits:10',
        ]);

        // Check if record already exists
        $check = $obj->where("client_id", $request->get('client.id'))->where("phone", $request->phone)->exists();
        
        // Store the records only if check returns false
        if($check){
            return view("apps.".$this->app.".".$this->module.".createedit")
                    ->with("alert", "User Already Exists")
                    ->with("stub", "create")
                    ->with("app", $this)
                    ->with("objs", $obj);
        }
        else{
            $obj->create($request->all());
    
            return redirect()->route('Reward.public', ["phone" => $request->phone]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Obj $obj, $id, Request $request)
    {
        // Retrieve the record
        $obj = $obj->where("client_id", $request->get('client.id'))->where("id", $id)->first();

        // Retrieve related records
        $rewards = $obj->rewards()->with('user')->orderBy('id', 'desc')->paginate(10);

        return view("apps.".$this->app.".".$this->module.".show")
                ->with("app", $this)
                ->with("obj", $obj)
                ->with("rewards", $rewards);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blog\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Obj $obj, Request $request)
    {
        // Retrieve Specific record
        $obj = $obj->where("client_id", $request->get('client.id'))->where("id", $id)->first();

        // Authorize the request
        $this->authorize('update', $obj);

        return view("apps.".$this->app.".".$this->module.".createedit")
                ->with("stub", "update")
                ->with("app", $this)
                ->with("obj", $obj);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blog\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Obj $obj, $id)
    {
        // load the resource
        $obj = $obj->where("client_id", $request->get('client.id'))->where('id',$id)->first();

        // authorize the app
        $this->authorize('update', $obj);

        //update the resource
        $obj->update($request->all());

        return redirect($request->current_url);
    }
                                                                                                                                                                                            
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Obj $obj, Request $request)
    {   

        // load the resource
        $obj = $obj->where("client_id", $request->get('client.id'))->where('id',$id)->first();

        // authorize
        // $this->authorize('update', $obj);

        // delete the resource
        $obj->delete();

        return redirect()->route($this->module.'.index', 'all_data');
    }

    public function dashboard( Request $request){

        $obj = new Obj;
        $reward = new Reward;
        // authorize the app
        $this->authorize('viewAny', $obj);

        // Initialize required variables
        $customers = array();
        $rewards = array();
        $amount = array();
        $new_customers = 0;
        $loyal_customers = 0;
        $reward_transactions = 0;
        $revenue = 0;   

        $prev_revenue = 0;
        $prev_new_customers = 0;
        $prev_loyal_customers = 0;
        $prev_reward_transactions = 0;

        $revenue_increase = 0;
        $new_customer_increase = 0;
        $loyal_customer_increase = 0;   

        // Required dates
        $current_date = Carbon::now()->toDateString();
        $this_week = Carbon::now()->subday(6)->toDateString();
        $year = date("Y");
        $month = date("m");  

        $yesterday = Carbon::yesterday()->toDateString();
        $lastWeek = Carbon::now()->subday(13)->toDateString();
        $lastMonth = Carbon::now()->submonth()->format('m');
        $lastYear = Carbon::now()->subyear()->format('Y');

        // Get total count of customers in the database
        $total_customers = $obj->where("client_id", $request->get('client.id'))->count();

        // Get the filter if exists
        $filter = $request->input('filter');
        if(empty($filter)){
            $filter = 'this_year';
        }

        // Generate databased on filter
        if($filter == 'today'){
            // Retrieve records
            $objs = $obj->where("client_id", $request->get('client.id'))->where('created_at', "LIKE", "%{$current_date}%")->orderBy('created_at', "asc")->get();

            // Get the number of customers
            $new_customers = $objs->count();

            // Create an array of customers 
            // Associative array format:
                // {
                //      "1": 9,
                //      "2": 15, 
                // }
            foreach($objs as $obj){
                $key = date("h A",strtotime($obj['created_at']));
                if(array_key_exists($key, $customers)){
                    $customers[$key] += 1;
                }
                else{
                    $customers += array(
                        $key => 1,
                    ); 
                }
            }

            // Retrieve credit and redeem points 
            $reward_objs = $reward->where("client_id", $request->get('client.id'))->where('created_at', "LIKE", "%{$current_date}%")->orderBy("created_at", "desc")->get();

            // Create an array of credit and redeem points of that particular month for each day
            // Associative array format:
                // {
                //      "2": {
                //                  "credits": 100,
                //                  "redeem": 40
                //              },
                //      "5": {
                //                  "credits": 30,
                //                  "redeem":10,
                //              }, 
                // }
            foreach($reward_objs as $reward){
                $key = date("h A",strtotime($reward['created_at']));
                if(array_key_exists($key, $rewards)){
                    $rewards[$key]['credits'] += $reward['credits'];
                    $rewards[$key]['redeem'] += $reward['redeem'];
                }
                else{
                    $rewards += array(
                        $key => array(
                            "credits" => $reward['credits'],
                            "redeem" => $reward['redeem'],
                        ),
                    ); 
                }
            }

            // Retrieve latest rewards transactions
            $reward_transactions = $reward->where("client_id", $request->get('client.id'))->where("created_at", "LIKE", "%{$current_date}%")->orderBy('id', 'desc')->limit(20)->get();

            foreach($reward_transactions as $reward_transaction){
                $key = date("h A",strtotime($reward_transaction['created_at']));
                if(array_key_exists($key, $amount)){
                    $amount[$key] += $reward_transaction['amount'];
                }
                else{
                    $amount += array(
                        $key => $reward_transaction['amount'],
                    ); 
                }
            }

            // Present Total Revenue
            $records = $reward->where("client_id", $request->get('client.id'))->where("created_at", "LIKE", "%{$current_date}%")->get();
            foreach($records as $record){
                $revenue += $record->amount;
            }

            // Previous Total Revenue
            $records = $reward->where("client_id", $request->get('client.id'))->where("created_at", "LIKE", "%{$yesterday}%")->get();
            foreach($records as $record){
                $prev_revenue += $record->amount;
            }

            // Previous new customer records
            $prev_new_customers = $obj->where("client_id", $request->get('client.id'))->where('created_at', "LIKE", "%{$yesterday}%")->get();

            // Retrieve latest rewards transactions
            $prev_reward_transactions = $reward->where("client_id", $request->get('client.id'))->where("created_at", "LIKE", "%{$yesterday}%")->get();

            
            // Current Loyal Customers Logic
            // Customer ids of customers who did transaction - present
            $customer_ids = array(); 
            if(!empty($reward_transactions)){
                foreach($reward_transactions as $r_t){
                    array_push($customer_ids, $r_t->customer_id);
                }
                $customer_ids = array_unique($customer_ids);
            }
            // Total new customer ids
            $new_customer_ids = array();
            if(!empty($objs)){
                foreach($objs as $obj){
                    array_push($new_customer_ids, $obj->id);
                }
                $new_customer_ids = array_unique($new_customer_ids);
            }
            // Current Loyal Customers
            $loyal_customers = count(array_diff($customer_ids, $new_customer_ids));

            // Previous Loyal Customers Logic
            // Customer ids of customers who did transaction - Previous
            $customer_ids = array(); 
            if(!empty($prev_reward_transactions)){
                foreach($prev_reward_transactions as $r_t){
                    array_push($customer_ids, $r_t->customer_id);
                }
                $customer_ids = array_unique($customer_ids);
            }
            // Total new customer ids
            $new_customer_ids = array();
            if(!empty($prev_new_customers)){
                foreach($prev_new_customers as $p_n_c){
                    array_push($new_customer_ids, $p_n_c->id);
                }
                $new_customer_ids = array_unique($new_customer_ids);
            }
            // Current Loyal Customers
            $prev_loyal_customers = count(array_diff($customer_ids, $new_customer_ids));

            // Calculations for growth column
            if($prev_revenue != 0){
                if($revenue != $prev_revenue){
                    $revenue_increase = (($revenue - $prev_revenue) / $prev_revenue) * 100;
                }
            }
            if($prev_new_customers->count() != 0){
                if($objs->count() != $prev_new_customers->count()){
                    $new_customer_increase = (($objs->count() - $prev_new_customers->count()) / $prev_new_customers->count()) * 100;
                }
            }
            if($prev_loyal_customers != 0){
                if($loyal_customers != $prev_loyal_customers){
                    $loyal_customer_increase = (($loyal_customers - $prev_loyal_customers) / $prev_loyal_customers) * 100;
                }
            }
        }
        else if($filter == 'this_week'){
                // Retrieve records 
                $objs = $obj->where("client_id", $request->get('client.id'))->where('created_at', '>=', $this_week)->get();

                // Get the number of customers 
                $new_customers = $objs->count();

                // Create an array of customers 
                // Associative array format:
                    // {
                    //      "1": 9,
                    //      "2": 15, 
                    // }
                foreach($objs as $obj){
                    $key = date("d",strtotime($obj['created_at']));
                    if(array_key_exists($key, $customers)){
                        $customers[$key] += 1;
                    }
                    else{
                        $customers += array(
                            $key => 1,
                        ); 
                    }
                }

                // Retrieve credit and redeem points 
                $reward_objs = $reward->where("client_id", $request->get('client.id'))->where('created_at', '>=', $this_week)->get();

                // Create an array of credit and redeem points 
                // Associative array format:
                    // {
                    //      "2": {
                    //                  "credits": 100,
                    //                  "redeem": 40
                    //              },
                    //      "5": {
                    //                  "credits": 30,
                    //                  "redeem":10,
                    //              }, 
                    // }
                foreach($reward_objs as $reward){
                    $key = date("d",strtotime($reward['created_at']));
                    if(array_key_exists($key, $rewards)){
                        $rewards[$key]['credits'] += $reward['credits'];
                        $rewards[$key]['redeem'] += $reward['redeem'];
                    }
                    else{
                        $rewards += array(
                            $key => array(
                                "credits" => $reward['credits'],
                                "redeem" => $reward['redeem'],
                            ),
                        ); 
                    }
                }

            // Retrieve latest rewards transactions
            $reward_transactions = $reward->where("client_id", $request->get('client.id'))->where('created_at', '>', $this_week)->orderBy('id', 'desc')->limit(20)->get();

            foreach($reward_transactions as $reward_transaction){
                $key = date("d",strtotime($reward_transaction['created_at']));
                if(array_key_exists($key, $amount)){
                    $amount[$key] += $reward_transaction['amount'];
                }
                else{
                    $amount += array(
                        $key => $reward_transaction['amount'],
                    ); 
                }
            }

            // Present Total Revenue
            $records = $reward->where("client_id", $request->get('client.id'))->where("created_at", ">", $this_week)->get();
            foreach($records as $record){
                $revenue += $record->amount;
            }

            // Previous Total Revenue
            $records = $reward->where("client_id", $request->get('client.id'))->where("created_at", ">=", $lastWeek)->where("created_at", "<", $this_week)->get();
            foreach($records as $record){
                $prev_revenue += $record->amount;
            }            

            // Previous new customer records
            $prev_new_customers = $obj->where("client_id", $request->get('client.id'))->where("created_at", ">=", $lastWeek)->where("created_at", "<", $this_week)->get();

            // Retrieve latest rewards transactions
            $prev_reward_transactions = $reward->where("client_id", $request->get('client.id'))->where("created_at", ">=", $lastWeek)->where("created_at", "<", $this_week)->get();

            
            // Current Loyal Customers Logic
            // Customer ids of customers who did transaction - present
            $customer_ids = array(); 
            if(!empty($reward_transactions)){
                foreach($reward_transactions as $r_t){
                    array_push($customer_ids, $r_t->customer_id);
                }
                $customer_ids = array_unique($customer_ids);
            }
            // Total new customer ids
            $new_customer_ids = array();
            if(!empty($objs)){
                foreach($objs as $obj){
                    array_push($new_customer_ids, $obj->id);
                }
                $new_customer_ids = array_unique($new_customer_ids);
            }
            // Current Loyal Customers
            $loyal_customers = count(array_diff($customer_ids, $new_customer_ids));

            // Previous Loyal Customers Logic
            // Customer ids of customers who did transaction - Previous
            $customer_ids = array(); 
            if(!empty($prev_reward_transactions)){
                foreach($prev_reward_transactions as $r_t){
                    array_push($customer_ids, $r_t->customer_id);
                }
                $customer_ids = array_unique($customer_ids);
            }
            // Total new customer ids
            $new_customer_ids = array();
            if(!empty($prev_new_customers)){
                foreach($prev_new_customers as $p_n_c){
                    array_push($new_customer_ids, $p_n_c->id);
                }
                $new_customer_ids = array_unique($new_customer_ids);
            }
            // Current Loyal Customers
            $prev_loyal_customers = count(array_diff($customer_ids, $new_customer_ids));

            // Calculations for growth column
            if($prev_revenue != 0){
                if($revenue != $prev_revenue){
                    $revenue_increase = (($revenue - $prev_revenue) / $prev_revenue) * 100;
                }
            }
            if($prev_new_customers->count() != 0){
                if($objs->count() != $prev_new_customers->count()){
                    $new_customer_increase = (($objs->count() - $prev_new_customers->count()) / $prev_new_customers->count()) * 100;
                }
            }
            if($prev_loyal_customers != 0){
                if($loyal_customers != $prev_loyal_customers){
                    $loyal_customer_increase = (($loyal_customers - $prev_loyal_customers) / $prev_loyal_customers) * 100;
                }
            }
        }
        else if($filter == 'this_month'){
            // Retrieve records
            $objs = $obj->where("client_id", $request->get('client.id'))->whereMonth('created_at', $month)->get();

            // Get the number of customers 
            $new_customers = $objs->count();

            // Create an array of customers 
            // Associative array format:
                // {
                //      "1": 9,
                //      "2": 15, 
                // }
            foreach($objs as $obj){
                $key = date("d",strtotime($obj['created_at']));
                if(array_key_exists($key, $customers)){
                    $customers[$key] += 1;
                }
                else{
                    $customers += array(
                        $key => 1,
                    ); 
                }
            }

            // Retrieve credit and redeem points 
            $reward_objs = $reward->where("client_id", $request->get('client.id'))->whereMonth('created_at', $month)->get();

            // Create an array of credit and redeem points 
            // Associative array format:
                // {
                //      "2": {
                //                  "credits": 100,
                //                  "redeem": 40
                //              },
                //      "5": {
                //                  "credits": 30,
                //                  "redeem":10,
                //              }, 
                // }
            foreach($reward_objs as $reward){
                $key = date("d",strtotime($reward['created_at']));
                if(array_key_exists($key, $rewards)){
                    $rewards[$key]['credits'] += $reward['credits'];
                    $rewards[$key]['redeem'] += $reward['redeem'];
                }
                else{
                    $rewards += array(
                        $key => array(
                            "credits" => $reward['credits'],
                            "redeem" => $reward['redeem'],
                        ),
                    ); 
                }
            }

            // Retrieve latest rewards transactions
            $reward_transactions = $reward->where("client_id", $request->get('client.id'))->whereMonth('created_at', $month)->orderBy('id', 'desc')->limit(20)->get();

            foreach($reward_transactions as $reward_transaction){
                $key = date("d",strtotime($reward_transaction['created_at']));
                if(array_key_exists($key, $amount)){
                    $amount[$key] += $reward_transaction['amount'];
                }
                else{
                    $amount += array(
                        $key => $reward_transaction['amount'],
                    ); 
                }
            }

            // Present Total Revenue
            $records = $reward->where("client_id", $request->get('client.id'))->where("created_at", "LIKE", "%{$month}%")->get();
            foreach($records as $record){
                $revenue += $record->amount;
            }

            // Previous Total Revenue
            $records = $reward->where("client_id", $request->get('client.id'))->where("created_at", "LIKE", "%{$lastMonth}%")->get();
            foreach($records as $record){
                $prev_revenue += $record->amount;
            }

            // Previous new customer records
            $prev_new_customers = $obj->where("client_id", $request->get('client.id'))->where('created_at', "LIKE", "%{$lastMonth}%")->get();

            // Retrieve latest rewards transactions
            $prev_reward_transactions = $reward->where("client_id", $request->get('client.id'))->where("created_at", "LIKE", "%{$lastMonth}%")->get();

            
            // Current Loyal Customers Logic
            // Customer ids of customers who did transaction - present
            $customer_ids = array(); 
            if(!empty($reward_transactions)){
                foreach($reward_transactions as $r_t){
                    array_push($customer_ids, $r_t->customer_id);
                }
                $customer_ids = array_unique($customer_ids);
            }
            // Total new customer ids
            $new_customer_ids = array();
            if(!empty($objs)){
                foreach($objs as $obj){
                    array_push($new_customer_ids, $obj->id);
                }
                $new_customer_ids = array_unique($new_customer_ids);
            }
            // Current Loyal Customers
            $loyal_customers = count(array_diff($customer_ids, $new_customer_ids));

            // Previous Loyal Customers Logic
            // Customer ids of customers who did transaction - Previous
            $customer_ids = array(); 
            if(!empty($prev_reward_transactions)){
                foreach($prev_reward_transactions as $r_t){
                    array_push($customer_ids, $r_t->customer_id);
                }
                $customer_ids = array_unique($customer_ids);
            }
            // Total new customer ids
            $new_customer_ids = array();
            if(!empty($prev_new_customers)){
                foreach($prev_new_customers as $p_n_c){
                    array_push($new_customer_ids, $p_n_c->id);
                }
                $new_customer_ids = array_unique($new_customer_ids);
            }
            // Current Loyal Customers
            $prev_loyal_customers = count(array_diff($customer_ids, $new_customer_ids));

            // Calculations for growth column
            if($prev_revenue != 0){
                if($revenue != $prev_revenue){
                    $revenue_increase = (($revenue - $prev_revenue) / $prev_revenue) * 100;
                }
            }
            if($prev_new_customers->count() != 0){
                if($objs->count() != $prev_new_customers->count()){
                    $new_customer_increase = (($objs->count() - $prev_new_customers->count()) / $prev_new_customers->count()) * 100;
                }
            }
            if($prev_loyal_customers != 0){
                if($loyal_customers != $prev_loyal_customers){
                    $loyal_customer_increase = (($loyal_customers - $prev_loyal_customers) / $prev_loyal_customers) * 100;
                }
            }

            // ddd($prev_new_customers->count());
        }
        else if ($filter == "this_year"){
            // Retrieve records 
            $objs = $obj->where("client_id", $request->get('client.id'))->whereYear('created_at', $year)->orderBy('id')->get();

            // Get count of the customers 
            $new_customers = $objs->count();

            // Create an array of customers 
            // Associative array format:
                // {
                //      "Jan": 1,
                //      "Feb": 2, 
                // }
            foreach($objs as $obj){
                $key = date("M",strtotime($obj['created_at']));
                if(array_key_exists($key, $customers)){
                    $customers[$key] += 1;
                }
                else{
                    $customers += array(
                        $key => 1,
                    ); 
                }
            }

            // Retrieve records 
            $reward_objs = $reward->where("client_id", $request->get('client.id'))->whereYear('created_at', $year)->get();
                        
            // Create an array of credit and redeem points 
            // Associative array format:
                // {
                //      "Jan": {
                //                  "credits": 100,
                //                  "redeem": 40
                //              },
                //      "Feb": {
                //                  "credits": 30,
                //                  "redeem":10,
                //              }, 
                // }
            foreach($reward_objs as $reward){
                $key = date("M",strtotime($reward['created_at']));
                if(array_key_exists($key, $rewards)){
                    $rewards[$key]['credits'] += $reward['credits'];
                    $rewards[$key]['redeem'] += $reward['redeem'];
                }
                else{
                    $rewards += array(
                        $key => array(
                            "credits" => $reward['credits'],
                            "redeem" => $reward['redeem'],
                        ),
                    ); 
                }
            }

            // Retrieve latest rewards transactions
            $reward_transactions = $reward->where("client_id", $request->get('client.id'))->whereYear('created_at', $year)->orderBy('id', 'desc')->limit(20)->get();

            foreach($reward_transactions as $reward_transaction){
                $key = date("M",strtotime($reward_transaction['created_at']));
                if(array_key_exists($key, $amount)){
                    $amount[$key] += $reward_transaction['amount'];
                }
                else{
                    $amount += array(
                        $key => $reward_transaction['amount'],
                    ); 
                }
            }

            // Present Total Revenue
            $records = $reward->where("client_id", $request->get('client.id'))->where("created_at", "LIKE", "%{$year}%")->get();
            foreach($records as $record){
                $revenue += $record->amount;
            }

            // Previous Total Revenue
            $records = $reward->where("client_id", $request->get('client.id'))->where("created_at", "LIKE", "%{$lastYear}%")->get();
            foreach($records as $record){
                $prev_revenue += $record->amount;
            }

            // Previous new customer records
            $prev_new_customers = $obj->where("client_id", $request->get('client.id'))->where('created_at', "LIKE", "%{$lastYear}%")->get();

            // Retrieve latest rewards transactions
            $prev_reward_transactions = $reward->where("client_id", $request->get('client.id'))->where("created_at", "LIKE", "%{$lastYear}%")->get();

            
            // Current Loyal Customers Logic
            // Customer ids of customers who did transaction - present
            $customer_ids = array(); 
            if(!empty($reward_transactions)){
                foreach($reward_transactions as $r_t){
                    array_push($customer_ids, $r_t->customer_id);
                }
                $customer_ids = array_unique($customer_ids);
            }
            // Total new customer ids
            $new_customer_ids = array();
            if(!empty($objs)){
                foreach($objs as $obj){
                    array_push($new_customer_ids, $obj->id);
                }
                $new_customer_ids = array_unique($new_customer_ids);
            }
            // Current Loyal Customers
            $loyal_customers = count(array_diff($customer_ids, $new_customer_ids));

            // Previous Loyal Customers Logic
            // Customer ids of customers who did transaction - Previous
            $customer_ids = array(); 
            if(!empty($prev_reward_transactions)){
                foreach($prev_reward_transactions as $r_t){
                    array_push($customer_ids, $r_t->customer_id);
                }
                $customer_ids = array_unique($customer_ids);
            }
            // Total new customer ids
            $new_customer_ids = array();
            if(!empty($prev_new_customers)){
                foreach($prev_new_customers as $p_n_c){
                    array_push($new_customer_ids, $p_n_c->id);
                }
                $new_customer_ids = array_unique($new_customer_ids);
            }
            // Current Loyal Customers
            $prev_loyal_customers = count(array_diff($customer_ids, $new_customer_ids));

            // Calculations for growth column
            if($prev_revenue != 0){
                if($revenue != $prev_revenue){
                    $revenue_increase = (($revenue - $prev_revenue) / $prev_revenue) * 100;
                }
            }
            if($prev_new_customers->count() != 0){
                if($objs->count() != $prev_new_customers->count()){
                    $new_customer_increase = (($objs->count() - $prev_new_customers->count()) / $prev_new_customers->count()) * 100;
                }
            }
            if($prev_loyal_customers != 0){
                if($loyal_customers != $prev_loyal_customers){
                    $loyal_customer_increase = (($loyal_customers - $prev_loyal_customers) / $prev_loyal_customers) * 100;
                }
            }
        }
        else if($filter == 'all_data'){
            // Retrieve records 
            $objs = $obj->where("client_id", $request->get('client.id'))->get();

            // Get the number of customers 
            $new_customers = $objs->count();

            // Create an array of customers 
            // Associative array format:
                // {
                //      "1": 9,
                //      "2": 15, 
                // }
            foreach($objs as $obj){
                $key = date("Y",strtotime($obj['created_at']));
                if(array_key_exists($key, $customers)){
                    $customers[$key] += 1;
                }
                else{
                    $customers += array(
                        $key => 1,
                    ); 
                }
            }

            // Retrieve credit and redeem points 
            $reward_objs = $reward->where("client_id", $request->get('client.id'))->get();

            // Create an array of credit and redeem points 
            // Associative array format:
                // {
                //      "2": {
                //                  "credits": 100,
                //                  "redeem": 40
                //              },
                //      "5": {
                //                  "credits": 30,
                //                  "redeem":10,
                //              }, 
                // }
            foreach($reward_objs as $reward){
                $key = date("Y",strtotime($reward['created_at']));
                if(array_key_exists($key, $rewards)){
                    $rewards[$key]['credits'] += $reward['credits'];
                    $rewards[$key]['redeem'] += $reward['redeem'];
                }
                else{
                    $rewards += array(
                        $key => array(
                            "credits" => $reward['credits'],
                            "redeem" => $reward['redeem'],
                        ),
                    ); 
                }
            }

            // Retrieve latest rewards transactions
            $reward_transactions = $reward->where("client_id", $request->get('client.id'))->orderBy('id',"desc")->limit(30)->get();

            foreach($reward_transactions as $reward_transaction){
                $key = date("Y",strtotime($reward_transaction['created_at']));
                if(array_key_exists($key, $amount)){
                    $amount[$key] += $reward_transaction['amount'];
                }
                else{
                    $amount += array(
                        $key => $reward_transaction['amount'],
                    ); 
                }
            }

            // Present Total Revenue
            $records = $reward->where("client_id", $request->get('client.id'))->get();
            foreach($records as $record){
                $revenue += $record->amount;
            }
        }

        return view("apps.".$this->app.".".$this->module.".dashboard")
        ->with("app", $this)
        ->with("customers", json_encode($customers))
        ->with("rewards", json_encode($rewards))
        ->with("amount", json_encode($amount))
        ->with("filter", $filter)
        ->with("new_customers", $new_customers)
        ->with("total_customers", $total_customers)
        ->with("reward_transactions", $reward_transactions)
        ->with("revenue", $revenue)
        ->with("loyal_customers", $loyal_customers)
        ->with("revenue_increase", round($revenue_increase))
        ->with("new_customer_increase", round($new_customer_increase))
        ->with("loyal_customer_increase", round($loyal_customer_increase));
    
    }
}
