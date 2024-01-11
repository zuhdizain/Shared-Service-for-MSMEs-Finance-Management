@extends('HR_Apps.layout.main')

@section('content-hr')

    <!-- Main Content -->
    <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="align-items-center mb-4">
                <h3 class="h3 mb-0 text-gray-800">Informasi Profile Pengguna</h3>
            </div>

            <!-- Informasi Karyawan -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-sm-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary mt-2">Informasi Karyawan</h6>
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
                                    <label for="gender" class="col-md-3 col-form-label font-weight-bold">Jenis Kelamin</label>
                                    <div class="col-md-9">
                                        <input type="text" disabled readonly class="form-control-plaintext" value="{{ auth()->user()->gender }}">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                @endauth

                <div class="card-footer">
                    Untuk melihat informasi usaha yang tersedia silahkan klik <a href="{{ route('company.index') }}">disini</a>.
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

@endsection