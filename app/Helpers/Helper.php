<?php

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use App\Models\College\College;


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

// function to load modules from the settings
if (!function_exists('adminMetaTitle')) {
	function adminMetaTitle($title){
		$client_name = request()->get('client.name');
		request()->merge(['client.meta_title'=>$title . ' | ' .$client_name]);
	}
}

// function to load modules from the settings
if (!function_exists('updateMetaTitle')) {
	function updateMetaTitle($title){
		$content = request()->get('app.theme.prefix');
		
		$pieces = explode('<title>',$content);
		
        $buffer = $pieces[0].'<title>'.$title.$pieces[1];//preg_replace('/(<title>)(.*?)(<\/title>)/i', '$1' . $title . '$3', $content);
      	$pieces = explode('<meta property="og:title" content="',$buffer);
      	if(isset($pieces[1])){
      		$new_buffer = $pieces[0].'<meta property="og:title" content="'.$title.$pieces[1];
       	 //$buffer = preg_replace('/(<meta property="og:title" content=")(.*?)(">)/i', '$1' . $title . '$3', $buffer);
        	request()->merge(['app.theme.prefix' => $new_buffer,]);
      	}
      	
	}
}

// function to load modules from the settings
if (!function_exists('updateMetaImage')) {
	function updateMetaImage($image){
		$content = request()->get('app.theme.prefix');
        $buffer = preg_replace('/(<meta property="og:image" content=")(.*?)(">)/i', '$1' . $image . '$3', $content);
        request()->merge(['app.theme.prefix' => $buffer,]);
	}
}
// function to load modules from the settings
if (!function_exists('updateMetaUrl')) {
	function updateMetaUrl(){
		$content = request()->get('app.theme.prefix');
		$url = url()->current();
        $buffer = preg_replace('/(<meta property="og:url" content=")(.*?)(">)/i', '$1' . $url . '$3', $content);
        request()->merge(['app.theme.prefix' => $buffer,]);
	}
}



