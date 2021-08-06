<?php

namespace App\Http\Controllers\Mailer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mailer\MailLog as Obj;

class MailLogController extends Controller
{   

    public function __construct(){
        // load the app, module and component name to object params
        $this->app      =   'Mailer';
        $this->module   =   'MailLog';
        $this->componentName = componentName('agency');
    }


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
    
    public function destroy($id)
    {   
        // load the resource
        $obj = Obj::where('id',$id)->first();
        // authorize the app
        $this->authorize('delete', $obj);
        // delete the resource
        $obj->delete();

        // flash message and redirect to controller index page
        $alert = '('.$this->app.'/'.$this->module.'/'.$id.') item  Successfully deleted!';
        return redirect()->route($this->module.'.index')->with('alert',$alert);
        //ddd(here);
    }
}
