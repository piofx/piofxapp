<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Core\Call as Obj;
use Illuminate\Support\Facades\Storage;

class CallController extends Controller
{
    /**
     * Define the app and module object variables and component name 
     *
     */
    public function __construct(){
        // load the app, module and component name to object params
        $this->app      =   'Core';
        $this->module   =   'Call';
        $this->componentName = componentName('agency');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Obj $obj,Request $request)
    {

        // check for search string
        $item = $request->item;
        // load alerts if any
        $alert = session()->get('alert');
        // retrive the listing
        $data = $obj->getRecords($request);

        $adata = $obj->analyzeRecords($data);

        $caller_role = client('caller_role');
        $caller_center = client('caller_center');

        foreach($caller_center as $c=>$center){
            if(isset($cdata['center'][$center])){
                foreach($adata as $a=>$b){
                     if($a==$c){
                        if(isset($b['contacted']))
                            $cdata['center'][$center]["contacted"] +=$b['contacted'];
                        if(isset($b['answered']))
                            $cdata['center'][$center]["answered"] +=$b['answered'];
                        if(isset($b['score']))
                            $cdata['center'][$center]["score"] +=$b['score'];
                        if(isset($b['users']))
                            $cdata['center'][$center]["users"] +=$b['users'];
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
                $cdata['center'][$center] = ["contacted"=>0,"answered"=>0,"Interested"=>0,"admission"=>0,"avg_talktime"=>0,"total_talktime"=>0,"status_str"=>null,"avg_duration"=>0,"total_duration"=>0,"employees"=>0,"score"=>0,"users"=>0];
                 foreach($adata as $a=>$b){
                        
                    if($a==$c){
                        if(isset($b['contacted']))
                            $cdata['center'][$center]["contacted"] +=$b['contacted'];
                        if(isset($b['answered']))
                            $cdata['center'][$center]["answered"] +=$b['answered'];
                        if(isset($b['score']))
                            $cdata['center'][$center]["score"] +=$b['score'];
                        if(isset($b['users']))
                            $cdata['center'][$center]["users"] +=$b['users'];
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

            if(isset($cdata['center'][$center]["employees"]) && $cdata['center'][$center]["employees"]!=0)
            $cdata['center'][$center]["score"] = intval($cdata['center'][$center]["score"] / $cdata['center'][$center]["employees"]);
            else
                 $cdata['center'][$center]["score"] =0;
            if(isset($adata[$c])){
                $cdata['all'][$c] = $adata[$c]; 
            }else{
                $cdata['all'][$c] = ["contacted"=>0,"answered"=>0,"Interested"=>0,"admission"=>0,"avg_talktime"=>0,"total_talktime"=>0,"status_str"=>null,"score"=>0,"users"=>0];
            }
            
        }


        foreach($caller_center as $c=>$center){
            if(isset($adata[$c]))
            $cdata['center'][$center][$c] = $adata[$c];
            else
            $cdata['center'][$center][$c] = ["contacted"=>0,"answered"=>0,"Interested"=>0,"admission"=>0,"avg_talktime"=>0,"total_talktime"=>0,"status_str"=>null,"score"=>0,"users"=>0];
        }

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
        arsort($all);
        arsort($center);
        foreach($all as $a=>$b){
            $sdata['all'][$a] = $cdata['all'][$a];
        }
        foreach($center as $a=>$b){
            $sdata['center'][$a] = $cdata['center'][$a];
        }


        return view('apps.'.$this->app.'.'.$this->module.'.index')
                ->with('app',$this)
                ->with('obj',$obj)
                ->with('alert',$alert)
                ->with('data',$sdata);
    }

     // capture call trigger
    public function trigger(){
        $filename = 'samplecall.json';
        $r = request();
        $obj = request()->all();
        $call_center = client('caller_center');
                $call_phone = client('caller_phone');
                $call_role = client('caller_role');

        $data = json_decode(json_encode($obj),true);
        $data['completed'] = 0;
        Storage::disk('public')->put('calltrigger/'.$filename, json_encode($data,JSON_PRETTY_PRINT));
        $call = new Obj();
        $call->name = $r->get('name');
         $call->client_id = $r->get('client.id');
        $call->agency_id = $r->get('agency.id');
        $call->phone = $r->get('phoneNumber');
        $call->call_start_date =  date('Y-m-d h:m:s',$r->get('startTime'));
        $call->duration = $r->get('duration');
        $call->call_type=$r->get('type');
        $call->call_tag=$r->get('tag');
        $call->caller_name = $r->get('calledBy');

        $data = json_decode(json_encode($obj),true);
        $data['completed'] = 1;
        Storage::disk('public')->put('calltrigger/'.$filename, json_encode($data,JSON_PRETTY_PRINT));
         $cname =  $r->get('calledBy');
                    if(isset($call_center->$cname))
                        $call->caller_center = $call_center->$cname;
                    if(isset($call_phone->$cname))
                        $call->caller_phone = $call_phone->$cname;
                    if(isset($call_role->$cname))
                        $call->caller_role = $call_role->$cname;
        $call->save();

        $data = json_decode(json_encode($obj),true);
        $data['completed'] = 2;
        Storage::disk('public')->put('calltrigger/'.$filename, json_encode($data,JSON_PRETTY_PRINT));
        
        //Storage::disk('public')->put('calltrigger/'.$filename, json_encode($obj,JSON_PRETTY_PRINT));
    }

    // capture call trigger
    public function triggerview(){
        $filename = 'samplecall.json';
        if(Storage::disk('public')->exists('calltrigger/'.$filename) &request()->get('data')!=1){
                $data = Storage::disk('public')->get('calltrigger/'.$filename);
                dd($data);
        }else{
            if(request('data')==1){
                $filename = 'samplecall.json';
        $r = request();
        $obj = request()->all();
        $call_center = client('caller_center');
                $call_phone = client('caller_phone');
                $call_role = client('caller_role');

        $data = json_decode(json_encode($obj),true);
        $data['completed'] = 0;
        Storage::disk('public')->put('calltrigger/'.$filename, json_encode($data,JSON_PRETTY_PRINT));
        $call = new Obj();
        $call->client_id = $r->get('client.id');
        $call->agency_id = $r->get('agency.id');
        $call->name = $r->get('name');
        $call->phone = $r->get('phoneNumber');
        $call->call_start_date =  date('Y-m-d h:m:s',$r->get('startTime'));
        $call->duration = $r->get('duration');
        $call->call_type=$r->get('type');
        $call->call_tag=$r->get('tag');
        $call->caller_name = $r->get('calledBy');

        $data = json_decode(json_encode($obj),true);
        $data['completed'] = 1;
        Storage::disk('public')->put('calltrigger/'.$filename, json_encode($data,JSON_PRETTY_PRINT));
        $cname =  $r->get('calledBy');
                    if(isset($call_center->$cname))
                        $call->caller_center = $call_center->$cname;
                    if(isset($call_phone->$cname))
                        $call->caller_phone = $call_phone->$cname;
                    if(isset($call_role->$cname))
                        $call->caller_role = $call_role->$cname;
        $call->save();
     
        $data = json_decode(json_encode($obj),true);
        $data['completed'] = 2;
        Storage::disk('public')->put('calltrigger/'.$filename, json_encode($data,JSON_PRETTY_PRINT));
       
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function upload(Obj $obj,Request $request)
    {
        // load alerts if any
        $alert = session()->get('alert');

        try{
            
            if(isset($request->all()['file'])){
                
                $file      = $request->all()['file'];
                $fname = str_replace(' ','_',strtolower($file->getClientOriginalName()));
                $extension = strtolower($file->getClientOriginalExtension());

                if(!in_array($extension, ['csv'])){
                    $alert = 'Only CSV files are allowed';
                    return redirect()->route($this->module.'.upload')->with('alert',$alert);
                }

                $call_center = client('caller_center');
                $call_phone = client('caller_phone');
                $call_role = client('caller_role');

                 $row = 1;
                 $file_path = Storage::disk('public')->putFileAs('excels', $request->file('file'),$fname,'public');
                 $fpath = Storage::disk('public')->path($file_path);
                
                $last = Obj::orderBy('id','desc')->first();

                $last_time = 0;
                if($last){
                    $last_time = strtotime($last->call_start_date);
                }else{
                    $last = new obj();
                    $last->phone = '00';
                }
                if (($handle = fopen($fpath, "r")) !== FALSE) {
                  while (($data = fgetcsv($handle, 9000, ",")) !== FALSE) {
                    $num = count($data);
                    $row++;
                    $callmodel = new Obj();
                    $callmodel->client_id = $request->get('client.id');
                    $callmodel->agency_id = $request->get('agency.id');
                    $callmodel->name = $data[0];
                    $callmodel->phone = $data[1];
                    $time = strtotime($data[2]);
                    $newformat = date('Y-m-d h:m:s',$time);
                    $callmodel->call_start_date = $newformat;
                    $callmodel->call_type = $data[3];
                    $callmodel->call_tag = $data[4];
                    if($data[5])
                    $callmodel->duration = $data[5];
                    $callmodel->caller_name = $data[6];
                    $callmodel->status = $data[7];

                    $cname = $callmodel->caller_name;
                    if(isset($call_center->$cname))
                        $callmodel->caller_center = $call_center->$cname;
                    if(isset($call_phone->$cname))
                        $callmodel->caller_phone = $call_phone->$cname;
                    if(isset($call_role->$cname))
                        $callmodel->caller_role = $call_role->$cname;

                    if($row!=2 && $time>$last_time && $last->phone != $callmodel->phone){
                        $callmodel->save();
                    }
                   
                  }
                  fclose($handle);
                }

                $alert = 'Data Records Added!';
                return redirect()->route($this->module.'.index')->with('alert',$alert);
            }
            else{
                return view('apps.'.$this->app.'.'.$this->module.'.upload')
                    ->with('stub','Create')
                    ->with('alert',$alert)
                    ->with('obj',$obj)
                    ->with('editor',true)
                    ->with('app',$this);

            }

           
        }
        catch (QueryException $e){
           $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                $alert = 'Some error in updating the record';
                return redirect()->back()->withInput()->with('alert',$alert);
            }
        }

       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Obj $obj)
    {
        // authorize the app
        $this->authorize('create', $obj);

        return view('apps.'.$this->app.'.'.$this->module.'.createedit')
                ->with('stub','Create')
                ->with('obj',$obj)
                ->with('editor',true)
                ->with('app',$this);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Obj $obj,Request $request)
    {
        try{
            
            /* create a new entry */
            $obj = $obj->create($request->all());
            //reload cache and session data
            $obj->refreshCache();

            $alert = 'A new ('.$this->app.'/'.$this->module.') item is created!';
            return redirect()->route($this->module.'.index')->with('alert',$alert);
        }
        catch (QueryException $e){
           $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                $alert = 'Some error in updating the record';
                return redirect()->back()->withInput()->with('alert',$alert);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // load the resource
        $obj = Obj::where('id',$id)->first();
        // load alerts if any
        $alert = session()->get('alert');
        // authorize the app
        $this->authorize('view', $obj);

        if($obj)
            return view('apps.'.$this->app.'.'.$this->module.'.show')
                    ->with('obj',$obj)->with('app',$this)->with('alert',$alert);
        else
            abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // load the resource
        $obj = Obj::where('id',$id)->first();
        // authorize the app
        $this->authorize('view', $obj);

        if($obj)
            return view('apps.'.$this->app.'.'.$this->module.'.createedit')
                ->with('stub','Update')
                ->with('obj',$obj)
                ->with('editor',true)
                ->with('app',$this);
        else
            abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            
            // load the resource
            $obj = Obj::where('id',$id)->first();

            // authorize the app
            $this->authorize('update', $obj);
            //update the resource
            $obj->update($request->all()); 
            //reload cache and session data
            $obj->refreshCache();

            // flash message and redirect to controller index page
            $alert = 'A new ('.$this->app.'/'.$this->module.'/'.$id.') item is updated!';
            return redirect()->route($this->module.'.show',$id)->with('alert',$alert);
        }
        catch (QueryException $e){
           $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                 $alert = 'Some error in updating the record';
                 return redirect()->back()->withInput()->with('alert',$alert);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // load the resource
        $obj = Obj::where('id',$id)->first();
        // authorize
        $this->authorize('update', $obj);
        // delete the resource
        $obj->delete();

        // flash message and redirect to controller index page
        $alert = '('.$this->app.'/'.$this->module.'/'.$id.') item  Successfully deleted!';
        return redirect()->route($this->module.'.index')->with('alert',$alert);
    }
}
