
<x-dynamic-component :component="$app->componentName" class="mt-4" >

	<!--begin::Breadcrumb-->
	<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-4 font-size-sm ">
		<li class="breadcrumb-item">
			<a href="{{ route('dashboard')}}" class="text-muted">Dashboard</a>
		</li>
		<li class="breadcrumb-item">
			<a href="{{ route($app->module.'.index') }}"  class="text-muted">{{ ucfirst($app->module) }}</a>
		</li>
		@if($stub!='Create')
		<li class="breadcrumb-item">
			<a href="" class="text-muted">{{ $obj->name }}</a>
		</li>
		@endif
	</ul>
	<!--end::Breadcrumb-->


 <!--begin::Alert-->
  @if($alert)
    <x-snippets.alerts.basic>{{$alert}}</x-snippets.alerts.basic>
  @endif
  <!--end::Alert-->


	<!--begin::basic card-->
	<x-snippets.cards.basic>
      <h1 class="p-5 rounded border bg-light mb-3">
        @if($stub=='Create')
          Create {{ $app->module }}
        @else
          Update {{ $app->module }}
        @endif  
       </h1>
      
      @if($stub=='Create')
      <form method="post" action="{{route($app->module.'.store')}}" enctype="multipart/form-data">
      @else
      <form method="post" action="{{route($app->module.'.update',$obj->id)}}" enctype="multipart/form-data">
      @endif  

      <div class="row">
        <div class="col-12 col-md-4">
          <div class="form-group">
            <label for="formGroupExampleInput ">{{ ucfirst($app->module)}} Name</label>
            <input type="text" class="form-control" name="name" id="formGroupExampleInput" placeholder="Enter the Category Name" 
                @if($stub=='Create')
                value="{{ (old('name')) ? old('name') : '' }}"
                @else
                value = "{{ $obj->name }}"
                @endif

                 
              >
          </div>
        </div>
        <div class="col-12 col-md-4">
           <div class="form-group">
            <label for="formGroupExampleInput ">Domain</label>
            <input type="text" class="form-control" name="domain" id="formGroupExampleInput" placeholder="Enter the domain name" 
                @if($stub=='Create')
                value="{{ (old('domain')) ? old('domain') : '' }}"
                @else
                value = "{{ $obj->domain }}"
                @endif
                @if($stub!='Create') disabled @endif
              >
          </div>
        </div>
        <div class="col-12 col-md-4">
          <div class="form-group">
            <label for="formGroupExampleInput ">Status </label>
            <select class="form-control" name="status">
              <option value="1" @if(isset($obj)) @if($obj->status==1) selected @else selected @endif @else selected @endif >Active</option>
              <option value="0" @if(isset($obj)) @if($obj->status===0) selected @endif @endif >Inactive</option>
              
            </select>
          </div>

        </div>
      </div>
      
      
     
      @if(request()->get('dev'))
      <div class="form-group ">
        <label for="formGroupExampleInput ">Settings (json format)</label>
        <div class="border">
        <textarea id="editor" class="form-control border" name="settings"  rows="5">@if($stub=='Create'){{ (old('settings')) ? old('settings') : '' }}@else{{ json_encode(json_decode($obj->settings),JSON_PRETTY_PRINT) }}@endif
        </textarea>
      </div>
      </div>
      @else


        @if($stub=='Create')

         <div class=" rounded p-5 mb-4 bg-light-primary">
      <h4>Admin User</h4>
      <div class="row">
        <div class="col-12 col-md-4">
          <div class="form-group">
            <label for="formGroupExampleInput ">Name</label>
            <input type="text" class="form-control" name="user_name" id="formGroupExampleInput" placeholder="Enter the admin user name" 
            @if($stub=='Create')
            value="{{ (old('user_name')) ? old('user_name') : '' }}"
            @endif
            >
          </div>
        </div>
        <div class="col-12 col-md-4">
          <div class="form-group">
            <label for="formGroupExampleInput ">Email</label>
            <input type="text" class="form-control" name="user_email" id="formGroupExampleInput" placeholder="Enter the admin user email" 
            @if($stub=='Create')
            value="{{ (old('user_email')) ? old('user_email') : '' }}"
            @endif
            >
          </div>
        </div>
        <div class="col-12 col-md-4">
         <div class="form-group">
          <label for="formGroupExampleInput ">Phone</label>
          <input type="text" class="form-control" name="user_phone" id="formGroupExampleInput" placeholder="Enter the admin user phone" 
          @if($stub=='Create')
          value="{{ (old('user_phone')) ? old('user_phone') : '' }}"
          @endif
          >
        </div>
      </div>
     
    </div>
  </div>
        @endif

     <div class=" rounded p-5 mb-4 bg-light-success">
          <h4>Page Settings</h4>
          <div class="row">
            <div class="col-12 col-md-4">
              <div class="form-group">
                <label for="formGroupExampleInput ">Theme</label>
                <input type="text" class="form-control" name="settings_theme" id="formGroupExampleInput" placeholder="Enter the theme Name" 
                @if($stub=='Create')
                value="{{ (old('settings_theme')) ? old('settings_theme') : 'default' }}"
                @else
                value = "{{ isset(json_decode($obj->settings)->theme)? json_decode($obj->settings)->theme :'' }}"
                @endif
                >
              </div>
            </div>
            <div class="col-12 col-md-4">
             <div class="form-group">
              <label for="formGroupExampleInput ">Title</label>
              <input type="text" class="form-control" name="settings_title" id="formGroupExampleInput" placeholder="Enter the site title" 
              @if($stub=='Create')
              value="{{ (old('settings_title')) ? old('settings_title') : '' }}"
              @else
              value = "{{ isset(json_decode($obj->settings)->title)? json_decode($obj->settings)->title :'' }}"
              @endif
              >
            </div>
          </div>
          <div class="col-12 col-md-4">
           <div class="form-group">
            <label for="formGroupExampleInput ">Sub Title</label>
            <input type="text" class="form-control" name="settings_subtitle" id="formGroupExampleInput" placeholder="Enter the site subtitle" 
            @if($stub=='Create')
            value="{{ (old('settings_subtitle')) ? old('settings_subtitle') : '' }}"
            @else
            value = "{{ isset(json_decode($obj->settings)->subtitle)? json_decode($obj->settings)->subtitle :'' }}"
            @endif
            >
          </div>
        </div>
        <div class="col-12 col-md-4">
          <div class="form-group">
            <label for="formGroupExampleInput ">Display Email</label>
            <input type="text" class="form-control" name="settings_email" id="formGroupExampleInput" placeholder="Enter the email to be displayed" 
            @if($stub=='Create')
            value="{{ (old('settings_email')) ? old('settings_email') : '' }}"
            @else
            value = "{{ isset(json_decode($obj->settings)->email)? json_decode($obj->settings)->email :'' }}"
            @endif
            >
          </div>
        </div>
        <div class="col-12 col-md-4">
         <div class="form-group">
          <label for="formGroupExampleInput ">Display Phone</label>
          <input type="text" class="form-control" name="settings_phone" id="formGroupExampleInput" placeholder="Enter the phone number to be displayed" 
          @if($stub=='Create')
          value="{{ (old('settings_phone')) ? old('settings_phone') : '' }}"
          @else
          value = "{{ isset(json_decode($obj->settings)->phone)? json_decode($obj->settings)->phone :'' }}"
          @endif
          >
        </div>
      </div>
    </div>
  </div>

      @endif
      
     

      

      @if($stub=='Update')
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="id" value="{{ $obj->id }}">
      @endif
      <input type="hidden" name="setting" value="0">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
        <input type="hidden" name="dev" value="{{ request()->get('dev') }}">

        <input type="hidden" name="agency_id" value="{{ request()->get('agency.id') }}">
       <button type="submit" class="btn btn-info">Save</button>
    </form>
    
	</x-snippets.cards.basic>
	<!--end::basic card-->   

</x-dynamic-component>