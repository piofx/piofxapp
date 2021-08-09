<x-dynamic-component :component="$app->componentName" class="mt-4" >

	<!--begin::Breadcrumb-->
	<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-4 font-size-sm ">
		<li class="breadcrumb-item">
			<a href="{{ route('dashboard')}}" class="text-muted">Dashboard</a>
		</li>
		
		<li class="breadcrumb-item">
			<a href="" class="text-muted">{{ $obj->name }} Settings</a>
		</li>

	</ul>
	<!--end::Breadcrumb-->


  <!--begin::Alert-->
  @if(isset($alert))
    <x-snippets.alerts.basic>{{$alert}}</x-snippets.alerts.basic>
  @endif
  <!--end::Alert-->

<!--begin::basic card-->
<x-snippets.cards.basic>
	@if(!$editor)
		<div class="p-5 rounded border bg-light mb-3 d-flex align-items-center justify-content-between">
			<h1 class="m-0">Settings</h1>
			<a href="{{ route($app->module.'.settings', 'mode=dev') }}" class="btn btn-dark">Developer Mode</a>
		</div>
      
		<form method="post" action="{{route($app->module.'.update',$obj->id)}}" enctype="multipart/form-data">
			<div class="form-group">
				<label for="formGroupExampleInput ">Domain</label>
				<input type="text" class="form-control" name="domain" id="formGroupExampleInput" value = "{{ $obj->domain }}" disabled>
			</div>

			@if(request()->get('dev'))
				<div class="form-group ">
					<label for="formGroupExampleInput ">Settings (json format)</label>
					<div class="border">
						<textarea id="editor" class="form-control border" name="settings"  rows="5">@if($stub=='Create'){{ (old('settings')) ? old('settings') : '' }}@else{{ json_encode(json_decode($obj->settings),JSON_PRETTY_PRINT) }}@endif
						</textarea>
					</div>
				</div>

				<input type="hidden" name="dev" value="1">
			@else
				<div class="rounded p-5 mb-4 bg-light-success">
					<h4>Settings</h4>
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
			
			<input type="hidden" name="_method" value="PUT">
			<input type="hidden" name="setting" value="1">
			<input type="hidden" name="id" value="{{ $obj->id }}">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<button type="submit" class="btn btn-info">Save</button>
		</form>
    
	@else
		<div class="form-group ">
			<label for="formGroupExampleInput ">Settings</label>
			<div class="border">
				<textarea id="editor" class="form-control border" name="settings"  rows="5">@if($stub=='Create'){{ (old('settings')) ? old('settings') : '' }}@else{{ json_encode(json_decode($obj->settings),JSON_PRETTY_PRINT) }}@endif
				</textarea>
			</div>
		</div>
	@endif
</x-snippets.cards.basic>
<!--end::basic card-->   

</x-dynamic-component>