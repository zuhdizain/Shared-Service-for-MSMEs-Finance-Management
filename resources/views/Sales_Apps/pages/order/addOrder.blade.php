@extends('Sales_Apps.layouts.app')

@section('title')
    Manajemen Pesanan
@endsection

@section('content-sales')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tambah Pesanan Baru</h1>
        </div>
        <!-- Card -->
        <div class="card shadow mb-4">
            <div class="card-body mb-3 mt-3">
                <form method="POST" action="{{ route('order.add') }}">
                    @csrf
                    <div class="row mb-3">
                        <label for="inputDate" class="col-sm-2 col-form-label">Tanggal Pemesanan</label>
                        <div class="col-sm-10">
                          <input type="date" class="form-control" name="date" value="{{ old('date') }}" required>
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
