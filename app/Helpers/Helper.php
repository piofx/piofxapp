<?php

use Illuminate\Support\Facades\Storage;


// function to minify css
if (!function_exists('minifyCSS')) {
	function minifyCSS($css){
		$css = preg_replace('/\/\*((?!\*\/).)*\*\//', '', $css); // negative look ahead
		$css = preg_replace('/\s{2,}/', ' ', $css);
		$css = preg_replace('/\s*([:;{}])\s*/', '$1', $css);
		$css = preg_replace('/;}/', '}', $css);
		return $css;
	}
}

// function to load modules from the settings
if (!function_exists('componentName')) {
	function componentName($mode,$layout=null){

		if(!$layout)
			$layout = 'app';
		
		if($mode=='agency')
			$theme = request()->get('agency.theme.name');
		else
			$theme = 'barebone';//request()->get('client.theme.name');
		
		return 'themes.'.$theme.'.layouts.'.$layout;
	}
}



// function to retrive data theme settings
if (!function_exists('theme')) {
	function theme($key){

		$settings = request()->get('client.theme.settings');

		$value = null;

		//check if the settings json has the direct key and value pair
		if(isset($settings->$key))
			$value = $settings->$key;

		//check if the settings json has the key, value inside modules
		if(isset($settings->modules->$key->status))
			if($settings->modules->$key->status)
				$value = $settings->modules->$key->html_minified;

		return $value;
	}
}


// function to retrive data from the client settings
if (!function_exists('client')) {
	function client($key){
		$settings = json_decode(request()->get('client.settings'));
		$value = null;

		
		
		//check if the settings json has the direct key and value pair
		if(isset($settings->$key))
			$value = $settings->$key;

		//check if the settings json has the key, value inside apps
		if(isset($settings->apps->$key->status))
			if($settings->apps->$key->status)
				$value = $settings->apps->$key->html_minified;

			
		return $value;
	}
}

// function to retrive data from the agency settings
if (!function_exists('agency')) {
	function agency($key){
		$settings = request()->get('agency.settings');
		$value = null;

		//check if the settings json has the direct key and value pair
		if(isset($settings->$key))
			$value = $settings->$key;

		//check if the settings json has the key, value inside apps
		if(isset($settings->apps->$key->status))
			if($settings->apps->$key->status)
				$value = $settings->apps->$key->html_minified;

		return $value;
	}
}

 
if (! function_exists('s3_upload')) {
    function s3_upload($name,$path)
    {
        Storage::disk('s3')->put('images/'.$name,file_get_contents($path),'public'); 
        return  Storage::disk('s3')->url('images/'.$name);
    }
}
 

if (! function_exists('quill_imageupload')) {
    function quill_imageupload($user,$editor_data)
    {
    	$detail=$editor_data;
        if($detail){
            $dom = new \DomDocument();
            libxml_use_internal_errors(true);
            $dom->loadHtml(mb_convert_encoding($detail, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);    
            $images = $dom->getElementsByTagName('img');
            $data = null;
 
            foreach($images as $k => $img){
 
                $data = $img->getAttribute('src');
 
                if(strpos($data, ';'))
                {
                    list($type, $data) = explode(';', $data);
                    list(, $data)      = explode(',', $data);
                    $data = base64_decode($data);
 
                    $base_folder = '/app/public/';
                    $image_name=  'post_' . time() . "_" . $user->username . '_' . rand() . '.png';
					
                    $temp_path = storage_path() . $base_folder . 'images/' . $image_name;
                    // $web_path = env('APP_URL').'storage/images/'. $image_name;
					// Storage::disk('s3')->put('', file_get_contents($path),'public'); 
                    file_put_contents($temp_path, $data);
                    // resize
                    $imgr = Image::make($temp_path);
                    $imgr->resize(800, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $imgr->save($temp_path);
 
                    $url = s3_upload($image_name,$temp_path);
                    unlink(trim($temp_path));
 
                    $img->removeAttribute('src');
                    $img->setAttribute('src', $url);
					if($img->hasAttribute("class")){
						$img->removeAttribute('class');
						$img->setAttribute('class', 'img-fluid rounded-lg');
					}
					else{
						$img->setAttribute('class', 'img-fluid rounded-lg');
					}
                }
			}
 
            if($data)
                $detail = $dom->saveHTML();
            else
                $detail = $editor_data;
        }
        return $detail;
    }

if (! function_exists('debounce_valid_email'))
{
	function debounce_valid_email($email) {
        $api = '6075b8772c316';
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, 'https://api.debounce.io/v1/?api='.$api.'&email='.strtolower($email));
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);       

        $data = curl_exec($ch);
        curl_close($ch);

        $json = json_decode($data, true);

        if($json['debounce']['code']==5)
            return 1;
        else
            return 0;
    }
}

}