
<!--====== FOOTER PART START ======-->

<section class="footer-area footer-dark">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="footer-logo text-center">
          <h3>
            @if(isset(Session::get('settings')->logo_dark))
            <img src="{{Session::get('settings')->logo_dark}}" alt="logo"/>
            @else
            {{Session::get('name')}}
            @endif
          </h3>
        </div> <!-- footer logo -->
        <ul class="social text-center mt-60">
          @if(isset(Session::get('settings')->sociallinks))
          {!! Session::get('settings')->sociallinks !!}
          @endif
        </ul> <!-- social -->
        <div class="footer-support text-center">
          @if(isset(Session::get('settings')->contact))
          {!! Session::get('settings')->contact !!}
          @endif
        </div>
        
      </div>
    </div> <!-- row -->
  </div> <!-- container -->
</section>

<!--====== FOOTER PART ENDS ======-->

