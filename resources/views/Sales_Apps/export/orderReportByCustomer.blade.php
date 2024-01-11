<table>
    <thead>
        <tr>
            <th>LAPORAN PESANAN PELANGGAN</th>
        </tr>
        <tr>
            <th>ID Pelanggan</th>
            <th>Nama Pelanggan</th>
            <th>Tanggal Pesanan</th>
            <th>Nama Produk</th>
            <th>Jumlah Penjualan</th>
            <th>Hasil Penjualan</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($order as $item1)
            @foreach ($item1->orderDetail as $item2)
                <tr>
                    <td>{{ $item2->customer_id }}</td>
                    <td>{{ $item2->customer->customer_name }}</td>
                    <td>{{ date("d-m-Y", strtotime($item1->order_date)) }}</td>
                    <td>{{ $item2->product->product_name }}</td>
                    <td>{{ $item2->product_quantity }}</td>
                    <td>{{ number_format($item2->total_price, 0, ".", ".") }}</td>
                    <td>{{ $item1->orderStatus->order_status }}</td>
                </tr>
                @php
                    $soldCount += $item2->product_quantity;
                    $salesCount += $item2->total_price;
                @endphp
            @endforeach
        @endforeach
    </tbody>
    <thead>
        <tr class="table-primary">
            <th colspan="4" class="text-center">Total</th>
            <th>{{ $soldCount }}</th>
            <th>{{ number_format($salesCount, 0, ".", ".") }}</th>
        </tr>
    </thead>
</table>