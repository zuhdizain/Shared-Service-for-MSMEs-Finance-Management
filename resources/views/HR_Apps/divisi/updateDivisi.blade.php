@extends('HR_Apps.layout.main')

@section('content-hr')

    <!-- Main Content -->
    <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid">
            
            <!-- Page Heading -->
            <div class="align-items-center mb-4">
                <h3 class="h3 mb-0 text-gray-800">Edit Divisi Pegawai</h3>
                <h6 class="h6 mb-0 text-gray-800">Silahkan isi form berikut sesuai dengan format data yang tersedia.</h6>
            </div>

            <!-- Informasi Divisi -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Divisi</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body container">
                    <!-- Form Create Division(s) -->
                    <form method="POST" action="{{ route('division.update', $division->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="align-items-center">
                            <div class="form-group row">
                                <label for="division_name" class="form-label font-weight-bold col-sm-2">
                                    Nama Divisi</label>
                                <div class="col-sm-10">
                                    <input type="text" name="division_name" id="division_name" class="form-control bg-light border-0 small"
                                    value="{{ $division->division_name }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="division_payroll" class="form-label font-weight-bold col-sm-2">
                                    Gaji Divisi</label>
                                <div class="col-sm-10">
                                    <input type="number" name="division_payroll" class="form-control bg-light border-0 small"
                                    value="{{ $division->division_payroll }}">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <button class="btn btn-primary shadow-sm float-right" type="submit">Simpan</button>
                        <a href="{{ route('division.index') }}" class="btn btn-danger shadow-sm float-right mr-2">Cancel</a>
                    </form>
                    <!-- End Form -->
                </div>
                <!-- End Card Body -->
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

@endsection