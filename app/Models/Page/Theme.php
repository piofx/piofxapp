<?php

namespace App\Models\Page;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Core\Client;
use App\Models\Page\Asset;
use App\Models\Page\Module;
use App\Models\Page\Page;
use Illuminate\Support\Facades\Cache;
use Kyslik\ColumnSortable\Sortable;
use File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Theme extends Model
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
        'settings',
        'user_id',
        'admin',
        'client_id',
        'agency_id',
        'status',
    ];


    /**
     * Get the list of records from database
     *
     * @var array
     */
    public function getRecords($item,$limit,$user){

    	return $this->where('name','LIKE',"%{$item}%")
                    ->where('client_id',request()->get('client.id'))
                    ->orderBy('created_at','desc')
                    ->paginate($limit);

    }

    /**
     * Get the theme data
     *
     * @var array
     */
    public function getCurrentThemeID(){
       
        $theme =$this->where('slug',request()->get('client.theme.name'))
                    ->first();
        if($theme)
            return $theme->id;

        return null;

    }


     /**
     * Refresh the cache data
     *
     */

    public function updateCurrentTheme(){

        $default = request()->get('default');

        if($default){
            $client_id = request()->get('client.id');
            $client = Client::where('id',$client_id)->first();
            $settings = json_decode($client->settings);
            $settings->theme = $this->slug;
            $client->settings = json_encode($settings);
            $client->save();

            $domain = request()->getHttpHost();
            Cache::forget('client_'.$domain);
            Cache::forget('theme_'.$domain);
            Cache::forget('agency_'.$domain);
        }


    }
    

    /**
     * Refresh the cache data
     *
     */

    public function refreshCache(){

        // get the domain name
        $domain = $this->client->domain;

        // reload the cache
        Cache::forget('theme_'.$domain);
        Cache::forever('theme_'.$domain,$this);


    }

    /**
     * Function to replace the variables
     *
     */

    public function processHtml()
    {
        $theme_id = $this->id;
        $modules = Module::where('theme_id',$theme_id)->get();
        foreach($modules as $m){
          $m->processHtml($theme_id);
        }

        $pages = Page::where('theme_id',$theme_id)->get();
        foreach($pages as $p){
          $p->processHtml($theme_id);
        }
    }


    /**
     * Function to replace the variables
     *
     */

    public function processSettings()
    {
        $settings = json_decode($this->settings);

        if($settings)
        if(isset($settings->modules))
        foreach($settings->modules as $modulename=>$item){
            
            $module = Module::where('client_id',$this->client_id)->where('slug',$modulename)->first();
            if($module){
                $settings->modules->$modulename = $module;
            }
                
        }

        $this->settings = json_encode($settings);
        $this->save();
    }

    /**
     * Function to minify the html code
     *
     */
    public function minifyHtml($buffer) {

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
     * Identify theme details
     *
     */

    public function identifyTheme($obj,$path,$filename)
    {
        

        // for json file
        if (strpos($filename, '.json') !== false) {
            if (strpos($filename, 'theme_') !== false) {
              $content = File::get($path.'/'.$filename);
              $json = json_decode($content);
             
              if(request()->get('theme_slug')){
                $obj = Theme::where('slug',request()->get('theme_slug'))->where('client_id',request()->get('client.id'))->first();
              }else{
                $obj = new Theme;
              }

              

              if($obj->slug){

                $obj->settings = $json->settings;
                $obj->user_id = \Auth::user()->id;
                $obj->status = 1;
                $obj->save();
              }else{
                $obj->name = $json->name;
                $obj->slug = Str::random();
                $obj->settings = $json->settings;
                $obj->client_id = request()->get('client.id');
                $obj->agency_id = request()->get('agency.id');
                $obj->user_id = \Auth::user()->id;
                $obj->status = 1;
                
                $obj->save();
              }

                
              return $obj;

            }

        }
    }

    /**
     * Process files
     *
     */

    public function processFile($theme,$path,$filename,$extractToPath)
    {

        $content = File::get($path.'/'.$filename);
        $json = json_decode($content);

        //add the slashes 
        if($json)
        if(strpos($json->slug, '@') !== false){
            $json->slug = str_replace('@','/',$json->slug);
        }
        // for json file

        if (strpos($filename, '.json') !== false) {
            if (strpos($filename, 'asset_') !== false) {


                $fname = $json->slug;
                $fslug = $json->slug;
                //filename
                if (strpos($fname, 'file_') !== false) {
                }else
                    $fname = 'file_'.$fname;

                if(Storage::disk('private')->exists($extractToPath.'/'.$fname)){
                     //upload to s3
                    $f = Storage::disk('private')->path($extractToPath.'/'.$fname);
                    $path = Storage::disk('s3')->putFileAs('themes/'.$theme->id,$f,$fname,'public');
                    
                    $asset = null;
                    if(request()->get('theme_slug')){
                        $asset = Asset::where('slug',$fslug)->where('client_id',request()->get('client.id'))->first();
                    }

                    if($asset){
                        $asset->path = $path;
                        $asset->type = $json->type;
                        $asset->user_id = \Auth::user()->id;
                        $asset->theme_id = $theme->id;
                        $asset->status = 1;
                        $asset->save();
                    }else{
                        $asset = new Asset;
                        $asset->name = $json->name;
                        $asset->slug = $fslug;
                        $asset->path = $path;
                        $asset->type = $json->type;
                        $asset->client_id = request()->get('client.id');
                        $asset->agency_id = request()->get('agency.id');
                        $asset->user_id = \Auth::user()->id;
                        $asset->theme_id = $theme->id;
                        $asset->status = 1;
                        $asset->save();

                    }
                    
                }
               
              //copy($path.'/file_'.$json->slug, storage_path('app/public/themes/'.$theme->id.'/file_'.$json->slug));

            }else if (strpos($filename, 'module_') !== false) {
                $module = null;
                if(request()->get('theme_slug')){
                    $module = Module::where('slug',$json->slug)->where('client_id',request()->get('client.id'))->first();
                }


                if($module){
                  $module->html = $json->html;
                  $module->html_minified= $json->html_minified;
                  $module->settings= $json->settings;
                  $module->user_id = \Auth::user()->id;
                  $module->status = 1;
                  $module->save();
                }else{
                  $module = new Module;
                  $module->name = $json->name;
                  $module->slug = $json->slug;
                  $module->html = $json->html;
                  $module->html_minified= $json->html_minified;
                  $module->settings= $json->settings;
                  $module->admin= $json->admin;
                  $module->client_id = request()->get('client.id');
                  $module->agency_id = request()->get('agency.id');
                  $module->user_id = \Auth::user()->id;
                  $module->theme_id = $theme->id;
                  $module->status = 1;
                  $module->save();

                }
                 
              
            }
            else if (strpos($filename, 'page_') !== false) {
                $page = null;
                if(request()->get('theme_slug')){
                    $page = Page::where('slug',$json->slug)->where('client_id',request()->get('client.id'))->first();
                }

                if($page){
                  $page->html = $json->html;
                  $page->html_minified= $json->html_minified;
                  $page->settings= $json->settings;
                  $page->user_id = \Auth::user()->id;
                  $page->status = 1;
                  $page->save();
                }else{
                    $page = new Page;
                  $page->name = $json->name;
                  $page->slug = $json->slug;
                  $page->html = $json->html;
                  $page->html_minified= $json->html_minified;
                  $page->settings= $json->settings;
                  $page->admin= $json->admin;
                  $page->client_id = request()->get('client.id');
                  $page->agency_id = request()->get('agency.id');
                  $page->user_id = \Auth::user()->id;
                  $page->theme_id = $theme->id;
                  $page->status = 1;
                  $page->save();
                }
              
            }


            

        }
        
                    
    }

    /**
   * Save Settings
   *
   */
      public function saveSettings()
      {
          $data = request()->all();

          $settings = new Theme;
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

            return 1;
          }

          return 0;
          
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
