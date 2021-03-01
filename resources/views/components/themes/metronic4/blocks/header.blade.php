<!--begin::Header-->
<div id="kt_header" class="header bg-white header-fixed">
	<!--begin::Container-->
	<div class="container-fluid d-flex align-items-stretch justify-content-between">
		<!--begin::Left-->
		<div class="d-flex align-items-stretch mr-2">
			<!--begin::Page Title-->
			<h3 class="d-none text-dark d-lg-flex align-items-center mr-10 mb-0">
				<a href="/">
					<img alt="Logo" src="{{ agency('logo') }}" class="logo-default max-h-30px" />
				</a>
			</h3>
			<!--end::Page Title-->
			<!--begin::Header Menu Wrapper-->
			<div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
				<!--begin::Header Menu-->
				<div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
					<!--begin::Header Nav-->
					<x-snippets.menu.adminmenu />
					<!--end::Header Nav-->
				</div>
				<!--end::Header Menu-->
			</div>
			<!--end::Header Menu Wrapper-->
		</div>
		<!--end::Left-->

	</div>
	<!--end::Container-->
</div>
<!--end::Header-->