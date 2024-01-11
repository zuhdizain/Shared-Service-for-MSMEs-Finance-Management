@extends('Inventory_Apps.layout.main')

@section('content-inventory')

    <!-- Main Content -->
    <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="align-items-center mb-4">
                <h3 class="h3 mb-0 text-gray-800">My Profile</h3>
            </div>

            <!-- Informasi Karyawan -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-sm-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary mt-2">Informasi Karyawan</h6>
                    <a href="#" class="btn btn-warning mr-2 shadow-sm">
                        <span class="icon text-white-50">
                            <i class="fas fa-pencil-alt"></i>
                        </span>
                        <span class="text edit-sp">Edit</span>
                    </a>
                </div>
                @auth
                    <div class="card-body row">
                        <div class="col text-center py-2 picture">
                            @if (auth()->user()->user_image)
                                <img src="{{ asset('storage/' . auth()->user()->user_image) }}" alt="Profile pict" class="img-fluid rounded">
                            @else
                                <img src="{{ asset('template/img/undraw_profile_3.svg') }}" alt="Profile pict" class="img-fluid rounded">
                            @endif
                        </div>

                        <div class="row container align-items-center">
                            <div class="col-md-6">
                                <div class="row g-3">
                                    <label for="user_name" class="col-md-3 col-form-label font-weight-bold">Nama</label>
                                    <div class="col-md-9">
                                        <input type="text" disabled readonly class="form-control-plaintext" value="{{ auth()->user()->name }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row g-3">
                                    <label for="employee_email" class="col-md-3 col-form-label font-weight-bold">Email</label>
                                    <div class="col-md-9">
                                        <input type="text" disabled readonly class="form-control-plaintext" value="{{ auth()->user()->email }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row g-3">
                                    <label for="employee_level" class="col-md-3 col-form-label font-weight-bold">Jabatan</label>
                                    <div class="col-md-9">
                                        <input type="text" disabled readonly class="form-control-plaintext" value="{{ auth()->user()->position }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row g-3">
                                    <label for="employee_phone" class="col-md-3 col-form-label font-weight-bold">No. Telp</label>
                                    <div class="col-md-9">
                                        <input type="text" disabled readonly class="form-control-plaintext" value="(+62) {{ auth()->user()->phone }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row g-3">
                                    <label for="gender" class="col-md-3 col-form-label font-weight-bold">Gender</label>
                                    <div class="col-md-9">
                                        <input type="text" disabled readonly class="form-control-plaintext" value="{{ auth()->user()->gender }}">
                                    </div>
                                </div>
                            </div>

                        </div>
                    
                    </div>
                @endauth
            </div>

            <!-- Informasi Perusahaan -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Perusahaan</h6>
                </div>
                @auth
                    <div class="card-body row">
                        <div class="container align-items-center">
                            <div class="row g-3 mb-3 ml-2">
                                <label for="company_name" class="col-sm-2 col-form-label font-weight-bold">Nama Perusahaan</label>
                                <div class="col-sm-10">
                                    <input type="text" disabled readonly class="form-control-plaintext" value="">
                                </div>
                            </div>
                            <div class="row g-3 mb-3 ml-2">
                                <label for="company_email" class="col-sm-2 col-form-label font-weight-bold">Email</label>
                                <div class="col-sm-10">
                                    <input type="text" disabled readonly class="form-control-plaintext" value="">
                                </div>
                            </div>
                            <div class="row g-3 mb-3 ml-2">
                                <label for="company_phone" class="col-sm-2 col-form-label font-weight-bold">No. Telp</label>
                                <div class="col-sm-10">
                                    <input type="text" disabled readonly class="form-control-plaintext" value="(+62) ">
                                </div>
                            </div>
                            <div class="row g-3 ml-2">
                                <label for="company_address" class="col-sm-2 col-form-label font-weight-bold">Alamat</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly disabled class="form-control-plaintext" value="">
                                </div>
                            </div>
                        </div>
                    
                    </div>
                @endauth
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

@endsection