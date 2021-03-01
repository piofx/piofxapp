<?php

namespace App\Http\Controllers\UserManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserManagement\UserManager as Obj;

class UserManagerController extends Controller
{   
    public function __construct(){
        // load the app, module and component name to object params
        $this->app      =   'UserManagement';
        $this->module   =   'UserManager';
        $this->componentName = componentName('agency');
      }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Obj $objs,Request $request)
    {   
        $search_query = $request->input('search_query');
        
        $objs = $objs->where('firstname','LIKE',"%$search_query%")->paginate(10);
        return view("apps.".$this->app.".".$this->module.".index")
                ->with("app", $this)
                ->with("objs", $objs); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Obj $obj)
    {
        return view("apps.".$this->app.".".$this->module.".createEdit")
        ->with('stub', "create")
        ->with("app", $this)
        ->with("obj", $obj); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Obj $obj)
    {
        $obj = $obj->create($request->all());

        return redirect()->route($this->module.'.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,Obj $obj)
    {
        $objs = obj::find($id);
        return view("apps.".$this->app.".".$this->module.".profile")
                    ->with("app", $this)
                    ->with("stub", "update")
                    ->with("objs", $objs);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,Obj $obj)
    {   
        $obj = $obj->getRecord($id);

        return view("apps.".$this->app.".".$this->module.".createEdit")
              ->with("stub", "update")
              ->with("app", $this)
              ->with("obj", $obj);
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
        $obj = Obj::where('id',$id)->first();
        $obj = $obj->update($request->all());
        return redirect()->route($this->module.'.index'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $obj = Obj::where('id',$id)->delete();
        return redirect()->back();
    }
}
