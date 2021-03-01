@php
    function initials($str) {
        $ret = '';
        foreach (explode(' ', $str) as $word)
            $ret .= strtoupper($word[0]);
        return $ret;
    }
@endphp 

<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head>
		<meta charset="utf-8" />
		<title>{{ request()->get('client.name')}}</title>
		<meta name="description" content="Page with empty content" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		@include('components.themes.metronic7.blocks.styles')
		<link rel="shortcut icon" href="{{ asset('favicon_ka.ico') }}" />
        <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body style="max-width= 100vw; overflow-x: hidden; background: #fff6cc;">
        <a href="/"><div class=' p-3 display-4 text-white  text-center' style="background: #504942;font-family: 'Pacifico', cursive;">{{ request()->get('client.name')}}</div></a>

        @if(!request()->get('phone'))
        <div class="container-fluid d-flex justify-content-center text-left mt-5">
            <div class="row loyalty_main">
                <div class="col-5 d-flex justify-content-center align-items-center pl-5" style="min-height: 15rem;">
                    <div>
                        <h1 class="" style="color: #88c0c2;">There's only one thing that matters</h1>
                        <h1 class="text-dark font-weight-bolder">Customer Satisfaction</h1>
                        <!-- <a href="#reward_form" class="btn btn-light-danger mt-5">Check your rewards</a> -->
                    </div>
                </div>
                <div class="col-7 mt-5 mt-lg-0">
                    <img src="{{ asset('img/Giveaway.png') }}" alt="" class="img-fluid" width="500">
                </div>
            </div>
        </div>

        @endif
        <!--begin::Container-->
        <div class="container-fluid " style="max-width: 100rem;">
            @if($alert ?? "")
                @guest
                    <div class=" mt-3">
                        <!--begin::Engage Widget 7-->
                        <div class="card card-custom card-stretch gutter-b">
                            <div class="card-body d-flex p-0">
                                <div class="flex-grow-1 p-12 card-rounded bgi-no-repeat d-flex flex-column justify-content-center align-items-start shadow" style="background-color: #FFF4DE; background-position: right bottom; background-size: auto 50%; background-image: url({{ asset('themes/metronic/media/svg/humans/custom-8.svg') }})">
                                    <h3 class="text-danger font-weight-bolder m-0">No records found</h3>
                                    <h5 class="text-dark-50 font-size-xl font-weight-bold">Please contact the Sales Executive</h5>
                                     <a href="/">
                                    <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-02-01-052524/theme/html/demo1/dist/../src/media/svg/icons/Navigation/Angle-double-left.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24"/>
                                            <path d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z" fill="#000000" fill-rule="nonzero" transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999) "/>
                                            <path d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999) "/>
                                        </g>
                                    </svg><!--end::Svg Icon--></span>  homepage</a>
                                </div>

                            </div>
                        </div>
                        <!--end::Engage Widget 7-->
                    </div>
                @endguest
            @endif

             @if ($errors->any())
                <div class="alert alert-danger mt-3">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if($redeem_alert ?? '')
                <div class="alert alert-danger mt-5">
                    {!! $redeem_alert !!}
                </div>
            @endif

        @if(!request()->get('phone'))
            
            <form action="{{ url()->current() }}" class="my-5 p-8" id="reward_form" style="background: #fceeb0; border-radius: 2rem;">
                <h2 class="text-center text-dark font-weight-bolder">Know your Credits</h2>
                <h3 class="font-weight-bolder mt-3 text-center"><span style="color: #de9244;"> Redeemable</span></h3>
                <h5 class="mt-10" style="color: #88c0c2;">Enter your Phone Number:</h5>
                <input type="text" id="phone_number_input" name="phone" class="form-control mb-3" value="{{ $phone ?? "" }}" required>
                <input type="hidden" name="agency_id" value="{{ request()->get('agency.id') }}">
                <input type="hidden" name="client_id" value="{{ request()->get('client.id') }}">
                <button type="submit" class="btn btn-danger">Search</button>
                @guest
                    <a href="/login" class="btn btn-dark ml-3">Login</a>
                @else
                    <a href="/admin" class="btn btn-dark ml-3">Dashboard</a>
                @endguest
            </form>
        @endif

                @if(!empty($customer))
                    <div class="container bg-white rounded-lg p-5 my-7" style="max-width: 100rem;">
                        <div class="d-flex justify-content-between align-item-center p-5">
                            <div>
                                <h3>Hello, {{$customer->name}} 👋</h3>
                                <h1>Welcome!</h1>
                                <a href="/">
                                    <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-02-01-052524/theme/html/demo1/dist/../src/media/svg/icons/Navigation/Angle-double-left.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24"/>
                                            <path d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z" fill="#000000" fill-rule="nonzero" transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999) "/>
                                            <path d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999) "/>
                                        </g>
                                    </svg><!--end::Svg Icon--></span>  homepage</a>
                            </div>
                            <div>
                                <!--begin::Pic-->
                                <a href="{{ route('Customer.show', $customer->id) }}">
                                    <div class="flex-shrink-0 mr-7">
                                        <div class="symbol symbol-light-danger">
                                            <span class="font-size-h3 symbol-label font-weight-boldest">{{ initials($customer->name) }}</span>
                                        </div>
                                    </div>
                                </a>
                                <!--end::Pic-->
                            </div>
                        </div>
                        <div class="row mt-5 text-dark">
                            <div class="col-8 col-lg-6 d-flex align-items-center">
                                <div>
                                    <div class="card-body  align-items-center">
                                        <div class="">
                                            <div class="d-flex align-items-center">
                                                <h1 class="font-weight-bolder mr-3 d-flex align-items-center"><a href="{{ route('Customer.show', $customer->id) }}" class="text-dark">{{ $remaining_credits }} Credits</a></h1>
                                            </div>
                                            
                                            <h3 class="text-danger">Remaining Balance</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 col-lg-6 d-flex justify-content-end">
                                <img src="{{ asset('img/reward-2.webp') }}" class="img-lg-block" width="180px">
                            </div>
                        </div>
                    </div>

                    @auth
                        <!--begin::Tiles Widget 25-->
                        <div class="card card-custom bgi-no-repeat bgi-size-cover gutter-b bg-dark mt-7 p-5 d-flex justify-content-center" style="background-image: url({{ asset('themes/metronic/media/svg/patterns/taieri.svg') }}">
                            <div class="card-body d-flex">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <form action="{{ route($app->module.'.store') }}" class="text-white" method="POST">
                                            <input type="text" class="form-control form-control-lg bg-dark border-0 text-white mt-3" name="amount" style="background-color: #303651 !important"  placeholder="Amount">
                                            @if($settings->mode == 'generic')
                                                <input type="text" class="form-control form-control-lg bg-dark border-0 text-white mt-3" name="description" style="background-color: #303651 !important"  placeholder="Description">
                                                <div class="row">
                                                    <div class="col-12 col-lg-6 my-3">
                                                        <div class="p-5 rounded-lg " style="background-color: #303651">
                                                            <label>Credits:</label>
                                                            <input type="text" class="form-control form-control-lg bg-dark border-0 text-white" style="background-color: ##181C32 !important" name="credits" placeholder="Credit">
                                                            <button type="submit" name="credit_redeem" value="credit" class="btn btn-lg btn-light-danger btn-shadow font-weight-bold mt-3 px-4">Add Credits</button>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-lg-6 my-3">
                                                        <div class="p-5 rounded-lg " style="background-color: #303651">
                                                            <label>Redeem:</label>
                                                            <input type="text" class="form-control form-control-lg border-0 text-white" name="redeem" style="background-color: #181C32 !important" placeholder="Redeem">
                                                            <button type="submit" name="credit_redeem" value="redeem" class="btn btn-lg btn-light-danger btn-shadow font-weight-bold mt-3 px-4">Redeem</button>
                                                        </div>
                                                    </div>     
                                                </div>      
                                            @elseif($settings->mode == 'default')
                                                <input type="text" class="form-control form-control-lg bg-dark border-0 text-white mt-3" name="description" style="background-color: #303651 !important"  placeholder="Description">
                                                <div class="row">
                                                    <div class="col-12 col-lg-6 my-3">
                                                        <div class="p-5 rounded-lg " style="background-color: #303651">
                                                            <label>Credits:</label>
                                                            <input type="text" class="form-control form-control-lg bg-dark border-0 text-white" style="background-color: ##181C32 !important" name="credits" placeholder="Credit" value="{{ $settings->default_credits }}" readonly>
                                                            <button type="submit" name="credit_redeem" value="credit" class="btn btn-lg btn-light-danger btn-shadow font-weight-bold mt-3 px-4">Add Credits</button>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-lg-6 my-3">
                                                        <div class="p-5 rounded-lg " style="background-color: #303651">
                                                            <label>Redeem:</label>
                                                            <input type="text" class="form-control form-control-lg border-0 text-white" name="redeem" style="background-color: #181C32 !important" placeholder="Redeem">
                                                            <button type="submit" name="credit_redeem" value="redeem" class="btn btn-lg btn-light-danger btn-shadow font-weight-bold mt-3 px-4">Redeem</button>
                                                        </div>
                                                    </div>     
                                                </div> 
                                            @elseif($settings->mode == 'range_percent')
                                                <div class="row">
                                                    <div class="col-12 col-lg-6 my-3">
                                                        <div class="p-5 rounded-lg " style="background-color: #303651">
                                                            <label>Credits:</label>
                                                            <input type="text" class="form-control form-control-lg bg-dark border-0 text-white" style="background-color: #2c324a !important" placeholder="Credit" value="{{$settings->percent_1}}%" readonly>
                                                            <button type="submit" name="credit_redeem" value="credit" class="btn btn-lg btn-light-danger btn-shadow font-weight-bold mt-3 px-4">Add Credits</button>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-lg-6 my-3">
                                                        <div class="p-5 rounded-lg " style="background-color: #303651">
                                                            <label>Redeem:</label>
                                                            <input type="text" class="form-control form-control-lg border-0 text-white" name="redeem" style="background-color: #181C32 !important" placeholder="Redeem">
                                                            <button type="submit" name="credit_redeem" value="redeem" class="btn btn-lg btn-light-danger btn-shadow font-weight-bold mt-3 px-4">Redeem</button>
                                                        </div>
                                                    </div>     
                                                </div>     
                                            @elseif($settings->mode == 'range_fixed')
                                                <div class="row">
                                                    <div class="col-12 col-lg-6 my-3">
                                                        <div class="p-5 rounded-lg " style="background-color: #303651">
                                                            <label>Credits:</label>
                                                            <input type="text" class="form-control form-control-lg bg-dark border-0 text-white" style="background-color: ##181C32 !important" placeholder="Credit" value="Value is calculated based on settings" readonly>
                                                            <button type="submit" name="credit_redeem" value="credit" class="btn btn-lg btn-light-danger btn-shadow font-weight-bold mt-3 px-4">Add Credits</button>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-lg-6 my-3">
                                                        <div class="p-5 rounded-lg " style="background-color: #303651">
                                                            <label>Redeem:</label>
                                                            <input type="text" class="form-control form-control-lg border-0 text-white" name="redeem" style="background-color: #181C32 !important" placeholder="Redeem">
                                                            <button type="submit" name="credit_redeem" value="redeem" class="btn btn-lg btn-light-danger btn-shadow font-weight-bold mt-3 px-4">Redeem</button>
                                                        </div>
                                                    </div>     
                                                </div>                                                 
                                            @endif
                                            <input type="text" hidden name="customer_id" value="{{ $customer->id }}">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="_method" value="PUT">
                                            <input type="text" hidden value="{{ url()->full() }}" name="current_url">
                                            <input type="hidden" name="agency_id" value="{{ request()->get('agency.id') }}">
                                            <input type="hidden" name="client_id" value="{{ request()->get('client.id') }}">
                                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Tiles Widget 25-->
                    @endauth
                @else
                    @auth
                        @if($customer_status)
                            <div class="my-10" style="max-width=100rem;">
                                <div class="p-7 mt-5 text-dark rounded shadow" style=" background: #88c0c2;">
                                    <h1 class="text-center text-white mb-5">Create Customer</h1>
                                    <form action="{{ route('Customer.store') }}" method="POST">
                                        @csrf
                                        <div class="row g-3 mt-4">
                                            <div class="col-12 col-lg-6">
                                                <label >Name:</label>
                                                <input type="text" class="form-control" name="name" required>
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <label>Phone:</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">+91</span>
                                                    <input type="text" class="form-control" name="phone" id="phone_number_output"  value="{{request()->get('phone')}}" required>
                                                </div>
                                            </div>
                                        </div>
                                       
                                        <input type="text" hidden value="{{ url()->full() }}" name="current_url">
                                        <input type="hidden" name="agency_id" value="{{ request()->get('agency.id') }}">
                                        <input type="hidden" name="client_id" value="{{ request()->get('client.id') }}">
                                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                        <button type="submit" class="btn btn-light-danger px-4 mt-4">Create</button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    @endauth
                @endif

        </div>

        
		
		@include('components.themes.metronic7.blocks.scrolltop')
	</body>
	<!--end::Body-->
</html>


