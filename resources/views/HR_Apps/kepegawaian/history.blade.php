@extends('HR_Apps.layout.main')

@section('content-hr')

    <!-- Main Content -->
    <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid">
            
            <!-- Page Heading -->
            <div class="align-items-center mb-4">
                <h6 class="h3 mb-0 text-gray-800">Pegawai Tidak Aktif</h6>
                <h6 class="h6 mb-0 text-gray-800">Berikut merupakan list data karyawan yang telah keluar dan resign.</h6>
            </div>

            <!-- DataTables Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-sm-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary mt-2">Daftar Karyawan</h6>
                    <a href="{{ route('history.create') }}" class="btn btn-primary mr-2 shadow-sm">
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
                                    <th>Kontak</th>
                                    <th>Tanggal Keluar</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($histories as $hst)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>
                                            <div class="col g-3 mt-3">
                                                <h5 class="font-weight-bold">{{ $hst->name }}</h5>
                                                <p>{{ $hst->division->division_name }}</p>
                                            </div>                                            
                                        </td>
                                        <td>
                                            <div class="col g-3 mt-3">
                                                <h6 class="font-weight-bold">{{ $hst->email }}</h6>
                                                <p>(+62) {{ $hst->phone }}</p>
                                            </div>
                                        </td>
                                        <td>
                                            <h6 class="font-weight-bold mt-4">{{ $hst->outDate }}</h6>
                                        </td>
                                        <td>
                                            <a class="badge badge-success mt-3" href="{{ route('history.show', $hst->id) }}">Details</a>
                                            <form action="{{ route('history.destroy', $hst->id) }}" method="POST">
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