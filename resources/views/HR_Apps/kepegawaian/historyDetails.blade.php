@extends('HR_Apps.layout.main')

@section('content-hr')

    <!-- Main Content -->
    <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="col mb-4">
                <h3 class="h3 mb-0 text-gray-800">Detail Data</h3>
                <h6 class="h6 mb-0 text-gray-800">Berikut merupakan detail data karyawan yang pernah bekerja namun tidak aktif.</h6>
            </div>

            <!-- Informasi Karyawan -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-sm-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary mt-2">Informasi Karyawan</h6>
                    <div class="row float-right">
                        <div class="my-2"></div>
                        <a href="{{ route('history.index') }}" class="btn btn-secondary mr-3 shadow-sm">
                            <span class="icon text-white-50">
                                <i class="fas fa-arrow-left"></i>
                            </span>
                            <span class="text">Kembali</span>
                        </a>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body container">

                    <!-- Tambah Data Karyawan -->
                    <div class="align-items-center">
                        <div class="form-group row">
                            <label for="name" class="form-label font-weight-bold col-sm-2">
                                Nama Lengkap</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" id="name" class="form-control bg-light border-0 small"
                                value="{{ $histories->name }}" readonly disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="form-label font-weight-bold col-sm-2">
                                Email</label>
                            <div class="col-sm-10">
                                <input type="text" name="email" id="email" class="form-control bg-light border-0 small" 
                                value="{{ $histories->email }}" readonly disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="position" class="form-label font-weight-bold col-sm-2">
                                Jabatan</label>
                            <div class="col-sm-10">
                                <input type="text" name="position" id="position" class="form-control bg-light border-0 small"
                                value="{{ $histories->position }}" readonly disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="division" class="form-label font-weight-bold col-sm-2">
                                Divisi</label>
                            <div class="col-sm-10">
                                <input type="text" name="division" id="division" class="form-control bg-light border-0 small"
                                value="{{ $histories->division->division_name }}" readonly disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="phone" class="form-label font-weight-bold col-sm-2">
                                No. Telp</label>
                            <div class="col-sm-10">
                                <input type="text" name="phone" id="phone" class="form-control bg-light border-0 small" 
                                value="{{ $histories->phone }}" disabled readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="gender" class="form-label font-weight-bold col-sm-2">
                                Jenis Kelamin</label>
                            <div class="col-sm-10">
                                <input type="text" name="gender" id="gender" class="form-control bg-light border-0 small" 
                                value="{{ $histories->gender }}" disabled readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="religion" class="form-label font-weight-bold col-sm-2">
                                Agama</label>
                            <div class="col-sm-10">
                                <input type="text" name="religion" id="religion" class="form-control bg-light border-0 small"
                                value="{{ $histories->religion }}" disabled readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="age" class="form-label font-weight-bold col-sm-2">
                                Umur</label>
                            <div class="col-sm-10">
                                <input type="text" name="age" id="age" class="form-control bg-light border-0 small"
                                value="{{ $histories->age }}" disabled readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="marriage" class="form-label font-weight-bold col-sm-2">
                                Status Pernikahan</label>
                            <div class="col-sm-10">
                                <input type="text" name="marriage" id="marriage" class="form-control bg-light border-0 small" 
                                value="{{ $histories->marriage }}" disabled readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="child" class="form-label font-weight-bold col-sm-2">
                                Anak</label>
                            <div class="col-sm-10">
                                <input type="text" name="child" id="child" class="form-control bg-light border-0 small" 
                                value="{{ $histories->child }}" disabled readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="status" class="form-label font-weight-bold col-sm-2">
                                Status Karyawan</label>
                            <div class="col-sm-10">
                                <input type="text" name="status" id="status" class="form-control bg-light border-0 small" 
                                value="{{ $histories->status }}" disabled readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="acceptanceDate" class="form-label font-weight-bold col-sm-2">
                                Tanggal Diterima</label>
                            <div class="col-sm-10">
                                <input type="text" name="acceptanceDate" id="acceptanceDate" class="form-control bg-light border-0 small" 
                                value="{{ $histories->acceptanceDate }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="outDate" class="form-label font-weight-bold col-sm-2">
                                Tanggal Keluar</label>
                            <div class="col-sm-10">
                                <input type="text" name="outDate" id="outDate" class="form-control bg-light border-0 small"
                                value="{{ $histories->outDate }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="hospitalChart" class="form-label font-weight-bold col-sm-2">
                                Riwayat Penyakit</label>
                            <div class="col-sm-10">
                                <input type="text" name="hospitalChart" id="hospitalChart" class="form-control bg-light border-0 small" 
                                value="{{ $histories->hospitalChart }}" disabled readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="address" class="form-label font-weight-bold col-sm-2">
                                Alamat</label>
                            <div class="col-sm-10">
                                <textarea name="address" id="address" class="form-control bg-light border-0 small" rows="3" 
                                disabled readonly>{{ $histories->address }}</textarea>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <!-- End Card Body -->
            </div>

            <!-- Alasan Pengunduran -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Tambahan</h6>
                </div>

                <!-- Card Body -->
                <div class="card-body container">
                    <!-- Form Alasan Pengunduran -->
                    <div class="align-items-center">
                        <div class="form-group row">
                            <label for="statement" class="form-label font-weight-bold col-sm-2">
                                Penyebab Keluar</label>
                            <div class="col-sm-10">
                                <textarea name="statement" id="statement" class="form-control bg-light border-0 small" rows="3"
                                disabled readonly>{{ $histories->statement }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="severancePay" class="form-label font-weight-bold col-sm-2">
                                Jumlah Pesangon</label>
                            <div class="col-sm-10">
                                <input type="text" name="severancePay" id="severancePay" class="form-control bg-light border-0 small"
                                value="{{ $histories->severancePay }}" disabled readonly>
                            </div>
                        </div>
                        <div class="form-group mt-2">
                            <small class="form-text text-muted">Lihat Surat Disini</small>
                            <a for="statementLetter" href="files/{{ $histories->statementLetter }}" class="form-label font-weight-bold">
                                Surat Keterangan
                            </a>
                        </div>
                    </div>

                </div>
                <!-- End Card Body -->

            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

@endsection