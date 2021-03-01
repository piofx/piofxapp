
<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head>
		<meta charset="utf-8" />
		<title>{{ agency('meta_title') }}</title>
		<meta name="description" content="{{ agency('meta_description') }}" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		@include('components.themes.metronic4.blocks.styles')
		<link rel="shortcut icon" href="{{ agency('favicon_link') }}" />
	</head>
	<!--end::Head-->
	<!--begin::Body-->

	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled page-loading">
		<!--begin::Main-->
		
		@include('components.themes.metronic4.blocks.header_mobile')
		<div class="d-flex flex-column flex-root">
			<!--begin::Page-->
			<div class="d-flex flex-row flex-column-fluid page">
				
				<!--begin::Wrapper-->
				<div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">

					@include('components.themes.metronic4.blocks.header')

					@include('components.themes.metronic4.blocks.aside')
					
					<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<p class="p-0 p-md-3"></p>

						<!--begin::Container-->
							<div class="container">
								<p>{{ $slot }}</p>
							</div>
							<!--end::Container-->
						
					</div>
					<!--end::Content-->
					<!--begin::Footer-->
					@include('components.themes.metronic4.blocks.footer')
					<!--end::Footer-->
				</div>
				<!--end::Wrapper-->
			</div>
			<!--end::Page-->
		</div>
		<!--end::Main-->
	
		@include('components.themes.metronic4.blocks.scrolltop')
		@include('components.themes.metronic4.blocks.scripts')
	
	</body>
	<!--end::Body-->

</html>