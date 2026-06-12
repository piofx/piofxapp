<!-- Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel">Register</h3>
        <hr>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body pt-0 px-3">
        <div class="alert alert-warning alert-dismissible fade show alert_block" style="display: none" role="alert">
          <div class="alert_message"></div>
          
        </div>
        <form class="mt-3 registerform" action="{{ route('User.apiregister') }}" data-register="1" >
          <div class="register_block">
            <div class="form-group mb-3">
                <input type="text" class="form-control name" id="exampleInputName" name="name"  placeholder="Enter your fullname">
                <span class="name_error error text-danger" style="display: none;"><small>Name cannot be empty</small></span>
              </div>
              <div class="form-group mb-3">
                <input type="email" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp" placeholder="Enter your email address">
                <span class="name_error error text-danger" style="display: none;"><small>Email cannot be empty</small></span>
              </div>
              <div class="form-group mb-3">
                <div class="">
                  
                  <input id="phone" class="form-control form-control-solid h-auto rounded-lg" type="phone" name="phone" value="{{ old('phone') }}" placeholder="Phone number" required autofocus autocomplete="off" />
                  <button type="button" class="btn btn-success btn-sm mt-3 register_otp" style="cursor: pointer;">Register</button>
                  <div class="spinner-border spinner-border-sm ml-2 mt-1 otp_spinner" role="status" style="display: none;">
                    <span class="sr-only">Loading...</span>
                  </div><br>
                </div>
              </div>

              @if(client('phone_otp_login'))Already have a account? 
              <a href="/login_phone?redirect={{url()->full()}}" class="my-2 ">Login via SMS OTP</a> or <a href="{{ route('password.request') }}" class=" text-hover-primary pt-5" id="kt_login_forgot">Forgot Password ?</a>       
              @endif
            </div>

            <div class="otp_block" style="display: none;">
              <div class="form-group mb-3 ">
                 <div class="bg-light rounded p-3 border">
                
                  <input id="otp" class="form-control form-control-solid h-auto  rounded-lg" type="text" name="otp" value="{{ old('otp') }}" placeholder="Enter OTP "  autocomplete="off" />
                  <button type="button" class="btn btn-outline-dark btn-sm mt-3 register v_otp" data-otp="{{request()->session()->get('code')}}">Validate OTP 
                  </button><span class="text-dark ml-3 otp_success" style="display: none;"><i class="fa fa-check-circle text-dark"></i> Success</span>
                </div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="agency_id" value="{{ request()->get('agency.id') }}">
                <input type="hidden" name="client_id" value="{{ request()->get('client.id') }}">
                <input type="hidden" name="redirect" value="{{ request()->get('redirect') }}">
                <input type="hidden" name="curr_url" value="{{ url()->current() }}">
                <input type="hidden" name="settings_utm_source" value="{{ request()->get('utm_source') }}">
                <input type="hidden" name="settings_utm_campaign" value="{{ request()->get('utm_campaign') }}">
                <input type="hidden" name="settings_utm_medium" value="{{ request()->get('utm_medium') }}">
                <input type="hidden" name="settings_utm_content" value="{{ request()->get('utm_content') }}">
                <input type="hidden" name="settings_utm_referral" value="{{ request()->get('utm_referral') }}">
                <input type="hidden" name="settings_utm_term" value="{{ request()->get('utm_term') }}">
                <input type="hidden" name="code" value="{{ request()->session()->get('code') }}">

              </div>
                Dint recieve the SMS?  
              <a href="#" class="my-2 generate_phone_otp">Click here to resend OTP</a> 
             
             
          </div>
           
                    <div class="pb-lg-0 pb-1 ml-3">
                                         <div class="spinner-border spinner-border-sm ml-2 mt-1 login_spinner" role="status" style="display: none;">
                      <span class="sr-only">Loading...</span>
                    </div>
                    </div>

               
              
              <div class="alert alert-success mt-4 login_message" style="display: none;"></div>
            </form>
      </div>
      
    </div>
  </div>
</div>
