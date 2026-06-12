<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Referral extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id',
        'agency_id',
        'user_id',
        'user_name',
        'referral_id',
        'referral_name',
        'url',
        'data'
    ];

    public static function insert($referral_id, $user, $redirect){
        //get client id
        $client_id = request()->get('client.id');
        //get agency id
        $agency_id = request()->get('agency.id');
        $referral = User::find($referral_id);


        if($referral){
            $rf = new Referral();
            $rf->client_id = $client_id;
            $rf->agency_id = $agency_id;
            $rf->user_id = $user->id;
            $rf->user_name = $user->name;
            $rf->referral_id = $referral_id;
            $rf->referral_name = $referral->name;
            $rf->url = $redirect;
            $rf->save();
        }
        

    }

}
