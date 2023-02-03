<x-dynamic-component :component="$componentName" class="mt-4" >

	<div class="row">
		<div class="col-12 col-md-12">

			<h4 class="mb-6"><span class="svg-icon svg-icon-dark svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-02-01-052524/theme/html/demo1/dist/../src/media/svg/icons/Design/Mask.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
				<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
					<rect x="0" y="0" width="24" height="24"/>
					<path d="M7.67514486,18.731359 C9.6803634,17.3851601 11,15.0966889 11,12.5 C11,9.58867922 9.34119765,7.06479249 6.91718054,5.82192739 C8.29918974,4.68360845 10.0697622,4 12,4 C16.418278,4 20,7.581722 20,12 C20,16.418278 16.418278,20 12,20 C10.4066753,20 8.92214267,19.5342055 7.67514486,18.731359 Z" fill="#000000" opacity="0.3"/>
					<path d="M6.39268296,17.7059641 C4.91588435,16.254539 4,14.2342276 4,12 C4,10.0680854 4.68479668,8.29611365 5.82489501,6.91357974 C7.72637261,8.04773008 9,10.1251292 9,12.5 C9,14.6298467 7.97562469,16.5204376 6.39268296,17.7059641 Z" fill="#000000"/>
				</g>
			</svg><!--end::Svg Icon--></span> Core Modules</h4>
			<div class="row">
				@if(Auth::user()->role == 'superadmin')
				<div class='col-6 col-md-3'>
					<!--begin::Tiles Widget 11-->
					<div class="card card-custom gutter-b" style="max-height: 150px;background:#ec65c8;">
						<div class="card-body">
							<span class="svg-icon svg-icon-3x svg-icon-white ml-n2">

								<span class="svg-icon svg-icon-white svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-02-01-052524/theme/html/demo1/dist/../src/media/svg/icons/Design/Flatten.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
									<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
										<rect x="0" y="0" width="24" height="24"/>
										<circle fill="#000000" cx="9" cy="15" r="6"/>
										<path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3"/>
									</g>
								</svg><!--end::Svg Icon--></span> 
							</span>
							<div>
								<a href="{{ url('admin/agency')}}" class="text-inverse-success font-weight-bolder font-size-h4 mt-3">Agencies</a>
							</div>
						</div>
					</div>
					<!--end::Tiles Widget 11-->
				</div>

				<div class='col-6 col-md-3'>
					<!--begin::Tiles Widget 11-->
					<div class="card card-custom  gutter-b" style="max-height: 150px;background:#9a7b70">
						<div class="card-body">
							<span class="svg-icon svg-icon-3x svg-icon-white ml-n2">
								<!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
								<span class="svg-icon svg-icon-white svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-02-01-052524/theme/html/demo1/dist/../src/media/svg/icons/Communication/Shield-user.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
									<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
										<rect x="0" y="0" width="24" height="24"/>
										<path d="M4,4 L11.6314229,2.5691082 C11.8750185,2.52343403 12.1249815,2.52343403 12.3685771,2.5691082 L20,4 L20,13.2830094 C20,16.2173861 18.4883464,18.9447835 16,20.5 L12.5299989,22.6687507 C12.2057287,22.8714196 11.7942713,22.8714196 11.4700011,22.6687507 L8,20.5 C5.51165358,18.9447835 4,16.2173861 4,13.2830094 L4,4 Z" fill="#000000" opacity="0.3"/>
										<path d="M12,11 C10.8954305,11 10,10.1045695 10,9 C10,7.8954305 10.8954305,7 12,7 C13.1045695,7 14,7.8954305 14,9 C14,10.1045695 13.1045695,11 12,11 Z" fill="#000000" opacity="0.3"/>
										<path d="M7.00036205,16.4995035 C7.21569918,13.5165724 9.36772908,12 11.9907452,12 C14.6506758,12 16.8360465,13.4332455 16.9988413,16.5 C17.0053266,16.6221713 16.9988413,17 16.5815,17 C14.5228466,17 11.463736,17 7.4041679,17 C7.26484009,17 6.98863236,16.6619875 7.00036205,16.4995035 Z" fill="#000000" opacity="0.3"/>
									</g>
								</svg><!--end::Svg Icon--></span>
								<!--end::Svg Icon-->
							</span>
							<div>
								<a href="{{ url('admin/user/partner')}}" class="text-inverse-success font-weight-bolder font-size-h4 mt-3">Partners</a>
							</div>
						</div>
					</div>
					<!--end::Tiles Widget 11-->
				</div>
				@endif

				@php
					$blocked_roles = ['clientadmin', 'clientdeveloper', 'clientmanager', 'clientmoderator'];					
				@endphp
				
				@if(!in_array(Auth::user()->role, $blocked_roles))
				<div class='col-6 col-md-3'>
					<!--begin::Tiles Widget 11-->
					<div class="card card-custom bg-primary gutter-b" style="max-height: 150px;">
						<div class="card-body">
							<span class="svg-icon svg-icon-3x svg-icon-white ml-n2">

								<span class="svg-icon svg-icon-light svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-02-01-052524/theme/html/demo1/dist/../src/media/svg/icons/Design/Interselect.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
									<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
										<rect x="0" y="0" width="24" height="24"/>
										<path d="M6,9 L6,15 C6,16.6568542 7.34314575,18 9,18 L15,18 L15,18.8181818 C15,20.2324881 14.2324881,21 12.8181818,21 L5.18181818,21 C3.76751186,21 3,20.2324881 3,18.8181818 L3,11.1818182 C3,9.76751186 3.76751186,9 5.18181818,9 L6,9 Z M17,16 L17,10 C17,8.34314575 15.6568542,7 14,7 L8,7 L8,6.18181818 C8,4.76751186 8.76751186,4 10.1818182,4 L17.8181818,4 C19.2324881,4 20,4.76751186 20,6.18181818 L20,13.8181818 C20,15.2324881 19.2324881,16 17.8181818,16 L17,16 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
										<path d="M9.27272727,9 L13.7272727,9 C14.5522847,9 15,9.44771525 15,10.2727273 L15,14.7272727 C15,15.5522847 14.5522847,16 13.7272727,16 L9.27272727,16 C8.44771525,16 8,15.5522847 8,14.7272727 L8,10.2727273 C8,9.44771525 8.44771525,9 9.27272727,9 Z" fill="#000000"/>
									</g>
								</svg><!--end::Svg Icon--></span>
							</span>
							<div>
								<a href="{{ url('admin/client')}}" class="text-inverse-success font-weight-bolder font-size-h4 mt-3">Clients</a>
							</div>
						</div>
					</div>
					<!--end::Tiles Widget 11-->
				</div>
				@endif

				<div class='col-6 col-md-3'>
					<!--begin::Tiles Widget 11-->
					<div class="card card-custom bg-info gutter-b" style="max-height: 150px;">
						<div class="card-body">
							<span class="svg-icon svg-icon-3x svg-icon-white ml-n2">
								<span class="svg-icon svg-icon-white svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-02-01-052524/theme/html/demo1/dist/../src/media/svg/icons/Communication/Add-user.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
									<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
										<polygon points="0 0 24 0 24 24 0 24"/>
										<path d="M18,8 L16,8 C15.4477153,8 15,7.55228475 15,7 C15,6.44771525 15.4477153,6 16,6 L18,6 L18,4 C18,3.44771525 18.4477153,3 19,3 C19.5522847,3 20,3.44771525 20,4 L20,6 L22,6 C22.5522847,6 23,6.44771525 23,7 C23,7.55228475 22.5522847,8 22,8 L20,8 L20,10 C20,10.5522847 19.5522847,11 19,11 C18.4477153,11 18,10.5522847 18,10 L18,8 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
										<path d="M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
									</g>
								</svg><!--end::Svg Icon--></span>
							</span>
							<div>
								<a href="{{ url('admin/user')}}" class="text-inverse-success font-weight-bolder font-size-h4 mt-3">Users</a>
							</div>
						</div>
					</div>
					<!--end::Tiles Widget 11-->
				</div>

				

				<div class='col-6 col-md-3'>
					<!--begin::Tiles Widget 11-->
					<div class="card card-custom  gutter-b" style="max-height: 150px;background:#3f51b5">
						<div class="card-body">
							<span class="svg-icon svg-icon-3x svg-icon-white ml-n2">
								<span class="svg-icon svg-icon-white svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-02-01-052524/theme/html/demo1/dist/../src/media/svg/icons/Media/Equalizer.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
									<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
										<rect x="0" y="0" width="24" height="24"/>
										<rect fill="#000000" opacity="0.3" x="13" y="4" width="3" height="16" rx="1.5"/>
										<rect fill="#000000" x="8" y="9" width="3" height="11" rx="1.5"/>
										<rect fill="#000000" x="18" y="11" width="3" height="9" rx="1.5"/>
										<rect fill="#000000" x="3" y="13" width="3" height="7" rx="1.5"/>
									</g>
								</svg><!--end::Svg Icon--></span> 
							</span>
							<div>
								<a href="{{ url('admin/user/statistics')}}" class="text-inverse-success font-weight-bolder font-size-h4 mt-3">Statistics</a>
							</div>
						</div>
					</div>
					<!--end::Tiles Widget 11-->
				</div>

				<div class='col-6 col-md-3'>
					<!--begin::Tiles Widget 11-->
					<div class="card card-custom bg-danger gutter-b" style="max-height: 150px;">
						<div class="card-body">
							<span class="svg-icon svg-icon-3x svg-icon-white ml-n2">
								<!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
								<span class="svg-icon svg-icon-light svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-02-01-052524/theme/html/demo1/dist/../src/media/svg/icons/General/Settings-2.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
									<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
										<rect x="0" y="0" width="24" height="24"/>
										<path d="M5,8.6862915 L5,5 L8.6862915,5 L11.5857864,2.10050506 L14.4852814,5 L19,5 L19,9.51471863 L21.4852814,12 L19,14.4852814 L19,19 L14.4852814,19 L11.5857864,21.8994949 L8.6862915,19 L5,19 L5,15.3137085 L1.6862915,12 L5,8.6862915 Z M12,15 C13.6568542,15 15,13.6568542 15,12 C15,10.3431458 13.6568542,9 12,9 C10.3431458,9 9,10.3431458 9,12 C9,13.6568542 10.3431458,15 12,15 Z" fill="#000000"/>
									</g>
								</svg><!--end::Svg Icon--></span>
								<!--end::Svg Icon-->
							</span>
							<div>
								<a href="{{ url('admin/settings')}}" class="text-inverse-success font-weight-bolder font-size-h4 mt-3">Settings</a>
							</div>
						</div>
					</div>
					<!--end::Tiles Widget 11-->
				</div>

				<div class='col-6 col-md-3'>
						<!--begin::Tiles Widget 11-->
						<div class="card card-custom   gutter-b" style="max-height: 150px;background:#ff5500;">
							<div class="card-body">
								<span class="svg-icon svg-icon-3x svg-icon-white ml-n2">
									<span class="svg-icon svg-icon-white svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-02-01-052524/theme/html/demo1/dist/../src/media/svg/icons/Layout/Layout-top-panel-3.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
										<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											<rect x="0" y="0" width="24" height="24"/>
											<path d="M3,4 L20,4 C20.5522847,4 21,4.44771525 21,5 L21,7 C21,7.55228475 20.5522847,8 20,8 L3,8 C2.44771525,8 2,7.55228475 2,7 L2,5 C2,4.44771525 2.44771525,4 3,4 Z M3,10 L13,10 C13.5522847,10 14,10.4477153 14,11 L14,19 C14,19.5522847 13.5522847,20 13,20 L3,20 C2.44771525,20 2,19.5522847 2,19 L2,11 C2,10.4477153 2.44771525,10 3,10 Z" fill="#000000"/>
											<rect fill="#000000" opacity="0.3" x="16" y="10" width="5" height="10" rx="1"/>
										</g>
									</svg><!--end::Svg Icon--></span>
								</span>
								<div>
									<a href="{{ url('admin/theme')}}" class="text-inverse-success font-weight-bolder font-size-h4 mt-3">Webpages</a>
								</div>
							</div>
						</div>
						<!--end::Tiles Widget 11-->
					</div>

			</div>

			
				<div class="row">

					
					<div class='col-6 col-md-3'>
						<!--begin::Tiles Widget 11-->
						<div class="card card-custom  gutter-b" style="max-height: 150px;background:#4bc350;">
							<div class="card-body">
								<span class="svg-icon svg-icon-3x svg-icon-white ml-n2">
									<span class="svg-icon svg-icon-white svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-02-01-052524/theme/html/demo1/dist/../src/media/svg/icons/Communication/Write.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
										<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											<rect x="0" y="0" width="24" height="24"/>
											<path d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953) "/>
											<path d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
										</g>
									</svg><!--end::Svg Icon--></span>
								</span>
								<div>
									<a href="{{ url('/admin/blog')}}" class="text-inverse-success font-weight-bolder font-size-h4 mt-3">Blog</a>
								</div>
							</div>
						</div>
						<!--end::Tiles Widget 11-->
					</div>
					@if(Auth::user()->role == 'superadmin')
					<div class='col-6 col-md-3'>
						<!--begin::Tiles Widget 11-->
						<div class="card card-custom bg-success gutter-b" style="max-height: 150px;">
							<div class="card-body">
								<span class="svg-icon svg-icon-3x svg-icon-white ml-n2">
									<!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
									<span class="svg-icon svg-icon-white svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-02-01-052524/theme/html/demo1/dist/../src/media/svg/icons/Home/Flower2.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
										<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											<polygon points="0 0 24 0 24 24 0 24"/>
											<circle fill="#000000" opacity="0.3" cx="15" cy="17" r="5"/>
											<circle fill="#000000" opacity="0.3" cx="9" cy="17" r="5"/>
											<circle fill="#000000" opacity="0.3" cx="7" cy="11" r="5"/>
											<circle fill="#000000" opacity="0.3" cx="17" cy="11" r="5"/>
											<circle fill="#000000" opacity="0.3" cx="12" cy="7" r="5"/>
										</g>
									</svg><!--end::Svg Icon--></span>
									<!--end::Svg Icon-->
								</span>
								<div>
									<a href="{{ url('admin/loyalty')}}" class="text-inverse-success font-weight-bolder font-size-h4 mt-3">Loyalty</a>
								</div>
							</div>
						</div>
						<!--end::Tiles Widget 11-->
					</div>

					<div class='col-6 col-md-3'>
						<!--begin::Tiles Widget 11-->
						<div class="card card-custom bg-dark gutter-b" style="max-height: 150px;">
							<div class="card-body">
								<span class="svg-icon svg-icon-white svg-icon-3x svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Communication/Mail-opened.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
									<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
										<rect x="0" y="0" width="24" height="24"/>
										<path d="M6,2 L18,2 C18.5522847,2 19,2.44771525 19,3 L19,12 C19,12.5522847 18.5522847,13 18,13 L6,13 C5.44771525,13 5,12.5522847 5,12 L5,3 C5,2.44771525 5.44771525,2 6,2 Z M7.5,5 C7.22385763,5 7,5.22385763 7,5.5 C7,5.77614237 7.22385763,6 7.5,6 L13.5,6 C13.7761424,6 14,5.77614237 14,5.5 C14,5.22385763 13.7761424,5 13.5,5 L7.5,5 Z M7.5,7 C7.22385763,7 7,7.22385763 7,7.5 C7,7.77614237 7.22385763,8 7.5,8 L10.5,8 C10.7761424,8 11,7.77614237 11,7.5 C11,7.22385763 10.7761424,7 10.5,7 L7.5,7 Z" fill="#000000" opacity="0.3"/>
										<path d="M3.79274528,6.57253826 L12,12.5 L20.2072547,6.57253826 C20.4311176,6.4108595 20.7436609,6.46126971 20.9053396,6.68513259 C20.9668779,6.77033951 21,6.87277228 21,6.97787787 L21,17 C21,18.1045695 20.1045695,19 19,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,6.97787787 C3,6.70173549 3.22385763,6.47787787 3.5,6.47787787 C3.60510559,6.47787787 3.70753836,6.51099993 3.79274528,6.57253826 Z" fill="#000000"/>
									</g>
								</svg><!--end::Svg Icon--></span>
								<div>
									<a href="{{ url('admin/mailcampaigns') }}" class="text-inverse-success font-weight-bolder font-size-h4 mt-3">Mailer</a>
								</div>
							</div>
						</div>
						<!--end::Tiles Widget 11-->
					</div>


					@endif

					<div class='col-6 col-md-3'>
						<!--begin::Tiles Widget 11-->
						<div class="card card-custom bg-warning gutter-b" style="max-height: 150px;">
							<div class="card-body">
								<span class="svg-icon svg-icon-3x svg-icon-white ml-n2">
									<span class="svg-icon svg-icon-white svg-icon-2x"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Communication\Sending mail.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <path d="M4,16 L5,16 C5.55228475,16 6,16.4477153 6,17 C6,17.5522847 5.55228475,18 5,18 L4,18 C3.44771525,18 3,17.5522847 3,17 C3,16.4477153 3.44771525,16 4,16 Z M1,11 L5,11 C5.55228475,11 6,11.4477153 6,12 C6,12.5522847 5.55228475,13 5,13 L1,13 C0.44771525,13 6.76353751e-17,12.5522847 0,12 C-6.76353751e-17,11.4477153 0.44771525,11 1,11 Z M3,6 L5,6 C5.55228475,6 6,6.44771525 6,7 C6,7.55228475 5.55228475,8 5,8 L3,8 C2.44771525,8 2,7.55228475 2,7 C2,6.44771525 2.44771525,6 3,6 Z" fill="#000000" opacity="0.3"/>
        <path d="M10,6 L22,6 C23.1045695,6 24,6.8954305 24,8 L24,16 C24,17.1045695 23.1045695,18 22,18 L10,18 C8.8954305,18 8,17.1045695 8,16 L8,8 C8,6.8954305 8.8954305,6 10,6 Z M21.0849395,8.0718316 L16,10.7185839 L10.9150605,8.0718316 C10.6132433,7.91473331 10.2368262,8.02389331 10.0743092,8.31564728 C9.91179228,8.60740125 10.0247174,8.9712679 10.3265346,9.12836619 L15.705737,11.9282847 C15.8894428,12.0239051 16.1105572,12.0239051 16.294263,11.9282847 L21.6734654,9.12836619 C21.9752826,8.9712679 22.0882077,8.60740125 21.9256908,8.31564728 C21.7631738,8.02389331 21.3867567,7.91473331 21.0849395,8.0718316 Z" fill="#000000"/>
    </g>
