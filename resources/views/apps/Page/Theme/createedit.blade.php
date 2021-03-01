
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



  @if($stub=='Create')
    <form method="post" action="{{route($app->module.'.store')}}" enctype="multipart/form-data">
  @else
    <form method="post" action="{{route($app->module.'.update',$obj->id)}}" enctype="multipart/form-data">
  @endif  

	<!--begin::basic card-->
	<x-snippets.cards.action :title="$app->module " class="border"  >
  
      <div class="row">
        <div class="col-12 col-md-3">
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
        <div class="col-12 col-md-3">
          <div class="form-group">
            <label for="formGroupExampleInput ">Slug</label>
            <input type="text" class="form-control" name="slug" id="formGroupExampleInput" placeholder="Enter the unique url" 
                @if($stub=='Create')
                value="{{ (old('slug')) ? old('slug') : '' }}"
                @else
                value = "{{ $obj->slug }}"
                @endif
              >
          </div>
        </div>
        
        <div class="col-12 col-md-3">
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
        <div class="col-12 col-md-3">
          <div class="form-group">
            <label for="formGroupExampleInput ">Set as current theme</label>
            <div class="col-9 col-form-label">
            <div class="radio-inline">
                <label class="radio radio-success">
                    <input type="radio" name="default" @if(isset($obj)) @if(request()->get('client.theme.name')==$obj->slug) checked="checked" @endif @endif value="1"/>
                    <span></span>
                    Yes
                </label>
                <label class="radio radio-danger">
                    <input type="radio" name="default" @if(isset($obj)) @if(request()->get('client.theme.name')!=$obj->slug) checked="checked" @else  @endif @else checked="checked" @endif value="0"/>
                    <span></span>
                    No
                </label>
            </div>
            </div>
          </div>
        </div>
        @if(Auth::user()->checkRole(['superadmin','superdeveloper','agencyadmin','agencydeveloper']))
        <div class="col-12 col-md-3">
          <div class="form-group">
            <label for="formGroupExampleInput ">List in Library </label>
            <div class="col-9 col-form-label">
            <div class="radio-inline">
                <label class="radio radio-success">
                    <input type="radio" name="admin" @if(isset($obj)) @if($obj->admin==1) checked="checked" @endif @endif value="1"/>
                    <span></span>
                    Yes
                </label>
                <label class="radio radio-danger">
                    <input type="radio" name="admin" @if(isset($obj)) @if($obj->admin===0) checked="checked"  @endif @else checked="checked" @endif value="0"/>
                    <span></span>
                    No
                </label>
            </div>
            </div>
          </div>
        </div>
        @endif
      </div>  

      
      <div class="form-group bg-light border">
        <label for="formGroupExampleInput " class="px-4 pt-4 pb-2">Settings</label>
        <div class="">
<textarea id="editor" class="form-control border" name="settings"  rows="5">@if($stub=='Create'){{ (old('settings')) ? old('settings') : '' }}@else{{ $obj->settings }}@endif</textarea>
      </div>
      </div>
      
      @if($stub=='Update')
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="user_id" value="{{ $obj->user_id }}">
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