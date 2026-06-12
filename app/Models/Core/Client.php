<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Kyslik\ColumnSortable\Sortable;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Page\Theme;
use App\Models\Page\Page;

class Client extends Model
{
    use HasFactory,Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'domain',
        'settings',
        'agency_id',
        'user_id',
        'status',
    ];

    public $sortable = ['name',
                        'domain',
                        'created_at'];


    /**
     * Get the list of records from database
     *
     * @var array
     */
    public function getRecords($item,$limit){
        if(\Auth::user()->checkRole(['superadmin','agencyadmin']))
        return $this->where('name','LIKE',"%{$item}%")
                    ->where('agency_id',request()->get('agency.id'))
                    ->orderBy('created_at','desc')
                    ->paginate($limit);
        else
        return $this->where('name','LIKE',"%{$item}%")
                    ->where('agency_id',request()->get('agency.id'))
                    ->where('user_id',\Auth::user()->id)
                    ->orderBy('created_at','desc')
                    ->paginate($limit);
    }


    public function refreshCache(){

        $client = $this;
        // get the domain name
        $domain = $client->domain;

        // reload the cache
        Cache::forget('theme_'.$domain);
        Cache::forget('agency_'.$domain);
        Cache::forget('client_'.$domain);
        Cache::forever('client_'.$domain,$client);

    }


    public function createAdminUser($request){
        $name = $request->get('user_name');
        $email = $request->get('user_email');
        $phone = $request->get('user_phone');
        $agency_id = $this->agency_id;
        $client_id = $this->id;
        $role = 'clientadmin';

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'client_id' =>$client_id,
            'phone'=>$phone,
            'agency_id' => $agency_id,
            'role' => $role,
            'password' => Hash::make($phone),
        ]);
        $request->merge(['user_id'=>$user->id]);
    }

    public function processSettings($request){

        // page settings
        $data['theme'] = $request->get('settings_theme');
        $data['title'] = $request->get('settings_title');
        $data['subtitle'] = $request->get('settings_subtitle');
        $data['email'] = $request->get('settings_email');
        $data['phone'] = $request->get('settings_phone');

        $request->merge(['settings'=>json_encode($data,JSON_PRETTY_PRINT)]);
    }

    public function setTemplate($request){

        // create the template
        $theme = new Theme();
        $theme->name = $request->get('settings_theme');
        $theme->slug = $request->get('settings_theme');
        $theme->settings = $request->get('settings');
        $theme->user_id = $request->get('user_id');
        $theme->agency_id = $this->agency_id;
        $theme->client_id = $this->id;
        $theme->status  = 1;
        $theme->save();

        //add page
        $page = new Page();
        $page->name = 'Root page';
        $page->slug = '/';
        $data = file_get_contents( '../resources/views/components/themes/'.$theme->slug.'/rootpage.php' );
        $page->html = $data;
        $page->html_minified = $data;
        $page->user_id = $request->get('user_id');
        $page->agency_id = $this->agency_id;
        $page->client_id = $this->id;
        $page->theme_id = $theme->id;
        $page->status = 1;
        $page->save();


    }

}
