@extends('HR_Apps.layout.main')

@section('content-hr')

    <!-- Main Content -->
    <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid">
            
            <!-- Page Heading -->
            <div class="align-items-center mb-4">
                <h3 class="h3 mb-0 text-gray-800">Data Pegawai</h3>
                <h6 class="h6 mb-0 text-gray-800">Berikut merupakan seluruh data karyawan yang tercatat dalam sistem.</h6>
            </div>

            <!-- DataTables Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-sm-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary mt-2">Daftar Karyawan</h6>
                    <a href="{{ route('employee.create') }}" class="btn btn-primary mr-2 shadow-sm">
                        <span class="icon text-white-50">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span class="text edit-sp">Tambah Data</span>
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Foto</th>
                                    <th>Karyawan</th>
                                    <th>Kontak</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $empl)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>
                                            <img src="{{ asset('storage/'.$empl->employee_image) }}" alt="Profile pict" 
                                            class="img-fluid picture text-center my-2" style="width:85px; height:85px"></img>
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col py-3 font">
                                                    <h5 class="font-weight-bold">{{ $empl->employee_name }}</h5>
                                                    <p>{{ $empl->division->division_name }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="col g-3 mt-3">
                                                <h6 class="font-weight-bold">{{ $empl->employee_email }}</h6>
                                                <p>(+62) {{ $empl->employee_phone }}</p>
                                            </div>
                                        </td>
                                        <td>
                                            <a class="badge badge-warning mt-4" href="{{ route('employee.edit', $empl->id) }}">Edit</a>
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