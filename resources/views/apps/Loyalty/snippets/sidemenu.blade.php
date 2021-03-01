<div class="list-group">
	<a href="{{ route('Loyalty.dashboard') }}" class="list-group-item list-group-item-action active">Dashboard</a>
	<a href="{{ route('Customer.index', 'all_data') }}" class="list-group-item list-group-item-action">Customers</a>
	@if(Auth::user()->checkRole(['superadmin','agencyadmin','clientadmin']))
	<a href="{{ route('User.index') }}" class="list-group-item list-group-item-action">Users</a>
	<a href="{{ route('Setting.create') }}" class="list-group-item list-group-item-action">Settings</a>
	@endif
</div>