// function to load modules from the settings
if (!function_exists('updateMetaDescription')) {
	function updateMetaDescription($description){
		$content = request()->get('app.theme.prefix');

		$pieces = explode('<meta name="description" content="',$content);

		$buffer = $pieces[0].'<meta name="description" content="'.$description." ".$pieces[1];

		
        //$buffer = preg_replace('/(<meta name="description" content=")(.*?)(">)/i', '$1' . $description . '$3', $content);
        // $buffer =  preg_replace('/(<meta name="description" content=")(.*?)(">)/i','<meta name="description" content="'.$description.'" >', $content);
		$pieces = explode('<meta property="og:description" content="',$buffer);
		if(isset($pieces[1])){
		$new_buffer = $pieces[0].'<meta property="og:description" content="'.$description.$pieces[1];
       //$new_buffer = preg_replace('/(<meta property="og:description" content=")(.*?)(">)/i', '$1' . $description . '$3', $buffer);
        request()->merge(['app.theme.prefix' => $new_buffer,]);
    	}else{
    		request()->merge(['app.theme.prefix' => $buffer,]);
    	}
    	
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
 

if (! function_exists('blog_image_upload')) {
    function blog_image_upload($userId, $editor_data)
    {
		// Check if temp path exists else create it
		if(!Storage::disk('public')->exists('images')) {
			Storage::disk('public')->makeDirectory('images'); //creates directory
		}

		// Get Editor data
    	$detail = $editor_data;
		// If data is present
        if($detail){
			// Get img data from html using dom
            $dom = new \DomDocument();
            libxml_use_internal_errors(true);
            $dom->loadHtml(mb_convert_encoding($detail, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);    
            $images = $dom->getElementsByTagName('img');
            $data = null;
 
			// For every image resize and upload images to s3
            foreach($images as $k => $img){
 
                $data = $img->getAttribute('src');
 
                if(strpos($data, ';'))
                {
                    list($type, $data) = explode(';', $data);
                    list(, $data)      = explode(',', $data);
					// Image data in base 64 format
                    $data = base64_decode($data);
 
                    $base_folder = '/app/public/';
                    $image_name=  'post_' . time() . "_" . $userId . '_' . rand() . '.jpg';

					// Temporary folder for image
                    $temp_path = storage_path() . $base_folder . 'images/' . $image_name;
                
					// Save image at temp path
                    file_put_contents($temp_path, $data);

					// Retrieve Image
					$retrieved_image = Storage::disk('public')->get('images/' . $image_name);
 
					// Resize and upload Image
					image_resize($retrieved_image, 800, $image_name);
					image_resize($retrieved_image, 400, $image_name);

					// Upload Original Image
                    $url = s3_upload($image_name, $temp_path);
                    unlink(trim($temp_path));
 
                    $img->removeAttribute('src');
                    $img->setAttribute('src', $url);
					if($img->hasAttribute("class")){
						$img->removeAttribute('class');
						$img->setAttribute('class', 'img-fluid rounded-lg rounded-3 w-100');
					}
					else{
						$img->setAttribute('class', 'img-fluid rounded-lg rounded-3 w-100');
					}
                }
			}
 
            if($data)
                $detail = $dom->saveHTML();
            else
                $detail = $editor_data;
        }

		// Delete Directory
		Storage::disk('public')->deleteDirectory('images');

        return $detail;
    }

	if (! function_exists('getCsv')) {
		function getCsv($columnNames, $rows, $fileName = 'file.csv') {
			$headers = [
				"Content-type" => "text/csv",
				"Content-Disposition" => "attachment; filename=" . $fileName,
				"Pragma" => "no-cache",
				"Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
				"Expires" => "0"
			];
			$callback = function() use ($columnNames, $rows ) {
				$file = fopen('php://output', 'w');
				fputcsv($file, $columnNames);
				foreach ($rows as $row) {
					fputcsv($file, $row);
				}
				fclose($file);
			};
			return response()->stream($callback, 200, $headers);
		}
	}

	if (! function_exists('image_resize')) {
		// Image = image retrieved from request object directly
		// Size = size in px
		// Filename = filename with extension
		function image_resize($image, $size, $filename)
		{
			$tag = 'resized';
			if($size <= 400){
				$tag = "mobile";
			} 

			// Getting filename without extension
			$filename = explode(".", $filename);
			$filename = $filename[0];

			// WebP version of the image
			$webpImgr = Image::make($image)->encode('webp');
			$webpImgr->resize($size, null, function ($constraint) {
				$constraint->aspectRatio();
				$constraint->upsize();
			});
			$webpImgr = $webpImgr->stream();
			Storage::disk('s3')->put('resized_images/'.$filename.'_'.$tag.'.webp', $webpImgr->__toString(),'public');

			// JPG Version of the image
			$jpgImgr = Image::make($image)->encode('jpg', 75);			
			$jpgImgr->resize($size, null, function ($constraint) {
							$constraint->aspectRatio();
							$constraint->upsize();
			});
			$jpgImgr = $jpgImgr->stream();
			Storage::disk('s3')->put('resized_images/'.$filename.'_'.$tag.'.jpg', $jpgImgr->__toString(),'public');
		}
	}

	if (! function_exists('debounce_valid_email')){
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

	// Function to change 1000 to 1k and so on
	if(!function_exists('format_number')){
		function format_number($input){
			$suffixes = array('', 'k', 'm', 'g', 't');
			$suffixIndex = 0;

			while(abs($input) >= 1000 && $suffixIndex < sizeof($suffixes))
			{
				$suffixIndex++;
				$input /= 1000;
			}

			return (
				$input > 0
					// precision of 3 decimal places
					? floor($input * 1000) / 1000
					: ceil($input * 1000) / 1000
				)
				. $suffixes[$suffixIndex];
		}
	}

	// Function to convert settings to json from front end
	if(!function_exists('dev_normal_mode')){
		function dev_normal_mode($data){
			$settings = array();
			$names = [];
			if(!isset($data['mode']))
				$data['mode'] = 'normal';


			// Check if data is sent from normal mode or dev mode
			if($data['mode'] == 'normal'){
				// Add the key and vales to settins array by checking if there is a nested array
				foreach($data as $k => $value){
					$keys = explode('-', $k);
					if($keys[0] == 'settings' && $keys[1] == 'array'){
						if(!in_array($keys[2], $names)){
							array_push($names, $keys[2]);
						}
					}
					else if($keys[0] == 'settings' && $keys[1] == 'sArray'){
						if(!in_array($keys[2], $names)){
							array_push($names, $keys[2]);
						}
					}
					else if($keys[0] == 'settings' && $keys[1] != 'array'){
						$settings[$keys[1]] = $value;
					}
					
				}

				foreach($names as $name){
					$new_keys = array();
					$temp = array();
					foreach($data as $k => $value){
						$keys = explode('-', $k);
						if(sizeof($keys) > 2 && $keys[1] == 'array' && $keys[2] == $name && $keys[4] == 'key'){
							foreach($value as $v ){
								array_push($new_keys, $v);
							}
						}
						elseif(sizeof($keys) > 2 && $keys[1] == 'array' && $keys[2] == $name && $keys[4] == 'value'){
							$t = array();
							foreach($value as $k => $v){
								$t[$new_keys[$k]] = $v;
							}
							array_push($temp, $t);
						}
						else if(sizeof($keys) > 2 && $keys[1] == 'sArray' && $keys[2] == $name && $keys[4] == 'value'){
							foreach($value as $k => $v){
								$temp[$keys[3]] = $v;
							}
						}
					}
					$settings[$name] = $temp;
				}

				$settings = json_encode($settings, JSON_PRETTY_PRINT, JSON_UNESCAPED_SLASHES);
			}
			else if($data['mode'] == 'dev'){
				if(validJson($data['settings'])){
					$settings = json_encode(json_decode($data['settings']), JSON_PRETTY_PRINT, JSON_UNESCAPED_SLASHES);
					$settings = str_replace("\r", "", $settings);
					$settings = str_replace("\t", "", $settings);
				}
				else{
					return 0;
				}
			}

			return $settings;
		}
	}

	if(!function_exists("validJson")){
		function validJson($encodedData){
			// Decode the data and if it is null, then Json in invalid
			$data = json_decode($encodedData);
			if(is_null($data)){
				return 0;
			}else{
				return 1;
			}
		}
	}

	if(!function_exists("sendWhatsApp")){
	     function sendWhatsApp($phone,$template,$variables){
	            $url = client("wa_url");
	            $token = client("wa_token");

	            if(!$url || !$token)
	            	return false;

	            $curl = curl_init();
	            if(strlen($phone)==10)
	                $phone = '91'.$phone;

	            if(count($variables)==0){
	                $msg = '{
	                "messaging_product": "whatsapp",
	                "to": '.$phone.',
	                "type": "template",
	                "template": {
	                    "name": "'.$template.'",
	                    "language": {
	                        "code": "en_US"
	                    }
	                }
	            }';
	            }elseif(count($variables)==1){
	                 $msg = '{
	                    "messaging_product": "whatsapp",
	                    "to": '.$phone.',
	                    "type": "template",
	                    "template": {
	                        "name": "'.$template.'",
	                        "language": {
	                            "code": "en_US"
	                        },
	                         "components": [
	                          {
	                            "type": "body",
	                            "parameters": [
	                              {
	                                "type": "text",
	                                "text": "'.$variables[0].'"
	                              }
	                            ]
	                          }
	                        ]
	                    }
	                }';
	            }else if(count($variables)==2){
	                $msg = '{
	                    "messaging_product": "whatsapp",
	                    "to": '.$phone.',
	                    "type": "template",
	                    "template": {
	                        "name": "'.$template.'",
	                        "language": {
	                            "code": "en_US"
	                        },
	                         "components": [
	                          {
	                            "type": "body",
	                            "parameters": [
	                              {
	                                "type": "text",
	                                "text": "'.$variables[0].'"
	                              },
	                              {
	                                "type": "text",
	                                "text": "'.$variables[1].'"
	                              }
	                            ]
	                          }
	                        ]
	                    }
	                }';
	            }else if(count($variables)==3){
	                $msg = '{
	                    "messaging_product": "whatsapp",
	                    "to": '.$phone.',
	                    "type": "template",
	                    "template": {
	                        "name": "'.$template.'",
	                        "language": {
	                            "code": "en_US"
	                        },
	                         "components": [
	                          {
	                            "type": "body",
	                            "parameters": [
	                              {
	                                "type": "text",
	                                "text": "'.$variables[0].'"
	                              },
	                              {
	                                "type": "text",
	                                "text": "'.$variables[1].'"
	                              },
	                              {
	                                "type": "text",
	                                "text": "'.$variables[2].'"
	                              }
	                            ]
	                          }
	                        ]
	                    }
	                }';
	            }else if(count($variables)==4){
	                $msg = '{
	                    "messaging_product": "whatsapp",
	                    "to": '.$phone.',
	                    "type": "template",
	                    "template": {
	                        "name": "'.$template.'",
	                        "language": {
	                            "code": "en_US"
	                        },
	                         "components": [
	                          {
	                            "type": "body",
	                            "parameters": [
	                              {
	                                "type": "text",
	                                "text": "'.$variables[0].'"
	                              },
	                              {
	                                "type": "text",
	                                "text": "'.$variables[1].'"
	                              },
	                              {
	                                "type": "text",
	                                "text": "'.$variables[2].'"
	                              },
	                              {
	                                "type": "text",
	                                "text": "'.$variables[3].'"
	                              }
	                            ]
	                          }
	                        ]
	                    }
	                }';
	            }
	           
	           //dd($msg);

	            curl_setopt_array($curl, array(
	              CURLOPT_URL => $url,
	              CURLOPT_RETURNTRANSFER => true,
	              CURLOPT_ENCODING => '',
	              CURLOPT_MAXREDIRS => 10,
	              CURLOPT_TIMEOUT => 0,
	              CURLOPT_FOLLOWLOCATION => true,
	              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	              CURLOPT_CUSTOMREQUEST => 'POST',
	              CURLOPT_POSTFIELDS =>$msg,
	              CURLOPT_HTTPHEADER => array(
	                'Content-Type: application/json',
	                'Authorization: Bearer '.$token
	              ),
	            ));

	            $response = curl_exec($curl);
	            curl_close($curl);
	            //dd($response);
	            return true;

	    }
	}

	if(!function_exists("colleges")){
		function colleges(){
			if(request()->get('refresh')){
				Cache::forget('collegesalls');
			}
			$colleges = Cache::get('collegesalls');
			if(!$colleges){
				$colleges = College::orderby('name')->get();
				Cache::forever('collegesalls',$colleges);
				return $colleges;
				
			}
	        return $colleges;
		}
	}

	if(!function_exists("branches")){
		function branches(){
			$branches = ["Aeronautical Engineering","Civil Engineering","Computer Science and Engineering (CSE)","CSE (AI & ML)","CSE (Cyber Security)","CSE (Data Science)","CSE (Internet of Things)","CSE (Networks)","CSE (Software Engineering)","Electrical and Electronics Engineering (EEE)","Electronics and Communication Engineering (ECE)","Electronics and Instrumentation Engineering","Electronics and Telematics Engineering","Information Technology (IT)","Mechatronics Engineering (Mechanical)","Mechanical Engineering","Metallurgy and Materials Engineering","Mining Engineering","Bachelor of Business Administration (BBA)","Bachelor of Computer Applications (BCA)","Bachelor of Science Computers(BSC - CS)","Bachelor of Science (BSC Regular)","Bachelor of Commerce Computers (BCOM - CS)","Bachelor of Commerce (BCOM Regular)","Bachelor of Pharmacy (BPharma)","Masters of Business Administration (MBA)","Master of Computer Applications (MCA)","Master of Technology (MTECH)","Master of Science Computers (MSCS)","Master of Science Regular (MSC)","Master of Pharma (MPharma)","OTHER"];
	        return $branches;
		}
	}

	if(!function_exists("yop")){
		function yop(){
			$yop = ["2020","2021","2022","2023","2024","2026","2027","2028","2029","2030","OTHER"];
	        return $yop;
		}
	}

	if(!function_exists("cities")){
		function cities(){
			$data = file_get_contents('cities.json');
			$data = str_replace("\"","",$data);
			$data = str_replace("\n","",$data);
			$cities = explode(",",$data);
	        return $cities;
		}
	}

	if(!function_exists("districts")){
		function districts(){
			$data = json_decode(file_get_contents('districts.json'),true);
	        $states = $districts = [];
	        foreach($data as $a =>$b){
	            foreach($b as $m=>$n)
	            {
	                foreach($n as $p=>$q)
	                    if($p=='state'){
	                        array_push($states,$q);
	                    }else{
	                        foreach($q as $r=>$s)
	                            array_push($districts,$s);
	                    }
	            }
	        }
	        sort($districts);
	        return $districts;
		}
	}

	if(!function_exists("states")){
		function states(){
			$data = json_decode(file_get_contents('districts.json'),true);
	        $states = $districts = [];
	        foreach($data as $a =>$b){
	            foreach($b as $m=>$n)
	            {
	                foreach($n as $p=>$q)
	                    if($p=='state'){
	                        array_push($states,$q);
	                    }else{
	                        foreach($q as $r=>$s)
	                            array_push($districts,$s);
	                    }
	            }
	        }
	        sort($states);
	        return $states;
		}
	}

	if(!function_exists("zones")){
		function zones(){
			$data = ["Vijayawada","Visakhapatnam","Tirupati","Warangal","Guntur","Kakinada","Anantapur","Karimnagar","Khammam","Dilshuknagar","Secunderabad","Ameerpet","Kukatpally","Mehdipatnam","Narayanguda","Kompally","Uppal-Ghatkesar","Filmcity","Chevella","Ibrahimpatnam","Shamshabad","Vizianagaram","Kurnool","Nellore","Ongole","Kadapa"];
	        sort($data);
	        return $data;
		}
	}

	if(!function_exists("designations")){
		function designations(){
			$data = ["TPO","Principal","Receptionist","Faculty","HOD","Coordinator"];
	        sort($data);
	        return $data;
		}
	}

	if(!function_exists("processForm")){
		function processForm($data){
	        $d = [];
	        $form = explode(',',$data);
	        foreach($form as $k=>$f){
	            $item = ["name"=>$f,"type"=>"input","values"=>""];
	            if(preg_match_all('/<<+(.*?)>>/', $f, $regs))
	            {
	                foreach ($regs[1] as $reg){
	                    $variable = trim($reg);
	                    $item['name'] = str_replace($regs[0], '', $f);


	                    if(is_numeric($variable)){
	                        $item['type'] = 'textarea';
	                        $item['values'] = $variable;

	                    }else if($variable=='file'){
	                        $item['type'] = 'file';
	                        $item['values'] = $variable;
	                    }else{
	                        $options = explode('/',$variable);
	                        $item['values'] = $options;
	                        $item['type'] = 'checkbox';
	                    }
	                    
	                }
	            }

	            if(preg_match_all('/{{+(.*?)}}/', $f, $regs))
	            {

	                foreach ($regs[1] as $reg){
	                    $variable = trim($reg);
	                    $item['name'] = str_replace($regs[0], '', $f);
	                    $options = explode('/',$variable);
	                    $item['values'] = $options;
	                    $item['type'] = 'radio';
	                    
	                }
	            }

	            $d[$k] = $item;

	        }

	        return $d;
	    }
	}


}