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

<div class="card rounded">
    <div class="card-body">
		@if($stub=='Create')
		<form method="post" action="{{route($app->module.'.store')}}" enctype="multipart/form-data">
		@else
		<form method="post" action="{{route($app->module.'.update',$obj->id)}}" enctype="multipart/form-data">
		@endif  
            @if(!$editor)
				<div class="p-5 rounded-lg border bg-light d-flex justify-content-between align-items-center">
					<h1 class="m-0">Client</h1>
					<div>
						<button  type="submit" class="btn btn-primary font-weight-bold">Save</button>
						<a href="{{ route($app->module.'.create', 'mode=dev') }}" class="btn btn-dark">Developer Mode</a>
					</div>
				</div>

				@if(!empty($settings))
                    <div class="bg-light p-7 mt-5 rounded-lg border">
                        @php
                            function print_data($setting_array, $key){
                                $id = 0;
                                foreach($setting_array as $k => $v){
                                    $text = '<div class="bg-light rounded-lg p-3 px-5 mb-3">';
                                        $text = $text . '<div class="row my-3">
                                                            <div class="col-12 col-lg-2 p-2 px-lg-3 d-flex align-items-center">
                                                                <h5 class="m-0 mb-1 mb-lg-0">'. ucwords(str_replace('_', ' ', $k)) .'</h5>
                                                            </div>
                                                            <div class="col-12 col-lg-10 p-1 px-lg-3">
                                                                <input type="text" hidden name="settings-array-'. $key. '-' .$k .'-key[]" class="form-control" value="'. $k .'">
                                                                <input type="text" name="settings-array-'. $key. '-' .$k .'-value[]" class="form-control" value="'. $v .'">
                                                            </div>
                                                        </div>';
                                    $text = $text . "</div>";
                                    echo $text;
                                    $id = $id + 1;
                                }
                            }
                        @endphp
						<div class="row">
							@foreach($settings as $k => $setting)
								@if(!empty($setting) && is_array($setting))
									<div class="col-12 bg-white p-5 rounded-lg my-3">
										<h5>{{ ucwords(str_replace('_', ' ', $k)) }}</h5>
										{{ print_data($setting, $k) }}
									</div>
								@else
									<div class="col-12 col-lg-4 mb-2">
										<label class="m-0 mb-3 mb-lg-0">{{ ucwords(str_replace('_', ' ', $k)) }}</label>
										<input type="text" name="{{ 'settings-' . $k }}" class="form-control" value="{{ $setting }}">
									</div>
								@endif
							@endforeach
						</div>
                    </div>
                @endif

				@if($stub=='Update')
					<input type="hidden" name="_method" value="PUT">
				@endif
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="mode" value="normal">
			@else
				<div class="p-5 rounded-lg border bg-light d-flex justify-content-between align-items-center">
					<h1 class="m-0">Client</h1>
					<button type="submit" class="btn btn-dark">Save</button>
				</div>
				<div class="mt-5">
					<div id="content" style="min-height: 800px"></div>
					<textarea id="content_editor" class="form-control border d-none" name="settings" rows="5">{{ $settings ? json_encode($settings, JSON_PRETTY_PRINT) : ''}}</textarea>
				</div>
				@if($stub=='Update')
					<input type="hidden" name="_method" value="PUT">
				@endif
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="mode" value="dev">
			@endif
        </form>

    </div>
</div>

</x-dynamic-component>