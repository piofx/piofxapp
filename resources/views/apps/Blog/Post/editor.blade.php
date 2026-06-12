
<x-dynamic-component :component="$app->componentName" class="mt-4" >

  <!--begin::Breadcrumb-->
  <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-4 font-size-sm ">
      <li class="breadcrumb-item">
        <a href="{{ route('dashboard')}}" class="text-muted">Dashboard</a>
      </li>
      <li class="breadcrumb-item">
        <a href="/admin/blog"  class="text-muted">Blogs</a>
      </li>
     
   
  </ul>
  <!--end::Breadcrumb-->

 <!--begin::Alert-->
  @if($alert)
    <x-snippets.alerts.basic>{{$alert}}</x-snippets.alerts.basic>
  @endif
  <!--end::Alert-->
  <x-snippets.alerts.codesave></x-snippets.alerts.codesave>

  <form method="post" class="url_codesave" action="{{route('blog.editor')}}?slug={{$obj->slug}}" enctype="multipart/form-data"> 

  <!--begin::basic card-->
  <x-snippets.cards.action :title="$app->module " class="border">
  
      <div class="row">
        <div class="col-12 col-md-3">
          <div class="form-group">
            <label for="formGroupExampleInput ">{{ ucfirst($app->module)}} Name</label>
            <input type="text" class="form-control" name="name" id="formGroupExampleInput" placeholder="Enter the Category Name" 
               
                value = "{{ $obj->title }}"
              
              >
          </div>
        </div>
        <div class="col-12 col-md-3">
          <div class="form-group">
            <label for="formGroupExampleInput ">Slug</label>
            <input type="text" class="form-control" name="slug" id="formGroupExampleInput" placeholder="Enter the unique url" 
               
                value = "{{ $obj->slug }}"
              
              >
          </div>
        </div>
       
       
      </div>  

      <div class="form-group bg-light border">
        <label for="formGroupExampleInput " class="px-4 pt-4 pb-2">HTML Editor (Use Ctrl+S to save)</label>
        <div class="">
          <div id="content" style="min-height: 800px"></div>
<textarea id="content_editor" class="form-control border d-none" name="content"  rows="5">{{ $obj->content }}</textarea>
      </div>
      </div>
      
        
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <input type="hidden" name="agency_id" value="{{ request()->get('agency.id') }}">
        <input type="hidden" name="client_id" value="{{ request()->get('client.id') }}">
        <input type="hidden" name="save" value="1">
      
    
    
  </x-snippets.cards.action>
  <!--end::basic card-->   
  </form>

</x-dynamic-component>