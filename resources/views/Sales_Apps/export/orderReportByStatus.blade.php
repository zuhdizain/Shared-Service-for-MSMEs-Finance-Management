<table>
    <thead>
        <tr>
            <th>LAPORAN PESANAN STATUS</th>
        </tr>
        <tr>
            <th>ID Pesanan</th>
            <th>Tanggal Pesanan</th>
            <th>Status Pesanan</th>
            <th>Jumlah Penjualan</th>
            <th>Hasil Penjualan</th>
        </tr>
    </thead>
    <tbody>
        @php
            $a = 0;
            $b = 0;
        @endphp
        @foreach ($order as $item)
            @php
                $product_quantity = 0;
                $total_sales = 0;
                foreach ($item->orderDetail as $data) {
                    $product_quantity += $data->product_quantity;
                    $total_sales += $data->total_price;
                }
                $a += $product_quantity;
                $b += $total_sales;
            @endphp
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ date("d-m-Y", strtotime($item->order_date)) }}</td>
                <td>{{ $item->orderStatus->order_status }}</td>
                <td>{{ $product_quantity }}</td>
                <td>{{ number_format($total_sales, 0, ".", ".") }}</td>
            </tr>
        @endforeach
    </tbody>
    <thead>
        <tr class="table-primary">
            <th colspan="3" class="text-center">Total</th>
            <th>{{ $a }}</th>
            <th>{{ number_format($b, 0, ".", ".") }}</th>
        </tr>
    </thead>
</table>