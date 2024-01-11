@extends('HR_Apps.layout.main')

@section('content-hr')

    <!-- Main Content -->
    <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid">
            
            <!-- Page Heading -->
            <div class="align-items-center mb-4">
                <h3 class="h3 mb-0 text-gray-800">Jadwal Piket Pegawai</h3>
                <h6 class="h6 mb-0 text-gray-800">Silahkan isi form berikut sesuai dengan format data yang tersedia.</h6>
            </div>

            <!-- Informasi Piket -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Piket</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body container">
                    <!-- Form Create Picket(s) -->
                    <form method="POST" action="{{ route('picket.store') }}">
                        @csrf
                        <div class="align-items-center">
                            <div class="form-group row">
                                <label for="employee_name" class="form-label font-weight-bold col-sm-2">
                                    Nama Karyawan</label>
                                <div class="col-sm-10">
                                    <select class="custom-select bg-light border-0 small" name="employee_id" required>
                                        <option>Pilih Karyawan</option>
                                        @foreach($employee as $emp)
                                            <option value="{{ $emp->id }}">{{ $emp->employee_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="division_name" class="form-label font-weight-bold col-sm-2">
                                    Divisi Karyawan</label>
                                <div class="col-sm-10">
                                    <select class="custom-select bg-light border-0 small" name="division_id" required>
                                        <option>Pilih Divisi</option>
                                        @foreach($division as $dvs)
                                            <option value="{{ $dvs->id }}">{{ $dvs->division_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="days" class="form-label font-weight-bold col-sm-2">
                                    Hari Piket</label>
                                <div class="col-sm-10">
                                    <select class="custom-select bg-light border-0 small" name="days" id="days" required>
                                        <option selected>Pilih Hari</option>
                                        <option value="Senin">Senin</option>
                                        <option value="Selasa">Selasa</option>
                                        <option value="Rabu">Rabu</option>
                                        <option value="Kamis">Kamis</option>
                                        <option value="Jumat">Jum'at</option>
                                        <option value="Sabtu">Sabtu</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="picket" class="form-label font-weight-bold col-sm-2">
                                    Shift</label>
                                <div class="col-sm-10">
                                    <input type="time" class="form-control bg-light border-0 small" name="picket" id="picket" required>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <button class="btn btn-primary shadow-sm float-right" type="submit">Simpan</button>
                        <a class="btn btn-danger shadow-sm float-right mr-2" href="{{ route('picket.index') }}">
                            Cancel</a>
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