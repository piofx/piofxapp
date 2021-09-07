<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Core\Client as Obj;
use App\Models\Core\Agency;
use App\Models\Page\Theme;
use App\Models\Page\Page;
use Illuminate\Support\Facades\Cache;

class Client
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // get the domain name
        $domain = request()->getHttpHost();

        // refresh the cache
        if($request->get('refresh')){
            Cache::forget('client_'.$domain);
            Cache::forget('theme_'.$domain);
            Cache::forget('agency_'.$domain);
            Cache::forget('page_'.$domain, '3600');
            session()->flush();
        }

        // load client from cache
        $client = Cache::remember('client_'.$domain, '3600', function () use($domain){
            return Obj::where('domain',$domain)->first();
        });

        if($request->get('dump'))
            dd($client);

        if(!$client)
            abort('404','Site not found');

        $client_id = $client->id;

        // load client from cache
        $agency= Cache::remember('agency_'.$domain, '3600', function () use($client){
            return Agency::where('id',$client->agency_id)->first();
        });

        // convert settings to object
        $settings = json_decode($client->settings);
        $themename = $settings->theme;

        // load theme from cache
        $theme = Cache::remember('theme_'.$domain, '3600', function () use($client_id,$themename){
            return Theme::where('client_id',$client_id)->where('slug',$themename)->first();
        });

        if(!$theme){
            $theme = Theme::where('client_id',$client_id)->where('slug','default')->first();
        }


        $theme->settings = json_decode($theme->settings);
        $agency_settings = json_decode($agency->settings);

        //load page data for app embed in the theme
        $this->themeapp($theme,$client_id,$domain,$request);

        //check for redirects
        $redirect_check = $this->redirect($settings);
        if($redirect_check)
            return redirect($redirect_check,301);

        if(!$settings)
            abort('404','Invalid Settings');
        
        if($client){
            if($client->status){
                $this->add($request,$client,$domain,$theme,$settings,$agency_settings,$agency);

                // If maintenance mode is active then allow only few routes
                // If superadmin is given in url then allow acces even in maintenance mode
                if(isset($settings->maintenance_mode) && $settings->maintenance_mode == 'active'){
                    $path = explode("/", $request->path());
                    $allowed_routes = ['admin', 'login', 'register', 'forgot-password', 'logout', 'logged_in'];
                    if(!in_array($path[0], $allowed_routes)){
                        if(request()->get('superadmin')){
                            return $next($request);
                        }
                        abort('403','Site is under Maintenance');
                    }
                }
                
                return $next($request);
            }else{
                abort('403','Site inactive');
            }
        }else{
            abort('403','Site not found');
        }
        
    }

    public function add($request,$client,$domain,$theme,$settings,$agency_settings,$agency){


        $request->request->add(['domain.name' => $domain]);

        $request->request->add(['client.id' => $client->id]);
        $request->request->add(['client.name' => $client->name]);
        $request->request->add(['client.settings' => $client->settings]);
        $request->request->add(['client.devmode' => false]);
        if(isset($settings->devmode)){
            if($settings->devmode)
                $request->request->add(['client.devmode' => true]);
        }
        $request->request->add(['client.theme.id' => $theme->id]);
        $request->request->add(['client.theme.active' => $theme->status]);
        $request->request->add(['client.theme.name' => $theme->slug]);
        $request->request->add(['client.theme.slug' => $theme->slug]);
        $request->request->add(['client.theme.settings' => $theme->settings]);
        
        $request->request->add(['agency.id' => $agency->id]);
        $request->request->add(['agency.theme.name' => $agency_settings->theme]);
        $request->request->add(['agency.settings' => $agency_settings]);

    }


    public function themeapp($theme,$client_id,$domain,$request){


        $app_page = Cache::remember('page_'.$domain, '3600', function () use($client_id,$theme){
            return Page::where('client_id',$client_id)->where('theme_id',$theme->id)->where('slug','+')->first();
        });

        if(!$app_page)
            return false;
        else{
            $data = $app_page->html_minified;
            $pieces = explode('{{+}}', $data);
            if(count($pieces)==2){
                $request->request->add(['app.theme.prefix' => $pieces[0]]);
                $request->request->add(['app.theme.suffix' => $pieces[1]]);
            }
        }
        
    }

    public function redirect($client_settings){

        if(isset($client_settings->redirect)){

            $redirects = json_decode(json_encode($client_settings->redirect, JSON_PRETTY_PRINT), true);

            $requestUrl = request()->path();
            $requestUrlParts = explode("/", $requestUrl);
            // check for direct match
            if(isset($redirects['/'.$requestUrl])){
                return $redirects['/'.$requestUrl];
            }
            // Check if the redirect slug exists in the url, if true replace it
            else if(isset($redirects['/'.end($requestUrlParts)])){
                $newSlug = explode("/",$redirects['/'.end($requestUrlParts)]);
                $newUrl = str_replace(end($requestUrlParts), end($newSlug), $requestUrl);
                return $newUrl;
            }
            // check if there is something like /xyz/* and redirect accordingly
            else if(isset($redirects['/'.$requestUrlParts[0].'/*'])){
                return $redirects['/'.$requestUrlParts[0].'/*'];
            }
        }
        return null;
    }

    public function maintenance(){
        
    }
   
}
