<?php

namespace App\Http\Controllers\Template;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Template\Template;
use App\Models\Template\TemplateCategory;
use App\Models\Template\TemplateTag as Obj;


class TemplateTagController extends Controller
{
  /**
   * Define the app and module object variables and component name 
   *
   */
  public function __construct(){
      // load the app, module and component name to object params
      $this->app      =   'Template';
      $this->module   =   'TemplateTag';
      $this->componentName = componentName('agency');
  }

  public function index(Obj $obj,Request $request)
  {   
    // check for search string
    $query = $request->input('query');

    // Authorize the request
    $this->authorize('view', $obj);

    // Retrieve all records
    $objs = $obj->where("name", "LIKE", "%".$query."%")->orderBy('name', 'asc')->paginate(10);
      
    return view("apps.".$this->app.".".$this->module.".index")
            ->with("app", $this)
            ->with("objs", $objs);     
  }




  public function create(Obj $obj)
  {
    // authorize the app
    $this->authorize('create', $obj);

    return view("apps.".$this->app.".".$this->module.".createEdit")
          ->with('stub', "create")
          ->with("app", $this)
          ->with("obj", $obj);
  }

  public function store(Request $request, Obj $obj)
  { 
    //Validating the fields
    $request->validate([
      'name' => 'required|max:255',
      'slug' => 'required',   
    ]);
    // Authorize the request
    $this->authorize('create', $obj);

    // Store the records
    $obj = $obj->create($request->all());

    return redirect()->route($this->module.'.index');
  }

  public function edit($slug, Obj $obj)
  {
    // Retrieve Specific record
    $obj = $obj->getRecord($slug);
    // Authorize the request
    $this->authorize('edit', $obj);

    return view("apps.".$this->app.".".$this->module.".createEdit")
            ->with("stub", "update")
            ->with("app", $this)
            ->with("obj", $obj);
  }

  public function update($id, Request $request)
  {
      // load the resource
      $obj = Obj::where('id',$id)->first();

      // authorize the app
      $this->authorize('update', $obj);

      //update the resource
      $obj = $obj->update($request->all());
      return redirect()->route($this->module.'.index'); 
  }
  
    public function destroy($id)
    {
      // load the resource
      $obj = Obj::where('id',$id)->first();
      
      // authorize
      $this->authorize('delete', $obj);
      
      // delete the resource
      $obj->delete();

      return redirect()->route($this->module.'.index');

  }

}
