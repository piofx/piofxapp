<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Call extends Model
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
        'call_start_date',
        'call_tag',
        'call_type',
        'duration',
        'caller_name',
        'status',
        'caller_role',
        'caller_center',
        'caller_phone',
    ];

     /**
     * Get the list of records from database
     *
     * @var array
     */
    public function getRecords($request){

        $start = $request->get('start');
        $end = $request->get('end');
        $filter = $request->get('filter');

        if($start && $end){
            $data = $this->where('created_at','>=',$start)->where('created_at','<=',$end)->get();
        }else if($filter=='thismonth'){
            $data = $this->whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', '=', Carbon::now()->year)->get();
        }else if($filter=='lastmonth'){
               $data = $this->whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->whereYear('created_at', '=', Carbon::now()->year)->get();
        }else{
            $data = $this->get();
        }
        return $data;
    }

    public function analyzeRecords($data){

        $set = [];
        $data_callers = $data->groupBy('caller_name');
        foreach($data_callers as $caller=>$callerdata){
            foreach($callerdata as $cdata){
                if($cdata['call_type']=='outgoing'){
                    if($cdata['call_tag']=='answered'){
                        if(isset($set[$caller]['contacted']))
                            $set[$caller]['contacted']++;
                        else
                            $set[$caller]['contacted']=1;

                        if(isset($set[$caller]['calls']))
                            $set[$caller]['calls']++;
                        else
                            $set[$caller]['calls'] =1;

                        if(isset($set[$caller]['duration']))
                            $set[$caller]['duration'] +=$cdata['duration'];
                        else
                            $set[$caller]['duration'] =$cdata['duration'];

                        if(isset($set[$caller]['status'][$cdata['status']])){
                            $set[$caller]['status'][$cdata['status']]++;
                        }else{
                            $set[$caller]['status'][$cdata['status']]=1;
                        }
                    }       
                }

                 if($cdata['call_type']=='incoming'){
                    if($cdata['call_tag']=='answered'){
                        if(isset($set[$caller]['answered']))
                            $set[$caller]['answered']++;
                        else
                            $set[$caller]['answered']=1;

                        if(isset($set[$caller]['calls']))
                            $set[$caller]['calls']++;
                        else
                            $set[$caller]['calls'] =1;

                        if(isset($set[$caller]['duration']))
                            $set[$caller]['duration'] +=$cdata['duration'];
                        else
                            $set[$caller]['duration'] =$cdata['duration'];

                        if(isset($set[$caller]['status'][$cdata['status']])){
                            $set[$caller]['status'][$cdata['status']]++;
                        }else{
                            $set[$caller]['status'][$cdata['status']]=1;
                        }
                    }
                }

            }

            $set[$caller]['status_str'] ='';
            foreach( $set[$caller]['status'] as $s=>$t){
                if($s)
                $set[$caller]['status_str'] = $set[$caller]['status_str'] .$s.' - '.$t."<br>";
            }

            $init =  intval(round($set[$caller]['duration']/  $set[$caller]['calls'],2));
            if($init){
               $hours = floor($init / 3600);
                $minutes = floor(($init / 60) % 60);
                $seconds = $init % 60;
                if($hours)
                    $set[$caller]['avg_talktime'] = $hours.'h '.$minutes.'m '.$seconds.'s';
                else if($minutes)
                    $set[$caller]['avg_talktime'] = $minutes.'m '.$seconds.'s';
                else
                    $set[$caller]['avg_talktime'] = $seconds.'s'; 
            }else{
                $set[$caller]['avg_talktime']=0;
            }
            

            $init =  intval( $set[$caller]['duration']);
            if($init){
                $hours = floor($init / 3600);
                $minutes = floor(($init / 60) % 60);
                $seconds = $init % 60;
                if($hours)
                    $set[$caller]['total_talktime'] = $hours.'h '.$minutes.'m '.$seconds.'s';
                else if($minutes)
                    $set[$caller]['total_talktime'] = $minutes.'m '.$seconds.'s';
                else
                    $set[$caller]['total_talktime'] = $seconds.'s';
            }else{
                $set[$caller]['total_talktime']=0;
            }
        }
        return $set;
    }




}
