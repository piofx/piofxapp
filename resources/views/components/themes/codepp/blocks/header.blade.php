<!--====== NAVBAR TWO PART START ======-->

    <section class="navbar-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <nav class="navbar navbar-expand-lg">

                          @if(isset(Session::get('settings')->logo_light))
                            <a class="navbar-brand" href="#">
                                <img src="{{Session::get('settings')->logo_light}}" alt="Logo" style="width:80px" data-logo_light="{{Session::get('settings')->logo_light}}" data-Logo_dark="@if(isset(Session::get('settings')->logo_dark)){{Session::get('settings')->logo_dark}} @endif"/>
                              </a>
                          @else
                            <a href="/">{{Session::get('name')}}</a>
                          @endif
                        
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTwo" aria-controls="navbarTwo" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="toggler-icon"></span>
                            <span class="toggler-icon"></span>
                            <span class="toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse sub-menu-bar" id="navbarTwo">
                            <ul class="navbar-nav m-auto">
                                @if(isset(Session::get('settings')->topmenu))
                                  {!! Session::get('settings')->topmenu !!}
                                @endif
                            </ul>
                        </div>
                        
                        <div class="navbar-btn d-none d-sm-inline-block">
                            <ul>
                                <li>
                                  @if(isset(Session::get('settings')->cta_button))
                                  {!! Session::get('settings')->cta_button !!}
                                  @endif
                                </li>
                            </ul>
                        </div>
                    </nav> <!-- navbar -->
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </section>

    <!--====== NAVBAR TWO PART ENDS ======-->
