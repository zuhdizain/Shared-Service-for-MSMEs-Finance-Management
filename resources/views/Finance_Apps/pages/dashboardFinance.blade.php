@extends('Finance_Apps.layouts.app')

@section('title')
    Dashboard
@endsection

@push('addon-style')
    <style>
        .report:hover {
            background-color: #dbdada;
            text-decoration: none;
        }

        .report img {
            height: auto;
            width: 125px;
        }

        .report p {
            color: #000
        }
    </style>
@endpush

@section('content-finance')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4 mt-5">
            <h1 class="h3 mb-0 text-gray-800">Selamat Datang {{ $user->name }}!</h1>
        </div>
        <div class="row" style="height: 65vh">
            {{-- <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Penjualan</div>
                                <div class="h5 mb-0 mt-2 font-weight-bold text-gray-800">Rp {{ number_format($totalSales, 0, ".", ".") }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Penjualan (bulan)</div>
                                <div class="h5 mb-0 mt-2 font-weight-bold text-gray-800">Rp {{ number_format($totalSalesMonthly, 0, ".", ".") }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Pesanan</div>
                                <div class="h5 mb-0 mt-2 font-weight-bold text-gray-800">{{ $totalOrder }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Pesanan (bulan)</div>
                                <div class="h5 mb-0 mt-2 font-weight-bold text-gray-800">{{ $totalOrderMonthly }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Area Chart -->
            <div class="col-12">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="myAreaChart"></canvas>
                            <div id="totalSalesMonthlyArray" data-sales="{{ json_encode($totalSalesMonthlyArray) }}"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
  
        <!-- Card -->
        {{-- <div class="card shadow mb-4">
            <div class="card-body">
                <h5 class="mb-3 text-gray-800"><b>Laporan Pemesanan</b></h5>
                <div class="row">
                    @foreach ($orderReport as $item)
                        <a href="{{ route('report.download', $item->id) }}" class="col-md-2 report">
                            <img src="{{ asset('img/excel_logo.png') }}" alt="img-report">
                            <p>{{ $item->report }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        </div> --}}
    </div>
@endsection

@push('addon-script')
    <!-- Page level plugins -->
    <script src="{{ asset('template/vendor/chart.js/Chart.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('template/js/chart-area.js') }}"></script>
@endpush