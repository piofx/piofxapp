@auth
	@if(Auth::user()->role=='clientadmin' || Auth::user()->role=='clientmoderator')
	<div class="list-group mb-4">
	  <a href="/admin/blog/create?template=none" class="list-group-item list-group-item-warning list-group-item-action"><i class="fa fa-edit"></i> Write Blog</a>
	  <a href="/logout" class="list-group-item list-group-item-warning list-group-item-action apiuser" data-user="1"><i class="fa fa-sign-out-alt"></i> Logout</a>
	</div>
	@else
	<a href="/logout" class="btn btn-sm btn-danger w-100 mb-3">Logout</a>
	@endif
@else
<a href="/login" class="btn btn-sm btn-danger w-100 mb-3 apiuser" data-user="0">Login</a>
@endauth