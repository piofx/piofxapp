<?php

namespace App\Http\Controllers\College;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\College\College as Obj;
use App\Models\Core\Whatsapp ;
use Illuminate\Support\Facades\Storage;

class CollegeController extends Controller
{
    /**
     * Define the app and module object variables and component name 
     *
     */
    public function __construct(){
        // load the app, module and component name to object params
        $this->app      =   'College';
        $this->module   =   'College';
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
        $zone = $request->zone;
        // load alerts if any
        $alert = session()->get('alert');
        // authorize the app
        $this->authorize('view', $obj);
        // retrive the listing
        $objs = $obj->getRecords($item,$zone,30);
        $client_id = request()->get('client.id');
        

        if($request->get('refresh')){
            Cache::forget('allcolleges_'.$client_id);
            $alert="Data refreshed";
        }
        
        $allcolleges = Cache::remember('allcolleges_'.$client_id,600,function() use($obj,$client_id){
            $colleges = $obj->where('client_id', $client_id)->orderBy('name')->get();
            foreach($colleges as $key=>$c){
                $colleges[$key]->registered = Cache::remember('wu_'.$c,600,function() use($c,$client_id){return Whatsapp::where('client_id',$client_id)->where('college',$c->name)->count();
                });
            }
            return $colleges;
        });


        $allcollegezones = $allcolleges->groupBy('zone');
        $data['zones'] = [];
        foreach(zones() as $a=>$b){
            if(isset($allcollegezones[$b]))
                $data['zones'][$b] = count($allcollegezones[$b]);
            else
                $data['zones'][$b] = 0;
        }

        if($zone)
            $allcollegetypes = $obj->where('zone',$zone)->where('client_id', request()->get('client.id'))->get()->groupBy('type');
        else
            $allcollegetypes = $allcolleges->groupBy('type');

        $data['types'] = ["all"=>0,"engineering"=>0,"degree"=>0,"other"=>0];
        $data['students'] = ["all"=>0,"engineering"=>0,"degree"=>0,"other"=>0];
        foreach($data['types'] as $a=>$b){
            if(isset($allcollegetypes[$a])){
                $data['types'][$a] = count($allcollegetypes[$a]);
                foreach($allcollegetypes[$a] as $c){
                    $data['students'][$a] += $c->registered;
                    $data['students']["all"] += $c->registered;
                }
                $data['types']["all"] += count($allcollegetypes[$a]);
                 
            }
            
        }



        return view('apps.'.$this->app.'.'.$this->module.'.index')
                ->with('app',$this)
                ->with('data',$data)
                ->with('alert',$alert)
                ->with('objs',$objs);
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
        $data['states'] = states();
        $data['districts'] = districts();
        $data['zones'] = zones();
        $data['designations'] = designations();
        return view('apps.'.$this->app.'.'.$this->module.'.createedit')
                ->with('stub','Create')
                ->with('obj',$obj)
                ->with('data',$data)
                ->with('editor',true)
                ->with('app',$this);
    }

    /**
     * Download the csv file
     *
     * @return \Illuminate\Http\Response
     */
     public function download(Obj $obj)
    {

        // Retrieve all the records
        $objs = $obj->where('agency_id', request()->get('agency.id'))->where('client_id', request()->get('client.id'))->get();
        $fileName = "colleges_".strtotime("now").'.csv';
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );
       
        $callback = function() use($objs) {
            $file = fopen('php://output', 'w');
            $columns = ['sno','name','code','type','location','zone','district','state','contact_person','contact_designation','contact_phone','contact_email','data_volume'];
            fputcsv($file, $columns);
                foreach($objs as $obj){
                    $row = [$obj->id,$obj->name,$obj->code,$obj->type,$obj->location,$obj->zone,$obj->district,$obj->state,$obj->contact_person,$obj->contact_designation,$obj->contact_phone,$obj->contact_email,$obj->data_volume];
                    fputcsv($file, $row);
                }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
      
    }

