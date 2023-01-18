<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Core\Client;
use App\Models\Core\Contact;
use App\Models\Admin\Tracker;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'client_id',
        'role',
        'status',
        'password',
        'group',
        'subgroup',
        'data',
        'json',
        'c1',
        'c2',
        'c3','c4','c5','c6',
        'c7','c8','c9','c10',
        'subscribe_phone',
        'subscribe_email',

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



     /**
     * Get the list of records from database
     *
     * @var array
     */
    public function getRecords($item,$limit,$user){

        if(!$user->isRole('superadmin'))
            return $this->where('name','LIKE',"%{$item}%")
                    ->where('client_id',$user->client_id)
                    ->orderBy('id','desc')
                    ->paginate($limit);
        else
            return $this->where('name','LIKE',"%{$item}%")
                    ->orderBy('id','desc')
                    ->paginate($limit);

    }

      /**
     * Get the client that owns the page.
     *
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the client that owns the page.
     *
     */
    public function tracker()
    {
        return $this->hasMany(Tracker::class);
    }

      /**
     * Get the contacts of the user
     *
     */
    public function contact()
    {
        return $this->hasMany(Contact::class);
    }

    public function isRole($role){
        if ($this->role == $role)
            return 1;
        else
            return 0;
    }

    public function checkRole($roles){
        $user = $this;
        
        foreach($roles as $r){
            if($r == $user->role){
                return true;
            }
        }
        return false;
    }

    public function isAdmin(){
        if(\Auth::user())
        {
            if(\Auth::user()->role == 'superadmin' )
                return true;
            else if(\Auth::user()->role == 'agencyadmin' )
                return true;
            else if(\Auth::user()->role == 'clientadmin' )
                return true;

            return false;
        }
        
        return false;
    }

    public function onlyAdminAccess(){
        if(\Auth::user())
        {
            if(\Auth::user()->role != 'superadmin' &&  \Auth::user()->role != 'agencyadmin' && \Auth::user()->role != 'clientadmin')
                abort('403','Only Admin can access this page!');
        }else{
            abort('403','Login to view the page');
        }
    }


    public function processForm($data){
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
