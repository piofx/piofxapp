<?php

namespace App\Http\Controllers\Loyalty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Loyalty\LoyaltySetting as Obj;

use Illuminate\Support\Facades\Auth;

class LoyaltySettingController extends Controller
{

    /**
     * Define the app and module object variables and component name 
     *
     */
    public function __construct(){
        // load the app, module and component name to object params
        $this->app      =   'Loyalty';
        $this->module   =   'Setting';
        $this->componentName = componentName('agency');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Obj $obj)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Obj $obj, Request $request)
    {
        $check = $obj->where('client_id', $request->get('client.id'))->exists();

        if($check){
            return redirect()->route($this->module.'.edit', $request->get('client.id'));
        }

        return view("apps.".$this->app.".".$this->module.".createedit")
                ->with("app", $this)
                ->with("stub", "create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Obj $obj, Request $request)
    {
        $check = $obj->where('client_id', $request->client_id)->exists();

        if($check){
            return redirect()->route($this->module.'.edit', $request->client_id);
        }

        if($request->mode == 'default'){
            // Validate the request object
            $validated = $request->validate([
                "default_credits" => "required | numeric",
                "min_redeem" => "required | numeric",
                "max_redeem" => "required | numeric",
            ]);

            $settings = array(
                'mode' => $request->mode,
                'default_credits' => $request->default_credits,
                'min_redeem' => $request->min_redeem,
                'max_redeem' => $request->max_redeem,
            );

            $obj->create([
                'agency_id' => $request->agency_id,
                'client_id' => $request->client_id,
                'settings' => json_encode($settings),
            ]);

            return redirect()->route($this->module.'.edit', $request->client_id);
        }
        elseif($request->mode == 'generic'){
            // Validate the request object
            $validated = $request->validate([
                "min_redeem" => "required | numeric",
                "max_redeem" => "required | numeric",
            ]);

            $settings = array(
                'mode' => $request->mode,
                'min_redeem' => $request->min_redeem,
                'max_redeem' => $request->max_redeem,
            );

            ddd($settings);

            $obj->create([
                'agency_id' => $request->agency_id,
                'client_id' => $request->client_id,
                'settings' => json_encode($settings),
            ]);
            
            return redirect()->route($this->module.'.edit', $request->client_id);
        }
        elseif($request->mode == 'range_percent'){
            // Validate the request object
            $validated = $request->validate([
                "percent_start_1" => "required | numeric",
                "percent_end_1" => "required | numeric",
                "percent_percentage_1" => "required | numeric",
                "percent_description_1" => "required",
                "min_redeem" => "required | numeric",
                "max_redeem" => "required | numeric",
            ]);

            $settings = array(
                'mode' => $request->mode,
                'start_1' => $request->percent_start_1,
                'start_2' => $request->percent_start_2,
                'start_3' => $request->percent_start_3,
                'end_1' => $request->percent_end_1,
                'end_2' => $request->percent_end_2,
                'end_3' => $request->percent_end_3,
                'percent_1' => $request->percent_percentage_1,
                'percent_2' => $request->percent_percentage_2,
                'percent_3' => $request->percent_percentage_3,
                'description_1' => $request->percent_description_1,
                'description_2' => $request->percent_description_2,
                'description_3' => $request->percent_description_3,
                'min_redeem' => $request->min_redeem,
                'max_redeem' => $request->max_redeem,
            );

            $obj->create([
                'agency_id' => $request->agency_id,
                'client_id' => $request->client_id,
                'settings' => json_encode($settings),
            ]);
            
            return redirect()->route($this->module.'.edit', $request->client_id);
        }
        elseif($request->mode == 'range_fixed'){
            // Validate the request object
            $validated = $request->validate([
                "fixed_start_1" => "required | numeric",
                "fixed_end_1" => "required | numeric",
                "fixed_credits_1" => "required | numeric",
                "fixed_description_1" => "required",
                "min_redeem" => "required | numeric",
                "max_redeem" => "required | numeric",
            ]);

            $settings = array(
                'mode' => $request->mode,
                'start_1' => $request->fixed_start_1,
                'start_2' => $request->fixed_start_2,
                'start_3' => $request->fixed_start_3,
                'end_1' => $request->fixed_end_1,
                'end_2' => $request->fixed_end_2,
                'end_3' => $request->fixed_end_3,
                'credits_1' => $request->fixed_credits_1,
                'credits_2' => $request->fixed_credits_2,
                'credits_3' => $request->fixed_credits_3,
                'description_1' => $request->fixed_description_1,
                'description_2' => $request->fixed_description_2,
                'description_3' => $request->fixed_description_3,
                'min_redeem' => $request->min_redeem,
                'max_redeem' => $request->max_redeem,
            );
            $obj->create([
                'agency_id' => $request->agency_id,
                'client_id' => $request->client_id,
                'settings' => json_encode($settings),
            ]);
            
            return redirect()->route($this->module.'.edit', $request->client_id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LoyaltySetting  $loyaltySetting
     * @return \Illuminate\Http\Response
     */
    public function show(Obj $obj)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LoyaltySetting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Obj $obj, $client_id, Request $request)
    {
        $obj = $obj->where('client_id', $client_id)->first();
        $settings = json_decode($obj->settings);

        // ddd($settings);
        return view("apps.".$this->app.".".$this->module.".createedit")
                ->with("app", $this)
                ->with("obj", $obj)
                ->with("stub", "update")
                ->with("settings", $settings);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LoyaltySetting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $client_id, Obj $obj)
    {
        if($request->mode == 'default'){
            // Validate the request object
            $validated = $request->validate([
                "default_credits" => "required | numeric",
                "min_redeem" => "required | numeric",
                "max_redeem" => "required | numeric",
            ]);

            $settings = array(
                'mode' => $request->mode,
                'default_credits' => $request->default_credits,
                'min_redeem' => $request->min_redeem,
                'max_redeem' => $request->max_redeem,
            );

            $obj->where("client_id", $client_id)->update([
                'settings' => json_encode($settings),
            ]);

            return redirect()->route($this->module.'.edit', $request->client_id);
        }
        elseif($request->mode == 'generic'){
            // Validate the request object
            $validated = $request->validate([
                "min_redeem" => "required | numeric",
                "max_redeem" => "required | numeric",
            ]);

            $settings = array(
                'mode' => $request->mode,
                'min_redeem' => $request->min_redeem,
                'max_redeem' => $request->max_redeem,
            );

            $obj->where("client_id", $client_id)->update([
                'settings' => json_encode($settings),
            ]);
            
            return redirect()->route($this->module.'.edit', $request->client_id);
        }
        elseif($request->mode == 'range_percent'){
            // Validate the request object
            $validated = $request->validate([
                "percent_start_1" => "required | numeric",
                "percent_end_1" => "required | numeric",
                "percent_percentage_1" => "required | numeric",
                "percent_description_1" => "required",
                "min_redeem" => "required | numeric",
                "max_redeem" => "required | numeric",
            ]);
            
            $settings = array(
                'mode' => $request->mode,
                'start_1' => $request->percent_start_1,
                'start_2' => $request->percent_start_2,
                'start_3' => $request->percent_start_3,
                'end_1' => $request->percent_end_1,
                'end_2' => $request->percent_end_2,
                'end_3' => $request->percent_end_3,
                'percent_1' => $request->percent_percentage_1,
                'percent_2' => $request->percent_percentage_2,
                'percent_3' => $request->percent_percentage_3,
                'description_1' => $request->percent_description_1,
                'description_2' => $request->percent_description_2,
                'description_3' => $request->percent_description_3,
                'min_redeem' => $request->min_redeem,
                'max_redeem' => $request->max_redeem,
            );

            $obj->where("client_id", $client_id)->update([
                'settings' => json_encode($settings),
            ]);
            
            return redirect()->route($this->module.'.edit', $request->client_id);
        }
        elseif($request->mode == 'range_fixed'){
            // Validate the request object
            $validated = $request->validate([
                "fixed_start_1" => "required | numeric",
                "fixed_end_1" => "required | numeric",
                "fixed_credits_1" => "required | numeric",
                "fixed_description_1" => "required",
                "min_redeem" => "required | numeric",
                "max_redeem" => "required | numeric",
            ]);

            $settings = array(
                'mode' => $request->mode,
                'start_1' => $request->fixed_start_1,
                'start_2' => $request->fixed_start_2,
                'start_3' => $request->fixed_start_3,
                'end_1' => $request->fixed_end_1,
                'end_2' => $request->fixed_end_2,
                'end_3' => $request->fixed_end_3,
                'credits_1' => $request->fixed_credits_1,
                'credits_2' => $request->fixed_credits_2,
                'credits_3' => $request->fixed_credits_3,
                'description_1' => $request->fixed_description_1,
                'description_2' => $request->fixed_description_2,
                'description_3' => $request->fixed_description_3,
                'min_redeem' => $request->min_redeem,
                'max_redeem' => $request->max_redeem,
            );
            $obj->where("client_id", $client_id)->update([
                'settings' => json_encode($settings),
            ]);
            
            return redirect()->route($this->module.'.edit', $request->client_id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LoyaltySetting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Obj $obj)
    {
        //
    }
}
