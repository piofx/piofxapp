<x-dynamic-component :component="$app->componentName" class="mt-4" >
<!-- Validation Errors -->
<x-auth-validation-errors class="mb-4" :errors="$errors" />

  <!--begin::Alert-->
  @if($alert)
    <x-snippets.alerts.basic>{{$alert}}</x-snippets.alerts.basic>
  @endif
  <!--end::Alert-->
  
<!--begin::Signin-->
<div class="login-form login-signin">
    <!--begin::Form-->
    <form class="form" novalidate="novalidate" id="kt_login_signin_form" method="POST" action="{{ route('logged_in') }}">
 
        @csrf
            <!--begin::Title-->
            <div class="pb-13 pt-lg-0 pt-5">
            <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">Welcome to {{ request()->get('client.name') }}</h3>
            <span class="text-muted font-weight-bold font-size-h4">Great things happen here!</span>
            </div>
            <!--end::Title-->
            <!--begin::Form group-->
            <div class="form-group">
                <label class="font-size-h6 font-weight-bolder text-dark">Email</label>
                <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg" type="email" name="email" value="{{ old('email')}}" required autofocus autocomplete="off" />
            </div>
            <!--end::Form group-->
            <!--begin::Form group-->
            <div class="form-group">
                <div class="d-flex justify-content-between mt-n5  pt-5">
                    <label class="font-size-h6 font-weight-bolder text-dark pt-4">Password</label>
                    
                </div>
                <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg" type="password" name="password" autocomplete="off" />
                <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg" type="hidden" name="client_id" value="{{request()->get('client.id')}}" />
            </div>

            <!--end::Form group-->
            <!--begin::Action-->
            <div class="pb-lg-4 pb-5 d-flex align-items-center ">
                <div>
                <button type="submit" id="kt_login_signin_submit" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">Sign In</button>
                </div>
                <div class="pb-lg-0 pb-5 ml-3">
                 <a href="{{ route('register')}}"  class="text-muted font-size-h6 font-weight-bolder text-hover-primary pt-5">Sign up</a>                
                </div>
                </div>
            <!--end::Action-->
            <input type="hidden" name="curr_url" value="{{ url()->current() }}">
             
        </form>
     <!--end::Form-->
    </div>

        @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-muted font-size-h6 font-weight-bolder text-hover-primary pt-5" id="kt_login_forgot">Forgot Password ?</a>
                    @endif
                        <!--end::Signin-->
                        
                    @if ($phone_login)
                    <hr>
                    <a href="{{ route('login_phone') }}" class="text-muted font-size-h6 font-weight-bolder text-hover-primary pt-5" id="kt_login_forgot">Login via SMS OTP</a>
                    @endif
   

</x-dynamic-component>