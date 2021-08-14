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

	<form method="post" action="{{route($app->module.'.update',$obj->id)}}" enctype="multipart/form-data">
		<!--begin::basic card-->
		<x-snippets.cards.basic>
			<div class="p-5 rounded border bg-light mb-3 d-flex align-items-center justify-content-between">
				<h1 class="m-0">Settings</h1>
				<div>
					<button type="submit" class="btn btn-info">Save</button>
					@if(request()->get('mode') != 'dev')
						<a href="{{ route($app->module.'.settings', 'mode=dev') }}" class="btn btn-dark">Developer Mode</a>
					@else
						<a href="{{ route($app->module.'.settings') }}" class="btn btn-primary">Normal Mode</a>
					@endif
				</div>
				
			</div>
			
			@if(!$editor)
				<div class="form-group">
					<label for="formGroupExampleInput ">Domain</label>
					<input type="text" class="form-control" name="domain" id="formGroupExampleInput" value = "{{ $obj->domain }}" disabled>
				</div>

				<div class="rounded p-5 mb-4 bg-light-success">
					@if(!empty($settings))
						<div class="">
							@php
								function isAssoc(array $array) {
									return count(array_filter(array_keys($array), 'is_string')) > 0;
								}

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
										@if(isAssoc($setting))
											<div class="col-12 my-3">
												<h2 class="font-weight-bold">{{ $k }}</h2>
												<div class="bg-white p-5 rounded-lg">
													@foreach($setting as $k => $v)
														<div class="row">
															<div class="col-12 col-lg-2 d-flex align-items-center mt-2 mb-0 mb-lg-2">
																<h5 class="m-0">{{ ucwords(str_replace('_', ' ', $k)) }}</h5>
															</div>
															<div class="col-12 col-lg-10 my-2">
																<input type="text" name="{{ 'settings-' . $k }}" class="form-control" value="{{ $v }}">
															</div>
														</div>
													@endforeach
												</div>
											</div>
										@else
											<div class="col-12 my-3">
												<h2 class="font-weight-bold mb-3">{{ ucwords(str_replace('_', ' ', $k)) }}</h2>
												<div class="p-5 rounded-lg bg-white">
													{{ print_data($setting, $k) }}
												</div>
											</div>
										@endif
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
				</div>
				
				
				<input type="hidden" name="mode" value="normal">
			@else
				<div class="mt-5">
					<div id="content" style="min-height: 800px"></div>
					<textarea id="content_editor" class="form-control border d-none" name="settings" rows="5">@if($stub=='Create'){{ (old('settings')) ? old('settings') : '' }}@else{{ json_encode(json_decode($obj->settings),JSON_PRETTY_PRINT) }}@endif</textarea>
				</div>

				<input type="hidden" name="mode" value="dev">
			@endif
			
			<input type="hidden" name="_method" value="PUT">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<input type="hidden" name="id" value="{{ $obj->id }}">
		</x-snippets.cards.basic>
		<!--end::basic card-->   
	</form>


</x-dynamic-component>