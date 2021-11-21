
<x-dynamic-component :component="$app->componentName" class="mt-4" >

	<!--begin::Breadcrumb-->
	<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-4 font-size-sm ">
		<li class="breadcrumb-item">
			<a href="{{ route('dashboard')}}" class="text-muted">Dashboard</a>
		</li>
		
		<li class="breadcrumb-item">
			<a href="" class="text-muted">Tracker</a>
		</li>
	</ul>
	<!--end::Breadcrumb-->

	<div class="card p-4 mb-5">
		<h1 class="mb-0 d-inline"><i class="fa fa-chart-bar"></i> Tracker<a href="?refresh=1" class="float-right h5"><i class="fa fa-retweet text-primary mt-1"></i> Refresh Data</a></h1>
	</div>
	<h3 class="mb-4"><i class="fa fa-angle-right"></i> Source </h3>
	<div class="row">
		@foreach($data['source'] as $h=>$k)
		@if($h)
		<div class="col-6 col-md-2">
			<!--begin::Stats Widget 31-->
			<div class="card card-custom bg-light-success card-stretch gutter-b">
				<!--begin::Body-->
				<div class="card-body">
					<span class="svg-icon svg-icon-2x svg-icon-success">
						<!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Media/Equalizer.svg-->
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
							<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								<rect x="0" y="0" width="24" height="24" />
								<rect fill="#000000" opacity="0.3" x="13" y="4" width="3" height="16" rx="1.5" />
								<rect fill="#000000" x="8" y="9" width="3" height="11" rx="1.5" />
								<rect fill="#000000" x="18" y="11" width="3" height="9" rx="1.5" />
								<rect fill="#000000" x="3" y="13" width="3" height="7" rx="1.5" />
							</g>
						</svg>
						<!--end::Svg Icon-->
					</span>
					<span class="card-title font-weight-bolder text-success font-size-h2 mb-0 mt-6 d-block">{{count($k)}}</span>
					<span class="font-weight-bold text-success font-size-sm">{{$h}}</span>
				</div>
				<!--end::Body-->
			</div>
			<!--end::Stats Widget 31-->
		</div>
		@endif
		@endforeach
	</div>

	<h3 class="mb-4"><i class="fa fa-angle-right"></i> Medium</h3>
	<div class="row">
		@foreach($data['medium'] as $h=>$k)
		@if($h)
		<div class="col-6 col-md-2">
			<!--begin::Stats Widget 31-->
			<div class="card card-custom bg-light-info card-stretch gutter-b">
				<!--begin::Body-->
				<div class="card-body">
					<span class="svg-icon svg-icon-2x svg-icon-success">
						<!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Media/Equalizer.svg-->
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
							<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								<rect x="0" y="0" width="24" height="24" />
								<rect fill="#000000" opacity="0.3" x="13" y="4" width="3" height="16" rx="1.5" />
								<rect fill="#000000" x="8" y="9" width="3" height="11" rx="1.5" />
								<rect fill="#000000" x="18" y="11" width="3" height="9" rx="1.5" />
								<rect fill="#000000" x="3" y="13" width="3" height="7" rx="1.5" />
							</g>
						</svg>
						<!--end::Svg Icon-->
					</span>
					<span class="card-title font-weight-bolder text-success font-size-h2 mb-0 mt-6 d-block">{{count($k)}}</span>
					<span class="font-weight-bold text-success font-size-sm">{{$h}}</span>
				</div>
				<!--end::Body-->
			</div>
			<!--end::Stats Widget 31-->
		</div>
		@endif
		@endforeach
	</div>

	<h3 class="mb-4"><i class="fa fa-angle-right"></i> Campaign</h3>
	<div class="row">
		@foreach($data['campaign'] as $h=>$k)
		@if($h)
		<div class="col-6 col-md-2">
			<!--begin::Stats Widget 31-->
			<div class="card card-custom bg-light-primary card-stretch gutter-b">
				<!--begin::Body-->
				<div class="card-body">
					<span class="svg-icon svg-icon-2x svg-icon-success">
						<!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Media/Equalizer.svg-->
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
							<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								<rect x="0" y="0" width="24" height="24" />
								<rect fill="#000000" opacity="0.3" x="13" y="4" width="3" height="16" rx="1.5" />
								<rect fill="#000000" x="8" y="9" width="3" height="11" rx="1.5" />
								<rect fill="#000000" x="18" y="11" width="3" height="9" rx="1.5" />
								<rect fill="#000000" x="3" y="13" width="3" height="7" rx="1.5" />
							</g>
						</svg>
						<!--end::Svg Icon-->
					</span>
					<span class="card-title font-weight-bolder text-success font-size-h2 mb-0 mt-6 d-block">{{count($k)}}</span>
					<span class="font-weight-bold text-success font-size-sm">{{$h}}</span>
				</div>
				<!--end::Body-->
			</div>
			<!--end::Stats Widget 31-->
		</div>
		@endif
		@endforeach
	</div>

		<h3 class="mb-4"><i class="fa fa-angle-right"></i> Content</h3>
	<div class="row">
		@foreach($data['content'] as $h=>$k)
		@if($h)
		<div class="col-6 col-md-2">
			<!--begin::Stats Widget 31-->
			<div class="card card-custom bg-light-success card-stretch gutter-b">
				<!--begin::Body-->
				<div class="card-body">
					<span class="svg-icon svg-icon-2x svg-icon-success">
						<!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Media/Equalizer.svg-->
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
							<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								<rect x="0" y="0" width="24" height="24" />
								<rect fill="#000000" opacity="0.3" x="13" y="4" width="3" height="16" rx="1.5" />
								<rect fill="#000000" x="8" y="9" width="3" height="11" rx="1.5" />
								<rect fill="#000000" x="18" y="11" width="3" height="9" rx="1.5" />
								<rect fill="#000000" x="3" y="13" width="3" height="7" rx="1.5" />
							</g>
						</svg>
						<!--end::Svg Icon-->
					</span>
					<span class="card-title font-weight-bolder text-success font-size-h2 mb-0 mt-6 d-block">{{count($k)}}</span>
					<span class="font-weight-bold text-success font-size-sm">{{$h}}</span>
				</div>
				<!--end::Body-->
			</div>
			<!--end::Stats Widget 31-->
		</div>
		@endif
		@endforeach
	</div>

		<h3 class="mb-4"><i class="fa fa-angle-right"></i> Term</h3>
	<div class="row">
		@foreach($data['term'] as $h=>$k)
		@if($h)
		<div class="col-6 col-md-2">
			<!--begin::Stats Widget 31-->
			<div class="card card-custom bg-white card-stretch gutter-b">
				<!--begin::Body-->
				<div class="card-body">
					<span class="svg-icon svg-icon-2x svg-icon-success">
						<!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Media/Equalizer.svg-->
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
							<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								<rect x="0" y="0" width="24" height="24" />
								<rect fill="#000000" opacity="0.3" x="13" y="4" width="3" height="16" rx="1.5" />
								<rect fill="#000000" x="8" y="9" width="3" height="11" rx="1.5" />
								<rect fill="#000000" x="18" y="11" width="3" height="9" rx="1.5" />
								<rect fill="#000000" x="3" y="13" width="3" height="7" rx="1.5" />
							</g>
						</svg>
						<!--end::Svg Icon-->
					</span>
					<span class="card-title font-weight-bolder text-success font-size-h2 mb-0 mt-6 d-block">{{count($k)}}</span>
					<span class="font-weight-bold text-success font-size-sm">{{$h}}</span>
				</div>
				<!--end::Body-->
			</div>
			<!--end::Stats Widget 31-->
		</div>
		@endif
		@endforeach
	</div>

	


</x-dynamic-component>