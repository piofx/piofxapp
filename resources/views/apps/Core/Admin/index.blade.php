<x-dynamic-component :component="$componentName" class="mt-4" >
	

	<div class="row">
		<div class="col-12 col-md-8">

			<h4 class="mb-6"><span class="svg-icon svg-icon-dark svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-02-01-052524/theme/html/demo1/dist/../src/media/svg/icons/Design/Mask.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
				<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
					<rect x="0" y="0" width="24" height="24"/>
					<path d="M7.67514486,18.731359 C9.6803634,17.3851601 11,15.0966889 11,12.5 C11,9.58867922 9.34119765,7.06479249 6.91718054,5.82192739 C8.29918974,4.68360845 10.0697622,4 12,4 C16.418278,4 20,7.581722 20,12 C20,16.418278 16.418278,20 12,20 C10.4066753,20 8.92214267,19.5342055 7.67514486,18.731359 Z" fill="#000000" opacity="0.3"/>
					<path d="M6.39268296,17.7059641 C4.91588435,16.254539 4,14.2342276 4,12 C4,10.0680854 4.68479668,8.29611365 5.82489501,6.91357974 C7.72637261,8.04773008 9,10.1251292 9,12.5 C9,14.6298467 7.97562469,16.5204376 6.39268296,17.7059641 Z" fill="#000000"/>
				</g>
			</svg><!--end::Svg Icon--></span> Core Modules</h4>
			<div class="row">




				@if(Auth::user()->role=='superadmin')
				<div class='col-6 col-md-4'>
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

				<div class='col-6 col-md-4'>
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
				
				
				<div class='col-6 col-md-4'>
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

				<div class='col-6 col-md-4'>
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

				
				<div class='col-6 col-md-4 d-none'>
					<!--begin::Tiles Widget 11-->
					<div class="card card-custom  gutter-b" style="max-height: 150px;background:#4b9c77">
						<div class="card-body">
							<span class="svg-icon svg-icon-3x svg-icon-white ml-n2">
								<span class="svg-icon svg-icon-white svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-02-01-052524/theme/html/demo1/dist/../src/media/svg/icons/Shopping/Wallet.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
									<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
										<rect x="0" y="0" width="24" height="24"/>
										<circle fill="#000000" opacity="0.3" cx="20.5" cy="12.5" r="1.5"/>
										<rect fill="#000000" opacity="0.3" transform="translate(12.000000, 6.500000) rotate(-15.000000) translate(-12.000000, -6.500000) " x="3" y="3" width="18" height="7" rx="1"/>
										<path d="M22,9.33681558 C21.5453723,9.12084552 21.0367986,9 20.5,9 C18.5670034,9 17,10.5670034 17,12.5 C17,14.4329966 18.5670034,16 20.5,16 C21.0367986,16 21.5453723,15.8791545 22,15.6631844 L22,18 C22,19.1045695 21.1045695,20 20,20 L4,20 C2.8954305,20 2,19.1045695 2,18 L2,6 C2,4.8954305 2.8954305,4 4,4 L20,4 C21.1045695,4 22,4.8954305 22,6 L22,9.33681558 Z" fill="#000000"/>
									</g>
								</svg><!--end::Svg Icon--></span> 
							</span>
							<div>
								<a href="{{ url('admin/billing')}}" class="text-inverse-success font-weight-bolder font-size-h4 mt-3">Billing</a>
							</div>
						</div>
					</div>
					<!--end::Tiles Widget 11-->
				</div>

				<div class='col-6 col-md-4'>
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
								<a href="{{ url('admin/statistics')}}" class="text-inverse-success font-weight-bolder font-size-h4 mt-3">Statistics</a>
							</div>
						</div>
					</div>
					<!--end::Tiles Widget 11-->
				</div>

				<div class='col-6 col-md-4'>
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



			</div>

			<h4 class="mb-6">

				<span class="svg-icon svg-icon-dark svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-02-01-052524/theme/html/demo1/dist/../src/media/svg/icons/Design/Color-profile.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
					<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
						<rect x="0" y="0" width="24" height="24"/>
						<path d="M12,10.9996338 C12.8356605,10.3719448 13.8743941,10 15,10 C17.7614237,10 20,12.2385763 20,15 C20,17.7614237 17.7614237,20 15,20 C13.8743941,20 12.8356605,19.6280552 12,19.0003662 C11.1643395,19.6280552 10.1256059,20 9,20 C6.23857625,20 4,17.7614237 4,15 C4,12.2385763 6.23857625,10 9,10 C10.1256059,10 11.1643395,10.3719448 12,10.9996338 Z M13.3336047,12.504354 C13.757474,13.2388026 14,14.0910788 14,15 C14,15.9088933 13.7574889,16.761145 13.3336438,17.4955783 C13.8188886,17.8206693 14.3938466,18 15,18 C16.6568542,18 18,16.6568542 18,15 C18,13.3431458 16.6568542,12 15,12 C14.3930587,12 13.8175971,12.18044 13.3336047,12.504354 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
						<circle fill="#000000" cx="12" cy="9" r="5"/>
					</g>
				</svg><!--end::Svg Icon--></span> Applications</h4>
				<div class="row">

					<div class='col-6 col-md-4'>
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
									<a href="{{ url('admin/theme')}}" class="text-inverse-success font-weight-bolder font-size-h4 mt-3">Theme</a>
								</div>
							</div>
						</div>
						<!--end::Tiles Widget 11-->
					</div>
					<div class='col-6 col-md-4'>
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

					<div class='col-6 col-md-4'>
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

					<div class='col-6 col-md-4'>
						<!--begin::Tiles Widget 11-->
						<div class="card card-custom bg-warning gutter-b" style="max-height: 150px;">
							<div class="card-body">
								<span class="svg-icon svg-icon-3x svg-icon-white ml-n2">
									<span class="svg-icon svg-icon-white svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-02-01-052524/theme/html/demo1/dist/../src/media/svg/icons/Communication/Chat5.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
										<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											<rect x="0" y="0" width="24" height="24"/>
											<path d="M21.9999843,15.009808 L22.0249378,15 L22.0249378,19.5857864 C22.0249378,20.1380712 21.5772226,20.5857864 21.0249378,20.5857864 C20.7597213,20.5857864 20.5053674,20.4804296 20.317831,20.2928932 L18.0249378,18 L6,18 C4.34314575,18 3,16.6568542 3,15 L3,6 C3,4.34314575 4.34314575,3 6,3 L19,3 C20.6568542,3 22,4.34314575 22,6 L22,15 C22,15.0032706 21.9999948,15.0065399 21.9999843,15.009808 Z" fill="#000000" opacity="0.3"/>
											<path d="M7.5,12 C6.67157288,12 6,11.3284271 6,10.5 C6,9.67157288 6.67157288,9 7.5,9 C8.32842712,9 9,9.67157288 9,10.5 C9,11.3284271 8.32842712,12 7.5,12 Z M12.5,12 C11.6715729,12 11,11.3284271 11,10.5 C11,9.67157288 11.6715729,9 12.5,9 C13.3284271,9 14,9.67157288 14,10.5 C14,11.3284271 13.3284271,12 12.5,12 Z M17.5,12 C16.6715729,12 16,11.3284271 16,10.5 C16,9.67157288 16.6715729,9 17.5,9 C18.3284271,9 19,9.67157288 19,10.5 C19,11.3284271 18.3284271,12 17.5,12 Z" fill="#000000" opacity="0.3"/>
										</g>
									</svg><!--end::Svg Icon--></span>
								</span>
								<div>
									<a href="{{ url('admin/contact')}}" class="text-inverse-success font-weight-bolder font-size-h4 mt-3">Contact</a>
								</div>
							</div>
						</div>
						<!--end::Tiles Widget 11-->
					</div>
				


				</div>

			</div>
			<div class="col-12 col-md-4">
				<h4 class="mb-6"><span class="svg-icon svg-icon-dark svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-02-01-052524/theme/html/demo1/dist/../src/media/svg/icons/Media/Equalizer.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
					<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
						<rect x="0" y="0" width="24" height="24"/>
						<rect fill="#000000" opacity="0.3" x="13" y="4" width="3" height="16" rx="1.5"/>
						<rect fill="#000000" x="8" y="9" width="3" height="11" rx="1.5"/>
						<rect fill="#000000" x="18" y="11" width="3" height="9" rx="1.5"/>
						<rect fill="#000000" x="3" y="13" width="3" height="7" rx="1.5"/>
					</g>
				</svg><!--end::Svg Icon--></span> Statistics</h4>
				<div class="row">



					<div class="col-12">
						<!--begin::Tiles Widget 5-->
						<div class="card card-custom bg-info gutter-b" style="height: 150px">
							<!--begin::Body-->
							<div class="card-body d-flex flex-column p-0">
								<!--begin::Stats-->
								<div class="flex-grow-1 card-spacer-x pt-6">
									<div class="text-inverse-info font-weight-bold">Visitors <small class='text-light-info'>this week</small></div>
									<div class="text-inverse-info font-weight-bolder font-size-h3">2,005</div>
								</div>
								<!--end::Stats-->
								<!--begin::Chart-->
								<div id="kt_tiles_widget_5_chart" class="card-rounded-bottom" style="height: 50px"></div>
								<!--end::Chart-->
							</div>
							<!--end::Body-->
						</div>
						<!--end::Tiles Widget 5-->
					</div>	



					<div class="col-12">
						<h4 class="mb-6"><span class="svg-icon svg-icon-dark svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-02-01-052524/theme/html/demo1/dist/../src/media/svg/icons/Shopping/Wallet.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
							<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								<rect x="0" y="0" width="24" height="24"/>
								<circle fill="#000000" opacity="0.3" cx="20.5" cy="12.5" r="1.5"/>
								<rect fill="#000000" opacity="0.3" transform="translate(12.000000, 6.500000) rotate(-15.000000) translate(-12.000000, -6.500000) " x="3" y="3" width="18" height="7" rx="1"/>
								<path d="M22,9.33681558 C21.5453723,9.12084552 21.0367986,9 20.5,9 C18.5670034,9 17,10.5670034 17,12.5 C17,14.4329966 18.5670034,16 20.5,16 C21.0367986,16 21.5453723,15.8791545 22,15.6631844 L22,18 C22,19.1045695 21.1045695,20 20,20 L4,20 C2.8954305,20 2,19.1045695 2,18 L2,6 C2,4.8954305 2.8954305,4 4,4 L20,4 C21.1045695,4 22,4.8954305 22,6 L22,9.33681558 Z" fill="#000000"/>
							</g>
						</svg><!--end::Svg Icon--></span>  Transactions</h4>
						<!--begin::Tiles Widget 4-->
						<div class="card card-custom gutter-b" style="height: 130px">
							<!--begin::Body-->
							<div class="card-body d-flex flex-column">
								<!--begin::Stats-->
								<div class="flex-grow-1">
									<div class="text-dark-50 font-weight-bold">Credit Balance </div>
									<div class="font-weight-bolder font-size-h3"><i class="fas fa fa-rupee-sign"></i>4,900</div>
								</div>
								<!--end::Stats-->
								<!--begin::Progress-->
								<div class="progress progress-xs">
									<div class="progress-bar bg-success" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
								<!--end::Progress-->
							</div>
							<!--end::Body-->
						</div>
						<!--end::Tiles Widget 4-->
					</div>
				</div>

			</div>
		</div>




	</x-dynamic-component>