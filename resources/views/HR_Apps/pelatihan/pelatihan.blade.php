@extends('HR_Apps.layout.main')

@section('content-hr')

    <!-- Main Content -->
    <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid">
            
            <!-- Page Heading -->
            <div class="align-items-center mb-4">
                <h3 class="h3 mb-0 text-gray-800">Data Pelatihan Pegawai</h3>
                <h6 class="h6 mb-0 text-gray-800">Berikut merupakan seluruh data pelatihan yang pernah diikuti oleh karyawan yang tercatat dalam sistem.</h6>
            </div>

            <!-- DataTables Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-sm-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary mt-2">Daftar Pelatihan Karyawan</h6>
                    <a href="{{ route('training.create') }}" class="btn btn-primary mr-2 shadow-sm">
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
                                    <th>Karyawan</th>
                                    <th>Jenis Pelatihan</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($training as $trn)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>
                                            <div class="col g-3 mt-3">
                                                <h5 class="font-weight-bold">{{ $trn->employee_name }}</h5>
                                                <p>{{ $trn->division->division_name }}</p>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="my-4">{{ $trn->training_name }}</p>
                                        </td>
                                        <td>
                                            <p class="my-4">{{ $trn->startDate }}</p>
                                        </td>
                                        <td>
                                            <p class="my-4">{{ $trn->endDate }}</p>
                                        </td>
                                        <td>
                                            <a class="badge badge-warning mt-4" href="{{ route('training.show', $trn->id) }}">Details</a>
                                            <form action="{{ route('training.destroy', $trn->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="badge badge-danger border-0" value="delete" type="submit"
                                                onclick="return confirm('Anda ingin menghapus data?')">Hapus</button>
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