<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboardFinance') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Finance Apps</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Request::is('finance/dashboardFinance*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboardFinance') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Menu Finance
    </div>
    <li class="nav-item {{ Request::is('finance/balance-sheet') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('finance.balanceSheet') }}">
            <i class="fas fa-receipt"></i>
            <span>Balance Sheet</span>
        </a>
    </li>
    <li class="nav-item {{ Request::is('finance/profit-loss') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('finance.profitLoss') }}">
            <i class="fas fa-receipt"></i>
            <span>Profit & Loss</span>
        </a>
    </li>
    <li class="nav-item {{ Request::is('finance/cash-flow') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('finance.cashFlow') }}">
            <i class="fas fa-receipt"></i>
            <span>Cash Flow</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>