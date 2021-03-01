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
            session()->flush();
        }

        // load client from cache
        $client = Cache::remember('client_'.$domain, '3600', function () use($domain){
            return Obj::where('domain',$domain)->first();
        });

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

        if(!$settings)
            abort('404','Invalid Settings');
        
        if($client){
            if($client->status){
                $this->add($request,$client,$domain,$theme,$settings,$agency_settings,$agency);
                
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
        $request->request->add(['client.theme.id' => $theme->id]);
        $request->request->add(['client.theme.name' => $theme->slug]);
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

   
}
