@extends('HR_Apps.layout.main')

@section('content-hr')

    <!-- Main Content -->
    <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="col mb-4">
                <h3 class="h3 mb-0 text-gray-800">Edit Profile</h3>
                <h6 class="h6 mb-0 text-gray-800">Silahkan edit data Anda pada form berikut dan isi sesuai dengan format data yang tersedia.</h6>
            </div>

            <!-- Informasi Karyawan -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-sm-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary mt-2">Informasi Karyawan</h6>
                    <div class="row float-right">
                        <div class="my-2"></div>
                        <a href="#" class="btn btn-primary mr-2 shadow-sm">
                            <span class="icon text-white-50">
                                <i class="fas fa-check"></i>
                            </span>
                            <span class="text">Simpan</span>
                        </a>
                        <div class="my-2"></div>
                        <a href="{{ url('/myProfile') }}" class="btn btn-secondary mr-3 shadow-sm">
                            <span class="icon text-white-50">
                                <i class="fas fa-ban"></i>
                            </span>
                            <span class="text">Cancel</span>
                        </a>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body container">
                    <!-- Form Edit Profile -->
                    <form action="#">
                        <div class="align-items-center">
                            <div class="form-group row">
                                <label for="user_name" class="form-label font-weight-bold col-sm-2">
                                    Nama Lengkap</label>
                                <div class="col-sm-10">
                                    <input type="text" name="user_name" class="form-control bg-light border-0 small">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="user_email" class="form-label font-weight-bold col-sm-2">
                                    Email</label>
                                <div class="col-sm-10">
                                    <input type="text" name="user_email" class="form-control bg-light border-0 small" placeholder="example@example.com">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="user_position" class="form-label font-weight-bold col-sm-2">
                                    Jabatan</label>
                                <div class="col-sm-10">
                                    <input type="text" name="user_position" class="form-control bg-light border-0 small">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="user_phone" class="form-label font-weight-bold col-sm-2">
                                    No. Telp</label>
                                <div class="col-sm-10">
                                    <input type="number" name="user_phone" class="form-control bg-light border-0 small">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="user_gender" class="form-label font-weight-bold col-sm-2">
                                    Jenis Kelamin</label>
                                <div class="col-sm-10">
                                    <select class="custom-select bg-light border-0 small" name="user_gender">
                                        <option selected>Pilih Jenis Kelamin</option>
                                        <option value="Pria">Pria</option>
                                        <option value="Wanita">Wanita</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="user_image" class="form-label font-weight-bold col-sm-2">
                                    Tambahkan Gambar</label>
                                <div class="col-sm-10">
                                    <input type="file" class="btn btn-primary btn-sm shadow-sm" name="user_image">
                                    <small class="form-text text-muted">Tipe file .png, .jgp, .jpeg</small>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- End Form -->
                </div>
                <!-- End Card Body -->
            </div>

            <!-- Informasi Perusahaan -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Perusahaan</h6>
                </div>

                <!-- Card Body -->
                <div class="card-body container">
                    <!-- Form Edit Profile -->
                    <form action="#">
                        <div class="align-items-center">
                            <div class="form-group row">
                                <label for="company_name" class="form-label font-weight-bold col-sm-2">
                                    Nama</label>
                                <div class="col-sm-10">
                                    <input type="text" name="company_name" class="form-control bg-light border-0 small">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="company_email" class="form-label font-weight-bold col-sm-2">
                                    Email</label>
                                <div class="col-sm-10">
                                    <input type="text" name="company_email" class="form-control bg-light border-0 small" placeholder="example@example.com">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="company_phone" class="form-label font-weight-bold col-sm-2">
                                    No. Telp</label>
                                <div class="col-sm-10">
                                    <input type="number" name="company_phone" class="form-control bg-light border-0 small">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="company_address" class="form-label font-weight-bold col-sm-2">
                                    Alamat</label>
                                <div class="col-sm-10">
                                    <textarea name="company_address" class="form-control bg-light border-0 small" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
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