</svg><!--end::Svg Icon--></span>
								</span>
								<div>
									<a href="{{ url('admin/contact')}}" class="text-inverse-success font-weight-bolder font-size-h4 mt-3">Contact Form</a>
								</div>
							</div>
						</div>
						<!--end::Tiles Widget 11-->
					</div>
					<div class='col-6 col-md-3 '>
					<!--begin::Tiles Widget 11-->
					<div class="card card-custom  gutter-b" style="max-height: 150px;background:#4b9c77">
						<div class="card-body">
							<span class="svg-icon svg-icon-3x svg-icon-white ml-n2">
								<span class="svg-icon svg-icon-white svg-icon-2x"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Communication\Outgoing-call.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <path d="M7.14296018,11.6653622 C7.06267828,11.7456441 6.95746388,11.7962128 6.84462255,11.8087507 C6.57016914,11.8392455 6.32295974,11.641478 6.29246492,11.3670246 L5.76926113,6.65819047 C5.76518362,6.62149288 5.76518362,6.58445654 5.76926113,6.54775895 C5.79975595,6.27330553 6.04696535,6.07553802 6.32141876,6.10603284 L11.0302529,6.62923663 C11.1430942,6.64177456 11.2483086,6.69234321 11.3285905,6.77262511 C11.5238526,6.96788726 11.5238526,7.28446974 11.3285905,7.47973189 L9.94288211,8.86544026 L11.4443443,10.3669024 C11.6396064,10.5621646 11.6396064,10.8787471 11.4443443,11.0740092 L10.7372375,11.781116 C10.5419754,11.9763782 10.2253929,11.9763782 10.0301307,11.781116 L8.52866855,10.2796538 L7.14296018,11.6653622 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
        <path d="M12.0799676,14.7839934 L14.2839934,12.5799676 C14.8927139,11.9712471 15.0436229,11.0413042 14.6586342,10.2713269 L14.5337539,10.0215663 C14.1487653,9.25158901 14.2996742,8.3216461 14.9083948,7.71292558 L17.6411989,4.98012149 C17.836461,4.78485934 18.1530435,4.78485934 18.3483056,4.98012149 C18.3863063,5.01812215 18.4179321,5.06200062 18.4419658,5.11006808 L19.5459415,7.31801948 C20.3904962,9.0071287 20.0594452,11.0471565 18.7240871,12.3825146 L12.7252616,18.3813401 C11.2717221,19.8348796 9.12170075,20.3424308 7.17157288,19.6923882 L4.75709327,18.8875616 C4.49512161,18.8002377 4.35354162,18.5170777 4.4408655,18.2551061 C4.46541191,18.1814669 4.50676633,18.114554 4.56165376,18.0596666 L7.21292558,15.4083948 C7.8216461,14.7996742 8.75158901,14.6487653 9.52156634,15.0337539 L9.77132688,15.1586342 C10.5413042,15.5436229 11.4712471,15.3927139 12.0799676,14.7839934 Z" fill="#000000"/>
    </g>
