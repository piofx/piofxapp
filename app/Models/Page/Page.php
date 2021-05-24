<?php

namespace App\Models\Page;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Core\Client;
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
                         $path = 'themes/'.$theme_id.'/file_'.$asset->slug;
                        $data = ($asset) ? Storage::disk('s3')->url($path) : '';
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
      public function saveSettings()
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
                    
                    $data = ($asset) ? Storage::disk('s3')->url('devmode/'.$theme_id.'/code/assets/'.$asset->type.'file_'.$asset->slug) : '';
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
