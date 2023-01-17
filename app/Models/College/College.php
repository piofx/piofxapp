<?php

namespace App\Models\College;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class College extends Model
{
    use HasFactory;
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'code',
        'type',
        'location',
        'zone',
        'district',
        'state',
        'contact_person',
        'contact_designation',
        'contact_phone',
        'contact_email',
        'data_volume',
        'client_id',
        'agency_id',
        'status',
    ];

    /**
     * Get the list of records from database
     *
     * @var array
     */
    public function getRecords($item,$zone,$limit){
        if($zone)
        return $this->where('name','LIKE',"%{$item}%")
                    ->where('zone',$zone)
                    ->orderBy('created_at','desc')
                    ->paginate($limit);
        else
        return $this->where('name','LIKE',"%{$item}%")
                    ->orderBy('created_at','desc')
                    ->paginate($limit);
    }
}