</svg><!--end::Svg Icon--></span>
							</span>
							<div>
								<a href="{{ url('admin/call')}}" class="text-inverse-success font-weight-bolder font-size-h4 mt-3">Telecallers</a>
							</div>
						</div>
					</div>
					<!--end::Tiles Widget 11-->
				</div>


				<div class='col-6 col-md-3 '>
					<!--begin::Tiles Widget 11-->
					<div class="card card-custom  bg-success gutter-b" style="max-height: 150px;background:#4b9c77">
						<div class="card-body">
							<span class="svg-icon svg-icon-3x svg-icon-white ml-n2">
								<span class="svg-icon svg-icon-white svg-icon-2x"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Communication\Outgoing-call.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <path d="M7.14296018,11.6653622 C7.06267828,11.7456441 6.95746388,11.7962128 6.84462255,11.8087507 C6.57016914,11.8392455 6.32295974,11.641478 6.29246492,11.3670246 L5.76926113,6.65819047 C5.76518362,6.62149288 5.76518362,6.58445654 5.76926113,6.54775895 C5.79975595,6.27330553 6.04696535,6.07553802 6.32141876,6.10603284 L11.0302529,6.62923663 C11.1430942,6.64177456 11.2483086,6.69234321 11.3285905,6.77262511 C11.5238526,6.96788726 11.5238526,7.28446974 11.3285905,7.47973189 L9.94288211,8.86544026 L11.4443443,10.3669024 C11.6396064,10.5621646 11.6396064,10.8787471 11.4443443,11.0740092 L10.7372375,11.781116 C10.5419754,11.9763782 10.2253929,11.9763782 10.0301307,11.781116 L8.52866855,10.2796538 L7.14296018,11.6653622 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
        <path d="M12.0799676,14.7839934 L14.2839934,12.5799676 C14.8927139,11.9712471 15.0436229,11.0413042 14.6586342,10.2713269 L14.5337539,10.0215663 C14.1487653,9.25158901 14.2996742,8.3216461 14.9083948,7.71292558 L17.6411989,4.98012149 C17.836461,4.78485934 18.1530435,4.78485934 18.3483056,4.98012149 C18.3863063,5.01812215 18.4179321,5.06200062 18.4419658,5.11006808 L19.5459415,7.31801948 C20.3904962,9.0071287 20.0594452,11.0471565 18.7240871,12.3825146 L12.7252616,18.3813401 C11.2717221,19.8348796 9.12170075,20.3424308 7.17157288,19.6923882 L4.75709327,18.8875616 C4.49512161,18.8002377 4.35354162,18.5170777 4.4408655,18.2551061 C4.46541191,18.1814669 4.50676633,18.114554 4.56165376,18.0596666 L7.21292558,15.4083948 C7.8216461,14.7996742 8.75158901,14.6487653 9.52156634,15.0337539 L9.77132688,15.1586342 C10.5413042,15.5436229 11.4712471,15.3927139 12.0799676,14.7839934 Z" fill="#000000"/>
    </g>
