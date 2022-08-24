<?php

namespace App\Models\Page;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Core\Client;
use App\Models\Core\Referral;
use App\Models\Core\Contact;
use App\Models\Core\Order;
use App\Models\Page\Module;
use App\Models\Page\Theme;
use App\Models\Page\Asset;
use Illuminate\Support\Facades\Cache;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Support\Facades\Storage;

class Page extends Model
{
    use HasFactory,Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'html',
        'html_minified',
        'settings',
        'admin',
        'user_id',
        'client_id',
        'agency_id',
        'theme_id',
        'status',
    ];


    /**
     * Get the list of records from database
     *
     * @var array
     */
    public function getRecords($item,$limit,$theme_id){

    	return $this->where('name','LIKE',"%{$item}%")
                    ->where('client_id',request()->get('client.id'))
                    ->where('theme_id',$theme_id)
                    ->orderBy('created_at','desc')
                    ->paginate($limit);

    }

    /**
     * Refresh the cache data
     *
     */
    public function refreshCache($theme_id){

        $page = $this;
        // get the domain name
        $domain = $page->client->domain;
        
        // reload the cache
        Cache::forget('page_'.$domain.'_'.$theme_id.'_'.$page->slug);
        Cache::forever('page_'.$domain.'_'.$theme_id.'_'.$page->slug,$page);

    }

    /** 
     * 
     * Function to store request params in session
     * 
     */
    public function loadRequestParamsInSession(){
        $request = request();
        if($request->get('settings_source')){
             request()->session()->put('settings_source',$request->get('settings_source'));
        }

        if($request->get('settings_utm_source')){
             request()->session()->put('settings_utm_source',$request->get('settings_utm_source'));
        }else if($request->get('utm_source')){
            request()->session()->put('settings_utm_source',$request->get('utm_source'));
        }

        if($request->get('settings_campaign')){
             request()->session()->put('settings_campaign',$request->get('settings_campaign'));
        }

        if($request->get('settings_utm_campaign')){
             request()->session()->put('settings_utm_campaign',$request->get('settings_utm_campaign'));
        }else if($request->get('utm_campaign')){
            request()->session()->put('settings_utm_campaign',$request->get('utm_campaign'));
        }

        if($request->get('settings_utm_medium')){
             request()->session()->put('settings_utm_medium',$request->get('settings_utm_medium'));
        }else if($request->get('utm_medium')){
             request()->session()->put('settings_utm_medium',$request->get('utm_medium'));
        }

        if($request->get('settings_utm_term')){
             request()->session()->put('settings_utm_term',$request->get('settings_utm_term'));
        }else if($request->get('utm_term')){
            request()->session()->put('settings_utm_term',$request->get('utm_term'));
        }

        if($request->get('settings_utm_content')){
             request()->session()->put('settings_utm_content',$request->get('settings_utm_content'));
        }else if($request->get('utm_content')){
            request()->session()->put('settings_utm_content',$request->get('utm_content'));
        }

    }



    /**
     * Function to replace the auth varaibles
     *
     */
    public function checkAuthBasedReplacement(){

        $content = $this->html_minified;
        $settings = json_decode($this->settings);
        $data = '';
        //get client id
        $client_id = request()->get('client.id');

        if(!request()->session()->get('code')){
            $code = mt_rand(1000, 9999);
            request()->session()->put('code',$code);
        }else{
            $code = request()->session()->get('code');
        }


        $this->auth = 1;
        //auth variavle
        if(preg_match_all('/@guest+(.*?)@endguest/', $content, $regs))
        {
            foreach ($regs[1] as $reg){
                $variable = trim($reg);
                if (strpos($variable, '@else') !== false) {
                    $pieces = explode('@else',$variable);

                    if(!\Auth::user()){
                        $content = str_replace('@guest'.$reg.'@endguest', $pieces[0].'<form class="mt-3" action="/user/apilogin" data-login="1"></form>' , $content);
                        $this->auth = 0;
                    }else{
                        $content = str_replace('@guest'.$reg.'@endguest', $pieces[1] , $content);  
                        
                    }
                }else{
                    if(!\Auth::user()){
                        $content = str_replace('@guest'.$reg.'@endguest', $reg , $content);
                        $this->auth = 0;
                    }else{
                        $content = str_replace('@guest'.$reg.'@endguest', '' , $content); 
                        $this->auth = 1; 
                    }
                }
            }
            
        }

        if(\Auth::user()){
            $content = str_replace('@myname',  \Auth::user()->name , $content);
            $rurl = url()->current()."?refresh=1&utm_source=userref&utm_referral=".\Auth::user()->id;
            $content = str_replace('@rurl',  $rurl , $content);
        }
        
       

        if(preg_match_all('/@loginpopup+(.*?)@endloginpopup/', $content, $regs))
        {
            foreach ($regs[1] as $reg){
                $variable = trim($reg);
                if (strpos($variable, '@else') !== false) {
                    $pieces = explode('@else',$variable);
                    if(!\Auth::user()){
                        $content = str_replace('@loginpopup'.$reg.'@endloginpopup', '<a href="#" class="btn  btn-loginpopup" data-toggle="modal" data-target="#loginModal">'.$pieces[0].'</a><form class="mt-3" action="/user/apilogin" data-login="1"></form>' , $content);
                        $this->auth = 1;
                    }else{
                        $content = str_replace('@loginpopup'.$reg.'@endloginpopup', $pieces[1] , $content);  
                        $this->auth = 0;
                    }
                }else{
                    if(!\Auth::user()){
                        $content = str_replace('@auth'.$reg.'@endauth', $reg , $content);
                        $this->auth = 1;
                    }else{
                        $content = str_replace('@auth'.$reg.'@endauth', '' , $content); 
                        $this->auth = 0; 
                    }
                }
            }
            
        }


        if(preg_match_all('/@registerpopup+(.*?)@endregisterpopup/', $content, $regs))
        {
            foreach ($regs[1] as $reg){
                $variable = trim($reg);
                if (strpos($variable, '@else') !== false) {
                    $pieces = explode('@else',$variable);
                    if(!\Auth::user()){
                        $content = str_replace('@registerpopup'.$reg.'@endregisterpopup', '<a href="#" class="btn  btn-loginpopup" data-toggle="modal" data-target="#loginModal">'.$pieces[0].'</a><form class="mt-3" action="/user/apilogin" data-login="1"></form>' , $content);
                        $this->auth = 2;
                    }else{
                        $content = str_replace('@registerpopup'.$reg.'@endregisterpopup', $pieces[1] , $content);  
                        $this->auth = 0;
                    }
                }else{
                    if(!\Auth::user()){
                        $content = str_replace('@registerpopup'.$reg.'@endregisterpopup', $reg , $content);
                        $this->auth = 2;
                    }else{
                        $content = str_replace('@registerpopup'.$reg.'@endregisterpopup', '' , $content); 
                        $this->auth = 0; 
                    }
                }
            }

             if(preg_match_all('/@redirect+(.*?)@endredirect/', $content, $regs))
                {
                    foreach ($regs[1] as $reg){
                        $this->redirected = trim($reg);
                        return $this;
                    }
                }
        }

        if(preg_match_all('/@uniqueform+(.*?)@enduniqueform/', $content, $regs))
        {
            foreach ($regs[1] as $reg){
                $variable = trim($reg);
                if (strpos($variable, '@uniqueformelse') !== false) {
                    $pieces = explode('@uniqueformelse',$variable);
                    $form_entry = false;
                    if(preg_match_all('/@formname+(.*?)@endformname/', $pieces[0], $regs2))
                    {
                        foreach ($regs2[1] as $reg2){
                            $category_name = trim($reg2);
                            // remove the @formname block
                            $pieces[0] = str_replace('@formname'.$reg2.'@endformname', '' , $pieces[0]);
                        }
                        $form_entry = Contact::where('category',$category_name)->where('email',\Auth::user()->email)->where('client_id',$client_id)->first();
                    }

                    if(!$form_entry){
                        $content = str_replace('@uniqueform'.$reg.'@enduniqueform', $pieces[0] , $content);
                   
                    }else{
                        $content = str_replace('@uniqueform'.$reg.'@enduniqueform', $pieces[1] , $content);  
                
                    }
                }
            }
            
        }

        if(preg_match_all('/@buy+(.*?)@endbuy/', $content, $regs))
        {
            $user_id = \Auth::user()->id;

 
            foreach ($regs[1] as $reg){
                $variable = trim($reg);
                if (strpos($variable, '@buyelse') !== false) {
                    $pieces = explode('@buyelse',$variable);
                    $price = 0;
                    $validity = 12;
                    $purpose = '';
                    $product='default';
                    if(preg_match_all('/@price+(.*?)@endprice/', $pieces[0], $regs2))
                    {
                        foreach ($regs2[1] as $reg2){
                            $price = trim($reg2);
                        }
                        $pieces[0] = str_replace('@price'.$reg2.'@endprice', '' , $pieces[0]);
                    }

                    if(preg_match_all('/@validity+(.*?)@endvalidity/', $pieces[0], $regs2))
                    {
                        foreach ($regs2[1] as $reg2){
                            $validity = trim($reg2);
                        }
                        $pieces[0] = str_replace('@validity'.$reg2.'@endvalidity', '' , $pieces[0]);
                    }

                    if(preg_match_all('/@purpose+(.*?)@endpurpose/', $pieces[0], $regs2))
                    {
                        foreach ($regs2[1] as $reg2){
                            $purpose = trim($reg2);
                        }
                        $pieces[0] = str_replace('@purpose'.$reg2.'@endpurpose', '' , $pieces[0]);
                    }

                    if(preg_match_all('/@product+(.*?)@endproduct/', $pieces[0], $regs2))
                    {
                        foreach ($regs2[1] as $reg2){
                            $product = trim($reg2);
                        }
                        $pieces[0] = str_replace('@product'.$reg2.'@endproduct', '' , $pieces[0]);
                    }

                    $order = Order::where('user_id',$user_id)->where('product',$product)->orderBy('id','desc')->first();

                    $buyurl = route('product.order').'?purpose='.$purpose.'&txn_amount='.$price.'&validity='.$validity.'&product='.$product.'&redirect_url='.url()->current();
                    if($order){
                        $pieces[0] = str_replace("@buyurl",$buyurl,$pieces[0]);
                        if($order->status==1)
                        {
                            $pieces[1] = str_replace("@buyalert",'<div class="alert alert-success mb-3">Your product('.$purpose.') is activated!</div>',$pieces[1]);
                            $pieces[1] = str_replace("@buyurl",'',$pieces[1]);
                            $content = str_replace('@buy'.$reg.'@endbuy', $pieces[1] , $content);
                        }else if($order->status == 0){
                            $pieces[0] = str_replace("@buyalert",'<div class="alert alert-danger mb-3">Your payment is not completed! Retry!</div>',$pieces[0]);
                            $content = str_replace('@buy'.$reg.'@endbuy', $pieces[0] , $content);
                        }else if($order->status==2){
                            $pieces[0] = str_replace("@buyalert",'<div class="alert alert-warning mb-3">Your payment failed! Retry!</div>',$pieces[0]);
                            $content = str_replace('@buy'.$reg.'@endbuy', $pieces[0] , $content);
                        }
                        
                    }else{
                        $pieces[0] = str_replace("@buyalert",'',$pieces[0]);
                        $pieces[0] = str_replace("@buyurl",$buyurl,$pieces[0]);
                        $content = str_replace('@buy'.$reg.'@endbuy', $pieces[0] , $content);
                    }

                    
                }
            }
            
        }

        if(preg_match_all('/@referral+(.*?)@endreferral/', $content, $regs))
        {
            $referral_id = \Auth::user()->id;

 
            foreach ($regs[1] as $reg){
                $variable = trim($reg);
                if (strpos($variable, '@referralelse') !== false) {
                    $pieces = explode('@referralelse',$variable);
                    if(preg_match_all('/@rcount+(.*?)@endrcount/', $pieces[0], $regs2))
                    {
                        foreach ($regs2[1] as $reg2){
                            $rcount = trim($reg2);
                        }
                        $referrals = Page::referralCheck($referral_id,$rcount);
                        $pieces[0] = str_replace('@rcount'.$reg2.'@endrcount', '' , $pieces[0]);
                    }
                    $k=0;
                    if(count($referrals) < $rcount){
                       foreach($referrals as $k=>$rf){
                            $pieces[0] = str_replace("@rf".($k+1),$rf->user_name,$pieces[0]);
                       }

                       for($m=$k;$m<10;$m++){
                            $pieces[0] = str_replace("@rf".($m+1),'-',$pieces[0]);
                       }
                        
                       $content = str_replace('@referral'.$reg.'@endreferral', $pieces[0] , $content);
                    }else{
                       $content = str_replace('@referral'.$reg.'@endreferral', $pieces[1] , $content);  
                    }
                }
            }
            
        }



        if(preg_match_all('/@testapi+(.*?)@endtestapi/', $content, $regs))
        {
            $email = \Auth::user()->email;

 
            foreach ($regs[1] as $reg){
                $variable = trim($reg);
                if (strpos($variable, '@testapielse') !== false) {
                    $pieces = explode('@testapielse',$variable);
                    $form_entry = false;
                    $test_attempt = false;
                    if(preg_match_all('/@testurl+(.*?)@endtesturl/', $pieces[0], $regs2))
                    {
                        foreach ($regs2[1] as $reg2){
                            $slug = trim($reg2);

                            // remove the @testslug block
                            $pieces[0] = str_replace('@testurl'.$reg2.'@endtesturl', Page::testUrl($email,$slug) , $pieces[0]);
                            if(request()->get('dump2'))
                             dd(Page::testUrl($email,$slug));
                        }

                        if(request()->get('dump3'))
                            dd($slug);
                        $test_attempt = Page::testAttemptCheck($email,$slug);
                        if(request()->get('dump4'))
                            dd($test_attempt);
                    }



                    if(!$test_attempt){
                        $content = str_replace('@testapi'.$reg.'@endtestapi', $pieces[0] , $content);
                    }else{

                        if(isset($test_attempt->attempt->score)){
                            $pieces[1] = str_replace("@score",$test_attempt->attempt->score,$pieces[1]);
                            $pieces[1] = str_replace("@max",$test_attempt->attempt->max,$pieces[1]);
                        }else{
                            $pieces[1] = str_replace("@score",'-',$pieces[1]);
                            $pieces[1] = str_replace("@max",'-',$pieces[1]);
                        }
                        

                        $html = "<div class='alert alert-primary alert-testapi'>".$pieces[1]."</div>";
                        $content = str_replace('@testapi'.$reg.'@endtestapi', $pieces[1] , $content); 
                        // if(isset($test_attempt->exam_2)){

                        //     if(!$test_attempt->attempt_2)
                        //         $content = str_replace('@testapi'.$reg.'@endtestapi', $pieces[0] , $content);
                        // }else{
                             
                        //}
                        
                    }
                }
            }
            
        }


                
        $content = $this->minifyHtml($content);
        $this->html_minified = $content;

        return $this;
    }


    /**
     * Function to return the test url
     *
     */
    public static function testUrl($email,$slug){

        // create url
        $client_settings = json_decode(request()->get('client.settings'));
        if(isset($client_settings->testapi_url)){
           $url = $client_settings->testapi_url;
           $lastchar = $url[-1];
            if ( strcmp($lastchar, "/") === 0 ) {
               $url = $url.'test/'.$slug.'?email='.$email.'&hashcode=piofxapp734'.'&redirect='.url()->current();
            } else {
               $url = $url.'/test/'.$slug.'?email='.$email.'&hashcode=piofxapp734'.'&redirect='.url()->current();
            }

            return $url;
        }else
         return null;
        
    }

     /**
     * Function to check if referrals are satisfied
     *
     */
    public static function referralCheck($referral_id,$rcount){

        $client_id=request()->get('client.id');
        $url = url()->current();

        $referrals = Referral::where('client_id',$client_id)->where('referral_id',$referral_id)->where('url',$url)->get();

        return $referrals;
        
    }

    /**
     * Function to check if the test has been attempted
     *
     */
    public static function testAttemptCheck($email,$slug){

        // create url
        $client_settings = json_decode(request()->get('client.settings'));
        $user = \Auth::user();
        if(isset($client_settings->testapi_url)){
           $url = $client_settings->testapi_url;
           $lastchar = $url[-1];
            if ( strcmp($lastchar, "/") === 0 ) {
               $url = $url.'test/'.$slug.'/analysis_api?email='.$email.'&hashcode=piofxapp734&name='.$user->name.'&phone='.$user->phone;
            } else {
               $url = $url.'/test/'.$slug.'/analysis_api?email='.$email.'&hashcode=piofxapp734&name='.$user->name.'&phone='.$user->phone;
            }



            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $headers = array(
               "Accept: application/json",
            );
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            //for debug only!
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_VERBOSE, true);

            $resp = curl_exec($curl);
            curl_close($curl);
           

            // Will dump a beauty json :3
            return json_decode($resp); 
        }else
         return null;
        
    }

    /**
     * Function to replace the variables
     *
     */

    public function processHtml()
    {
        $content = $this->html;
        $settings = json_decode($this->settings);
        $data = '';

        //dd($settings);
        if(preg_match_all('/{{+(.*?)}}/', $content, $regs))
        {
            foreach ($regs[1] as $reg){
                $variable = trim($reg);
              

                $pos_0 = substr($variable,0,1);

                //varaibles in the current page settings
                if($pos_0=='$'){
                    $variable_name = str_replace('$', '', $variable);

                    $data = (isset($settings->$variable_name)) ? $settings->$variable_name : '';
                   
                    $content = str_replace('{{'.$reg.'}}', $data , $content);
                }

                //imporitng modules
                if($pos_0=='@'){
                    $variable_name = str_replace('@', '', $variable);

                    $module = Module::where('client_id',$this->client_id)->where('theme_id',$this->theme_id)->where('slug',$variable_name)->first();
                    //load it only if it is active
                    if($module)
                    if($module->status){
                        //check for local data
                        $data = $module->processPageModuleHtml($this->theme_id,$this->settings);
                    }
                    else
                        $data = '';
                    //dd($data);
                    $content = str_replace('{{'.$reg.'}}', $data , $content);
                }

                // loading theme setings variables
                if($pos_0==':'){
                    $variable_name = str_replace(':', '', $variable);
                    $theme = Theme::where('client_id',$this->client_id)->where('id',$this->theme_id)->first();
                    $sett = json_decode($theme->settings);

                    $data = (isset($sett->$variable_name)) ? $sett->$variable_name : '';
                    $content = str_replace('{{'.$reg.'}}', $data , $content);
                }




                if($pos_0=='&'){
                    $variable_name = str_replace('&', '', $variable);
                    $asset = Asset::where('client_id',$this->client_id)->where('theme_id',$this->theme_id)->where('slug',$variable_name)->first();
                    $data = ($asset) ? Storage::disk('s3')->url($asset->path) : '';
                    $content = str_replace('{{'.$reg.'}}', $data , $content);
                }

            }

            
        } 

        $content = $this->minifyHtml($content);
        $this->html_minified = $content;
        $this->save();
    }

    /**
     * Function to replace the variables from local storage
     *
     */

    public function processHtmlLocal($theme_id,$content,$settings,$server=false)
    {
        if(is_string($settings))
            $settings = json_decode($settings);
        $data = '';

      
        if(preg_match_all('/{{+(.*?)}}/', $content, $regs))
        {
            foreach ($regs[1] as $reg){
                $variable = trim($reg);
              

                $pos_0 = substr($variable,0,1);

                //varaibles in the current page settings
                if($pos_0=='$'){
                    $variable_name = str_replace('$', '', $variable);

                    $data = (isset($settings->$variable_name)) ? $settings->$variable_name : '';
                   
                    $content = str_replace('{{'.$reg.'}}', $data , $content);
                }

                //dd($content);

                //imporitng modules
                if($pos_0=='@'){
                    $variable_name = str_replace('@', '', $variable);


                    $module = null;
                    if(Storage::disk('public')->exists('devmode/'.$theme_id.'/data/module_'.$variable_name.'.json'))
                        $module = json_decode(Storage::disk('public')->get('devmode/'.$theme_id.'/data/module_'.$variable_name.'.json'));
                    
                    $settings_module = null;
                    if(Storage::disk('public')->exists('devmode/'.$theme_id.'/code/settings/module_'.$variable_name.'.json'))
                        $settings_module = json_decode(Storage::disk('public')->get('devmode/'.$theme_id.'/code/settings/module_'.$variable_name.'.json'));


                    //load it only if it is active
                    if($module)
                    if($module->status){
                        //check for local data
                        $data = Module::processPageModuleHtmlLocal($theme_id,$settings,$module->html,$settings_module,true);
                    }
                    else
                        $data = '';
                    //dd($data);
                    $content = str_replace('{{'.$reg.'}}', $data , $content);
                }

                // loading theme setings variables
                if($pos_0==':'){
                    $variable_name = str_replace(':', '', $variable);
                    $theme = null;
                    $theme_slug= request()->get('client.theme.slug');
                    if(Storage::disk('public')->exists('devmode/'.$theme_id.'/data/theme_'.$theme_slug.'.json'))
                        $theme = json_decode(Storage::disk('public')->get('devmode/'.$theme_id.'/data/theme_'.$theme_slug.'.json'));
                    
                    $settings_theme = null;
                    if(Storage::disk('public')->exists('devmode/'.$theme_id.'/code/settings/theme_'.$theme_slug.'.json'))
                        $settings_theme = json_decode(Storage::disk('public')->get('devmode/'.$theme_id.'/code/settings/theme_'.$theme_slug.'.json'));

                    $data = (isset($settings_theme->$variable_name)) ? $settings_theme->$variable_name : '';
                    $content = str_replace('{{'.$reg.'}}', $data , $content);
                }




                if($pos_0=='&'){
                    $variable_name = str_replace('&', '', $variable);
                    $asset = null;
                    if(Storage::disk('public')->exists('devmode/'.$theme_id.'/data/asset_'.$variable_name.'.json'))
                        $asset = json_decode(Storage::disk('public')->get('devmode/'.$theme_id.'/data/asset_'.$variable_name.'.json'));
                    
                    if(!$server)
                        $data = ($asset) ? Storage::disk('public')->url('devmode/'.$theme_id.'/code/assets/'.$asset->type.'/file_'.$asset->slug) : '';
                    else{
                        //  $path = 'themes/'.$theme_id.'/file_'.$asset->slug;
                        // $data = ($asset) ? Storage::disk('s3')->url($path) : '';
                        if(isset($asset->slug)){
                            $path = 'themes/'.$theme_id.'/file_'.$asset->slug;
                            $data = ($asset) ? Storage::disk('s3')->url($path) : '';
                        }else{
                            $data ='';
                        }
                        //$data = ($asset) ? Storage::disk('s3')->url($asset->path) : '';
                    }
                    $content = str_replace('{{'.$reg.'}}', $data , $content);
                }

            }

            
        } 

      

        $content = $this->minifyHtml($content);
        return $content;
    }

    /**
     * Function to minify the html code
     *
     */
    public static function minifyHtml($buffer) {

        $search = array(
            '/\>[^\S ]+/s',     // strip whitespaces after tags, except space
            '/[^\S ]+\</s',     // strip whitespaces before tags, except space
            '/(\s)+/s',         // shorten multiple whitespace sequences
            '/<!--(.|\s)*?-->/' // Remove HTML comments
        );

        $replace = array(
            '>',
            '<',
            '\\1',
            ''
        );

        $buffer = preg_replace($search, $replace, $buffer);

        return $buffer;
    }

    /**
   * Get the user that owns the page.
   *
   */
      public function saveSettings($id=null)
      {
          $data = request()->all();
          $settings = new Module;
          $flag=0;
          foreach($data as $key => $value){
            if(substr( $key, 0, 8 ) === "settings"){
              $d = str_replace("settings_", "", $key);
              $settings->$d = $value;
              $flag = 1;
            }
          }
          if($flag){
            $this->settings = json_encode($settings);
            $this->save();
            $this->processHtml();
          }

          $this->refreshCache($id);
          
      }

    /**
     * Load page from storage - devmode
     *
     */
    public static function loadpage($theme_id,$theme_slug,$page_slug)
    {
        if($page_slug=='/')
            $page_slug = 'root';

        $obj = json_decode(Storage::disk('public')->get('devmode/'.$theme_id.'/data/page_'.$page_slug.'.json'));
        $content = Storage::disk('public')->get('devmode/'.$theme_id.'/code/pages/'.$page_slug.'.php');
        


        $settings = json_decode(Storage::disk('public')->get('devmode/'.$theme_id.'/code/settings/page_'.$page_slug.'.json'));
        $data = '';

        if(preg_match_all('/{{+(.*?)}}/', $content, $regs))
        {
            foreach ($regs[1] as $reg){
                $variable = trim($reg);
                $pos_0 = substr($variable,0,1);

                //varaibles in the current page settings
                if($pos_0=='$'){
                    $variable_name = str_replace('$', '', $variable);

                    $data = (isset($settings->$variable_name)) ? $settings->$variable_name : '';
                   
                    $content = str_replace('{{'.$reg.'}}', $data , $content);
                }

                //imporitng modules
                if($pos_0=='@'){
                    $variable_name = str_replace('@', '', $variable);

                    $module = null;
                    if(Storage::disk('public')->exists('devmode/'.$theme_id.'/data/module_'.$variable_name.'.json'))
                        $module = json_decode(Storage::disk('public')->get('devmode/'.$theme_id.'/data/module_'.$variable_name.'.json'));

                    $module_html = null;
                    if(Storage::disk('public')->exists('devmode/'.$theme_id.'/code/modules/'.$variable_name.'.php')){
                        $module_html = Storage::disk('public')->get('devmode/'.$theme_id.'/code/modules/'.$variable_name.'.php');
                    }

                    $module_settings = null;
                    if(Storage::disk('public')->exists('devmode/'.$theme_id.'/code/settings/module_'.$variable_name.'.json'))
                        $module_settings = json_decode(Storage::disk('public')->get('devmode/'.$theme_id.'/code/settings/module_'.$variable_name.'.json'));
                  
                    //load it only if it is active
                    if($module)
                    if($module->status){
                        //check for local data
                        $data = Module::processPageModuleHtmlLocal($theme_id,$settings,$module_html,$module_settings);
                        //$data = $module->processPageModuleHtml($this->theme_id,$this->settings);
                    }
                    else
                        $data = '';

                    $content = str_replace('{{'.$reg.'}}', $data , $content);
                }

                // loading theme setings variables
                if($pos_0==':'){
                    $variable_name = str_replace(':', '', $variable);

                    $theme = null;
                    $theme_slug= request()->get('client.theme.slug');
                    if(Storage::disk('public')->exists('devmode/'.$theme_id.'/data/theme_'.$theme_slug.'.json'))
                        $theme = json_decode(Storage::disk('public')->get('devmode/'.$theme_id.'/data/theme_'.$theme_slug.'.json'));
                    
                    $sett = null;
                    if(Storage::disk('public')->exists('devmode/'.$theme_id.'/code/settings/theme_'.$theme_slug.'.json'))
                        $sett = json_decode(Storage::disk('public')->get('devmode/'.$theme_id.'/code/settings/theme_'.$theme_slug.'.json'));
                    // $theme = Theme::where('client_id',$this->client_id)->where('id',$this->theme_id)->first();
                    // $sett = json_decode($theme->settings);

                    $data = (isset($sett->$variable_name)) ? $sett->$variable_name : '';
                    $content = str_replace('{{'.$reg.'}}', $data , $content);
                }


                if($pos_0=='&'){
                    $variable_name = str_replace('&', '', $variable);
                    $asset = null;
                    if(Storage::disk('public')->exists('devmode/'.$theme_id.'/data/asset_'.$variable_name.'.json'))
                        $asset = json_decode(Storage::disk('public')->get('devmode/'.$theme_id.'/data/asset_'.$variable_name.'.json'));
                    
                    $data = ($asset) ? Storage::disk('public')->url('devmode/'.$theme_id.'/code/assets/'.$asset->type.'/file_'.$asset->slug) : '';
                    $content = str_replace('{{'.$reg.'}}', $data , $content);
                }

            }

            
        } 
        
        //$content = static::minifyHtml($content);
        $obj->html_minified = $content;
        return $obj;
    }

    /**
	 * Get the user that owns the page.
	 *
	 */
	public function user()
	{
	    return $this->belongsTo(User::class);
	}

	 /**
	 * Get the client that owns the page.
	 *
	 */
	public function client()
	{
	    return $this->belongsTo(Client::class);
	}

}
