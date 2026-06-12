
<ul class="menu-nav">
	<li class="menu-item" aria-haspopup="true">
		<a href="/admin" class="menu-link">
			<span class="menu-text">Dashboard</span>
		</a>
	</li>
	@if(Auth::user()->role=='superadmin')
	<li class="menu-item menu-item-submenu menu-item-rel" data-menu-toggle="click" aria-haspopup="true">
		<a href="javascript:;" class="menu-link menu-toggle">
			<span class="menu-text">Core</span>
			<span class="menu-desc"></span>
			<i class="menu-arrow"></i>
		</a>
		<div class="menu-submenu menu-submenu-classic menu-submenu-left">
			<ul class="menu-subnav">
				<li class="menu-item menu-item-submenu" >
					<a href="/admin/agency" class="menu-link ">
						<span class="menu-text">Agencies</span>
					</a>
				</li>
				<li class="menu-item menu-item-submenu"  >
					<a href="/admin/client" class="menu-link ">
						<span class="menu-text">Clients</span>
					</a>
				</li>
			</ul>
		</div>
	</li>
	@endif
	<li class="menu-item" aria-haspopup="true">
		<a href="/admin/theme" class="menu-link">
			<span class="menu-text">Themes</span>
		</a>
	</li>
	<li class="menu-item" aria-haspopup="true">
		<a href="/admin/apps" class="menu-link">
			<span class="menu-text">Apps</span>
		</a>
	</li>
	<li class="menu-item" aria-haspopup="true">
		<a href="/admin/settings" class="menu-link">
			<span class="menu-text">Settings</span>
		</a>
	</li>
	<li class="menu-item" aria-haspopup="true">
		<a href="/logout" class="menu-link">
			<span class="menu-text">Logout</span>
		</a>
	</li>
</ul>