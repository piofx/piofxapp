<nav class="navbar navbar-dark bg-dark d-block d-lg-none">
  <div class="container-fluid">
    <a class="navbar-brand" href="#"><img src="{{ asset('img/logos/piofx-white.png') }}" class="w-50"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse mt-3" id="navbarTogglerDemo02">
		<a href="{{ route('Dashboard') }}" class="nav-link text-decoration-none text-white pl-0 py-2">Dashboard</a>
		<a href="{{ route('Reward.public') }}" class="nav-link text-decoration-none text-white pl-0 py-2">Rewards</a>
		<a href="{{ route('Customer.index') }}" class="nav-link text-decoration-none text-white pl-0 py-2">Customers</a>
		<!-- Begin Login, Register -->
		@if (Route::has('login'))
			<div class="d-flex justify-content-between align-items-center mt-1 mb-3">
				@auth
					<div class="nav-item mr-3">
						<form method="POST" action="{{ route('logout') }}">
							@csrf
							<a href="#" class="btn btn-light-danger font-weight-bold mr-2"  onclick="event.preventDefault();
													this.closest('form').submit();">
								Logout
							</a>
						</form>
					</div>
				@else
					<a href="{{ route('login') }}" class="btn btn-primary">Login</a>

					@if (Route::has('register'))
						<a href="{{ route('register') }}" class="btn btn-dark ml-4 ">Register</a>
					@endif
				@endauth
			</div>
		@endif
		<!-- End Login, Register -->
    </div>
  </div>
</nav>