@extends('HR_Apps.layout.main')

@section('content-hr')

    <!-- Main Content -->
    <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid">
            
            <!-- Page Heading -->
            <div class="align-items-center mb-4">
                <h3 class="h3 mb-0 text-gray-800">Absensi Pegawai</h3>
                <h6 class="h6 mb-0 text-gray-800">Berikut merupakan seluruh data karyawan yang tercatat dalam sistem.</h6>
            </div>

            <!-- DataTables Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-sm-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary mt-2">Daftar Karyawan</h6>
                    <div class="row float-right">
                        <div class="my-2"></div>
                        <a href="{{ route('absensi.create') }}" class="btn btn-primary mr-2 shadow-sm">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus"></i>
                            </span>
                            <span class="text edit-sp">Tambah Data</span>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Karyawan</th>
                                    <th>Kontak</th>
                                    <th>Tanggal</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($attendee as $atd)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>
                                            <h6 class="font-weight-bold">{{ $atd->employee->employee_name }}</h6>
                                            <p>{{ $atd->division->division_name }}</p>
                                        </td>
                                        <td>
                                            <h6 class="font-weight-bold">{{ $atd->employee->employee_email }}</h6>
                                            <p>(+62) {{ $atd->employee->employee_phone }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $atd->date }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $atd->description }}</p>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

@endsection