@extends('HR_Apps.layout.main')

@section('content-hr')

    <!-- Main Content -->
    <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid">
            
            <!-- Page Heading -->
            <div class="align-items-center mb-4">
                <h3 class="h3 mb-0 text-gray-800">Daftar Karyawan</h3>
                <h6 class="h6 mb-0 text-gray-800">Halaman yang menampilkan seluruh data karyawan pada tiap divisi.</h6>
            </div>

            <!-- DataTables Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-sm-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-secondary mt-2">Daftar Karyawan</h6>
                    <a href="{{ route('division.index') }}" class="btn btn-secondary mr-2 shadow-sm">
                        <span class="icon text-white-50">
                            <i class="fas fa-arrow-left"></i>
                        </span>
                        <span class="text edit-sp">Kembali</span>
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Karyawan</th>
                                    <th>Kontak</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($employee as $empl)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>
                                            <div class="mt-3 my-4">
                                                <h5 class="mt-2">{{ $empl->employee_name }}</h5>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="col g-3 mt-3">
                                                <h6 class="font-weight-bold">{{ $empl->employee_email }}</h6>
                                                <p>{{ $empl->employee_phone }}</p>
                                            </div>
                                        </td>
                                        <td>
                                            <a class="badge badge-success mt-4" href="{{ route('employee.show', $empl->id) }}">Details</a>
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