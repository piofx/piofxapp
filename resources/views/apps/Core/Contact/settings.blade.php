<x-dynamic-component :component="$app->componentName" class="mt-4" >

 <!--begin::Alert-->
  @if($alert)
    <x-snippets.alerts.basic>{{$alert}}</x-snippets.alerts.basic>
  @endif
  <!--end::Alert-->

  <!--begin::Breadcrumb-->
  <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-4 font-size-sm ">
    <li class="breadcrumb-item">
      <a href="{{ route('dashboard')}}" class="text-muted">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
      <a href="{{ route('Contact.index')}}"  class="text-muted">{{ ucfirst($app->module) }}</a>
    </li>
  </ul>
  <!--end::Breadcrumb-->

<!--begin::basic card-->
<x-snippets.cards.basic>
	
	@if($stub=='Create')
	<form method="post" action="{{route('Contact.settings')}}" enctype="multipart/form-data">
	@else
	<form method="post" action="{{route('Contact.settings')}}" enctype="multipart/form-data">
	@endif  
		<div class="p-5 rounded border bg-light mb-3 d-flex align-items-center justify-content-between">
			<h1 class="m-0">Settings</h1>
			<div>
				<button type="submit" class="btn btn-info">Save</button>
				@if(request()->get('mode') != 'dev')
					<a href="{{ route('Contact.settings', 'mode=dev') }}" class="btn btn-dark">Developer Mode</a>
				@else
					<a href="{{ route('Contact.settings') }}" class="btn btn-primary">Normal Mode</a>
				@endif
			</div>
		</div>
		@if(!$editor)
			@if(!empty($settings))
				<div class="bg-light mt-5 p-5 rounded">
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
								@if (isAssoc($setting))
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
										<div class="bg-white p-5 rounded-lg">
											{{ print_data($setting, $k) }}
										</div>
									</div>
								@endif
							@else
								@if(!(strlen($setting) > 100))
									<div class="col-12 col-lg-4">
										<div class="form-group">
											<label class="font-weight-bold">{{ ucwords(str_replace('_', ' ', $k)) }}</label>
											<input type="text" name="{{ 'settings-' . $k }}" class="form-control" value="{{ $setting }}">
										</div>
									</div>
								@else
									<div class="col-12 mb-5">
										<label class="font-weight-bold">{{ ucwords(str_replace('_', ' ', $k)) }}</label>
										<textarea name="{{ 'settings-' . $k }}" class="form-control d-block" rows="5">{{ $setting }}</textarea>
									</div>
								@endif
							@endif
						@endforeach
					</div>
				</div>
			@endif
			
			<input type="hidden" name="mode" value="normal">
		@else
			<div class="form-group ">
				<div class="border">
					<div id="content" style="min-height: 400px"></div>
					<textarea id="content_editor" class="form-control border d-none" name="settings" rows="5">@if($stub=='Create'){{ (old('settings')) ? old('settings') : '' }}@else{{ json_encode(json_decode($settings),JSON_PRETTY_PRINT) }}@endif
					</textarea>
				</div>
			</div>
			<input type="hidden" name="mode" value="dev">
		@endif
		<input type="hidden" name="setting" value="0">
		<input type="hidden" name="store" value="1">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
		<input type="hidden" name="agency_id" value="{{ request()->get('agency.id') }}">
		<input type="hidden" name="client_id" value="{{ request()->get('client.id') }}">
	</form>

</x-snippets.cards.basic>
<!--end::basic card-->   


</x-dynamic-component>