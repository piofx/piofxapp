<!-- JS Global Compulsory -->
<script src="../../assets/vendor/jquery/dist/jquery.min.js"></script>
<script src="../../assets/vendor/jquery-migrate/dist/jquery-migrate.min.js"></script>
<script src="../../assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<!-- JS Implementing Plugins -->
<script src="{{ asset('themes/front/vendor/hs-header/dist/hs-header.min.js') }}"></script>
<script src="{{ asset('themes/front/vendor/hs-go-to/dist/hs-go-to.min.js') }}"></script>
<script src="{{ asset('themes/front/vendor/hs-unfold/dist/hs-unfold.min.js') }}"></script>
<script src="{{ asset('themes/front/vendor/hs-mega-menu/dist/hs-mega-menu.min.js')}}"></script>
<script src="{{ asset('themes/front/vendor/hs-toggle-switch/dist/hs-toggle-switch.min.js') }}"></script>
<script src="{{ asset('themes/front/vendor/aos/dist/aos.js') }}"></script>
<!-- JS Front -->
<script src="{{ asset('themes/front/assets/js/hs.core.js') }}"></script>
<!-- JS Plugins Init. -->
<script>
  $(document).on('ready', function () {
      // initialization of header
      var header = new HSHeader($('#header')).init();

      // initialization of mega menu
      var megaMenu = new HSMegaMenu($('.js-mega-menu'), {
        desktop: {
          position: 'left'
        }
      }).init();

      // initialization of unfold
      var unfold = new HSUnfold('.js-hs-unfold-invoker').init();

      // initialization of toggle switch
      $('.js-toggle-switch').each(function () {
        var toggleSwitch = new HSToggleSwitch($(this)).init();
      });

      // initialization of aos
      AOS.init({
        duration: 650,
        once: true
      });

      // initialization of go to
      $('.js-go-to').each(function () {
        var goTo = new HSGoTo($(this)).init();
      });
    });
  </script>
  <!-- IE Support -->
  <script>
    if (/MSIE \d|Trident.*rv:/.test(navigator.userAgent)) document.write('<script src="{{ asset("themes/front/assets/vendor/polifills.js") }}"><\/script>');
  </script>