    /**
     * Upload the csv file
     *
     * @return \Illuminate\Http\Response
     */
    public function upload(Obj $obj,Request $request)
    {
        // authorize the app
        $this->authorize('create', $obj);
        // load alerts if any
        $alert = session()->get('alert');

        try{
            
            if(isset($request->all()['file'])){
                
                $file      = $request->all()['file'];
                $fname = 'college_'.str_replace(' ','_',strtolower($file->getClientOriginalName()));
                $extension = strtolower($file->getClientOriginalExtension());

                if(!in_array($extension, ['csv'])){
                    
                    $alert = 'Only CSV files are allowed!';
                    return redirect()->route('College.upload')->with('alert',$alert);
                }

                $row = 0;
                 $file_path = Storage::disk('public')->putFileAs('excels', $request->file('file'),$fname,'public');
                 $fpath = Storage::disk('public')->path($file_path);
                if (($handle = fopen($fpath, "r")) !== FALSE) {
                  while (($data = fgetcsv($handle, 9000, ",")) !== FALSE) {
                    if($row==0){
                        $row++;
                        continue;
                    }
                    $row++;
                    $var = array("","","","","","","","","","","","");
                    foreach($data as $a=>$b){
                        if($b!="" && $a!=0)
                            $var[$a-1]=$b;

                    }

                    $entry = Obj::where('name',$var[0])->first();
                    if($entry){
                        $entry->name = $var[0];
                        $entry->code = $var[1];
                        $entry->type = $var[2];
                        $entry->location = $var[3];
                        $entry->zone = $var[4];
                        $entry->district = $var[5];
                        $entry->state = $var[6];
                        $entry->contact_person = $var[7];
                        $entry->contact_designation = $var[8];
                        $entry->contact_phone = $var[9];
                        $entry->contact_email = $var[10];
                        $entry->data_volume = $var[11];
                        $entry->status=1;
                        $entry->save();
                    }else{
                        $entry = new Obj();
                        $entry->name = $var[0];
                        $entry->code = ($var[1])?$var[1]:'';
                        $entry->type = ($var[2])?$var[2]:'';
                        $entry->location = ($var[3])?$var[3]:'';
                        $entry->zone = ($var[4])?$var[4]:'';
                        $entry->district = ($var[5])?$var[5]:'';
                        $entry->state = ($var[6])?$var[6]:'';
                        $entry->contact_person = ($var[7])?$var[7]:'';
                        $entry->contact_designation = ($var[8])?$var[8]:'';
                        $entry->contact_phone = ($var[9])?$var[9]:'';
                        $entry->contact_email = ($var[10])?$var[10]:'';
                        $entry->data_volume = ($var[11])?$var[11]:'';
                        $entry->client_id = request()->get('client.id');
                        $entry->agency_id = request()->get('agency.id');
                        $entry->status=1;
                        $entry->save();
                    }
                    
                   
                  }
                  fclose($handle);
                }

                $alert = 'College data uploaded  ('.($row-1).')';
                return redirect()->route('College.index')->with('alert',$alert);

            }
            else{
                return view('apps.'.$this->app.'.'.$this->module.'.upload')
                    ->with('obj',$obj)
                    ->with('alert',$alert)
                    ->with('app',$this);

            }
        }catch (QueryException $e){
           $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                $alert = 'Some error in updating the record';
                return redirect()->back()->withInput()->with('alert',$alert);
            }
        }
        

        
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
            $obj->create($request->all());

            Cache::forever('colleges',$obj->all());
           
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
        $students = $obj->students();
        // load alerts if any
        $alert = session()->get('alert');
        // authorize the app
        $this->authorize('view', $obj);

        if($obj)
            return view('apps.'.$this->app.'.'.$this->module.'.show')
                    ->with('students',$students)
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

        $data['states'] = states();
        $data['districts'] = districts();
        $data['zones'] = zones();
        $data['designations'] = designations();

        if($obj)
            return view('apps.'.$this->app.'.'.$this->module.'.createedit')
                ->with('stub','Update')
                ->with('obj',$obj)
                ->with('data',$data)
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

            Cache::forever('colleges',$obj->all());

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
