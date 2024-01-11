@extends('HR_Apps.layout.main')

@section('content-hr')

    <!-- Main Content -->
    <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="col mb-4">
                <h3 class="h3 mb-0 text-gray-800">Edit Data</h3>
                <h6 class="h6 mb-0 text-gray-800">Silahkan edit data pelatihan pada form berikut dan isi sesuai dengan format data yang tersedia.</h6>
            </div>

            <form method="POST" action="{{ route('training.update', $training->id) }}">
                @csrf
                @method('PUT')
                <!-- Informasi Karyawan -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-sm-flex justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary mt-2">Informasi Karyawan</h6>
                        <div class="row float-right">
                            <div class="my-2"></div>
                            <button class="btn btn-success mr-2 shadow-sm" type="submit" id="submit">
                                <span class="icon text-white-50">
                                    <i class="fas fa-check"></i>
                                </span>
                                <span class="text">Simpan</span>
                            </button>
                            <div class="my-2"></div>
                            <a href="{{ route('training.index') }}" class="btn btn-secondary mr-3 shadow-sm">
                                <span class="icon text-white-50">
                                    <i class="fas fa-ban"></i>
                                </span>
                                <span class="text">Cancel</span>
                            </a>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body container">

                        <!-- Tambah Data Karyawan -->
                        <div class="align-items-center">
                            <div class="form-group row">
                                <label for="employee_name" class="form-label font-weight-bold col-sm-2">
                                    Nama Lengkap</label>
                                <div class="col-sm-10">
                                    <input type="text" name="employee_name" id="employee_name" class="form-control bg-light border-0 small"
                                    value="{{ old('employee_name', $training->employee_name) }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="emplpyee_email" class="form-label font-weight-bold col-sm-2">
                                    Email</label>
                                <div class="col-sm-10">
                                    <input type="text" name="employee_email" id="employee_email" class="form-control bg-light border-0 small" 
                                    placeholder="example@example.com" value="{{ old('employee_email', $training->employee_email) }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="employee_position" class="form-label font-weight-bold col-sm-2">
                                    Jabatan</label>
                                <div class="col-sm-10">
                                    <input type="text" name="employee_position" id="employee_position" class="form-control bg-light border-0 small"
                                    value="{{ old('employee_position', $training->employee_position) }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="division_name" class="form-label font-weight-bold col-sm-2">Divisi</label>
                                <div class="col-sm-10">
                                    <select class="custom-select bg-light border-0 small" name="division_id">
                                        <option>Pilih Divisi Karyawan</option>
                                        @foreach($division as $dvs)
                                            <option value="{{ $dvs->id }}">{{ $dvs->division_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Card Body -->
                </div>

                <!-- Informasi Pelatihan -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Informasi Pelatihan</h6>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body container">
                        <!-- Form Informasi Pelatihan -->
                        <div class="align-items-center">
                            <div class="form-group row">
                                <label for="training_name" class="form-label font-weight-bold col-sm-2">
                                    Jenis Pelatihan</label>
                                <div class="col-sm-10">
                                    <input type="text" name="training_name" id="training_name" class="form-control bg-light border-0 small"
                                    value="{{ old('training_name', $training->training_name) }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="training_institute" class="form-label font-weight-bold col-sm-2">
                                    Penyelenggara</label>
                                <div class="col-sm-10">
                                    <input type="text" name="training_institute" id="training_institute" class="form-control bg-light border-0 small"
                                    value="{{ old('training_institute', $training->training_institute) }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="startDate" class="form-label font-weight-bold col-sm-2">
                                    Tanggal Dimulai</label>
                                <div class="col-sm-10">
                                    <input type="date" name="startDate" id="startDate" class="form-control bg-light border-0 small"
                                    value="{{ old('startDate', $training->startDate) }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="endDate" class="form-label font-weight-bold col-sm-2">
                                    Tanggal Selesai</label>
                                <div class="col-sm-10">
                                    <input type="date" name="endDate" id="endDate" class="form-control bg-light border-0 small"
                                    value="{{ old('endDate', $training->endDate) }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="training_phone" class="form-label font-weight-bold col-sm-2">
                                    No. Telp</label>
                                <div class="col-sm-10">
                                    <input type="number" name="training_phone" id="training_phone" class="form-control bg-light border-0 small"
                                    value="{{ old('training_phone', $training->training_phone) }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="training_email" class="form-label font-weight-bold col-sm-2">
                                    Alamat Email</label>
                                <div class="col-sm-10">
                                    <input type="text" name="training_email" id="training_email" class="form-control bg-light border-0 small"
                                    value="{{ old('training_email', $training->training_email) }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="training_fee" class="form-label font-weight-bold col-sm-2">
                                    Biaya Pelatihan</label>
                                <div class="col-sm-10">
                                    <input type="number" name="training_fee" id="training_fee" class="form-control bg-light border-0 small"
                                    value="{{ old('training_fee', $training->training_fee) }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="training_address" class="form-label font-weight-bold col-sm-2">
                                    Alamat Pelatihan</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control bg-light border-0 small" name="training_address" rows="3">{{ old('training_address', $training->training_address) }}
                                    </textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- End Card Body -->

                </div>

            </form>
            <!-- End Form -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

@endsection