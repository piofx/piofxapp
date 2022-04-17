<x-dynamic-component :component="$app->componentName" class="mt-4" >
        <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors" />
        <!--begin::Form-->
        <form method="POST" action="{{ route('User.apiregister') }}" data-register="1" data-register_otp="1">
            @csrf
                    <!--begin::Title-->
                    <div class="pb-13 pt-lg-0 pt-5">
                    <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">Sign Up</h3>
                    <span class="text-muted font-weight-bold font-size-h4">Enter your details to create your account</span>
                    </div>
                    <!--end::Title-->

                    <div class="row">
                        <div class='col-12 col-md-6'>
                            <!-- Name -->
                            <div class="form-group">
                                <label class="font-size-h6 font-weight-bolder text-dark" for="name" :value="__('Name')">Name</label>
                                <input id="name" class="form-control form-control-solid h-auto py-4 px-4 rounded-lg" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="off" />
                            </div>
                        </div>
                        <div class='col-12 col-md-6'>
                             <!-- Phone number -->

                            <div class="form-group">
                                <label class="font-size-h6 font-weight-bolder text-dark" for="email" :value="__('Email')">Email</label>
                                <input id="email" class="form-control form-control-solid h-auto py-4 px-4 rounded-lg" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="off" />
                                
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class='col-12 col-md-6'></div>
                        <div class='col-12 col-md-6'></div>
                    </div>
                    


                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="rounded mb-4 p-4" style="background: #d6edf7">
                             <!-- Email Address -->
                            <div class="">
                                <label class="font-size-h6 font-weight-bolder text-dark" for="phone" :value="__('Phone')">Phone Number</label>
                                <input id="phone" class="form-control form-control-solid h-auto py-4 px-4 rounded-lg" type="phone" name="phone" value="{{ old('phone') }}" required autofocus autocomplete="off" />
                                <small>Kindly enter valid phone number for OTP verification</small><br>
                                <button class="btn btn-outline-dark btn-sm mt-3 generate_phone_otp">Generate OTP</button>
                                 <div class="spinner-border spinner-border-sm ml-2 mt-1 otp_spinner" role="status" style="display: none;">
                                  <span class="sr-only">Loading...</span>
                                </div><br>
                            </div>
                            </div>

                        </div>
                        <div class="col-12 col-md-6">
                             <div class="rounded mb-4 p-4" style="background: #d6edf7">
                             <!-- Email Address -->
                            <div class="">
                                <label class="font-size-h6 font-weight-bolder text-dark" for="otp" :value="__('OTP')">OTP Verification</label>
                                <input id="otp" class="form-control form-control-solid h-auto py-4 px-4 rounded-lg" type="text" name="otp" value="{{ old('otp') }}" required autofocus autocomplete="off" />
                                    <small>Kindly wait for 2mins for OTP via sms, before retrying.</small><br>
                                <button class="btn btn-outline-dark btn-sm mt-3 validate_otp" data-otp="{{$code}}">Validate OTP 
                                </button><span class="text-dark ml-3 otp_success" style="display: none;"><i class="fa fa-check-circle text-dark"></i> Success</span>
                            </div>
                            </div>
                            
                        </div>
                    </div>

                   

                    <div class="row">
                        <div class='col-12 col-md-6'>
                            <!-- Password -->
                            <div class="form-group">
                                <label class="font-size-h6 font-weight-bolder text-dark" for="password" :value="__('Password')" >Password</label>
                                <input id="password" class="form-control form-control-solid h-auto py-4 px-4 rounded-lg" type="password" name="password" value="{{ old('password') }}" required autocomplete="new-password" />
                            </div>
                        </div>
                        <div class='col-12 col-md-6'>
                            <!-- Confirm Password -->
                            <div class="form-group">
                                <label class="font-size-h6 font-weight-bolder text-dark" for="password_confirmation" :value="__('Confirm Password')" >Confrim Password</label>
                                <input id="password_confirmation" class="form-control form-control-solid h-auto py-4 px-4 rounded-lg" type="password" name="password_confirmation" />
                            </div>
                                    
                        </div>
                    </div>

                <div class="row">
                  @if($form)
                      @foreach($form as $k=>$f)
                      <div class='col-12 col-md-6'>
                        @if($f['type']=='input')
                        <div class="js-form-message form-group mb-4">
                          <label for="emailAddressExample2" class="input-label">{{$f['name']}}</label>
                          <input type="text" class="form-control" name="settings_{{ str_replace(' ','_',$f['name'])}}" value="@if(!empty($form_data)){{ key_match($f['name'], $form_data) }}@endif">
                        </div>
                        @elseif($f['type']=='textarea')
                        <div class="js-form-message form-group mb-4">
                          <label for="emailAddressExample2" class="input-label">{{$f['name']}}</label>
                          <textarea class="form-control" id="exampleFormControlTextarea1" name="settings_{{ str_replace(' ','_',$f['name'])}}" rows="{{$f['values']}}">@if(!empty($form_data)){{ key_match($f['name'], $form_data) }}@endif</textarea>
                        </div>
                        @elseif($f['type']=='radio')
                        <div class="js-form-message form-group mb-4">
                          <label for="emailAddressExample2" class="input-label">{{$f['name']}}</label>
                          <select class="form-control" name="settings_{{ str_replace(' ','_',$f['name'])}}"  id="exampleFormControlSelect1">
                            @foreach($f['values'] as $v)
                                <option value="{{$v}}" @if(!empty($form_data) && value_match($f['name'], $v, $form_data)){{ 'selected' }}@endif>{{$v}}</option>
                            @endforeach
                          </select>
                        </div>
                        @elseif($f['type']=='file')
                        <div class="js-form-message form-group mb-4">
                          <label for="emailAddressExample2" class="input-label">{{$f['name']}}</label>
                          <input type="file" class="form-control-file" name="settings_{{ str_replace(' ','_',$f['name'])}}" id="exampleFormControlFile1">
                        </div>
                        @else
                        <div class="js-form-message form-group mb-4">
                          <label for="emailAddressExample2" class="input-label">{{$f['name']}}</label>
                            @foreach($f['values'] as $m=>$v)
                                <div class="form-check">
                                    @php
                                        $name = str_replace(' ','_',$f['name']);
                                    @endphp
                                    <input class="" name="settings_{{ str_replace(' ','_',$f['name'])}}[]" type="checkbox" @if(!empty($form_data) && value_match($f['name'], $v, $form_data)){{ "checked" }} @endif value="{{$v}}" id="defaultCheck{{$m}}">
                                    <label class="form-check-label" for="defaultCheck{{$m}}">
                                        {{$v}}
                                    </label>
                                </div>
                          @endforeach
                        </div>
                        @endif
                    </div>
                      @endforeach
                    @endif
                </div>


                    
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="agency_id" value="{{ request()->get('agency.id') }}">
        <input type="hidden" name="client_id" value="{{ request()->get('client.id') }}">
            <input type="hidden" name="redirect" value="{{ request()->get('redirect') }}">
        <input type="hidden" name="code" value="{{ $code }}">

                    
                    
                    <!--begin::Action-->
                    <div class="pb-lg-4 pb-5 d-flex align-items-center ">
                    <div>
                    <button type="submit" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3 register">Register 


                    </button>
                    </div>
                    <div class="pb-lg-0 pb-5 ml-3">
                                         <div class="spinner-border spinner-border-sm ml-2 mt-1 login_spinner" role="status" style="display: none;">
  <span class="sr-only">Loading...</span>
</div><br>
                    <a href="{{ route('login')}}"  class="text-muted font-size-h6 font-weight-bolder text-hover-primary pt-5">Already registered?</a>  &nbsp;&nbsp;
                    <a href="{{ route('password.request') }}" class="text-muted font-size-h6 font-weight-bolder text-hover-primary pt-5" id="kt_login_forgot">Forgot Password ?</a>              
                    </div>
                    </div>
                    <!--end::Action-->
                
        </form>
    <!--end::Form-->    
</x-dynamic-component>
