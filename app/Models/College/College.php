<?php

namespace App\Models\College;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Core\Whatsapp;

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
        {
            $colleges = $this->where('name','LIKE',"%{$item}%")
                    ->where('zone',$zone)
                    ->orderBy('created_at','desc')
                    ->paginate($limit);
        }else{
            $colleges = $this->where('name','LIKE',"%{$item}%")
                    ->orderBy('created_at','desc')
                    ->paginate($limit);
        }

        foreach($colleges as $key=>$c){
            $colleges[$key]->registered = Whatsapp::where('college',$c->name)->count();
        }
        return $colleges;
    }

     /**
     * Get the list of students from WhatsappTracker Table
     *
     * @var array
     */
    public function students(){
        $data= Whatsapp::where('college',$this->name)->get();
        $students['count'] = count($data);
        $students['branches'] = $data->groupBy('branch');
        return $students;
    }
}
