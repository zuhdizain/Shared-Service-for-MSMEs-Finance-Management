@extends('HR_Apps.layout.main')

@section('content-hr')

    <!-- Main Content -->
    <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="col mb-4">
                <h3 class="h3 mb-0 text-gray-800">Tambah Data</h3>
                <h6 class="h6 mb-0 text-gray-800">Silahkan tambah data karyawan pada form berikut dan isi sesuai dengan format data yang tersedia.</h6>
            </div>

            <form method="POST" action="{{ route('history.store') }}" enctype="multipart/form-data">
                @csrf
                <!-- Informasi Karyawan -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-sm-flex justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary mt-2">Informasi Karyawan</h6>
                        <div class="row float-right">
                            <div class="my-2"></div>
                            <button class="btn btn-primary mr-2 shadow-sm" type="submit" id="submit">
                                <span class="icon text-white-50">
                                    <i class="fas fa-check"></i>
                                </span>
                                <span class="text">Simpan</span>
                            </button>
                            <div class="my-2"></div>
                            <a href="{{ route('history.index') }}" class="btn btn-secondary mr-3 shadow-sm">
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
                                <label for="name" class="form-label font-weight-bold col-sm-2">
                                    Nama Lengkap</label>
                                <div class="col-sm-10">
                                    <input type="text" name="name" id="name" class="form-control bg-light border-0 small"
                                    value="{{ old('name') }}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="form-label font-weight-bold col-sm-2">
                                    Email</label>
                                <div class="col-sm-10">
                                    <input type="text" name="email" id="email" class="form-control bg-light border-0 small" 
                                    placeholder="example@example.com" value="{{ old('email') }}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="position" class="form-label font-weight-bold col-sm-2">
                                    Jabatan</label>
                                <div class="col-sm-10">
                                    <input type="text" name="position" id="position" class="form-control bg-light border-0 small"
                                    value="{{ old('position') }}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="division" class="form-label font-weight-bold col-sm-2">
                                    Divisi</label>
                                <div class="col-sm-10">
                                    <select class="custom-select bg-light border-0 small" name="division_id" required>
                                        <option>Pilih Divisi Karyawan</option>
                                        @foreach($division as $dvs)
                                            <option value="{{ $dvs->id }}">{{ $dvs->division_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="phone" class="form-label font-weight-bold col-sm-2">
                                    No. Telp</label>
                                <div class="col-sm-10">
                                    <input type="number" name="phone" id="phone" class="form-control bg-light border-0 small" 
                                    placeholder="ex. 081255566" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="gender" class="form-label font-weight-bold col-sm-2">
                                    Jenis Kelamin</label>
                                <div class="col-sm-10">
                                    <select class="custom-select bg-light border-0 small" name="gender" id="gender" required>
                                        <option selected>Pilih Jenis Kelamin</option>
                                        <option value="Pria">Pria</option>
                                        <option value="Wanita">Wanita</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="religion" class="form-label font-weight-bold col-sm-2">
                                    Agama</label>
                                <div class="col-sm-10">
                                    <input type="text" name="religion" id="religion" class="form-control bg-light border-0 small"
                                    value="{{ old('religion') }}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="age" class="form-label font-weight-bold col-sm-2">
                                    Umur</label>
                                <div class="col-sm-10">
                                    <input type="number" name="age" id="age" class="form-control bg-light border-0 small" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="marriage" class="form-label font-weight-bold col-sm-2">
                                    Status Pernikahan</label>
                                <div class="col-sm-10">
                                    <select class="custom-select bg-light border-0 small" name="marriage" id="marriage" required>
                                        <option selected>Pilih Status Pernikahan</option>
                                        <option value="Menikah">Menikah</option>
                                        <option value="Belum Menikah">Belum Menikah</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="child" class="form-label font-weight-bold col-sm-2">
                                    Anak</label>
                                <div class="col-sm-10">
                                    <input type="number" name="child" id="child" class="form-control bg-light border-0 small" 
                                    placeholder="Jika tidak ada isi 0" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="status" class="form-label font-weight-bold col-sm-2">
                                    Status Karyawan</label>
                                <div class="col-sm-10">
                                    <select class="custom-select bg-light border-0 small" name="status" id="status" required>
                                        <option selected>Pilih Status Karyawan</option>
                                        <option value="Karyawan Tetap">Karyawan Tetap</option>
                                        <option value="Magang">Magang</option>
                                        <option value="Keluar">Resign</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="acceptanceDate" class="form-label font-weight-bold col-sm-2">
                                    Tanggal Diterima</label>
                                <div class="col-sm-10">
                                    <input type="date" name="acceptanceDate" id="acceptanceDate" class="form-control bg-light border-0 small" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="outDate" class="form-label font-weight-bold col-sm-2">
                                    Tanggal Keluar</label>
                                <div class="col-sm-10">
                                    <input type="date" name="outDate" id="outDate" class="form-control bg-light border-0 small" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="hospitalChart" class="form-label font-weight-bold col-sm-2">
                                    Riwayat Penyakit</label>
                                <div class="col-sm-10">
                                    <input type="text" name="hospitalChart" id="hospitalChart" class="form-control bg-light border-0 small" 
                                    placeholder="Jika tidak ada isi 'Tidak Ada'" value="{{ old('hospitalChart') }}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="address" class="form-label font-weight-bold col-sm-2">
                                    Alamat</label>
                                <div class="col-sm-10">
                                    <textarea name="address" id="address" class="form-control bg-light border-0 small" rows="3" 
                                    value="{{ old('address') }}" required></textarea>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <!-- End Card Body -->
                </div>

                <!-- Alasan Pengunduran -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Info Tambahan Karyawan</h6>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body container">
                        <!-- Form Alasan Pengunduran -->
                        <div class="align-items-center">
                            <div class="form-group row">
                                <label for="statement" class="form-label font-weight-bold col-sm-2">
                                    Alasan Tidak Aktif</label>
                                <div class="col-sm-10">
                                    <textarea name="statement" id="statement" class="form-control bg-light border-0 small" rows="3"
                                    value="{{ old('statement') }}"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="severancePay" class="form-label font-weight-bold col-sm-2">
                                    Jumlah Pesangon</label>
                                <div class="col-sm-10">
                                    <input type="number" name="severancePay" id="severancePay" class="form-control bg-light border-0 small" placeholder="ex. 15000000">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="statementLetter" class="form-label font-weight-bold col-sm-2">
                                    Surat Keterangan</label>
                                <div class="col-sm-10">
                                    <input type="file" class="btn btn-primary btn-sm shadow-sm @error('statementLetter') is-invalid @enderror" 
                                    name="statementLetter" id="statementLetter">
                                    @error('statementLetter')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <small class="form-text text-muted">Tipe file .pdf, .txt</small>
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