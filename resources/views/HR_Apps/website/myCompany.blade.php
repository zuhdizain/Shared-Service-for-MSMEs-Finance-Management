@extends('HR_Apps.layout.main')

@section('content-hr')

    <!-- Main Content -->
    <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="align-items-center mb-4">
                <h3 class="h3 mb-0 text-gray-800">Informasi Usaha Pengguna</h3>
            </div>

            <!-- Informasi Usaha -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-sm-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary mt-2">Informasi Usaha</h6>
                    <a href="{{ route('user.index') }}" class="btn btn-secondary mr-2 shadow-sm">
                        <span class="icon text-white-50">
                            <i class="fas fa-arrow-left"></i>
                        </span>
                        <span class="text edit-sp">Kembali</span>
                    </a>
                </div>
                    <div class="card-body row">
                        <div class="container align-items-center">
                            <div class="row g-3 mb-3 ml-2">
                                <label for="company_name" class="col-sm-2 col-form-label font-weight-bold">Nama Usaha</label>
                                <div class="col-sm-10">
                                    <input type="text" disabled readonly class="form-control-plaintext" value="{{ $company->company_name }}">
                                </div>
                            </div>
                            <div class="row g-3 mb-3 ml-2">
                                <label for="company_email" class="col-sm-2 col-form-label font-weight-bold">Email</label>
                                <div class="col-sm-10">
                                    <input type="text" disabled readonly class="form-control-plaintext" value="{{ $company->company_email }}">
                                </div>
                            </div>
                            <div class="row g-3 mb-3 ml-2">
                                <label for="company_phone" class="col-sm-2 col-form-label font-weight-bold">No. Telp</label>
                                <div class="col-sm-10">
                                    <input type="text" disabled readonly class="form-control-plaintext" value="{{ $company->company_phone }}">
                                </div>
                            </div>
                            <div class="row g-3 ml-2">
                                <label for="company_address" class="col-sm-2 col-form-label font-weight-bold">Alamat</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly disabled class="form-control-plaintext" value="{{ $company->company_address }}">
                                </div>
                            </div>
                        </div>
                    
                    </div>
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

@endsection