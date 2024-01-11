@extends('Sales_Apps.layouts.app')

@section('title')
    Manajemen Pesanan
@endsection

@section('content-sales')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Detail Pesanan</h1>
        </div>
        <div class="row">
            <div class="col-12 col-md-8">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="row mb-3">
                            <label for="inputDate" class="col-md-4 col-form-label mb-3">Tanggal Pemesanan</label>
                            <div class="col-md-8">
                                <input type="date" class="form-control" value="{{ $orderDetail2->order->order_date }}" disabled>
                            </div>
                            <label for="inputResi" class="col-md-4 col-form-label mb-3">Resi Pengiriman</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" value="{{ $orderDetail2->order->delivery_number }}" disabled>
                            </div>
                        </div>
                        <h5 class="mb-2 text-gray-800"><b>Detail Pelanggan</b></h5>
                        <div class="form-row">
                            <div class="form-group col-12 col-md-4">
                                <label for="cutomerName">Nama</label>
                                <input type="text" class="form-control" value="{{ $orderDetail2->customer->customer_name }}" readonly>
                            </div>
                            <div class="form-group col-12 col-md-4">
                                <label for="cutomerEmail">Email</label>
                                <input type="text" class="form-control" value="{{ $orderDetail2->customer->customer_email }}" readonly>
                            </div>
                            <div class="form-group col-12 col-md-4">
                                <label for="cutomerPhone">Telepon</label>
                                <input type="text" class="form-control" value="{{ $orderDetail2->customer->customer_phone }}" readonly>
                            </div>
                            <div class="form-group col-12">
                                <label for="cutomerAddress">Alamat</label>
                                <textarea class="form-control" cols="10" rows="3" readonly>{{ $orderDetail2->customer->customer_address }}</textarea>
                            </div>
                        </div>
                        <h5 class="mt-2 mb-2 text-gray-800"><b>Detail Produk</b></h5>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Nama Produk</th>
                                        <th>Harga</th>
                                        <th>Tipe</th>
                                        <th>Quantitas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $totalPrice = 0;
                                    @endphp
                                    @foreach ($orderDetail1 as $item)
                                        @php
                                            $totalPrice += $item->total_price;
                                        @endphp
                                        <tr>
                                            <td>{{ $item->product->product_name }}</td>
                                            <td>Rp {{ number_format(($item->product_quantity*$item->product->product_price), 0, ".", ".") }}</td>
                                            <td>{{ $item->product->productType->type }}</td>
                                            <td>{{ $item->product_quantity }}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <th>Total Harga</th>
                                        <th colspan="3">Rp {{ number_format($totalPrice, 0, ".", ".") }}</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @if ($orderDetail2->order->orderStatus->order_status == "Gagal" || $orderDetail2->order->orderStatus->order_status == "Refund" || $orderDetail2->order->orderStatus->order_status == "Cancel")
                    <!-- Form -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <h5 class="mb-3 text-gray-800"><b>Formulir Refund</b></h5>
                            <form method="POST" action="{{ route('order.refund') }}">
                                @csrf
                                <div class="row mb-3">
                                    <label for="inputOrderId" class="col-md-2 col-form-label">ID Pesanan :</label>
                                    <div class="col-md-2">
                                        <input type="input" class="form-control" name="orderId" value="{{ $orderDetail2->order->id }}" readonly>
                                    </div>
                                    <label for="inputDate" class="col-md-3 col-form-label">Tanggal Pemesanan :</label>
                                    <div class="col-md-5">
                                        <input type="date" class="form-control" name="orderDate" value="{{ $orderDetail2->order->order_date }}" readonly>
                                    </div>
                                </div>
                                @if (empty($orderDetail2->order->orderStatus->returnForm->id))
                                    <div class="form-group">
                                        <label for="inputDes">Deskripsi</label>
                                        <textarea class="form-control" name="desc" cols="30" rows="5" required>{{ old('desc') }}</textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Submit
                                    </button>
                                @else
                                    <div class="form-group">
                                        <label for="inputDes">Deskripsi</label>
                                        <textarea class="form-control" name="desc" cols="30" rows="5" readonly>{{ $orderDetail2->order->orderStatus->returnForm->isi_form }}</textarea>
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-12 col-md-4">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <!-- Order Status -->
                        @if ($orderDetail2->order->orderStatus->order_status != "Pending")
                            <h5 class="mb-3 text-gray-800"><b>Status Pesanan</b></h5>
                            <div class="form-group">
                                <input type="text" class="form-control" value="{{ $orderDetail2->order->orderStatus->order_status }}" readonly>
                            </div>
                            <!-- Return Status -->
                            @if ($orderDetail2->order->orderStatus->returnForm)
                                @if ($orderDetail2->order->orderStatus->returnForm->return_status == "Pending")
                                    <h5 class="mb-3 text-gray-800"><b>Status Refund</b></h5>
                                    <div class="row">
                                        <div class="col-4">
                                            <a href="{{ route('order.updateRefundStatusSuccess', $orderDetail2->order->id) }}" class="btn btn-success btn-icon-split mr-2">
                                                <span class="icon text-white">
                                                    <i class="fas fa-check"></i>
                                                </span>
                                                <span class="text">Sukses</span>
                                            </a>
                                        </div>
                                        <div class="col-4">
                                            <a href="{{ route('order.updateRefundStatusFailed', $orderDetail2->order->id) }}" class="btn btn-danger btn-icon-split mr-2">
                                                <span class="icon text-white">
                                                    <i class="fas fa-times"></i>
                                                </span>
                                                <span class="text">Cancel</span>
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <h5 class="mb-3 text-gray-800"><b>Status Refund</b></h5>
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="{{ $orderDetail2->order->orderStatus->returnForm->return_status }}" readonly>
                                    </div>
                                @endif
                            @endif
                        @else
                            <h5 class="mb-3 text-gray-800"><b>Status Pesanan</b></h5>
                            <div class="row">
                                <div class="col-4">
                                    <a href="{{ route('order.updateStatusSuccess', $orderDetail2->order_id) }}" class="btn btn-success btn-icon-split mr-2">
                                        <span class="icon text-white">
                                            <i class="fas fa-check"></i>
                                        </span>
                                        <span class="text">Sukses</span>
                                    </a>
                                </div>
                                <div class="col-4">
                                    <a href="{{ route('order.updateStatusFailed', $orderDetail2->order_id) }}" class="btn btn-danger btn-icon-split mr-2">
                                        <span class="icon text-white">
                                            <i class="fas fa-times"></i>
                                        </span>
                                        <span class="text">Refund</span>
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <h5 class="mb-3 text-gray-800"><b>Bukti Pembayaran</b></h5>
                        <img src="{{ asset('storage/'.$orderDetail2->payment_proof) }}" class="previewImg img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
