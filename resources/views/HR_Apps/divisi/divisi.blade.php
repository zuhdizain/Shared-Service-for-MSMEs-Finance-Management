@extends('HR_Apps.layout.main')

@section('content-hr')

    <!-- Main Content -->
    <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid">
            
            <!-- Page Heading -->
            <div class="align-items-center mb-4">
                <h3 class="h3 mb-0 text-gray-800">Divisi Pegawai</h3>
                <h6 class="h6 mb-0 text-gray-800">Halaman yang menampilkan berbagai divisi/departemen yang ada.</h6>
            </div>

            <!-- DataTables Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-sm-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary mt-2">Divisi/Departement</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Divisi</th>
                                    <th>Gaji Divisi</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($division as $dvs)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>
                                            <h6 class="mt-2">
                                                <a href="{{ route('division.allEmpDvs', [$dvs->id]) }}">{{ $dvs->division_name }}</a>
                                            </h6>
                                        </td>
                                        <td>
                                            <h6 class="mt-2">Rp {{ $dvs->division_payroll }}</h6>
                                        </td>
                                        <td>
                                            <a href="{{ route('division.edit', $dvs->id) }}" class="btn btn-warning btn-sm shadow-sm">
                                                <i class="fas fa-pencil-alt" aria-hidden="true"></i>
                                            </a>
                                            <form action="{{ route('division.destroy', $dvs->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm shadow-sm border-0" value="delete" type="submit"
                                                onclick="return confirm('Anda ingin menghapus data?')">
                                                    <i class="fas fa-trash" aria-hidden="true"></i>
                                                </button>
                                            </form>
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