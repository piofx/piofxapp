<!--begin::Footer-->
<!-- ======= Footer ======= -->
  <footer id="footer">

    <div class="footer-newsletter">
      <div class="container">
       
      </div>
    </div>

    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-3 col-md-6 footer-contact">
            <h3>
            	@if(isset(Session::get('settings')->logo_dark))
            		<img src="{{Session::get('settings')->logo_dark}}" />
            	@else
            		{{Session::get('name')}}
            	@endif
            </h3>
            <p>
              @if(isset(Session::get('settings')->contact))
            		{!! Session::get('settings')->contact !!}
              @endif
            </p>
          </div>

          @if(isset(Session::get('settings')->footermenu))
                {!! Session::get('settings')->footermenu !!}
          @endif

          @if(isset(Session::get('settings')->sociallinks))
                {!! Session::get('settings')->sociallinks !!}
          @endif

        </div>
      </div>
    </div>

    <div class="container footer-bottom clearfix">
      <div class="copyright">
        &copy; Copyright <strong><span>{{Session::get('name')}}</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/arsha-free-bootstrap-html-template-corporate/ -->
        Designed by <a href="{{ env('APP_CORE')}}">Piofx Media</a>
      </div>
    </div>
  </footer><!-- End Footer -->
<!--end::Footer-->