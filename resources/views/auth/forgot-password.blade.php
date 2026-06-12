<x-dynamic-component :component="$app->componentName" class="mt-4" >
<!-- Validation Errors -->
<x-auth-validation-errors class="mb-4" :errors="$errors" />
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
        <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors" />
        
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
                    <!--begin::Title-->
                    <div class="pb-13 pt-lg-0 pt-5">
                    
                    <span class="text-muted font-weight-bold font-size-h4">Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.</span>
                    </div>
                    <!--end::Title-->
                    

                    <!-- Email Address -->
                    <div class="form-group">
                        <label class="font-size-h6 font-weight-bolder text-dark" for="email" :value="__('Email')">Email</label>
                        <input id="email" class="form-control form-control-solid h-auto py-5 px-4 rounded-lg" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="off" />
                    </div>                    
                    <!--begin::Action-->
                    <div class="pb-lg-4 pb-5 d-flex align-items-center ">
                    <div>
                    <button type="submit" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">Email Password Reset Link</button>
                    </div>
                    
                    </div>
                    <!--end::Action-->
                
        </form>
        
</x-dynamic-component>
