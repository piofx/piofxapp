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
    <form class="form" novalidate="novalidate" id="kt_login_signin_form" method="POST" action="{{ route('logged_in') }}" data-otp="1">
 
        @csrf
            <!--begin::Title-->
            <div class="pb-13 pt-lg-0 pt-5">
            <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">Welcome to {{ request()->get('client.name') }}</h3>
            <span class="text-muted font-weight-bold font-size-h4">Login via OTP</span>
            </div>
            <!--end::Title-->
            <!--begin::Form group-->
            <div class="form-group">
                <label class="font-size-h6 font-weight-bolder text-dark">Phone Number</label>
                <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg" type="phone" name="phone" value="{{ old('phone')}}" required autofocus autocomplete="off" />
            </div>
             <div class="form-group">
                <button class="btn btn-outline-dark generate_phone_otp" type="button">Generate OTP</button>
             </div>

            <!--end::Form group-->
            <!--begin::Form group-->
            <div class="form-group">
                <div class="d-flex justify-content-between mt-n5  pt-5">
                    <label class="font-size-h6 font-weight-bolder text-dark pt-4">Enter OTP</label>
                    
                </div>
                <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg" type="text" name="otp" autocomplete="off" />
                <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg" type="hidden" name="client_id" value="{{request()->get('client.id')}}" />
            </div>

            <!--end::Form group-->
            <!--begin::Action-->
            <div class="pb-lg-4 pb-5 d-flex align-items-center ">
                <div>
                <button type="submit" id="kt_login_signin_submit" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3" data-code="{{$code}}" >Login </button>
                </div>
                
                </div>
            <!--end::Action-->
            <input type="hidden" name="curr_url" value="{{ url()->current() }}">
             
        </form>
     <!--end::Form-->
    </div>

                    <a href="{{ route('login') }}" class="text-muted font-size-h6 font-weight-bolder text-hover-primary pt-5" id="kt_login_forgot"><i class="fa fa-angle-double-left"></i> Login via email</a>
                 
                        <!--end::Signin-->
   

</x-dynamic-component>