@extends('HR_Apps.layout.main')

@section('content-hr')

    <!-- Main Content -->
    <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid">
            
            <!-- Page Heading -->
            <div class="align-items-center mb-4">
                <h3 class="h3 mb-0 text-gray-800">Detail Piket</h3>
                <h6 class="h6 mb-0 text-gray-800">Berikut merupakan detail piket karyawan yang tercatat dalam sistem.</h6>
            </div>

            <!-- DataTables Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-sm-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary mt-2">Shift Karyawan</h6>
                    <a href="{{ route('picket.index') }}" class="btn btn-secondary mr-3 shadow-sm">
                        <span class="icon text-white-50">
                            <i class="fas fa-arrow-left"></i>
                        </span>
                        <span class="text">Kembali</span>
                    </a>
                </div>
                <div class="card-body">
                    <table class="table table-striped container text-center">
                        <thead>
                          <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Nama Karyawan</th>
                            <th scope="col">Divisi</th>
                            <th scope="col">Shift</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $empl)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>
                                    <p>{{ $empl->employee->employee_name }}</p>
                                </td>
                                <td>
                                    <p>{{ $empl->division->division_name }}</p>
                                </td>
                                <td>
                                    <p>{{ $empl->picket }}</p>
                                </td>
                                {{-- <td>
                                    <a class="badge badge-success mt-4" href="{{ route('employee.show', $empl->id) }}">Details</a>
                                </td> --}}
                            </tr>
                        @endforeach
                        </tbody>
                      </table>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

@endsection