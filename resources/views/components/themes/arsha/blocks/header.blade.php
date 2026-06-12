  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top header-inner-pages">
    <div class="container d-flex align-items-center">

      <h1 class="logo mr-auto">
      	@if(client('logo'))
      		<a href="/" class="logo mr-auto">
            	<img src="{{ client('logo')}}" alt="" class="img-fluid"/>
            </a>
        @else
        	<a href="/">{{client('name')}}</a>
        @endif
      </h1>

      <nav class="nav-menu d-none d-lg-block">
        <ul>
        @if(client('header_menu'))
  			{!! client('header_menu') !!}
  		  @endif
        </ul>
      </nav><!-- .nav-menu -->

      <a href="#about" class="get-started-btn scrollto">Get Started</a>

    </div>
  </header><!-- End Header -->