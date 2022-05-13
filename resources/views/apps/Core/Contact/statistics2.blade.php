
<x-dynamic-component :component="$app->componentName" class="mt-4" >

	<!--begin::Breadcrumb-->
	<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-4 font-size-sm ">
		<li class="breadcrumb-item">
			<a href="{{ route('dashboard')}}" class="text-muted">Dashboard</a>
		</li>
		<li class="breadcrumb-item">
			<a href="{{ route('Contact.index')}}" class="text-muted">Contact</a>
		</li>
		<li class="breadcrumb-item">
			<a href="" class="text-muted">Statistics</a>
		</li>
	</ul>
	<!--end::Breadcrumb-->

	<div class="card p-4 mb-5">
		<h1 class="mb-0 d-inline"><i class="fa fa-chart-bar"></i> Form Statistics 
		</h1>
		<a href="{{ route('Contact.admin.statistics') }}">back to stats</a>
	</div>

	@if(isset($data))

	<div class="row">
		@foreach($data as $a=>$b)
		<div class="col-6 col-md-2">
			<!--begin::Stats Widget 31-->
			<div class="card card-custom bg-light border border-light-info card-stretch gutter-b">
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
					<span class="card-title font-weight-bolder text-dark font-size-h2 mb-0 mt-6 d-block">{{$b}}</span>
					<span class="font-weight-bold text-success ">{{$a}}</span>
				</div>
				<!--end::Body-->
			</div>
			<!--end::Stats Widget 31-->
		</div>
		@endforeach
	</div>

	@endif


</x-dynamic-component>