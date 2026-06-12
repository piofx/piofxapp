<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Kyslik\ColumnSortable\Sortable;

class Agency extends Model
{
    use HasFactory,Sortable;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'settings',
        'domain',
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
        return $this->where('name','LIKE',"%{$item}%")
                    ->sortable()
                    ->orderBy('created_at','desc')
                    ->paginate($limit);
    }


    public function refreshCache(){
        // get the domain name
        $domain = $this->domain;

        // reload the cache
        Cache::forget('agency_'.$domain);
        Cache::forever('agency_'.$domain,$this);

    }
}
