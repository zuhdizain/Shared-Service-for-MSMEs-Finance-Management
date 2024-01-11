<table>
    <thead>
        <tr>
            <th>Laporan pesanan dari tanggal {{ $dateStart }} sampai {{ $dateEnd }}.</th>
        </tr>
        <tr>
            <th>ID Pesanan</th>
            <th>Tanggal Pesanan</th>
            <th>Jumlah Penjualan</th>
            <th>Hasil Penjualan</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($order as $item1)
            @php
                $sales_amount = 0;
                $total_sales = 0;
                foreach ($item1->orderDetail as $data) {
                    $sales_amount += $data->product_quantity;
                    $total_sales += $data->total_price;
                }
            @endphp
            <tr>
                <td>{{ $item1->id }}</td>
                <td>{{ date("d-m-Y", strtotime($item1->order_date)) }}</td>
                <td>{{ $sales_amount }}</td>
                <td>{{ number_format($total_sales, 0, ".", ".") }}</td>
                <td>{{ $item1->orderStatus->order_status }}</td>
            </tr>
            <tr>
                <td></td>
                <td>Produk</td>
                <td>Jumlah Produk</td>
                <td>Harga</td>
            </tr>
            @foreach ($item1->orderDetail as $item2)
                <tr>
                    <td></td>
                    <td>{{ $item2->product->product_name }}</td>
                    <td>{{ $item2->product_quantity }}</td>
                    <td>{{ number_format($item2->total_price, 0, ".", ".") }}</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>