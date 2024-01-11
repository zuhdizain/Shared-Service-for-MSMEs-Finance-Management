@extends('HR_Apps.layout.main')

@section('content-hr')

    <!-- Main Content -->
    <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid">
            
            <!-- Page Heading -->
            <div class="align-items-center mb-4">
                <h3 class="h3 mb-0 text-gray-800">Jadwal Piket</h3>
                <h6 class="h6 mb-0 text-gray-800">Berikut merupakan jadwal piket karyawan yang tercatat dalam sistem.</h6>
            </div>

            <!-- DataTables Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-sm-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary mt-2">Daftar Piket</h6>
                    <a href="{{ route('picket.create') }}" class="btn btn-primary mr-2 shadow-sm">
                        <span class="icon text-white-50">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span class="text edit-sp">Tambah Data</span>
                    </a>
                </div>
                <div class="card-body">
                    <table class="table table-striped container text-center">
                        <thead>
                          <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Hari</th>
                            <th scope="col">Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>
                                    <p>Senin</p>
                                </td>
                                <td>
                                    <a class="badge badge-success" href="{{ route('picket.allEmp', ["Senin"]) }}">Details</a>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>
                                    <p>Selasa</p>
                                </td>
                                <td>
                                    <a class="badge badge-success" href="{{ route('picket.allEmp', ["Selasa"]) }}">Details</a>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>
                                    <p>Rabu</p>
                                </td>
                                <td>
                                    <a class="badge badge-success" href="{{ route('picket.allEmp', ["Rabu"]) }}">Details</a>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">4</th>
                                <td>
                                    <p>Kamis</p>
                                </td>
                                <td>
                                    <a class="badge badge-success" href="{{ route('picket.allEmp', ["Kamis"]) }}">Details</a>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">5</th>
                                <td>
                                    <p>Jumat</p>
                                </td>
                                <td>
                                    <a class="badge badge-success" href="{{ route('picket.allEmp', ["Jumat"]) }}">Details</a>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">6</th>
                                <td>
                                    <p>Sabtu</p>
                                </td>
                                <td>
                                    <a class="badge badge-success" href="{{ route('picket.allEmp', ["Sabtu"]) }}">Details</a>
                                </td>
                            </tr>
                        </tbody>
                      </table>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

@endsection