<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use carbon\carbon;
use Illuminate\Support\Facades\DB;

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
        'admission_date',
        'demo_date',
        'walkin_date',
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

    public function analyzeRecordsEntity($data){

        $set = [];$callers = [];
        $entity = request()->get('entity');

        $item = null;
        $caller_center = client('caller_center');
        foreach($caller_center as $caller =>$center){
            if($entity==$caller){
                $item ='caller';
                break;
            }

            if($entity ==$center){
                $item='center';
                break;
            }
        }

        if($item==null)
            abort('403','entity not found');


        if($item=='caller')
            $data_dates= Call::select('id','name','caller_name','call_type','call_tag','status','phone','caller_name','caller_phone','caller_center','duration', DB::raw('DATE(call_start_date) as date'))->where('call_start_date','>', Carbon::now()->subDays(30))->where('caller_name',$entity)->get()->groupBy('date');
        else{

            
            foreach($caller_center as $caller =>$center){
                if($entity==$center){
                    array_push($callers,$caller);
                }
            }
            $data_dates= Call::select('id','name','caller_name','call_type','call_tag','status','phone','caller_name','caller_phone','caller_center','duration', DB::raw('DATE(call_start_date) as date'))->where('call_start_date','>', Carbon::now()->subDays(30))->whereIn('caller_name',$callers)->get()->groupBy('date');
            
        }
        
        foreach($data_dates as $caller=>$callerdata){

            $set[$caller]['users'] = $callerdata->where('duration','!=',0)->unique('phone')->count();
            foreach($callerdata as $cdata){
            
                if(!isset($set[$caller]['admission'])){
                     $set[$caller]['admission']=0;
                      $set[$caller]['admitted']=array();
                }
                       

                if($cdata['status']=='Admission'){
                    if($cdata['admission_date']){
                        $set[$caller]['admission']++;
                        array_push($set[$caller]['admitted'],$cdata['name']);
                    }
                        
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

            $set[$caller]['employees'] = count($callers);
        }

       
        return $set;
    }

    public function analyzeRecords($data){

        $set = [];
        $data_callers = $data->groupBy('caller_name');

        $admit=0;
        foreach($data as $d){
            //echo $d['phone'].' - '.$d['status']."<br>";

            if($d['status']=='Admission')
                $admit++;
        }
        
        foreach($data_callers as $caller=>$callerdata){
            $set[$caller]['users'] = $callerdata->where('duration','!=',0)->unique('phone')->count();
     
            foreach($callerdata as $cdata){
                if(!isset($set[$caller]['admission'])){
                     $set[$caller]['admission']=0;
                      $set[$caller]['admitted']=array();
                      $set[$caller]['admitted_phone']=array();
                }
                       
                
                if($cdata['status']=='Admission'){
                    if($cdata['admission_date']){
                        $set[$caller]['admission']++;

                        array_push($set[$caller]['admitted'],$cdata['name']);
                        array_push($set[$caller]['admitted_phone'],$cdata['phone']);
                    }
                        
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

    dd($set);

        return $set;
    }

    public function formulateDataEntity($adata){

        $item = null;
        $entity = request()->get('entity');
        $caller_center = client('caller_center');
        foreach($caller_center as $caller =>$center){
            if($entity==$caller){
                $item ='caller';
                break;
            }
            if($entity ==$center){
                $item='center';
                break;
            }
        }

        $sdata['all'] = $adata;
        $sdata['center'] = [];
        if($item=='caller'){
            $sdata['entity'] = 1;
        }else{
            //center
            foreach($sdata['all'] as $date=>$d){
                $sdata['all'][$date]['score'] = intval($sdata['all'][$date]['score']/$sdata['all'][$date]['employees']);
                if(isset($d['duration'])){
                   $init = intval(round($d['duration']/  $d['calls'],2));
                    $hours = floor($init / 3600);
                    $minutes = floor(($init / 60) % 60);
                    $seconds = $init % 60;
                    if($hours)
                        $t = $hours.'h '.$minutes.'m '.$seconds.'s';
                    else if($minutes)
                        $t= $minutes.'m '.$seconds.'s';
                    else
                        $t = $seconds.'s'; 

                    $sdata['all'][$date]['avg_talktime'] = $t; 
                }else{
                    $sdata['all'][$date]['avg_talktime'] =0;
                }
            }
            $sdata['entity'] = 1;
            $sdata['entity_center'] = 1;
        }

        $counter = array("high"=>0,"low"=>0,"excellent"=>0,"decent"=>0);
            foreach($sdata['all'] as $date=>$d){
                $sdata['date'] = $date;
                if($d['score']<40 && \carbon\Carbon::parse($date)->format('l')!='Sunday' && \carbon\Carbon::parse($date)->format('l')!='Saturday'){
                    $counter['low']++;
                }elseif($d['score']>=40 && $d['score']<100){
                    $counter['decent']++;
                }elseif($d['score']>=100 && $d['score']<200){
                    $counter['high']++;
                }elseif($d['score']>=200){
                    $counter['excellent']++;
                }
            }
            $sdata['counter'] =$counter; 
        return $sdata;
    }

    public function formulateDataOverall($adata){

        $caller_role = client('caller_role');
        $caller_center = client('caller_center');
        $centers = [];
        foreach($caller_center as $c=>$center){
            if(isset($cdata['center'][$center])){
                
                foreach($adata as $a=>$b){
                    if(!in_array($center, $centers))
                        array_push($centers,$center);
                     if($a==$c){
                        if(isset($b['contacted']))
                            $cdata['center'][$center]["contacted"] +=$b['contacted'];
                        if(isset($b['answered']))
                            $cdata['center'][$center]["answered"] +=$b['answered'];
                        if(isset($b['score']))
                            $cdata['center'][$center]["score"] +=$b['score'];
                        if(isset($b['users']))
                            $cdata['center'][$center]["users"] +=$b['users'];
                        if(isset($b['admission'])){
                            $cdata['center'][$center]["admission"] +=$b['admission'];
                            $dd=null;
                            foreach($b['admitted'] as $name){
                                $dd['name'] = $name;
                                $dd['caller'] = $a;
                                array_push($cdata['center'][$center]["admitted"],$dd); 
                            }
                            
                         
                        }
                        if(isset($b['status']['Interested']))
                            $cdata['center'][$center]["Interested"] +=intval($b['status']['Interested']);
                        if(isset($b['avg_duration']))
                            $cdata['center'][$center]["avg_duration"] +=intval($b['avg_duration']);
                        if(isset($b['total_duration']))
                            $cdata['center'][$center]["total_duration"] +=intval($b['total_duration']);
                         $cdata['center'][$center]["employees"]++;
                    }
                }
                
            }else{
                $cdata['center'][$center] = ["contacted"=>0,"answered"=>0,"Interested"=>0,"admission"=>0,"avg_talktime"=>0,"total_talktime"=>0,"status_str"=>null,"avg_duration"=>0,"total_duration"=>0,"employees"=>0,"score"=>0,"users"=>0,"admitted"=>[]];
                
                 foreach($adata as $a=>$b){
                        if(!in_array($center, $centers))
                        array_push($centers,$center);
                    if($a==$c){
                        if(isset($b['contacted']))
                            $cdata['center'][$center]["contacted"] +=$b['contacted'];
                        if(isset($b['answered']))
                            $cdata['center'][$center]["answered"] +=$b['answered'];
                        if(isset($b['score']))
                            $cdata['center'][$center]["score"] +=$b['score'];
                        if(isset($b['users']))
                            $cdata['center'][$center]["users"] +=$b['users'];
                        if(isset($b['admission']))
                            $cdata['center'][$center]["admission"] +=$b['admission'];
                        if(isset($b['status']['Interested']))
                            $cdata['center'][$center]["Interested"] +=intval($b['status']['Interested']);
                        if(isset($b['avg_duration'])){
                            $cdata['center'][$center]["avg_duration"] +=intval($b['avg_duration']);
                        }
                        $cdata['center'][$center]["employees"]++;
                        if(isset($b['total_duration']))
                            $cdata['center'][$center]["total_duration"] +=intval($b['total_duration']);
                    }
                    
                }

            }
           
            if(isset($adata[$c])){
                $cdata['all'][$c] = $adata[$c]; 
            }else{
                $cdata['all'][$c] = ["contacted"=>0,"answered"=>0,"Interested"=>0,"admission"=>0,"avg_talktime"=>0,"total_talktime"=>0,"status_str"=>null,"score"=>0,"users"=>0];
            }
            
        }

        foreach($centers as $center){
            if(isset($cdata['center'][$center]["employees"]) && $cdata['center'][$center]["employees"]!=0)
            $cdata['center'][$center]["score"] = intval($cdata['center'][$center]["score"] / $cdata['center'][$center]["employees"]);
            else
                 $cdata['center'][$center]["score"] =0;
        }

        
         
        // foreach($caller_center as $c=>$center){
        //     if(isset($adata[$c]))
        //     $cdata['center'][$center][$c] = $adata[$c];
        //     else
        //     $cdata['center'][$center][$c] = ["contacted"=>0,"answered"=>0,"Interested"=>0,"admission"=>0,"avg_talktime"=>0,"total_talktime"=>0,"status_str"=>null,"score"=>0,"users"=>0];
        // }

        //dd($cdata);
        //sorted data
        $sdata =[]; $center =[]; $all =[];
        foreach($cdata['center'] as $a=>$b){
            $center[$a] = $b['score'];
        }
        foreach($cdata['all'] as $a=>$b){
            if(isset($b['score']))
                $all[$a] = $b['score'];
            else
                $all[$a] = 0;
        }

        $sdata['overall'] =array("users"=>0,"interacted"=>0,"total_duration"=>0,"admission"=>0,"talktime"=>0);
        arsort($all);
        arsort($center);
        foreach($all as $a=>$b){
            $sdata['all'][$a] = $cdata['all'][$a];
        }
        foreach($center as $a=>$b){
            $sdata['center'][$a] = $cdata['center'][$a];
            $sdata['overall']["users"]+=$cdata['center'][$a]["users"];
            if(!isset($cdata['center'][$a]["contacted"]))
                $cdata['center'][$a]["contacted"]=0;
            if(!isset($cdata['center'][$a]["answered"]))
                $cdata['center'][$a]["answered"]=0;
            $sdata['overall']["interacted"]+=($cdata['center'][$a]["contacted"]+$cdata['center'][$a]["answered"]);
            $sdata['overall']["total_duration"]+=$cdata['center'][$a]["total_duration"];
            $sdata['overall']["admission"]+=$cdata['center'][$a]["admission"];

        }

        $init = intval($sdata['overall']["total_duration"]);
        $hours = floor($init / 3600);
        $minutes = floor(($init / 60) % 60);
        $seconds = $init % 60;
        if($hours)
            $t = $hours.'h '.$minutes.'m '.$seconds.'s';
        else if($minutes)
            $t= $minutes.'m '.$seconds.'s';
        else
            $t = $seconds.'s'; 

        $sdata['overall']['talktime'] = $t;
        $sdata['over_all'] = 1;

   

        return $sdata;
    }



}
