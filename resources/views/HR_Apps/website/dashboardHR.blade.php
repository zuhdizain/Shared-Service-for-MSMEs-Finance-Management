@extends('HR_Apps.layout.main')

@section('content-hr')

    <!-- Main Content -->
    <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid">

            @auth
                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Selamat Datang, {{ auth()->user()->name }}!</h1>
                </div>
            @endauth 

            <!-- Content Row -->
            <div class="row">

                <!-- Jumlah Pegawai Card -->
                <div class="col mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Jumlah Pegawai</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalEmployee }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pegawai Tidak Aktif Card -->
                <div class="col mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Pegawai Tidak Aktif</div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-auto">
                                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $totalInactive }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Jumlah Divisi Card -->
                <div class="col mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Jumlah Divisi</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalDivision }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-list-alt fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Row -->
            <div class="row">

                <div class="col-lg-6 mb-3">
                    <!-- Greetings -->
                    <div class="card shadow mb-3">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Aplikasi Manajemen Data Pegawai</h6>
                        </div>
                        <div class="card-body text-center">
                            <h3>Selamat Datang di Aplikasi Manajemen Data Pegawai</h3>
                            <hr>
                            <p>Jika terdapat kendala dan pertanyaan, silahkan hubungi call center kami.</p>
                            <p>Layanan call center aktif selama jam kerja pukul 08.00 - 15.00 WIB</p>
                        </div>
                    </div>
                </div>

                <!-- Content Column -->
                <div class="col-lg-6 mb-3">
                    <!-- Employee Category -->
                    <div class="card shadow mb-3">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Kategori Karyawan</h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-pie pt-4">
                                <canvas id="myPieChart"></canvas>
                            </div>
                            <hr>
                            <div class="mt-4 text-center small">
                                <span class="mr-2">
                                    <i class="fas fa-circle text-primary"></i> Pria
                                </span>
                                <span class="mr-2">
                                    <i class="fas fa-circle text-success"></i> Wanita
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

@endsection