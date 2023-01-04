<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Core\Call as Obj;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Exports\CallExport;
use Maatwebsite\Excel\Facades\Excel;

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
        $this->componentName = componentName('agency','plain');
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

        if(request()->get('entity')){
            $adata = $obj->analyzeRecordsEntity($data);
            $sdata = $obj->formulateDataEntity($adata);
        }
        else{
            $adata = $obj->analyzeRecords($data);
            $sdata = $obj->formulateDataOverall($adata);
        }


        $admitted = 0;
        if(request()->get('admitted')){
            $admitted = 1;
        }



        //update page meta title
        adminMetaTitle('Telecaller Dashboard');

        if($admitted)
        return view('apps.'.$this->app.'.'.$this->module.'.admitted')
                ->with('app',$this)
                ->with('obj',$obj)
                ->with('alert',$alert)
                ->with('data',$sdata);

        else
        return view('apps.'.$this->app.'.'.$this->module.'.index')
                ->with('app',$this)
                ->with('obj',$obj)
                ->with('alert',$alert)
                ->with('data',$sdata);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminIndex(Obj $obj,Request $request)
    {

        $this->componentName = componentName('agency');
        //pre-process the request
        if(request()->get('caller') && request()->get('list')){
            request()->merge([request()->get('list')=>request()->get('caller')]); 
        }
        // check for search string
        $item = $request->item;
        // load alerts if any
        $alert = session()->get('alert');
        // retrive the listing
        $data = $obj->getRecords($request);

        if(request()->get('entity')){
            $adata = $obj->analyzeRecordsEntity($data);
            $sdata = $obj->formulateDataEntity($adata);
        }
        else{
            $adata = $obj->analyzeRecords($data);
            $sdata = $obj->formulateDataOverall($adata);

        }

        $admitted = 0;
        if(request()->get('admitted') || request()->get('demo') || request()->get('walkin')){
            $admitted = 1;
        }

        if(request()->get('download')){
            request()->session()->put('data',$sdata);

            ob_end_clean(); // this
            ob_start(); 
            $dt = Carbon::now()->toDateString();
            $start = request()->get('start');
            $end = request()->get('end');
            $dts = Carbon::parse($start)->format('Y-m-d');
             $dte = Carbon::parse($end)->format('Y-m-d');
            $filename = request()->get('walkin')."_Walkins_".$dts."_to_".$dte.".xlsx";
          
            return Excel::download(new CallExport, $filename);
        }

        //update page meta title
        adminMetaTitle('Telecaller Dashboard');

        if($admitted)
        return view('apps.'.$this->app.'.'.$this->module.'.admindata')
                ->with('app',$this)
                ->with('obj',$obj)
                ->with('alert',$alert)
                ->with('data',$sdata);

        else
        return view('apps.'.$this->app.'.'.$this->module.'.adminindex')
                ->with('app',$this)
                ->with('obj',$obj)
                ->with('alert',$alert)
                ->with('data',$sdata);
    }

    public function documents(){
        return view('apps.'.$this->app.'.'.$this->module.'.documents')->with('app',$this);
    }

     public function tutorials(){

        return view('apps.'.$this->app.'.'.$this->module.'.tutorials')->with('app',$this);
    }

        // capture call trigger
    public function itrigger(){
        $filename = 'isamplecall.json';
        $r = request();
        $obj = request()->all();
        $call_center = client('caller_center');
        $call_phone = client('caller_phone');
        $call_role = client('caller_role');

        $data = json_decode(json_encode($obj),true);
        $data['completed'] = 3;
        Storage::disk('public')->put('calltrigger/'.$filename, json_encode($data,JSON_PRETTY_PRINT));
        $data['caller_name'] = $data['assigned']['from'];
        $dd = array();
        $dd['admission_date']=$data['admission_date'] = null;
        $dd['walkin_date']=$data['walkin_date'] = null;
        $dd['demo_date']=$data['demo_date'] = null;
        foreach($data['userFields'] as $d){
            if($d['name']=='Admission Date'){
                $dd['admission_date'] = $data['admission_date'] = date('Y-m-d h:m:s',$d['value']);
                $data['completed'] = $data['admission_date'];
            }
            elseif($d['name']=='Demo Date'){
                $dd['demo_date'] =$data['demo_date'] = date('Y-m-d h:m:s',$d['value']);
                $data['completed'] = $data['demo_date'];
            }
            elseif($d['name']=='Walkin Date'){
                $dd['walkin_date'] = $data['walkin_date'] = date('Y-m-d h:m:s',$d['value']);
                $data['completed'] = $data['walkin_date'];
            }
            elseif($d['name']=='Status'){
                $dd['status'] = $data['status'] = $d['value'];
            }
            elseif($d['name']=='Year Of Passing'){
                $dd['year_of_passing'] = $data['year_of_passing'] = $d['value'];
            }
            elseif($d['name']=='Branch'){
                $dd['branch'] = $data['branch'] = $d['value'];
            }
            elseif($d['name']=='Graduation Percentage'){
                $dd['graduation_percentage']= $data['graduation_percentage'] = $d['value'];
            }
            elseif($d['name']=='Backlogs'){
                $dd['backlogs'] = $data['backlogs'] = $d['value'];
            }
            elseif($d['name']=='Source'){
                $dd['source'] = $data['source'] = $d['value'];
            }
            elseif($d['name']=='Remarks'){
                $dd['remarks'] = $data['remarks'] = $d['value'];
            }
        }

        if(isset($data['notes']))
            $dd['remarks'] = $data['remarks'] = $data['notes'];

        $data['name'] = $data['customer']['name'];
        $data['phone'] = $data['customer']['phoneNumber'];
        $data['interaction_at'] = date('Y-m-d h:m:s',$data['createdAt']);

        $call = Obj::where('phone',$data['phone'])->where('caller_name',$data['caller_name'])->orderBy('admission_date','desc')->first();
        $call->status = $data['status'];
        if($data['admission_date']){
            $call->admission_date =  $data['admission_date'];
            $call->call_start_date = $data['admission_date'];
        }
        if($data['walkin_date']){
            $call->walkin_date =  $data['walkin_date'];
        }
        if($data['demo_date']){
            $call->demo_date =  $data['demo_date'];
        }
        $call->data =json_encode($dd,JSON_PRETTY_PRINT);
        $call->name = $data['name'];
        $call->save();
       // $data['completed'] = 1;
        Storage::disk('public')->put('calltrigger/'.$filename, json_encode($data,JSON_PRETTY_PRINT));
        
        //Storage::disk('public')->put('calltrigger/'.$filename, json_encode($obj,JSON_PRETTY_PRINT));
    }


        // capture call trigger
    public function itriggerview(){
        $filename = 'isamplecall.json';
        if(Storage::disk('public')->exists('calltrigger/'.$filename) &request()->get('data')!=1){
                $data = Storage::disk('public')->get('calltrigger/'.$filename);
                dd($data);
        }else{
            if(request('data')==1){
                $filename = 'isamplecall.json';
        $r = request();
        $obj = request()->all();
        $call_center = client('caller_center');
        $call_phone = client('caller_phone');
        $call_role = client('caller_role');

        

        $data = json_decode($obj,true);
        dd($data);
        $data['completed'] = 0;
        Storage::disk('public')->put('calltrigger/'.$filename, json_encode($data,JSON_PRETTY_PRINT));
      
     
       
            }
        }
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
