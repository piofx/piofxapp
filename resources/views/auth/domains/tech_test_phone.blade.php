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

                                
                                @if(client('whatsapp_otp_register'))
                                <small>Kindly enter valid phone number for OTP generation via Whatsapp</small><br>
                                <button type="button" class="btn btn-outline-dark btn-sm mt-3 generate_whatsapp_otp">Generate OTP</button>
                                @else
                                <small>Kindly enter valid phone number for OTP verification</small><br>
                                <button type="button" class="btn btn-outline-dark btn-sm mt-3 generate_phone_otp">Generate OTP</button>
                                @endif
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
                                <label class="font-size-h6 font-weight-bolder text-dark" for="otp" :value="__('OTP')">Enter OTP Verification code</label>
                                <input id="otp" class="form-control form-control-solid h-auto py-4 px-4 rounded-lg" type="text" name="otp" value="{{ old('otp') }}" required autofocus autocomplete="off" />
                                    <small>Kindly wait for 2mins for OTP, before retrying.</small><br>
                                <button class="btn btn-outline-dark btn-sm mt-3 validate_otp" data-otp="{{$code}}">Validate OTP 
                                </button><span class="text-dark ml-3 otp_success" style="display: none;"><i class="fa fa-check-circle text-dark"></i> Success</span>
                            </div>
                            </div>
                            
                        </div>
                    </div>

                   
                    @if(request()->get('password'))
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
                    @endif

                <div class="row">
                    <div class='col-12 col-md-3'>
                    <label class="font-size-h6 font-weight-bolder text-dark" for="c1" >College Name</label>
                    <select class="form-control" name="c1">
                    @foreach(colleges() as $d)
                    <option value="{{$d->name}}"> {{$d->name}}</option>
                    @endforeach
                    </select>
                   
                    </div>
                    <div class='col-12 col-md-3'>
                    <label class="font-size-h6 font-weight-bolder text-dark" for="c2" >Branch</label>
                    <select class="form-control" name="c2">
                    @foreach(branches() as $d)
                    <option value="{{$d}}"> {{$d}}</option>
                    @endforeach
                    </select>
                    </div>
                    <div class='col-12 col-md-3'>
                    <label class="font-size-h6 font-weight-bolder text-dark" for="c3" >Year of Passing</label>
                    <input class="form-control c3" list="datalistYOP" name="c3" id="exampleDataList" placeholder="Type to search..." required
                    >
                    <datalist id="datalistYOP">
                       @foreach(yop() as $d)
                        <option value="{{$d}}">
                      @endforeach
                    </datalist>
                   
                    </div>
                    <div class='col-12 col-md-3'>
                        <label for="formGroupExampleInput " class="font-size-h6 font-weight-bolder text-dark">Any Backlogs? </label>
                        <select class="form-control" name="c4">
                          <option value="None" >None</option>
                          <option value="One"  >One</option>
                           <option value="One"  >Two</option>
                            <option value="One"  >Three or more</option>
                        </select>
                    </div>
                </div>

                 <div class="row my-2">
                   
                    <div class='col-12 col-md-3'>
                        <label class="font-size-h6 font-weight-bolder text-dark" for="c5" >Current City</label>
                        <input class="form-control" list="datalistCities" name="c5" id="exampleDataList" placeholder="Type to search..."
                        >
                        <datalist id="datalistCities">
                          @foreach(cities() as $d)
                            <option value="{{$d}}">
                          @endforeach
                        </datalist>
                    </div>
                    <div class='col-12 col-md-3'>
                        <label class="font-size-h6 font-weight-bolder text-dark" for="c6" >District</label>
                        <select class="form-control" name="c6">
                    @foreach(districts() as $d)
                    <option value="{{$d}}"> {{$d}}</option>
                    @endforeach
                    </select>
                   
                    </div>
                    <div class='col-12 col-md-3'>
                        <label class="font-size-h6 font-weight-bolder text-dark" for="c7" >State</label>
                        <select class="form-control" name="c7">
                    @foreach(states() as $d)
                    <option value="{{$d}}"> {{$d}}</option>
                    @endforeach
                    </select>
                    </div>
                </div>

                <div class="row my-2">
                    <div class='col-12'>
                    <label class="font-size-h6 font-weight-bolder text-dark" for="c7" >Career Plan</label>
                    <div class="form-check">           
                        <input class=" mb-2" name="settings_interests[]" type="checkbox" value="govtjob" id="defaultCheck1">
                        <label class="form-check-label mb-2" for="defaultCheck1">
                            Govt JOB &nbsp;&nbsp;
                        </label>
                         <input class="" name="settings_interests[]" type="checkbox" value="softjob" id="defaultCheck2"> 
                        <label class="form-check-label" for="defaultCheck2">
                            Software JOB &nbsp;&nbsp;
                        </label>
                        <input class="" name="settings_interests[]" type="checkbox" value="msinus" id="defaultCheck3">
                        <label class="form-check-label" for="defaultCheck3">
                            MS in US &nbsp;&nbsp;
                        </label> 
                        <input class="" name="settings_interests[]" type="checkbox" value="mtech" id="defaultCheck4">
                        <label class="form-check-label" for="defaultCheck4">
                            MTECH &nbsp;&nbsp;
                        </label> 
                        <input class="" name="settings_interests[]" type="checkbox" value="mba" id="defaultCheck5">
                        <label class="form-check-label" for="defaultCheck5">
                            MBA &nbsp;&nbsp;
                        </label> 
                        <input class="" name="settings_interests[]" type="checkbox" value="notdecided" id="defaultCheck6">
                        <label class="form-check-label" for="defaultCheck6">
                            NOT Decided &nbsp;&nbsp;
                        </label> 
                    </div>
                </div>
                </div>

                    
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="agency_id" value="{{ request()->get('agency.id') }}">
                <input type="hidden" name="client_id" value="{{ request()->get('client.id') }}">
                <input type="hidden" name="wa_tracker" value="1">
                <input type="hidden" name="phone_subscribe" value="1">
                <input type="hidden" name="redirect" value="{{ request()->get('redirect') }}">
                <input type="hidden" name="settings_utm_source" value="{{ request()->get('utm_source') }}">
                <input type="hidden" name="settings_utm_campaign" value="{{ request()->get('utm_campaign') }}">
                <input type="hidden" name="settings_utm_medium" value="{{ request()->get('utm_medium') }}">
                <input type="hidden" name="settings_utm_content" value="{{ request()->get('utm_content') }}">
                <input type="hidden" name="settings_utm_term" value="{{ request()->get('utm_term') }}">
                <input type="hidden" name="settings_utm_referral" value="{{ request()->get('utm_referral') }}">
                <input type="hidden" name="curr_url" value="{{ url()->current() }}">
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
