<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Whatsapp extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'code',
        'college',
        'branch',
        'yop',
        'zone',
        'account',
        'instagram',
        'youtube',
        'comment',
        'data',
        'user_id',
        'agency_id',
        'client_id',
        'status',
    ];

    protected $table = 'whatsapptracker';


    public static function getEntry($phone){
    	$entry = Whatsapp::where('phone',$phone)->first();

    	if($entry)
    		return $entry;
    	else{
    		$entry = new Whatsapp();
    		$entry->user_id = '0';
    		$entry->agency_id = request()->get('agency.id');
    		$entry->client_id = request()->get('client.id');
    		$entry->status =0;
    		return $entry;
    	}

    }

    public function setPhone($phone,$name){
    	$this->phone = $phone;
    	$this->name = $name;
    	$this->save();
    }

    public function setEmail($email){
    	$this->email = $email;
    	$this->save();
    }

    public function setCode($code){
    	$this->code = $code;
    	$this->save();
    }

    public function setInstagram($instagram){
    	$this->instagram = $instagram;
    	$this->save();
    }

    public function setYoutube($youtube){
    	$this->youtube = $youtube;
    	$this->save();
    }
}
