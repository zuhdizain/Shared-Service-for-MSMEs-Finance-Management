@extends('HR_Apps.layout.main')

@section('content-hr')

    <!-- Main Content -->
    <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid">
            
            <!-- Page Heading -->
            <div class="align-items-center mb-4">
                <h3 class="h3 mb-0 text-gray-800">Unduh Absensi</h3>
                <h6 class="h6 mb-0 text-gray-800">Berikut merupakan seluruh data absensi pada hari ini.</h6>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3 d-sm-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary mt-2">Daftar Absensi</h6>
                </div>
                <div class="card-body">
                    {{-- <form action="{{ route('absensi.pertanggal') }}" method="POST">
                        @csrf --}}
                        <div class="form-group row">
                            <label for="tanggal_awal" class="form-label font-weight-bold col-sm-2">Tanggal Awal</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control bg-light border-0 small" name="tglawal" id="tglawal">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tanggal_akhir" class="form-label font-weight-bold col-sm-2">Tanggal Akhir</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control bg-light border-0 small" name="tglakhir" id="tglakhir">
                            </div>
                        </div>
                    {{-- </form> --}}
                    <hr>
                    <a class="btn btn-warning shadow-sm float-right" href=""
                    onclick="this.href='/hr/cetak-pegawai-pertanggal/'+ document.getElementById('tglawal').value +
                    '/' + document.getElementById('tglakhir').value" target="_blank">
                        <span class="icon text-white-50">
                            <i class="fas fa-download"></i>
                        </span>
                        <span class="text edit-sp">Unduh Data</span>
                    </a>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

@endsection