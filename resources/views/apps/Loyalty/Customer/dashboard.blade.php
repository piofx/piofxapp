<x-dynamic-component :component="$app->componentName">

	<div id="customer_chart_data" data-value="{{ $customers }}">
	</div>
	<div id="rewards_data" data-value="{{ $rewards }}">
	</div>
	<div id="revenue_chart_data" data-value="{{ $amount }}">
	</div>

	<div class="row">
		<div class="col-12 col-lg-8">
			<div class="container text-white p-3 mb-3 rounded" style="background: #1d3557;">
				<h5>Filter:</h5>
				<form action="{{ route('Loyalty.dashboard') }}" method="GET" class="d-flex" id="filter_form">
					<select class="form-control form-select border-0 text-white" style="background: #457b9d;" name="filter" onchange="filter_charts_result()">
						<option value="today" @if($filter ?? ""){{$filter == 'today' ? "selected" : "" }}@endif>Today</option>
						<option value="this_week" @if($filter ?? ""){{$filter == 'this_week' ? "selected" : "" }}@endif>Last 7 days</option>
						<option value="this_month" @if($filter ?? ""){{$filter == 'this_month' ? "selected" : "" }}@endif>This Month</option>
						<option value="this_year" @if($filter ?? ""){{$filter == 'this_year' ? "selected" : "" }}@endif>This Year</option>
						<option value="all_data" @if($filter ?? ""){{$filter == 'all_data' ? "selected" : "" }}@endif>All Data</option>
					</select>
				</form>
			</div>

			<div class="row">
				<div class="col-12">
					<div class="row my-2">
						<div class="col-12 col-md-7 align-middle pl-md-5 pr-md-2">
							<!--begin::Engage Widget 2-->
								<div class="d-flex p-0">
									<div class="flex-grow-1 bg-success p-8 card-rounded bgi-no-repeat" style="background-position: calc(100% + 0.5rem) bottom; background-size: auto 40%; background-image: url({{ asset('themes/metronic/media/svg/patterns/taieri.svg') }});min-height: 22.7rem;" >
										<h3 class="text-inverse-danger mt-2 font-weight-bolder"><a href="{{ route('Customer.index', $filter) }}" class="text-inverse-danger">Revenue</a></h3>
										<div class="d-flex align-items-start">
											<i class="fas fa-rupee-sign text-dark mr-2 mt-6" style="font-size: 3rem"></i>
											<h1 class="text-white font-weight-bolder p-0 m-0 text-break" style="font-size: 5rem;"> {{ $revenue }}</h1>
										</div>
									</div>
								</div>
							<!--end::Engage Widget 2-->
						</div>
						<div class="col-12 col-md-5 align-middle mt-3 mt-md-0 pl-md-2 pr-md-5">
							<!--begin::Engage Widget 2-->
								<div class="d-flex p-0">
									<div class="flex-grow-1 bg-danger p-8 card-rounded bgi-no-repeat" style="background-position: calc(100% + 0.5rem) bottom; background-size: auto 70%; background-image: url({{ asset('themes/metronic/media/svg/humans/custom-3.svg') }})">
										<h3 class="text-inverse-danger mt-2 font-weight-bolder"><a href="{{ route('Customer.index', $filter) }}" class="text-inverse-danger">New Customers</a></h3>
										<h1 class="text-white" style="font-size: 3rem;">{{ $new_customers }}</h1>
									</div>
								</div>
							<!--end::Engage Widget 2-->
							<!--begin::Engage Widget 3-->
							<div class="d-flex p-0 mt-4">
								<div class="flex-grow-1 p-8 card-rounded flex-grow-1 bgi-no-repeat" style="background-color: #663259; background-position: 100% bottom; background-size: auto 70%; background-image: url({{ asset('themes/metronic/media/svg/humans/custom-4.svg') }})">
									<h3 class="text-inverse-danger mt-2 font-weight-bolder"><a href="{{ route('Customer.index', 'all_data') }}" class="text-inverse-danger">Loyal Customers</a></h3>
									<h1 class="text-white" style="font-size: 3rem;">{{ $loyal_customers }}</h1>
								</div>
							</div>
							<!--end::Engage Widget 3-->
						</div>
					</div>

					<div class="bg-white rounded p-7 my-5 shadow-sm">
						<h3>Growth</h3>
						<hr>
						<div class="row">
							<div class="col-12 col-md-4">
								<div class="bg-primary-o-50 p-5 rounded-lg">
									<h3>Revenue:</h3>
									<div class="d-flex align-items-center">
										<h2 class="m-0 text-dark font-weight-bolder">{{ $revenue_increase }}%</h2>
										<i class="fas @if($revenue_increase < 0){{'fa-arrow-down text-danger'}}@else{{'fa-arrow-up text-success'}}@endif ml-3"></i>
									</div>
								</div>
							</div>
							<div class="col-12 col-md-4 mt-3 mt-md-0">
								<div class="bg-danger-o-50 p-5 rounded-lg">
									<h3>New Customers:</h3>
									<div class="d-flex align-items-center">
										<h2 class="m-0 text-dark font-weight-bolder">{{ $new_customer_increase }}%</h2>
										<i class="fas @if($new_customer_increase < 0){{'fa-arrow-down text-danger'}}@else{{'fa-arrow-up text-success'}}@endif ml-3"></i>
									</div>
								</div>
							</div>
							<div class="col-12 col-md-4 mt-3 mt-md-0">
								<div class="bg-success-o-50 p-5 rounded-lg">
									<h3>Loyal Customers:</h3>
									<div class="d-flex align-items-center">
										<h2 class="m-0 text-dark font-weight-bolder">{{ $loyal_customer_increase }}%</h2>
										<i class="fas @if($loyal_customer_increase < 0){{'fa-arrow-down text-danger'}}@else{{'fa-arrow-up text-success'}}@endif ml-3"></i>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!--begin::Card-->
					<div class="card card-custom gutter-b mt-7 mt-lg-5">
						<div class="card-header">
							<div class="card-title">
								<h3 class="card-label">Revenue</h3>
							</div>
						</div>
						<div class="card-body">
							<!--begin::Chart-->
							<div id="revenue_chart"></div>
							<!--end::Chart-->
						</div>
					</div>
					<!--end::Card-->
																				
					<!--begin::Card-->
					<div class="card card-custom gutter-b mt-7 mt-lg-5">
						<div class="card-header">
							<div class="card-title">
								<h3 class="card-label">Customers</h3>
							</div>
						</div>
						<div class="card-body">
							<!--begin::Chart-->
							<div id="customers_chart"></div>
							<!--end::Chart-->
						</div>
					</div>
					<!--end::Card-->

					<div class="row mt-3">
						<div class="col-12">
							<!--begin::Card-->
							<div class="card card-custom gutter-b">
								<div class="card-header">
									<div class="card-title">
										<h3 class="card-label">Credits/Redeem</h3>
									</div>
								</div>
								<div class="card-body">
									<!--begin::Chart-->
									<div id="rewards_chart"></div>
									<!--end::Chart-->
								</div>
							</div>
							<!--end::Card-->
						</div>
					</div>
				</div>
			</div>
			<!--end::Container-->
		</div>
		<div class="col-12 col-lg-4">
			@include('apps.Loyalty.snippets.sidemenu')
			<div class="bg-white p-5 mt-5 rounded shadow">
				<h3 class="text-center text-muted my-3">Transactions</h3>		

				<div class="timeline timeline-1">
					<div class="timeline-sep bg-primary-opacity-20" style="left: 10.25rem;"></div>
					@foreach($reward_transactions as $r_t)
						<div class="timeline-item">
							<div class="timeline-label " style="flex: 0 0 120px">{{ $r_t->created_at ? $r_t->created_at->diffForHumans() : "" }}</div>
							<div class="timeline-badge">
								<i class="fas fa-{{ $r_t->credits != 0 ? 'piggy-bank' : 'donate'}} {{ $r_t->credits != 0 ? 'text-success' : 'text-danger' }}"></i>
							</div>
							<div class="timeline-content text-muted font-weight-normal d-flex align-items-center">
								{{ $r_t->customer->name }} {{$r_t->credits !=0 ? ' got credited': ' redeemed'}}
								<span class="label label-inline ml-2 {{ $r_t->credits != 0 ? 'label-light-success' : 'label-light-danger' }} font-weight-bolder">{{ $r_t->credits != 0 ? $r_t->credits : $r_t->redeem }}</span>
							</div>
						</div>
					@endforeach
				</div>
			</div>
		</div>
	</div>

	
		
</x-dynamic-component>