</svg><!--end::Svg Icon--></span>
							</span>
							<div>
								<a href="{{ url('admin/college')}}" class="text-inverse-success font-weight-bolder font-size-h4 mt-3">Colleges</a>
							</div>
						</div>
					</div>
					<!--end::Tiles Widget 11-->
				</div>

				<div class='col-6 col-md-3 '>
					<!--begin::Tiles Widget 11-->
					<div class="card card-custom  bg-dark gutter-b" style="max-height: 150px;background:#4b9c77">
						<div class="card-body">
							<span class="svg-icon svg-icon-3x svg-icon-white ml-n2">
								<span class="svg-icon svg-icon-white svg-icon-2x"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Communication\Outgoing-call.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <path d="M7.14296018,11.6653622 C7.06267828,11.7456441 6.95746388,11.7962128 6.84462255,11.8087507 C6.57016914,11.8392455 6.32295974,11.641478 6.29246492,11.3670246 L5.76926113,6.65819047 C5.76518362,6.62149288 5.76518362,6.58445654 5.76926113,6.54775895 C5.79975595,6.27330553 6.04696535,6.07553802 6.32141876,6.10603284 L11.0302529,6.62923663 C11.1430942,6.64177456 11.2483086,6.69234321 11.3285905,6.77262511 C11.5238526,6.96788726 11.5238526,7.28446974 11.3285905,7.47973189 L9.94288211,8.86544026 L11.4443443,10.3669024 C11.6396064,10.5621646 11.6396064,10.8787471 11.4443443,11.0740092 L10.7372375,11.781116 C10.5419754,11.9763782 10.2253929,11.9763782 10.0301307,11.781116 L8.52866855,10.2796538 L7.14296018,11.6653622 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
        <path d="M12.0799676,14.7839934 L14.2839934,12.5799676 C14.8927139,11.9712471 15.0436229,11.0413042 14.6586342,10.2713269 L14.5337539,10.0215663 C14.1487653,9.25158901 14.2996742,8.3216461 14.9083948,7.71292558 L17.6411989,4.98012149 C17.836461,4.78485934 18.1530435,4.78485934 18.3483056,4.98012149 C18.3863063,5.01812215 18.4179321,5.06200062 18.4419658,5.11006808 L19.5459415,7.31801948 C20.3904962,9.0071287 20.0594452,11.0471565 18.7240871,12.3825146 L12.7252616,18.3813401 C11.2717221,19.8348796 9.12170075,20.3424308 7.17157288,19.6923882 L4.75709327,18.8875616 C4.49512161,18.8002377 4.35354162,18.5170777 4.4408655,18.2551061 C4.46541191,18.1814669 4.50676633,18.114554 4.56165376,18.0596666 L7.21292558,15.4083948 C7.8216461,14.7996742 8.75158901,14.6487653 9.52156634,15.0337539 L9.77132688,15.1586342 C10.5413042,15.5436229 11.4712471,15.3927139 12.0799676,14.7839934 Z" fill="#000000"/>
    </g>
</svg><!--end::Svg Icon--></span>
							</span>
							<div>
								<a href="{{ url('admin/whatsapp')}}" class="text-inverse-success font-weight-bolder font-size-h4 mt-3">Whatsapp Tracker</a>
							</div>
						</div>
					</div>
					<!--end::Tiles Widget 11-->
				</div>



					
				</div>

			</div>
			
		</div>




	</x-dynamic-component>