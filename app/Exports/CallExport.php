<?php

namespace App\Exports;

use App\Models\Core\Call;
use Maatwebsite\Excel\Concerns\FromCollection;

class CallExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = request()->session()->get('data');
        $wids = [];
        if(request()->get('walkin')){
            $walkins = $data['center'][request()->get('walkin')]['walkin_list'];
            foreach($walkins as $w){
                array_push($wids,$w->id);
            }
        }
        else
        {
            foreach($data['center'] as $k){
                $walkins = $k['walkin_list'];
               foreach($walkins as $w){
                    array_push($wids,$w->id);
                } 
            }
            
        }

        
        
        $wdata = Call::whereIn('id',$wids)->get();

        foreach($wdata as $a=>$b){
            $wdata[$a]->id = $a+1;
            $wdata[$a]->client_id = $b->name;
            $wdata[$a]->agency_id = $b->phone;
            $wdata[$a]->name= $b->walkin_date;
            if($b->demo_date)
                $wdata[$a]->phone = "yes";
            else
                $wdata[$a]->phone = "-";
            if($b->admission_date)
                $wdata[$a]->call_start_date = "yes";
            else
                $wdata[$a]->call_start_date = "-";
            $wdata[$a]->call_type = $b->caller_name;

            $jdata = null;
            if($b->data)
            $jdata = json_decode($b->data);

            if(isset($jdata->year_of_passing))
                $wdata[$a]->call_tag = $jdata->year_of_passing;
            else
                $wdata[$a]->call_tag = '-';

            if(isset($jdata->branch))
                $wdata[$a]->duration = $jdata->branch;
            else
                $wdata[$a]->duration = '-';

            if(isset($jdata->percentage))
                $wdata[$a]->caller_name = $jdata->percentage;
            else
                $wdata[$a]->caller_name= '-';

            if(isset($jdata->backlogs))
                $wdata[$a]->caller_role = $jdata->backlogs;
            else
                $wdata[$a]->caller_role = '-';

            if(isset($jdata->remarks))
                $wdata[$a]->caller_center = $jdata->remarks;
            else
                $wdata[$a]->caller_center = '-';

            unset( $wdata[$a]->caller_phone);
            unset( $wdata[$a]->status);
            unset( $wdata[$a]->created_at);
            unset( $wdata[$a]->updated_at);
            unset( $wdata[$a]->admission_date);
            unset( $wdata[$a]->walkin_date);
            unset( $wdata[$a]->demo_date);
            unset( $wdata[$a]->data);

            



        }

        $call = new Call();

            $call->id = "Sno";
            $call->client_id = "Name";
            $call->agency_id = "Phone";
            $call->name = "Walkin Date";
            $call->phone = "Demo";
            $call->call_start_date = "Admission";
            $call->call_type= "Caller Name";
            $call->call_tag = "YOP";
            $call->duration = "Branch";
            $call->caller_name = "Percent";
            $call->caller_role = "Backlogs";
            $call->caller_center = "Remarks";
            unset( $call->caller_phone);
            unset( $call->status);
            unset( $call->created_at);
            unset( $call->updated_at);
            unset( $call->admission_date);
            unset( $call->walkin_date);
            unset( $call->demo_date);
            unset( $call->data);

            $wdata->prepend($call);

        return $wdata;
    }
}
