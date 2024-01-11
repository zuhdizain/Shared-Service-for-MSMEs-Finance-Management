@extends('Sales_Apps.layouts.app')

@section('title')
    Manajemen Pesanan
@endsection

@push('addon-style')
    <!-- Custom styles for this page -->
    <link href="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content-sales')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Daftar Status Pesanan</h1>
        </div>
        <!-- Table -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal Pesanan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($order as $item)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ date("d-m-Y", strtotime($item->order_date)) }}</td>
                                    <td>{{ $item->orderStatus->order_status}}</td>
                                    <td>
                                        <a href="{{ route('order.detailpage', $item->id) }}" class="btn btn-primary btn-icon-split mr-2">
                                            <span class="icon text-white">
                                                <i class="fas fa-info"></i>
                                            </span>
                                            <span class="text">Detail</span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('addon-script')
    <!-- Page level plugins -->
    <script src="{{ asset('template/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('template/js/demo/datatables-demo.js') }}"></script>
@endpush