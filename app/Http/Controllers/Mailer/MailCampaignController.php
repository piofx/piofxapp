<?php

namespace App\Http\Controllers\Mailer;
use App\Jobs\SendEmail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mailer\MailCampaign as Obj;
use App\Models\Mailer\MailTemplate;
use App\Models\Mailer\MailLog;
use App\Models\Mailer\MailSubscriber;
use App\Models\Core\Client;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MailCampaignController extends Controller
{
    public function __construct(){
        // load the app, module and component name to object params
        $this->app      =   'Mailer';
        $this->module   =   'MailCampaign';
        $this->componentName = componentName('agency');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Obj $obj,Request $request)
    {   
        if($request->input('query'))
        {
            // check for search string
            $query = $request->input('query');
            //ddd($query);
            $objs = $obj->where("name", "LIKE", "%".$query."%")->orderBy('name', 'asc')->get(); 
        }
        else
        {
            $objs = $obj->all();
        }
        // load alerts if any
        $alert = session()->get('alert');
        // authorize the app
        $this->authorize('view', $obj);
        
        return view('apps.'.$this->app.'.'.$this->module.'.index')
                ->with('app',$this)
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

        // load alerts if any
        $alert = session()->get('alert');

        $templates = MailTemplate::all();
        
        return view('apps.'.$this->app.'.'.$this->module.'.createedit')
                ->with('stub','create')
                ->with('obj',$obj)
                ->with('alert',$alert)
                ->with('app',$this)
                ->with('templates',$templates);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Obj $obj,Request $request)
    {        
        $time = $request->input('timezone');
        $scheduled = Carbon::parse($request->input('scheduled_at'))->addMinutes($time);
        $current = Carbon::now();
        $diff_in_minutes = $current->diffInMinutes($scheduled);
        //ddd($diff_in_minutes);
        
        $request->merge(['agency_id'=>request()->get('agency.id')])->merge(['client_id'=>request()->get('client.id')])->merge(['user_id'=> auth()->user()->id]); 
        
        $obj = $obj->create($request->all());
        $ems = preg_split ("/\,/", $request->emails);
        $template = MailTemplate::where('id',$request->mail_template_id)->first();
        $request->merge(['reference_id'=> $obj->id])->merge(['app'=> $this->app])->merge(['subject'=> $template->subject])->merge(['message'=> $template->message])->merge(['status'=> '0']);
        foreach($ems as $em)
        {   
            $subscriber = MailSubscriber::where('email', '=', $em)->first();
            $validate_email = debounce_valid_email($em);
            if ($subscriber === null)
            {
                MailSubscriber::create(['email' => $em,'status' => 1 ,'valid_email' => $validate_email,'client_id' => $request->client_id, 'agency_id' => $request->agency_id]);   
            }
            if($validate_email == 1)
            {
            $request->merge(['email'=> $em]);
            $log = MailLog::create($request->all());
            $details = ['email' => $log->email , 'content' => $log->message];
            $identity = $log->id;
            $data = $obj->id;
            SendEmail::dispatch($details,$identity,$data)->delay(Carbon::now()->addMinutes($diff_in_minutes));
            //SendEmail::dispatch($details,$identity,$data)->delay(Carbon::now()->addMinutes(1));
            }
        }
        
        $alert = 'A new ('.$this->app.'/'.$this->module.') item is created!';
        return redirect()->route($this->module.'.index')
                         ->with('alert',$alert);        
        
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,Obj $obj)
    {    
        // load the resource
        $obj = $obj->where('id',$id)->first();
        
        // authorize the app
        $this->authorize('edit', $obj);
        $templates = MailTemplate::all();
        if($obj)
            return view('apps.'.$this->app.'.'.$this->module.'.createedit')
                ->with('stub','update')
                ->with('obj',$obj)
                ->with('app',$this)
                ->with('templates',$templates);

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
    public function update(Request $request, $id ,Obj $obj)
    {   
        // load the resource
        $obj = $obj->where('id',$id)->first();

        // authorize the app
        $this->authorize('update', $obj);

        //update the resource
        $obj->update($request->all());

        //Fletching the data from jobs table
        $jobs = DB::table('jobs')->get();

        foreach ($jobs as $job) {

        $payload = json_decode($job->payload);

        $jb = unserialize($payload->data->command);  
        if($jb->data == $id)
        {
            DB::table('jobs')->where('id', '=', $job->id)->delete();
        }
        }
        //calculating time to schedule a job
        $time = $request->input('timezone');
        $scheduled = Carbon::parse($request->input('scheduled_at'))->addMinutes($time);
        $current = Carbon::now();
        $diff_in_minutes = $current->diffInMinutes($scheduled);
        //deleting mailog records for of current campaign
        $items = MailLog::where('reference_id',$obj->id)->get();
        foreach($items as $item)
        {
            $item->delete();
        }
        //creating mailogs and dispatching emails 
        $ems = preg_split ("/\,/", $request->emails);
        $template = MailTemplate::where('id',$request->mail_template_id)->first();
        foreach($ems as $em)
        {
            $request->merge(['reference_id'=> $obj->id])->merge(['app'=> $this->app])->merge(['subject'=> $template->subject])->merge(['message'=> $template->message])->merge(['status'=> '0'])->merge(['email'=> $em])->merge(['agency_id'=> $obj->agency_id])->merge(['client_id'=> $obj->client_id]);

            $maillog = MailLog::create($request->all());
            $details = ['email' => $maillog->email , 'content' => $maillog->message];
            $identity = $maillog->id;
            $data = $obj->id;
            SendEmail::dispatch($details,$identity,$data)->delay(Carbon::now()->addMinutes($diff_in_minutes));
            
        }

        // flash message and redirect to controller index page
        $alert = 'A new ('.$this->app.'/'.$this->module.'/'.$id.') item is updated!';
       
        //ddd($obj->template_category_id);
        return redirect()->route($this->module.'.index')->with('alert',$alert);
    }

    public function show($id)
    {
        // load the resource
        $obj = Obj::where('id',$id)->first();
        $template = MailTemplate::where('id',$obj->mail_template_id)->first();
        // load alerts if any
        $alert = session()->get('alert');
        // authorize the app
        $this->authorize('view', $obj);
        if($obj)
            return view('apps.'.$this->app.'.'.$this->module.'.show')
                    ->with('obj',$obj)->with('app',$this)->with('template',$template)->with('alert',$alert);
        else
            abort(404);
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
        // authorize the app
        $this->authorize('delete', $obj);
        
        //Fletching the data from jobs table
        $jobs = DB::table('jobs')->get();
        //deleting jobs
        foreach ($jobs as $job) 
        {
            $payload = json_decode($job->payload);
            $jb = unserialize($payload->data->command);  
            if($jb->data == $id)
            {
                DB::table('jobs')->where('id', '=', $job->id)->delete();
            }
        }
        //deleting mailogs 
        $items = MailLog::where('reference_id',$obj->id)->get();
        foreach($items as $item)
        {
            $item->delete();
        }
        // delete the resource
        $obj->delete();

        // flash message and redirect to controller index page
        $alert = '('.$this->app.'/'.$this->module.'/'.$id.') item  Successfully deleted!';
        return redirect()->route($this->module.'.index')->with('alert',$alert);
    }

    public function resendmails($id)
    {      
        // load the resource
        $obj = Obj::where('id',$id)->first();
        // authorize the app
        $this->authorize('resendmails', $obj);
        $ems = preg_split ("/\,/", $obj->emails);
        $template = MailTemplate::where('id',$obj->mail_template_id)->first();
        foreach($ems as $em)
        {       
            $log = MailLog::create(['agency_id' => $obj->agency_id ,'status' => 0 ,'client_id' => $obj->client_id , 'mail_template_id' => $obj->mail_template_id ,'reference_id' => $obj->id , 'email' => $em, 'scheduled_at' => $obj->scheduled_at, 'app' => $this->app , 'subject'=> $template->subject ,'message'=> $template->message]);
            $validate_email = debounce_valid_email($em);
            if($validate_email == 1)
            {
            $details = ['email' => $log->email , 'content' => $log->message];
            $identity = $log->id;
            $data = $id;
            SendEmail::dispatch($details,$identity,$data)->delay(Carbon::now()->addMinutes(0));
            }
        }
        // flash message and redirect to controller show page
        $alert = 'Mails Resent';
        return redirect()->route($this->module.'.show',$id)->with('alert',$alert);
    }
}


