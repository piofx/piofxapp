<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\Core\Statistic as Obj;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Exception;

use Google_Client;
use Google_Service_Webmasters;
use Google_Service_Webmasters_SearchAnalyticsQueryRequest;
use SearchConsole;
use Google_Service_Analytics;

class StatisticsController extends Controller
{

    /**
     * Define the app and module object variables and component name 
     *
     */
    public function __construct(){
        // load the app, module and component name to object params
        $this->app      =   'Core';
        $this->module   =   'Statistics';
        $this->componentName = componentName('agency');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Obj $obj, Request $request)
    {
        // set search console data filename
        $filename = "queryData_".request()->get('client.id')."_.json";


        if(!Storage::disk('s3')->exists('searchConsole/'.request()->get('client.id')."/".$filename)){
            // Initialize a new google client and set the client id and secret
            $client = new Google_Client();

            // Flag to check if authentication is done
            $authentication = False;

            $from_date = date('Y-m-d', strtotime('-3 months'));
            $to_date = date('Y-m-d', strtotime('-1 day'));
            if($request->session()->get("clientWebsiteUrl")){
                $website_url = $request->session()->get('clientWebsiteUrl');
            }
            
            // Check if request has the auth code
            if($request->input("client_id") || $request->input("code")){
                if($request->session()->get('clientId')){
                    $client_id = $request->session()->get('clientId');
                }else{
                    $client_id = trim($request->input('client_id'));
                    $request->session()->put('clientId', $client_id);
                }

                if($request->session()->get('clientSecret')){
                    $client_secret = $request->session()->get('clientSecret');
                }else{
                    $client_secret = trim($request->input('client_secret'));
                    $request->session()->put('clientSecret', $client_secret);
                }

                if($request->session()->get('clientRedirectUrl')){
                    $redirect_url = $request->session()->get('clientRedirectUrl');
                }else{
                    $redirect_url = $request->input('redirect_url');
                    $request->session()->put('clientRedirectUrl', $redirect_url);
                }

                // Set website url to session
                if($request->input("website_url")){
                    $request->session()->put('clientWebsiteUrl', trim($request->input('website_url')));
                }
                
                // Set the client id and secret and other parameters
                $client->setClientId($client_id);
                $client->setClientSecret($client_secret);
                $client->setRedirectUri($redirect_url);
                $client->addScope("https://www.googleapis.com/auth/webmasters");
                $client->setAccessType('offline');
                $client->setIncludeGrantedScopes(true); 

                if($request->input("client_id")){
                    // Create an authentication url and redirect to the authentication page
                    $authUrl = $client->createAuthUrl();
                    header("Location: ". $authUrl);
                }
                elseif($request->input("code")){  
                    $authCode = $request->input('code');
                    // Exchange authorization code for an access token.
                    $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
                    
                    // Check to see if there was an error.
                    if (array_key_exists('error', $accessToken)) {
                        throw new Exception(join(', ', $accessToken));
                    }
                    
                    // Put the access token in the session
                    $request->session()->put('searchConsoleToken', $accessToken);
                }
            }

            // Check if session has the access token
            // If it does then set the access token for the client
            if ($request->session()->has('searchConsoleToken')) {
                $accessToken = $request->session()->get('searchConsoleToken');
                $client->setAccessToken($accessToken);
            }
            else{
                // Refresh the token if possible
                if ($client->getRefreshToken()) {
                    $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
                }
            }

            // If access token was set to the client then retrieve the seach console data
            if ($client->getAccessToken()) {
                // Create a new object for search console
                $obj = new \Google_Service_Webmasters_SearchAnalyticsQueryRequest();

                $obj->setStartDate($from_date);
                $obj->setEndDate($to_date);

                // Set the dimensions of what to retrieve
                $obj->setDimensions($dimensions);
                $obj->setSearchType('web');

                // Retrieve the data
                try {
                    $service = new Google_Service_Webmasters($client);
                    $queryData = $service->searchanalytics->query($website_url, $obj);
                    Storage::disk('s3')->put('searchConsole/'.request()->get('client.id')."/".$filename, json_encode($queryData), "public");
                } 
                catch(\Exception $e ) {
                    echo $e->getMessage();
                }  

                $authentication = True;

                return view('apps.'.$this->app.'.'.$this->module.'.searchConsole')
                    ->with('app',$this)
                    ->with("authentication", $authentication)
                    ->with("queryData", $queryData);
            }

            return view('apps.'.$this->app.'.'.$this->module.'.searchConsole')
                    ->with('app',$this)
                    ->with('authentication', $authentication);
        }
        else{
            $searchConsoleData = Storage::disk('s3')->get('searchConsole/'.$filename);
            ddd(json_decode($searchConsoleData));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Core\Statistic  $statistic
     * @return \Illuminate\Http\Response
     */
    public function show(Statistic $statistic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Core\Statistic  $statistic
     * @return \Illuminate\Http\Response
     */
    public function edit(Statistic $statistic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Core\Statistic  $statistic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Statistic $statistic)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Core\Statistic  $statistic
     * @return \Illuminate\Http\Response
     */
    public function destroy(Statistic $statistic)
    {
        //
    }
}
