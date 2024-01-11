@extends('Sales_Apps.layouts.app')

@section('title')
    Manajemen Pelanggan
@endsection

@section('content-sales')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tambah Pelanggan Baru</h1>
        </div>
        <!-- Card -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <form method="POST" action="{{ route('customer.add') }}">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-12">
                            <label for="inputName">Nama</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label for="inputEmail">Email</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">@</div>
                                </div>
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}" min="0" required>
                            </div>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label for="inputPhone">Telepon</label>
                            <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" required>
                        </div>
                        <div class="form-group col-12">
                            <label for="inputAddress">Alamat</label>
                            <textarea class="form-control" name="address" cols="30" rows="5">{{ old('address') }}</textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                        Submit
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
