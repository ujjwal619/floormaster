<header class="header header-menu">
	<div class="header__inner">
		<nav class="header__navigation">
			<!--Menu-->
			<ul class="menu clearfix">
				<li class="menu-item">
					<a href="#" class="menu-link">Functions</a>
					<ul class="nav__submenu">
						<li class="nav__submenu-item"><a href="#">Menu Map</a></li>
					</ul>
				</li>
				
				<li class="menu-item">
					<a href="#" class="menu-link">Jobs</a>
					<ul class="nav__submenu">
						<li class="nav__submenu-item"><a href="{{ route('admin.jobs.index') }}">Jobs</a></li>
						<li class="nav__submenu-item"><a href="{{ route('admin.quotes.index') }}">Quotes</a></li>

						<li class="nav__submenu-item"><a href="{{ route('admin.templates.index') }}">Costing Template</a></li>
						<li class="nav__submenu-item"><a href="{{ route('admin.installation-complaints.index') }}">Installation Complaint</a></li>
					</ul>
				</li>
				<li class="menu-item"><a href="#" class="menu-link">Creditors</a></li>
				<li class="menu-item"><a href="#" class="menu-link">General Ledger</a></li>
				<li class="menu-item"><a href="#" class="menu-link">Stock</a></li>
        <li class="menu-item"><a href="{{ route('admin.bookings.index') }}" class="menu-link">Bookings</a></li>
				<li class="menu-item"><a href="{{ route('admin.products.index') }}" class="menu-link">Products</a></li>
				<li class="menu-item"><a href="#" class="menu-link">Faxes</a></li>
				<li class="menu-item">
					<a href="#" class="menu-link">Support</a>
				</li>
			</ul>
			<!--End Menu-->
		</nav>
	</div>
</header>
