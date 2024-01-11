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
    <li class="nav-item {{ Request::is('finance/manage*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('finance.index') }}">
            <i class="fas fa-money-check-alt"></i>
            <span>Manajemen Keuangan</span>
        </a>
    </li>
    <li class="nav-item {{ Request::is('finance/report*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReport"
            aria-expanded="true" aria-controls="collapseOrder">
            <i class="fas fa-fw fa-receipt"></i>
            <span>Laporan Keuangan</span>
        </a>
        <div id="collapseReport" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ Request::is('finance/balance-sheet') ? 'active' : '' }}" href="{{ route('finance.balanceSheet') }}">Balance Sheet</a>
                <a class="collapse-item {{ Request::is('finance/report/cash-flow') ? 'active' : '' }}" href="{{ route('report.cashFlow') }}">Cash Flow</a>
                <a class="collapse-item {{ Request::is('finance/report/profit-loss') ? 'active' : '' }}" href="{{ route('report.profitLoss') }}">Profit & Loss</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>