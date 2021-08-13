<x-dynamic-component :component="$app->componentName" class="mt-4" >
  <!-- Validation Errors -->
  <x-auth-validation-errors class="mb-4" :errors="$errors" />
  <!--begin::Alert-->
  @if($alert)
    <x-snippets.alerts.basic>{{$alert}}</x-snippets.alerts.basic>
  @endif
  <!--end::Alert-->
	<!--begin::Breadcrumb-->
	<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-4 font-size-sm ">

		<li class="breadcrumb-item">
			<a href="{{ route($app->module.'.index') }}"  class="text-muted">{{ ucfirst($app->module) }}</a>
		</li>
		@if($stub!='create')
		<li class="breadcrumb-item">
			<a href="" class="text-muted">{{ $obj->name }}</a>
		</li>
		@endif
	</ul>
	<!--end::Breadcrumb-->

  @if($stub=='create')
    <form method="post" action="{{route($app->module.'.store')}}" enctype="multipart/form-data">
  @endif
  @if($stub == 'update')
    <form method="post" action="{{route($app->module.'.update',$obj->id)}}" enctype="multipart/form-data">
  @endif  

	<!--begin::basic card-->
	<x-snippets.cards.action :title="$app->module " class="border">
  
    <div class="row">
      <div class="col-12 col-md-6">
        <div class="js-form-message form-group mb-4">
            <label for="emailAddressExample2" class="input-label">Email address</label>
            <input type="email" class="form-control" name="email" id="emailAddressExample2" placeholder="alexhecker@pixeel.com" aria-label="alexhecker@pixeel.com"
                   data-msg="Please enter a valid email address." value="@if(isset($obj->email)) {{$obj->email}} @endif">
          </div>

      </div>
    </div>
        
      <div class="row">
        <div class="col-12 col-md-6">
          <div class="js-form-message form-group mb-4">
              <label class="input-label">Information</label>
              <input type="text" class="form-control" name="info" placeholder="Enter the info" aria-label="Enter the info"
                       value="@if(isset($obj->info)) {{$obj->info}} @endif">
          </div>
        </div>
      </div>
      
      <div class="row">     
  
        <div class="col-12 col-md-4">
          <div class="form-group">
            <label for="formGroupExampleInput ">Status </label>
            <div class="col-9 col-form-label">
            <div class="radio-inline">
                <label class="radio radio-success">
                    <input type="radio" name="status" @if(isset($obj)) @if($obj->status==1) checked="checked" @endif @endif value="1"/>
                    <span></span>
                    Active
                </label>
                <label class="radio radio-danger">
                    <input type="radio" name="status" @if(isset($obj)) @if($obj->status==0) checked="checked" @endif @endif value="0"/>
                    <span></span>
                    Inactive
                </label>
            </div>
            </div>
          </div>
        </div>
      </div>
        


      @if($stub=='update')
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="id" value="{{ $obj->id }}">
      @endif
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
        <input type="hidden" name="agency_id" value="{{ request()->get('agency.id') }}">
        <input type="hidden" name="client_id" value="{{ request()->get('client.id') }}">
    
	</x-snippets.cards.action>
	<!--end::basic card-->   
  </form>

</x-dynamic-component>