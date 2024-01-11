@extends('Sales_Apps.layouts.app')

@section('title')
    Laporan Pesanan
@endsection

@section('content-sales')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Laporan Pesanan</h1>
        </div>
        <!-- Card -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <h5 class="mb-3 text-gray-800"><b>Buat Laporan Berdasarkan</b></h5>
                <div class="row mb-3">
                    <div class="col-2">
                        <button class="btn btn-primary btn-user btn-block" id="btn-product">
                            Produk
                        </button>
                    </div>
                    <div class="col-2">
                        <button class="btn btn-primary btn-user btn-block" id="btn-customer">
                            Pelanggan
                        </button>
                    </div>
                    <div class="col-2">
                        <button class="btn btn-primary btn-user btn-block" id="btn-status">
                            Status
                        </button>
                    </div>
                    <div class="col-2">
                        <button class="btn btn-primary btn-user btn-block" id="btn-date">
                            Tanggal
                        </button>
                    </div>
                </div>
                <!-- By Date --> 
                <div id="report-by-date">
                    <form class="form mt-4" id="form-order-by-date">
                        <div class="form-row">
                            <label for="inputDate" class="col-12">Tanggal Pemesanan</label>
                            <div class="form-group col-12 col-md-5">
                                <input type="date" class="form-control" name="dateStart" id="dateStart" value="{{ old('dateStart') }}" required>
                            </div>
                            <p class="col-0 col-md-2 text-center">sampai dengan</p>
                            <div class="form-group col-12 col-md-5">
                                <input type="date" class="form-control" name="dateEnd" id="dateEnd" value="{{ old('dateEnd') }}" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-user btn-block">
                            Tampilkan Laporan
                        </button>
                    </form>
                </div>
                <div id="order-report"></div>
            </div>
        </div>
    </div>
@endsection

@push('addon-script')
    <script>
        $(document).ready(function() {
            $('#report-by-date').hide();

            $('#btn-date').on('click', function() {
                $('#report-by-date').toggle();
            });

            // Create order report by product
            $('#btn-product').on('click', function() {
                $('#report-by-date').hide();
                $.ajax({
                    type: "POST",
                    url: "/sales/report/report-by-product",
                    data: {
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(data) {
                        $('#order-report').html(data);
                    }
                });
            });

            // Create order report by customer
            $('#btn-customer').on('click', function() {
                $('#report-by-date').hide();
                $.ajax({
                    type: "POST",
                    url: "/sales/report/report-by-customer",
                    data: {
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(data) {
                        $('#order-report').html(data);
                    }
                });
            });

            // Create order report by status
            $('#btn-status').on('click', function() {
                $('#report-by-date').hide();
                $.ajax({
                    type: "POST",
                    url: "/sales/report/report-by-status",
                    data: {
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(data) {
                        $('#order-report').html(data);
                    }
                });
            });

            // Create order report by date
            $('#form-order-by-date').on('submit', function(e) {
                e.preventDefault();
                var dateStart = document.getElementById('dateStart').value;
                var dateEnd = document.getElementById('dateEnd').value;
                $.ajax({
                    type: "POST",
                    url: "/sales/report/report-by-date",
                    data: {
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                        "dateStart": dateStart,
                        "dateEnd": dateEnd,
                    },
                    success: function(data) {
                        $('#order-report').html(data);
                    }
                });
            });
        });
    </script>
@endpush