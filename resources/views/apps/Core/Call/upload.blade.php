
<x-dynamic-component :component="$app->componentName" class="mt-4" >
  <x-snippets.alerts.codesave></x-snippets.alerts.codesave>
  <!--begin::Breadcrumb-->
  <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-4 font-size-sm ">
    <li class="breadcrumb-item">
      <a href="{{ route('dashboard')}}" class="text-muted">Dashboard</a>
    </li>
   
    @if($stub!='Create')
    <li class="breadcrumb-item">
      <a href="" class="text-muted">Upload</a>
    </li>
    @endif
  </ul>
  <!--end::Breadcrumb-->


  <!--begin::Alert-->
  @if($alert)
    <x-snippets.alerts.basic>{{$alert}}</x-snippets.alerts.basic>
  @endif
  <!--end::Alert-->

  @if($stub=='Create')
    <form method="post" class="url_codesave" action="{{route($app->module.'.upload')}}" enctype="multipart/form-data">
  @else
    <form method="post" class="url_codesave" action="{{route($app->module.'.upload',[$obj->id])}}" enctype="multipart/form-data">
  @endif  

  <!--begin::basic card-->
 <x-snippets.cards.basic>
  
          <div class="form-group bg-light border p-4">
            <label for="exampleFormControlFile1">Upload File</label>
            <input type="file" class="form-control-file" name="file" id="exampleFormControlFile1">
          </div>
       
     
      
      
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <input type="hidden" name="agency_id" value="{{ request()->get('agency.id') }}">
        <input type="hidden" name="client_id" value="{{ request()->get('client.id') }}">
      
         <button type="submit" class="btn btn-info">Save</button>
    
  </x-snippets.cards.basic>
  <!--end::basic card-->   
  </form>

</x-dynamic-component>