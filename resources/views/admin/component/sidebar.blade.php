<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboardAdmin') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Admin Apps</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboardAdmin') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    {{-- ====================================================================================================================================================================  --}}
    {{-- ====================================================================================================================================================================  --}}
    <!-- Heading HR -->
    <div class="sidebar-heading">
        Sumber Daya Manusia (HR)
    </div>

    <!-- Nav Item - HR Apps Menu -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('hr.companyList') }}">
            <i class="fas fa-fw fa-id-badge"></i>
            <span>Daftar Perusahaan</span>
        </a>
    </li>

    <!-- Nav Item - Absensi Menu -->
    <li class="nav-item {{ Request::is('hr/absensi') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#example"
        aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-id-badge"></i>
            <span>Absensi</span>
        </a>
        <div id="example" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('absensi.index') }}">Absensi</a>
                <a class="collapse-item" href="{{ route('absensi.cetak') }}">Cetak Absensi</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Divisi Menu -->
    <li class="nav-item {{ Request::is('hr/division') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-server"></i>
            <span>Divisi</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('division.index') }}">Semua Divisi</a>
                <a class="collapse-item" href="{{ route('division.create') }}">Tambah Divisi</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Kepegawaian Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
            aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-users"></i>
            <span>Kepegawaian</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ Request::is('hr/employee') ? 'active' : '' }}" href="{{ route('employee.index') }}">Data Pegawai</a>
                <a class="collapse-item {{ Request::is('hr/history') ? 'active' : '' }}" href="{{ route('history.index') }}">Pegawai Tidak Aktif</a>
                <a class="collapse-item {{ Request::is('hr/training') ? 'active' : '' }}" href="{{ route('training.index') }}">Pelatihan Pegawai</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Jadwal Piket Menu -->
    <li class="nav-item {{ Request::is('hr/picket') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('picket.index') }}">
            <i class="fas fa-fw fa-list-alt"></i>
            <span>Jadwal Piket</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    {{-- ====================================================================================================================================================================  --}}
    {{-- ====================================================================================================================================================================  --}}
    <!-- Heading Inventory -->
    <div class="sidebar-heading">
        Manajemen Inventaris
    </div>

    <!-- Nav Item - Good Menu -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('good.index') }}">
            <i class="fas fa-fw fa-id-badge"></i>
            <span>Goods</span>
        </a>
    </li>

    <!-- Nav Item - Product Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProduct"
            aria-controls="collapseProduct">
            <i class="fas fa-fw fa-users"></i>
            <span>Produk</span>
        </a>
        <div id="collapseProduct" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ Request::is('supplier/product') ? 'active' : '' }}" href="{{ route('product.index') }}">Daftar Produk</a>
                <a class="collapse-item {{ Request::is('supplier/out') ? 'active' : '' }}" href="{{ route('out.index') }}">Produk Keluar</a>
                <a class="collapse-item {{ Request::is('supplier/retur') ? 'active' : '' }}" href="{{ route('retur.index') }}">Produk Return</a>
                <a class="collapse-item {{ Request::is('supplier/expired') ? 'active' : '' }}" href="{{ route('expired.index') }}">Produk kadaluarsa</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Report Menu -->
    <li class="nav-item">
        <a class="nav-link" href="{{ url('supplier/orderReport') }}">
            <i class="fas fa-fw fa-envelope"></i>
            <span>Order Report</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    {{-- ====================================================================================================================================================================  --}}
    {{-- ====================================================================================================================================================================  --}}
    <!-- Heading Sales -->
    <div class="sidebar-heading">
        Manajemen Pesanan
    </div>

    <!-- Nav Item - Order Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOrder"
            aria-expanded="true" aria-controls="collapseOrder">
            <i class="fas fa-fw fa-receipt"></i>
            <span>Manajemen Pesanan</span>
        </a>
        <div id="collapseOrder" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('order.index') }}">Daftar Pesanan</a>
                <a class="collapse-item" href="{{ route('report.index') }}">Laporan Pesanan</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Customer Menu -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('customer.index') }}">
            <i class="fas fa-fw fa-user"></i>
            <span>Pelanggan</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    {{-- ====================================================================================================================================================================  --}}
    {{-- ====================================================================================================================================================================  --}}
    <!-- Heading Sales -->
    <div class="sidebar-heading">
        Manajemen Keuangan
    </div>

    <!-- Nav Item - Order Menu -->
    <li class="nav-item">
        
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>