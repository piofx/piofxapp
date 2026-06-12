
<x-dynamic-component :component="$app->componentName" class="mt-4" >

	<!--begin::Breadcrumb-->
	<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-4 font-size-sm ">
		<li class="breadcrumb-item">
			<a href="{{ route('dashboard')}}" class="text-muted">Dashboard</a>
		</li>
		<li class="breadcrumb-item">
			<a href="{{ route($app->module.'.index') }}"  class="text-muted">{{ ucfirst($app->module) }}</a>
		</li>
		<li class="breadcrumb-item">
			<a href="" class="text-muted">Statistics</a>
		</li>
	</ul>
	<!--end::Breadcrumb-->

	<div class="card p-4 mb-5">
		<h1 class="mb-0 d-inline"><i class="fa fa-chart-bar"></i> User Statistics <a href="?refresh=1" class="float-right h5"><i class="fa fa-retweet text-primary mt-1"></i> Refresh Data</a></h1>
	</div>
	<h3 class="mb-4"><i class="fa fa-angle-right"></i> Overall</h3>
	<div class="row">
		<div class="col-6 col-md-2">
			<!--begin::Stats Widget 30-->
			<div class="card card-custom bg-info card-stretch gutter-b">
				<!--begin::Body-->
				<div class="card-body">
					<span class="svg-icon svg-icon-2x svg-icon-white">
						<!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Communication/Group.svg-->
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
							<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								<polygon points="0 0 24 0 24 24 0 24" />
								<path d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
								<path d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
							</g>
						</svg>
						<!--end::Svg Icon-->
					</span>
					<span class="card-title font-weight-bolder text-white font-size-h2 mb-0 mt-6 d-block">{{ $data['all']['total']}}</span>
					<span class="font-weight-bold text-white font-size-sm">Total Users</span>
				</div>
				<!--end::Body-->
			</div>
			<!--end::Stats Widget 30-->
		</div>

		<div class="col-6 col-md-2">
			<!--begin::Stats Widget 31-->
			<div class="card card-custom bg-danger card-stretch gutter-b">
				<!--begin::Body-->
				<div class="card-body">
					<span class="svg-icon svg-icon-2x svg-icon-white">
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
					<span class="card-title font-weight-bolder text-white font-size-h2 mb-0 mt-6 d-block">{{$data['all']['this_week']}}</span>
					<span class="font-weight-bold text-white font-size-sm">This week</span>
				</div>
				<!--end::Body-->
			</div>
			<!--end::Stats Widget 31-->
		</div>

		<div class="col-6 col-md-2">
			<!--begin::Stats Widget 31-->
			<div class="card card-custom bg-primary card-stretch gutter-b">
				<!--begin::Body-->
				<div class="card-body">
					<span class="svg-icon svg-icon-2x svg-icon-white">
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
					<span class="card-title font-weight-bolder text-white font-size-h2 mb-0 mt-6 d-block">{{$data['all']['this_month']}}</span>
					<span class="font-weight-bold text-white font-size-sm">This month</span>
				</div>
				<!--end::Body-->
			</div>
			<!--end::Stats Widget 31-->
		</div>

		<div class="col-6 col-md-2">
			<!--begin::Stats Widget 31-->
			<div class="card card-custom bg-warning card-stretch gutter-b">
				<!--begin::Body-->
				<div class="card-body">
					<span class="svg-icon svg-icon-2x svg-icon-white">
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
					<span class="card-title font-weight-bolder text-white font-size-h2 mb-0 mt-6 d-block">{{$data['all']['this_year']}}</span>
					<span class="font-weight-bold text-white font-size-sm">This year</span>
				</div>
				<!--end::Body-->
			</div>
			<!--end::Stats Widget 31-->
		</div>

		<div class="col-6 col-md-2">
			<!--begin::Stats Widget 31-->
			<div class="card card-custom bg-light-info card-stretch gutter-b">
				<!--begin::Body-->
				<div class="card-body">
					<span class="svg-icon svg-icon-2x svg-icon-info">
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
					<span class="card-title font-weight-bolder text-info font-size-h2 mb-0 mt-6 d-block">{{$data['all']['last_month']}}</span>
					<span class="font-weight-bold text-info font-size-sm">Last month</span>
				</div>
				<!--end::Body-->
			</div>
			<!--end::Stats Widget 31-->
		</div>

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
					<span class="card-title font-weight-bolder text-success font-size-h2 mb-0 mt-6 d-block">{{$data['all']['last_year']}}</span>
					<span class="font-weight-bold text-success font-size-sm">Last year</span>
				</div>
				<!--end::Body-->
			</div>
			<!--end::Stats Widget 31-->
		</div>
	</div>

		<h3 class="mb-4"><i class="fa fa-angle-right"></i> Active Users</h3>
	<div class="row">
		<div class="col-6 col-md-2">
			<!--begin::Stats Widget 30-->
			<div class="card card-custom bg-light-primary border border-light-info card-stretch gutter-b">
				<!--begin::Body-->
				<div class="card-body">
					<span class="svg-icon svg-icon-2x svg-icon-primary">
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
					<span class="card-title font-weight-bolder text-primary font-size-h2 mb-0 mt-6 d-block">{{ $data['active']['this_week']}}</span>
					<span class="font-weight-bold text-primary font-size-sm">This Week</span>
				</div>
				<!--end::Body-->
			</div>
			<!--end::Stats Widget 30-->
		</div>

		<div class="col-6 col-md-2">
			<!--begin::Stats Widget 30-->
			<div class="card card-custom bg-light-primary border border-light-info card-stretch gutter-b">
				<!--begin::Body-->
				<div class="card-body">
					<span class="svg-icon svg-icon-2x svg-icon-primary">
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
					<span class="card-title font-weight-bolder text-primary font-size-h2 mb-0 mt-6 d-block">{{ $data['active']['this_month']}}</span>
					<span class="font-weight-bold text-primary font-size-sm">This month</span>
				</div>
				<!--end::Body-->
			</div>
			<!--end::Stats Widget 30-->
		</div>

		<div class="col-6 col-md-2">
			<!--begin::Stats Widget 30-->
			<div class="card card-custom bg-light-primary border border-light-info card-stretch gutter-b">
				<!--begin::Body-->
				<div class="card-body">
					<span class="svg-icon svg-icon-2x svg-icon-primary">
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
					<span class="card-title font-weight-bolder text-primary font-size-h2 mb-0 mt-6 d-block">{{ $data['active']['past_30']}}</span>
					<span class="font-weight-bold text-primary font-size-sm">Last 30 days</span>
				</div>
				<!--end::Body-->
			</div>
			<!--end::Stats Widget 30-->
		</div>

		<div class="col-6 col-md-2">
			<!--begin::Stats Widget 30-->
			<div class="card card-custom bg-light-primary border border-light-info card-stretch gutter-b">
				<!--begin::Body-->
				<div class="card-body">
					<span class="svg-icon svg-icon-2x svg-icon-primary">
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
					<span class="card-title font-weight-bolder text-primary font-size-h2 mb-0 mt-6 d-block">{{ $data['active']['past_60']}}</span>
					<span class="font-weight-bold text-primary font-size-sm">Last 60 days</span>
				</div>
				<!--end::Body-->
			</div>
			<!--end::Stats Widget 30-->
		</div>

		<div class="col-6 col-md-2">
			<!--begin::Stats Widget 30-->
			<div class="card card-custom bg-light-primary border border-light-info card-stretch gutter-b">
				<!--begin::Body-->
				<div class="card-body">
					<span class="svg-icon svg-icon-2x svg-icon-primary">
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
					<span class="card-title font-weight-bolder text-primary font-size-h2 mb-0 mt-6 d-block">{{ $data['active']['past_90']}}</span>
					<span class="font-weight-bold text-primary font-size-sm">Last 90 days</span>
				</div>
				<!--end::Body-->
			</div>
			<!--end::Stats Widget 30-->
		</div>

		<div class="col-6 col-md-2">
			<!--begin::Stats Widget 30-->
			<div class="card card-custom bg-light-primary border border-light-info card-stretch gutter-b">
				<!--begin::Body-->
				<div class="card-body">
					<span class="svg-icon svg-icon-2x svg-icon-primary">
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
					<span class="card-title font-weight-bolder text-primary font-size-h2 mb-0 mt-6 d-block">{{ $data['active']['past_180']}}</span>
					<span class="font-weight-bold text-primary font-size-sm">Last 180 days</span>
				</div>
				<!--end::Body-->
			</div>
			<!--end::Stats Widget 30-->
		</div>

		
	</div>

	@if(isset($data['other']))
	@foreach($data['other'] as $k=>$v)
	<h3 class="mb-4"><i class="fa fa-angle-right"></i> {{$k}}</h3>
	<div class="row">
		@foreach($v as $a=>$b)
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
	@endforeach
	@endif


</x-dynamic-component>