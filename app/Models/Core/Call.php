<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use carbon\carbon;

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
            $data = $this->where('call_start_date','>=',$start)->where('call_start_date','<=',$end)->get();
        }else if($filter=='thismonth' ){
            $data = $this->whereMonth('call_start_date', Carbon::now()->month)->whereYear('call_start_date', '=', Carbon::now()->year)->get();
        }else if($filter=='lastmonth' ){
               $data = $this->whereMonth('call_start_date', '=', Carbon::now()->subMonth()->month)->whereYear('call_start_date', '=', Carbon::now()->year)->get();
        }else if($filter=='last7days' ){
               $data = $this->whereDate('call_start_date', Carbon::now()->subDays(7))->get();
         }else if($filter=='last30days' ){
               $data = $this->where('call_start_date','>', Carbon::now()->subDays(30))->get();
        
        }else if($filter=='today' || $filter==null){
               $data = $this->whereDay('call_start_date', '=', Carbon::now()->day)->whereMonth('call_start_date', '=', Carbon::now()->month)->whereYear('call_start_date', '=', Carbon::now()->year)->get();
        }else if($filter=='yesterday' ){
               $data = $this->whereDay('call_start_date', '=', Carbon::now()->subDay()->day)->whereMonth('call_start_date', '=', Carbon::now()->month)->whereYear('call_start_date', '=', Carbon::now()->year)->get();
        }else if($filter=='overall'){
            $data = $this->get();
        }
        return $data;
    }


    public function getTime($init){
        $hours = floor($init / 3600);
        $minutes = floor(($init / 60) % 60);
        $seconds = $init % 60;
        if($hours)
            $t = $hours.'h '.$minutes.'m '.$seconds.'s';
        else if($minutes)
            $t = $minutes.'m '.$seconds.'s';
        else
            $t = $seconds.'s'; 

        return $t;
    }

    public function analyzeRecords($data){

        $set = [];
        $data_callers = $data->groupBy('caller_name');


        foreach($data_callers as $caller=>$callerdata){
            $set[$caller]['users'] = $callerdata->where('duration','!=',0)->unique('phone')->count();
     
            foreach($callerdata as $cdata){

                if(!isset($set[$caller]['Admission']))
                        $set[$caller]['admission']=0;

                if($cdata['status']=='Admission'){
                        $set[$caller]['admission']++;
                }

                if($cdata['call_type']=='outgoing'){
                    if($cdata['duration']!=0){
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
                    if($cdata['duration']!=0){
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
            if(isset($set[$caller]['status']))
            foreach( $set[$caller]['status'] as $s=>$t){
                if($s)
                $set[$caller]['status_str'] = $set[$caller]['status_str'] .$s.' - '.$t."<br>";
            }

            $init=0;
            $set[$caller]['avg_duration']= $avg_minutes  = 0;
            if(isset($set[$caller]['duration'])){
                $init =  intval(round($set[$caller]['duration']/  $set[$caller]['calls'],2));
                $avg_minutes = round($set[$caller]['duration']/  $set[$caller]['calls'],2)/60;
                $set[$caller]['avg_duration']=$init;
            }

             $set[$caller]['score'] = intval($set[$caller]['users'] * $avg_minutes) + $set[$caller]['admission'] * 100;
               
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
            
            $init=0;
            $set[$caller]['total_duration']=0;
            if(isset($set[$caller]['duration'])){
                $init =  intval( $set[$caller]['duration']);
                $set[$caller]['total_duration']=$init;
            }
         
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
