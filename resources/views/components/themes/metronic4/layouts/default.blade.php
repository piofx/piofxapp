
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
	<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled page-loading">
        <!--begin::Main-->
        <div class="d-flex flex-column flex-root">
            <!--begin::Login-->
            <div class="login login-4 login-signin-on d-flex flex-row-fluid" id="kt_login">
                <div class="d-flex flex-center flex-row-fluid bgi-size-cover bgi-position-top bgi-no-repeat" style="background-image: url('{{ asset('themes/metronic4/media/bg/bg-3.jpg')}}');">
                    <div class="login-form text-center p-7 position-relative overflow-hidden">
                        <!--begin::Login Header-->
                        <div class="d-flex flex-center mb-15">
                            <a href="#">
                                <img src="{{ agency('logo')}}" class="max-h-75px" alt="" />
                            </a>
                        </div>
                        <!--end::Login Header-->
                        <!--begin::Login Sign in form-->
                        <div class="login-signin">
                            <div class="mb-5">
                                <h3 class="display-1">Hello!</h3>
                                <div class="badge badge-success font-weight-bold">Site is active</div>
                            </div>
                          <div style="max-width: 300px">Piofxapp is a multidomain cloud webapp service. It is a developer friendly framework developed using Laravel with an absolute focus on speed, modularity, extensibility and maintainability.</div>
                            <div class="mt-10">
                                <a href="/login"  class="text-success text-hover-primary font-weight-bold">Login</a> &nbsp;
                                <a href="/register"  class="text-muted text-hover-primary font-weight-bold">Sign Up!</a>
                            </div>
                        </div>
                        <!--end::Login Sign in form-->
                       
                      
                    </div>
                </div>
            </div>
            <!--end::Login-->
        </div>
        <!--end::Main-->
		
		
		@include('components.themes.metronic4.blocks.scrolltop')
		@include('components.themes.metronic4.blocks.scripts')
	</body>
	<!--end::Body-->
</html>