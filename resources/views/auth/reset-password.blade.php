<x-dynamic-component :component="$app->componentName" class="mt-4" >
        <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <!--begin::Title-->
            <div class="pb-13 pt-lg-0 pt-5">
            <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">Reset Your Password</h3>
            <span class="text-muted font-weight-bold font-size-h4">Enter your details to Reset Your Password</span>
            </div>
            <!--end::Title-->

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div class="form-group">
                <label class="font-size-h6 font-weight-bolder text-dark" for="email" :value="__('Email')" >Email</label>
                <input id="email" class="form-control form-control-solid h-auto py-5 px-4 rounded-lg" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="off"/>
            </div>

            <!-- Password -->
            <div class="mt-4" class="form-group">
                <label class="font-size-h6 font-weight-bolder text-dark" for="password" :value="__('Password')" >Password</label>
                <x-input id="password" class="form-control form-control-solid h-auto py-5 px-4 rounded-lg" type="password" name="password" required />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4" class="form-group">
                <label class="font-size-h6 font-weight-bolder text-dark" for="password_confirmation" :value="__('Confirm Password')" >Confrim Password</label>
                <x-input id="password_confirmation" class="form-control form-control-solid h-auto py-5 px-4 rounded-lg" type="password" name="password_confirmation" required />
            </div>

            <!--begin::Action-->
            <div class="pb-lg-4 pb-5 d-flex align-items-center ">
            <div class="flex items-center justify-end mt-4">
            <button type="submit" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">Reset Password</button>
            </div>
            </div>
        </form>
    
</x-dynamic-component>
