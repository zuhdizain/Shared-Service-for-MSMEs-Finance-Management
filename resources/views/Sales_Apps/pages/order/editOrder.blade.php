@extends('Sales_Apps.layouts.app')

@section('title')
    Manajemen Pesanan
@endsection

@section('content-sales')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Detail Pesanan</h1>
        </div>
        <!-- Form -->
        <form id="form-order" method="POST" action="{{ route('order.update', $order->id) }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-12 col-md-8">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <h5 class="mb-2 text-gray-800"><b>Detail Pelanggan</b></h5>
                            <div class="form-row">
                                <div class="form-group col-12 col-md-4">
                                    <label for="cutomerName">Nama</label>
                                    <input type="text" class="form-control" value="{{ $orderDetail ? $orderDetail->customer->customer_name : '' }}" id="cutomerName" readonly>
                                </div>
                                <div class="form-group col-12 col-md-4">
                                    <label for="cutomerEmail">Email</label>
                                    <input type="text" class="form-control" value="{{ $orderDetail ? $orderDetail->customer->customer_email : '' }}" id="cutomerEmail" readonly>
                                </div>
                                <div class="form-group col-12 col-md-4">
                                    <label for="cutomerPhone">Telepon</label>
                                    <input type="text" class="form-control" value="{{ $orderDetail ? $orderDetail->customer->customer_phone : '' }}" id="cutomerPhone" readonly>
                                </div>
                                <div class="form-group col-12">
                                    <label for="cutomerAddress">Alamat</label>
                                    <textarea class="form-control" id="cutomerAddress" cols="10" rows="3" readonly>{{ $orderDetail ? $orderDetail->customer->customer_address : '' }}</textarea>
                                </div>
                            </div>
                            <h5 class="mt-2 mb-2 text-gray-800"><b>Detail Produk</b></h5>
                            <div id="product-detail"></div>
                            <h5 class="mt-2 mb-2 text-gray-800"><b>Bukti Pembayaran</b></h5>
                            <div class="form-group">
                                <input type="file" class="form-control-file" id="upload" name="file" onchange="previewImg()" required>
                            </div>
                            <img class="previewImg img-fluid mb-3">
                            <button type="submit" class="btn btn-primary btn-block">
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <input type="text" class="form-control" value="{{ $order->id }}" id="orderId" hidden>
                            <div class="form-group">
                                <label for="inputDate">Tanggal Pesanan</label>
                                <input type="date" class="form-control" name="date" value="{{ $order->order_date }}" required>
                            </div>
                            <div class="form-group">
                                <label for="inputResi">Resi Pengiriman</label>
                                <input type="text" class="form-control" name="delivery_number" required>
                            </div>
                            <div class="form-group">
                                <label for="inputCustomer">Pelangan</label>
                                <select class="form-control" id="customer" name="customer">
                                    <option value="">Pilih pelanggan</option>
                                    @if ($orderDetail)
                                        @foreach ($customer as $item)
                                            <option value="{{ $item->id }}" {{ $orderDetail->customer_id == $item->id ? 'selected'  : '' }}>{{ $item->customer_name }}</option>
                                        @endforeach
                                    @else
                                        @foreach ($customer as $item)
                                            <option value="{{ $item->id }}">{{ $item->customer_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <h5>Daftar Produk</h5>
                            <div id="list-product"></div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('addon-script')
    <script>
        function previewImg() {
            $('.previewImg').css('width', '400px');
            const image = document.querySelector('#upload');
            const imgPreview = document.querySelector('.previewImg');
            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);
            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }

        $(document).ready(function() {
            var customer_id = document.getElementById('customer').value;
            var order_id = document.getElementById('orderId').value;
            // Load order detail
            $.get("/sales/order/get-order-detail/" + order_id, function(data) {
                $('#product-detail').html(data);
            });

            // Load customer data
            $('#customer').on('change', (event) => {
                $.get("/sales/customer/" + event.target.value).then(customer => {
                    customer_id = customer.id;
                    $('#cutomerName').val(customer.customer_name);
                    $('#cutomerEmail').val(customer.customer_email);
                    $('#cutomerPhone').val(customer.customer_phone);
                    $('#cutomerAddress').val(customer.customer_address);
                });
            });

            // Load product
            $.get("/sales/order/get-all-product", function(data) {
                $('#list-product').html(data);
            });

            // Create order detail
            $('#list-product').on('click', ".btn-product", function() {
                if(customer_id == "") {
                    alert("Tambahkan pelanggan terlebih dahulu!");
                } else {
                    var product_id = $(this).data("id");

                    $.ajax({
                        type: "POST",
                        url: "/sales/order/order-product",
                        data: {
                            "_token": $('meta[name="csrf-token"]').attr('content'),
                            "order_id": order_id,
                            "product_id": product_id,
                            "customer_id": customer_id,
                        },
                        success: function(data) {
                            $('#product-detail').html(data);
                        }
                    });
                }
            });

            // Delete product order
            $('#product-detail').on('click', ".btn-delete-product-order", function() {
                var orderDetail_id = $(this).data("id");
                $.ajax({
                    type: "POST",
                    url: "/sales/order/delete-product-order/" + orderDetail_id,
                    data: {
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(data) {
                        $('#product-detail').html(data);
                    }
                });
            });

            // Increase product quantity
            $('#product-detail').on('click', ".btn-increase", function() {
                var orderDetail_id = $(this).data("id");
                $.ajax({
                    type: "POST",
                    url: "/sales/order/increase-quantity/" + orderDetail_id,
                    data: {
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(data) {
                        $('#product-detail').html(data);
                    }
                });
            });

            // Decrease product quantity
            $('#product-detail').on('click', ".btn-decrease", function() {
                var orderDetail_id = $(this).data("id");
                $.ajax({
                    type: "POST",
                    url: "/sales/order/decrease-quantity/" + orderDetail_id,
                    data: {
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(data) {
                        $('#product-detail').html(data);
                    }
                });
            });
        });
    </script>
@endpush
