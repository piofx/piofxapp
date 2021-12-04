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
        $searchConsoleData = null;
        $dateData = null;
        $fullData = null;
        $queryData = null;
        $pagesData = null;
        $selector = "3Months";

        if($request->input('selector')){
            $selector = $request->input('selector');
        }

        if($request->get('refresh')){
            $request->session()->forget('clientWebsiteUrl');
            $request->session()->forget('clientId');
            $request->session()->forget('clientSecret');
            $request->session()->forget('clientRedirectUrl');
            $request->session()->forget('searchConsoleToken');
        }

        // ddd(Storage::disk('s3')->exists("searchConsole/consoleData_".request()->get('client.id').".json"));

        // If refresh is clicked, delete the file from s3
        if($request->input('statisticsRefresh')){
            Storage::disk('s3')->delete("searchConsole/consoleData_".request()->get('client.id').".json");
            
        }

        // ddd(Storage::disk('s3')->exists("searchConsole/consoleData_".request()->get('client.id').".json"));

        if(!Storage::disk('s3')->exists("searchConsole/consoleData_".request()->get('client.id').".json")){
            // Initialize a new google client
            $client = new Google_Client();

            // Flag to check if authentication is done
            $authentication = False;

            // get website url from session
            if($request->session()->get("clientWebsiteUrl")){
                $website_url = $request->session()->get('clientWebsiteUrl');
            }
            
            // Check if request has the auth code
            if($request->input("client_id") || $request->input("code")){
                if($request->session()->get('clientId')){
                    $client_id = trim($request->session()->get('clientId'));
                }else{
                    $client_id = trim($request->input('client_id'));
                    $request->session()->put('clientId', $client_id);
                }

                if($request->session()->get('clientSecret')){
                    $client_secret = trim($request->session()->get('clientSecret'));
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
                    if(request()->get('dumpd'))
                        dd($authUrl);
                    header("Location: ". $authUrl);
                }
                elseif($request->input("code")){  
                    $authCode = $request->input('code');
                    if(request()->get('a_code'))
                     dd($authCode);

                    if(request()->get('client'))
                     dd($client);

                    // Exchange authorization code for an access token.
                    $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
                    
                    if(request()->get('a_token'))
                     dd($accessToken);

                    

                    // Check to see if there was an error.
                    if (array_key_exists('error', $accessToken)) {
                        throw new Exception(join(', ', $accessToken));
                    }
                    
                    // Put the access token in the session
                    $request->session()->put('searchConsoleToken', $accessToken);
                }
            }

            // ddd($client->getAccessToken());

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
                $consoleData = array();

                for($i=0; $i<3; $i++){
                    // Create a new object for search console
                    $obj = new \Google_Service_Webmasters_SearchAnalyticsQueryRequest();
                    $obj->setSearchType('web');
                    $obj->setRowLimit('5000');
                    $retrievedData = array();

                    if($i == 0){
                        $date = '1M';
                        $from_date = date('Y-m-d', strtotime('-1 month'));
                        $to_date = date('Y-m-d', strtotime('-1 day'));
                    }
                    elseif($i == 1){
                        $date = '3M';
                        $from_date = date('Y-m-d', strtotime('-3 months'));
                        $to_date = date('Y-m-d', strtotime('-1 day'));
                    }
                    elseif($i == 2){
                        $date = '1Y';
                        $from_date = date('Y-m-d', strtotime('-1 years'));
                        $to_date = date('Y-m-d', strtotime('-1 day'));
                    }

                    $obj->setStartDate($from_date);
                    $obj->setEndDate($to_date);
                
                    // Retrieve search console data
                    try {
                        // Initialize the service
                        $service = new Google_Service_Webmasters($client);

                        // Retrieve overall data
                        $fullData = $service->searchanalytics->query($website_url, $obj);

                        // Set dimension as query, for retrieving query data
                        $obj->setDimensions(['date']);
                        $dateData = $service->searchanalytics->query($website_url, $obj);

                        // Set dimension as query, for retrieving query data
                        $obj->setDimensions(['query']);
                        $queryData = $service->searchanalytics->query($website_url, $obj);

                        // Set dimension as page, for retrieving page data
                        $obj->setDimensions(['page']);
                        $pagesData = $service->searchanalytics->query($website_url, $obj);
                    } 
                    catch(\Exception $e) {
                        ddd($e->getMessage());
                    }  

                    $retrievedData['fullData'] = $fullData['rows'];
                    $retrievedData['dateData'] = $dateData['rows'];
                    $retrievedData['queryData'] = $queryData['rows'];
                    $retrievedData['pagesData'] = $pagesData['rows'];
                    
                    if($date == '1M'){
                        $consoleData['1Month'] = $retrievedData;
                    }
                    elseif($date == '3M'){
                        $consoleData['3Months'] = $retrievedData;
                    }
                    elseif($date == '1Y'){
                        $consoleData['1Year'] = $retrievedData;
                    }
                }

                Storage::disk('s3')->put("searchConsole/consoleData_".request()->get('client.id').".json", json_encode($consoleData), "public");
                $searchConsoleData = json_decode(Storage::disk('s3')->get("searchConsole/consoleData_".request()->get('client.id').".json"), true);

                $authentication = True;
            }
        }
        else{
            $authentication = True;
            $searchConsoleData = json_decode(Storage::disk('s3')->get("searchConsole/consoleData_".request()->get('client.id').".json"), true);
        }

        if(!empty($searchConsoleData)){
            $dateData = $searchConsoleData[$selector]['dateData'];
            if(!empty($dateData)){
                $dates = array();
                $clicks = array();
                $impressions = array();
                $ctr = array();
                $position = array();

                foreach($dateData as $data){
                    array_push($dates, $data['keys'][0]);
                    array_push($clicks, $data['clicks']);
                    array_push($impressions, $data['impressions']);
                    array_push($ctr, round($data['ctr'] * 100, 1));
                    array_push($position, round($data['position'], 1));
                }

                $dateData = array();
                $dateData['dates'] = array_reverse($dates);
                $dateData['clicks'] = array_reverse($clicks);
                $dateData['impressions'] = array_reverse($impressions);
                $dateData['ctr'] = array_reverse($ctr);
                $dateData['position'] = array_reverse($position);
            }

            $fullData = $searchConsoleData[$selector]['fullData'];
            if(!empty($fullData)){
                foreach($fullData as $data){
                    $total_clicks = format_number($data['clicks']);
                    $total_impressions = format_number($data['impressions']);
                    $average_ctr = round($data['ctr'] * 100, 1);
                    $average_position = round($data['position'], 1);
                }

                $fullData = array();
                $fullData['total_clicks'] = $total_clicks;
                $fullData['total_impressions'] = $total_impressions;
                $fullData['average_ctr'] = $average_ctr;
                $fullData['average_position'] = $average_position;
            }

            $queryData = $searchConsoleData[$selector]['queryData'];
            $pagesData = $searchConsoleData[$selector]['pagesData'];
            
        }

        return view('apps.'.$this->app.'.'.$this->module.'.searchConsole')
                    ->with('app',$this)
                    ->with('authentication', $authentication)
                    ->with('selector', $selector)
                    ->with('dateData', json_encode($dateData))
                    ->with("fullData", $fullData)
                    ->with("queryData", $queryData)
                    ->with("pagesData", $pagesData);
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
