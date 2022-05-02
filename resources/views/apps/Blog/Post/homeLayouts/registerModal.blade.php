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
      <div class="modal-body">
        <form class="mt-3 registerform" action="{{ route('User.apiregister') }}" data-register="1" >
            <div class="form-group">
                <label for="exampleInputName">Name</label>
                <input type="text" class="form-control" id="exampleInputName" name="name"  placeholder="Enter fullname">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp" placeholder="Enter email">
              </div>
              <div class="form-group">
                <div class="bg-light border p-3 rounded">
                  <label class="font-size-h6 font-weight-bolder text-dark" for="phone" :value="__('Phone')">Phone Number</label>
                  <input id="phone" class="form-control form-control-solid h-auto rounded-lg" type="phone" name="phone" value="{{ old('phone') }}" required autofocus autocomplete="off" />
                  <small>Kindly enter valid phone number for OTP verification</small><br>
                  <button type="button" class="btn btn-outline-dark btn-sm mt-3 generate_phone_otp">Generate OTP</button>
                  <div class="spinner-border spinner-border-sm ml-2 mt-1 otp_spinner" role="status" style="display: none;">
                    <span class="sr-only">Loading...</span>
                  </div><br>
                </div>
              </div>

              <div class="form-group">
                 <div class="bg-light rounded p-3 border">
                  <label class="font-size-h6 font-weight-bolder text-dark" for="otp" :value="__('OTP')">OTP Verification</label>
                  <input id="otp" class="form-control form-control-solid h-auto  rounded-lg" type="text" name="otp" value="{{ old('otp') }}"   autocomplete="off" />
                  <small>Kindly wait for 2mins for OTP via sms, before retrying.</small><br>
                  <button type="button" class="btn btn-outline-dark btn-sm mt-3 validate_otp" data-otp="{{request()->session()->get('code')}}">Validate OTP 
                  </button><span class="text-dark ml-3 otp_success" style="display: none;"><i class="fa fa-check-circle text-dark"></i> Success</span>
                </div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="agency_id" value="{{ request()->get('agency.id') }}">
                <input type="hidden" name="client_id" value="{{ request()->get('client.id') }}">
                <input type="hidden" name="redirect" value="{{ request()->get('redirect') }}">
                <input type="hidden" name="settings_utm_source" value="{{ request()->get('utm_source') }}">
                <input type="hidden" name="settings_utm_campaign" value="{{ request()->get('utm_campaign') }}">
                <input type="hidden" name="settings_utm_medium" value="{{ request()->get('utm_medium') }}">
                <input type="hidden" name="settings_utm_content" value="{{ request()->get('utm_content') }}">
                <input type="hidden" name="settings_utm_term" value="{{ request()->get('utm_term') }}">
                <input type="hidden" name="code" value="{{ request()->session()->get('code') }}">

              </div>
              <button type="button" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-2 my-1 mr-3 register">Register </button>
           
                    <div class="pb-lg-0 pb-1 ml-3">
                                         <div class="spinner-border spinner-border-sm ml-2 mt-1 login_spinner" role="status" style="display: none;">
                      <span class="sr-only">Loading...</span>
                    </div><br>
                    </div>
              <hr>
              @if(client('phone_otp_login'))Already have a account? 
              <a href="/login_phone?redirect={{url()->full()}}" class="my-2 ">Login via SMS OTP</a> or <a href="{{ route('password.request') }}" class=" text-hover-primary pt-5" id="kt_login_forgot">Forgot Password ?</a>       
              @endif
              <div class="alert alert-success mt-4 login_message" style="display: none;"></div>
            </form>
      </div>
      
    </div>
  </div>
</div>
