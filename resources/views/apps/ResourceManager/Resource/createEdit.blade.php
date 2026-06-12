<x-dynamic-component :component="$app->componentName">
<div class="container lst">
@if (count($errors) > 0)
<div class="alert alert-danger">
    <strong>Sorry!</strong> There were more problems with your HTML input.<br><br>
    <ul>
      @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
      @endforeach
    </ul>
</div>
@endif
  
@if(session('success'))
<div class="alert alert-success">
  {{ session('success') }}
</div> 
@endif
@if($stub == 'create')
    <form action="{{ route($app->module.'.store') }}" method="POST" enctype="multipart/form-data">
    @else
    <form action="{{ route($app->module.'.update', $obj->id) }}" method="POST" enctype="multipart/form-data">
@endif
 <div class="container center_div"> 
 <h2>Upload Files</h2>

    @csrf
    <div class="form-group">
    <label for="formGroupExampleInput">Title</label>
    <input type="text" class="form-control" id="formGroupExampleInput" placeholder="Enter Title" name="title" value="@if($stub == 'update'){{$obj ? $obj->title : ''}}@endif">
  </div>
  <div class="form-group">
    <label for="formGroupExampleInput2">Description</label>
    <input type="text" class="form-control" id="formGroupExampleInput2" placeholder="description" name="description" value="@if($stub == 'update'){{$obj ? $obj->description : ''}}@endif">
  </div>
   
  @if($stub == 'create')
    <div class="input-group hdtuto control-group lst increment" >
      <input type="file" name="file" class="myfrm form-control">
      </div>
      <div>
     
      <div class="form-group">
        <label for="seeAnotherField">Are you uploding a image</label>
        <select class="form-control" id="seeAnotherField">
              <option value="no">No</option>
              <option value="yes">Yes</option>
        </select>
      </div>
  
              
      <div class="form-check form-switch" id="otherFieldDiv">
          <input class="form-check-input" type="checkbox" id="otherFieldDiv" name="optimize">
          <label class="form-check-label" for="flexSwitchCheckChecked">optimize the image</label> 
      </div>
      
      </div>
      @else
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="id" value="{{ $obj->id }}">
    @endif
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <button type="submit" class="btn btn-success" style="margin-top:10px">Submit</button>
   
</form>    
</div>    
</div>
</x-dynamic-component>