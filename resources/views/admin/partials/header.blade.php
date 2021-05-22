<header class="header header-menu">
  <div class="header__inner">
    <nav class="header__navigation">
      <ul class="menu clearfix col-8">
        <li class="menu-item {{ getSubMenuClassName('admin.dashboard') }}"><a href="#" class="menu-link">Functions</a>
          <ul class="nav__submenu">
            <li class="nav__submenu-item"><a href="{{ route('admin.dashboard') }}">Menu Map</a></li>
            <li class="nav__submenu-item"><a href="{{ route('admin.setup.index') }}"
                                             class="menu-link">Setup</a></li>
            <li class="nav__submenu-item">
              <a href="/security" class="menu-link">Security</a>
            </li>
            <li class="nav__submenu-item"><a href="javascript:void(0)"
                                             onclick="event.preventDefault(); document.getElementById('logout-form').submit()"
                                             class="menu-link">
                Logout
              </a>
            </li>
          </ul>
        </li>

        <li class="menu-item {{ getSideBarClassName('quotes') }}">
          <a href="#" class="menu-link">Jobs</a>
          <ul class="nav__submenu">
            @can('client.access')
            <li class="nav__submenu-item"><a href="/clients">Clients</a></li>
            @endcan
            @can('quote.access')
            <li class="nav__submenu-item"><a href="{{ route('admin.quotes.index') }}">Quotes</a></li>
            @endcan
            @can('job.access')
            <li class="nav__submenu-item"><a href="{{ route('admin.jobs.index') }}">Jobs</a></li>
            @endcan
            @can('job.access.wip.report')
            <li class="nav__submenu-item"><a href="/work-in-progress">Work In Progress</a></li>
            @endcan
            <li class="nav__submenu-item"><a href="/memos">Active Memos</a></li>
            @can('billing.access')
            <li class="nav__submenu-item"><a href="/billings">Billing</a></li>
            @endcan
            @can('job.template')
            <li class="nav__submenu-item"><a href="/costing-templates">Costing Templates</a></li>
            @endcan
            @can('customer.complaints')
            <li class="nav__submenu-item">
              <a href="{{ route('admin.installation-complaints.index') }}">
                Installation Complaint
              </a>
            </li>
            @endcan
            @can('terms.access')
            <li class="nav__submenu-item"><a href="/terms">Terms</a></li>
            @endcan
            @can('contractors')
            <li class="nav__submenu-item"><a href="{{ route('admin.contractors.index') }}">Contractors</a></li>
            @endcan
          </ul>
        </li>

        <li class="menu-item">
          <a href="#" class="menu-link">Creditors</a>
          <ul class="nav__submenu">
            @can('suppliers')
            <li class="nav__submenu-item {{ getSideBarClassName('suppliers') }}">
              <a href="{{ route('admin.suppliers.index') }}">Suppliers</a>
            </li>
            @endcan
            @can('orders')
            <li class="nav__submenu-item"><a href="{{ route('admin.currentOrders.redirect') }}">Current Orders</a></li>
            @endcan
            @can('payables')
            <li class="nav__submenu-item"><a href="/payables">Payables</a></li>
            @endcan
            <li class="nav__submenu-item"><a href="/delivered-orders">Delivered Orders</a></li>
          </ul>
        </li>
        <li class="menu-item">
          <a href="#" class="menu-link">General Ledger</a>
          <ul class="nav__submenu">
            @can('account.chart')
            <li class="nav__submenu-item"><a href="{{ route('admin.accounts.index') }}">Chart of Accounts</a></li>
            @endcan
            @can('cheque.butt')
            <li class="nav__submenu-item"><a href="/cheque-butt">Cheque Butt</a></li>
            @endcan
            @can('cash.book')
            <li class="nav__submenu-item"><a href="/cash-book">Cash Book</a></li>
            @endcan
            <li class="nav__submenu-item"><a href="/bank-reconciliation">Bank Reconciliation</a></li>
            <li class="nav__submenu-item"><a href="/transaction-journals">Transaction Journal</a></li>
          </ul>
        </li>
        <li class="menu-item {{ getSideBarClassName('quotes') }}">
          <a href="#" class="menu-link">Stocks</a>
          <ul class="nav__submenu">
            <li class="nav__submenu-item"><a href="/action-required">Action Required</a></li>
            <li class="nav__submenu-item"><a href="{{ route('admin.stocks.redirect') }}" class="menu-link">Stocks</a>
            </li>
            <li class="nav__submenu-item"><a href="/stock-allocations">Allocations</a></li>
          </ul>
        </li>
        @can('bookings.access')
        <li class="menu-item"><a href="{{ route('admin.bookings.index') }}" class="menu-link">Bookings</a></li>
        @endcan
        <li class="menu-item {{ getSideBarClassName('products') }}">
          <a href="#" class="menu-link">Products</a>
          <ul class="nav__submenu">
            <li class="nav__submenu-item"><a href="{{ route('admin.products.index') }}">Price List and Sampling</a></li>
          </ul>
        </li>
        <li class="menu-item {{ getSideBarClassName('reports') }}">
          <a href="#" class="menu-link">Reports</a>
          <ul class="nav__submenu">
            <li class="nav__submenu-item"><a href="/reports/job">Job</a></li>
            <li class="nav__submenu-item"><a href="/reports/supplier">Suppliers</a></li>
            <li class="nav__submenu-item"><a href="/reports/product">Products</a></li>
          </ul>
        </li>
        <li class="menu-item"><a href="#" class="menu-link">Faxes</a></li>
        <li class="menu-item"><a href="#" class="menu-link">Support</a></li>
      </ul>
      <div class="col-4 text-right">Hi, {{ Auth::user()->username }}!</div>
    </nav>
  </div>
</header>

{!! Form::open([
	'url' => route('auth.logout'),
	'method' => 'post',
	'id' => 'logout-form',
	'style' => 'display:none;'
]) !!}
{!! Form::close() !!}
