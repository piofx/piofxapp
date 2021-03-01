<?php

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

