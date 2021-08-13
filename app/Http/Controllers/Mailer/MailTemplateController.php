<?php

namespace App\Http\Controllers\Mailer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mailer\MailTemplate as Obj;
use App\Models\Core\Client;
use Illuminate\Support\Facades\Auth;

class MailTemplateController extends Controller
{
    public function __construct(){
        // load the app, module and component name to object params
        $this->app      =   'Mailer';
        $this->module   =   'MailTemplate';
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
            $objs = $obj->where("name", "LIKE", "%".$query."%")->orderBy('name', 'asc')->paginate(10); 
        }
        else
        {
            $objs = $obj->paginate(10);
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

        return view('apps.'.$this->app.'.'.$this->module.'.createedit')
                ->with('stub','create')
                ->with('obj',$obj)
                ->with('alert',$alert)
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
        $request->validate([
            'name' => 'required|max:255',
            'message' => 'required',
            'slug' => 'required',       
        ]); 
        $request->merge(['agency_id'=>request()->get('agency.id')])->merge(['client_id'=>request()->get('client.id')])->merge(['user_id'=> auth()->user()->id]);   
        $obj = $obj->create($request->all());
        $alert = 'A new Mail Template is created!';
        return redirect()->route($this->module.'.index')
                         ->with('alert',$alert);        
        
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug,Obj $obj)
    {    
        
        // load the resource
        $obj = $obj->where('slug',$slug)->first();
        
        // authorize the app
        $this->authorize('edit', $obj);

        if($obj)
            return view('apps.'.$this->app.'.'.$this->module.'.createedit')
                ->with('stub','update')
                ->with('obj',$obj)
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
    public function update(Request $request, $slug ,Obj $obj)
    {   
        // load the resource
        $obj = $obj->where('slug',$slug)->first();
        
        // authorize the app
        $this->authorize('update', $obj);

        //update the resource
        $obj->update($request->all());

        // flash message and redirect to controller index page
        $alert = 'Template updated!';
       
        //ddd($obj->template_category_id);
        return redirect()->route($this->module.'.index')->with('alert',$alert);
    }

    public function show($slug)
    {
        // load the resource
        $obj = Obj::where('slug',$slug)->first();
        
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {   
        // load the resource
        $obj = Obj::where('slug',$slug)->first();

        // authorize the app
        $this->authorize('delete', $obj);
        
        // delete the resource
        $obj->delete();

        // flash message and redirect to controller index page
        $alert = 'Template Successfully deleted!';
        return redirect()->route($this->module.'.index')->with('alert',$alert);
    }

}
