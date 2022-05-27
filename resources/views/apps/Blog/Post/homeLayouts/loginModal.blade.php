<!-- Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Login  to proceed further...</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="mt-3" action="/user/apilogin" data-login="1">
              <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp" placeholder="Enter email">
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="Password">
              </div>
              <button type="button" class="btn btn-primary login_button mb-3">Login</button><br>
              @if(client('phone_otp_login'))
              Dont remember the password? <a href="/login_phone?redirect={{url()->full()}}" class="my-2 ">Login via SMS OTP</a>
              @else

               Dont have an account? <a href="/register?redirect={{url()->full()}}" class="">Register Now</a>
              
              @endif
             
              <hr>
              Dont remember the password? <a href="{{ route('password.request') }}" class=" text-hover-primary pt-5" id="kt_login_forgot">Forgot Password ?</a> 
               <input type="hidden" name="curr_url" value="{{ url()->current() }}">
              <div class="alert alert-success mt-4 login_message" style="display: none;"></div>
            </form>
      </div>
      
    </div>
  </div>
</div>
