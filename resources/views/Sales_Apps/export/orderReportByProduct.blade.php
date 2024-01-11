<table>
    <thead>
        <tr>
            <th>LAPORAN PESANAN PRODUK</th>
        </tr>
        <tr>
            <th>SUKSES</th>
        </tr>
        <tr>
            <th>ID Produk</th>
            <th>Nama Produk</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Jumlah Penjualan</th>
            <th>Hasil Penjualan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($product as $item)
            @php
                if (!in_array($item->id, $displayedProducts)) {
                    $displayedProducts[] = $item->id;

                    foreach ($item->orderDetail as $item2) {
                        if ($item2->order->orderStatus->order_status == "Sukses" || $item2->order->orderStatus->order_status == "Refund") {
                            // Mengakumulasi jumlah terjual dan pendapatan untuk setiap produk sukses/refund
                            if (isset($soldQuantities1[$item->id])) {
                                $soldQuantities1[$item->id] += $item2->product_quantity;
                            } else {
                                $soldQuantities1[$item->id] = $item2->product_quantity;
                            }
                            if (isset($totalSales1[$item->id])) {
                                $totalSales1[$item->id] += $item2->total_price;
                            } else {
                                $totalSales1[$item->id] = $item2->total_price;
                            }
                        } else if ($item2->order->orderStatus->order_status == "Cancel") {
                            // Mengakumulasi jumlah terjual dan pendapatan untuk setiap produk cancel
                            if (isset($soldQuantities2[$item->id])) {
                                $soldQuantities2[$item->id] += $item2->product_quantity;
                            } else {
                                $soldQuantities2[$item->id] = $item2->product_quantity;
                            }
                            if (isset($totalSales2[$item->id])) {
                                $totalSales2[$item->id] += $item2->total_price;
                            } else {
                                $totalSales2[$item->id] = $item2->total_price;
                            }
                        }
                    }
                    echo '
                        <tr>
                            <th>' . $item->id . '</th>
                            <th>' . $item->product_name . '</th>
                            <th>' . number_format($item->product_price, 0, ".", ".") . '</th>
                            <th>' . $item->product_quantity . '</th>
                            <th>' . $soldQuantities1[$item->id] . '</th>
                            <th>' . number_format($totalSales1[$item->id], 0, ".", ".") . '</th>
                        </tr>
                    ';

                    $soldCount1 += $soldQuantities1[$item->id];
                    $salesCount1 += $totalSales1[$item->id];
                }
            @endphp
        @endforeach
    </tbody>
    <thead>
        <tr class="table-primary">
            <th colspan="4" class="text-center">Total</th>
            <th>{{ $soldCount1 }}</th>
            <th>{{ number_format($salesCount1, 0, ".", ".") }}</th>
        </tr>
        <tr></tr>
        <tr>
            <th>GAGAL</th>
        </tr>
        <tr>
            <th>ID Produk</th>
            <th>Nama Produk</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Jumlah Penjualan</th>
            <th>Hasil Penjualan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($product as $item)
            @php
                foreach ($item->orderDetail as $item2) {
                if ($item2->order->orderStatus->order_status == "Cancel") {
                    echo '
                        <tr>
                            <td>' . $item->id . '</td>
                            <td>' . $item->product_name . '</td>
                            <td>' . number_format($item->product_price, 0, ".", ".") . '</td>
                            <td>' . $item->product_quantity . '</td>
                            <td>' . $soldQuantities2[$item->id] . '</td>
                            <td>' . number_format($totalSales2[$item->id], 0, ".", ".") . '</td>
                        </tr>
                    ';

                    $soldCount2 += $soldQuantities2[$item->id];
                    $salesCount2 += $totalSales2[$item->id];
                }
            }
            @endphp
        @endforeach
    </tbody>
    <thead>
        <tr class="table-primary">
            <th colspan="4" class="text-center">Total</th>
            <th>{{ $soldCount2 }}</th>
            <th>{{ number_format($salesCount2, 0, ".", ".") }}</th>
        </tr>
    </thead>
</table>