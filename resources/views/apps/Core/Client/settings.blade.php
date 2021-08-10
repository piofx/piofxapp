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

@if(!$editor)
	<!--begin::basic card-->
	<x-snippets.cards.basic>
		<div class="p-5 rounded border bg-light mb-3 d-flex align-items-center justify-content-between">
			<h1 class="m-0">Settings</h1>
			<a href="{{ route($app->module.'.settings', 'mode=dev') }}" class="btn btn-dark">Developer Mode</a>
		</div>
      
		<form method="post" action="{{route($app->module.'.update',$obj->id)}}" enctype="multipart/form-data">
			<div class="form-group">
				<label for="formGroupExampleInput ">Domain</label>
				<input type="text" class="form-control" name="domain" id="formGroupExampleInput" value = "{{ $obj->domain }}" disabled>
			</div>

			<div class="rounded p-5 mb-4 bg-light-success">
				@if(!empty($settings))
                    <div class="">
                        @php
                            function print_data($setting_array, $key){
                                $id = 0;
                                foreach($setting_array as $t => $data){
                                    $text = '<div class="bg-light rounded-lg p-3 px-5 mb-3">';
                                    foreach($data as $k => $s){
                                        $text = $text . '<div class="row my-3">
                                                            <div class="col-12 col-lg-2 p-2 px-lg-3 d-flex align-items-center">
                                                                <h5 class="m-0 mb-1 mb-lg-0">'. ucwords(str_replace('_', ' ', $k)) .'</h5>
                                                            </div>
                                                            <div class="col-12 col-lg-10 p-1 px-lg-3">
                                                                <input type="text" hidden name="settings-array-'. $key. '-' .$t .'-key[]" class="form-control" value="'. $k .'">
                                                                <input type="text" name="settings-array-'. $key. '-' .$t .'-value[]" class="form-control" value="'. $s .'">
                                                            </div>
                                                        </div>';
                                    }
                                    $text = $text . "</div>";
                                    echo $text;
                                    $id = $id + 1;
                                }
                            }
                        @endphp
						<div class="row mb-3">
							@foreach($settings as $k => $setting)
								@if(is_array($setting))
									<div class="col-12 bg-white p-5 rounded-lg my-3">
										<h2 class="font-weight-bold mb-3 pl-2">{{ ucwords(str_replace('_', ' ', $k)) }}</h2>
										{{ print_data($setting, $k) }}
									</div>
								@else
									@if($k != 'name')
									<div class="col-12 col-lg-4">
										<div class="form-group">
											<label>{{ ucwords(str_replace('_', ' ', $k)) }}</label>
											<input type="text" name="{{ 'settings-' . $k }}" class="form-control" value="{{ $setting }}">
										</div>
									</div>
									@else
										<input type="hidden" name="{{ 'settings-' . $k }}" class="form-control" value="{{ $setting }}">
									@endif
								@endif
							@endforeach
						</div>
					</div>
                @endif
				<!-- <div class="row">
					<div class="col-12 col-md-4">
						<div class="form-group">
							<label for="formGroupExampleInput ">Theme</label>
							<input type="text" class="form-control" name="settings-theme" id="formGroupExampleInput" placeholder="Enter the theme Name" 
							@if($stub=='Create')
								value="{{ (old('settings-theme')) ? old('settings-theme') : 'default' }}"
							@else
								value = "{{ isset(json_decode($obj->settings)->theme)? json_decode($obj->settings)->theme :'' }}"
							@endif
							>
						</div>
					</div>
					<div class="col-12 col-md-4">
						<div class="form-group">
							<label for="formGroupExampleInput ">Title</label>
							<input type="text" class="form-control" name="settings-title" id="formGroupExampleInput" placeholder="Enter the site title" 
							@if($stub=='Create')
								value="{{ (old('settings-title')) ? old('settings-title') : '' }}"
							@else
								value = "{{ isset(json_decode($obj->settings)->title)? json_decode($obj->settings)->title :'' }}"
							@endif
							>
						</div>
					</div>
					<div class="col-12 col-md-4">
						<div class="form-group">
							<label for="formGroupExampleInput ">Sub Title</label>
							<input type="text" class="form-control" name="settings-subtitle" id="formGroupExampleInput" placeholder="Enter the site subtitle" 
							@if($stub=='Create')
								value="{{ (old('settings-subtitle')) ? old('settings-subtitle') : '' }}"
							@else
								value = "{{ isset(json_decode($obj->settings)->subtitle)? json_decode($obj->settings)->subtitle :'' }}"
							@endif
							>
						</div>
					</div>
					<div class="col-12 col-md-4">
						<div class="form-group">
							<label for="formGroupExampleInput ">Display Email</label>
							<input type="text" class="form-control" name="settings-email" id="formGroupExampleInput" placeholder="Enter the email to be displayed" 
							@if($stub=='Create')
								value="{{ (old('settings-email')) ? old('settings-email') : '' }}"
							@else
								value = "{{ isset(json_decode($obj->settings)->email)? json_decode($obj->settings)->email :'' }}"
							@endif
							>
						</div>
					</div>
					<div class="col-12 col-md-4">
						<div class="form-group">
							<label for="formGroupExampleInput ">Display Phone</label>
							<input type="text" class="form-control" name="settings-phone" id="formGroupExampleInput" placeholder="Enter the phone number to be displayed" 
							@if($stub=='Create')
								value="{{ (old('settings-phone')) ? old('settings-phone') : '' }}"
							@else
								value = "{{ isset(json_decode($obj->settings)->phone)? json_decode($obj->settings)->phone :'' }}"
							@endif
							>
						</div>
					</div>
				</div> -->
			</div>
			
			<input type="hidden" name="_method" value="PUT">
			<input type="hidden" name="mode" value="normal">
			<input type="hidden" name="id" value="{{ $obj->id }}">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<button type="submit" class="btn btn-info">Save</button>
		</form>
	</x-snippets.cards.basic>
	<!--end::basic card-->   
	@else
		<form action="{{ route($app->module.'.update',$obj->id) }}" method="POST">
			<div class="card rounded">
				<div class="card-body">
					<div class="p-5 rounded-lg border bg-light d-flex justify-content-between align-items-center">
						<h1 class="m-0">Settings</h1>
						<button type="submit" class="btn btn-dark">Update</button>
					</div>
					<div class="mt-5">
						<div id="content" style="min-height: 800px"></div>
						<textarea id="content_editor" class="form-control border d-none" name="settings" rows="5">@if($stub=='Create'){{ (old('settings')) ? old('settings') : '' }}@else{{ json_encode(json_decode($obj->settings),JSON_PRETTY_PRINT) }}@endif</textarea>
					</div>
				</div>
			</div>
			<input type="hidden" name="_method" value="PUT">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<input type="hidden" name="mode" value="dev">
		</form>
	@endif


</x-dynamic-component>