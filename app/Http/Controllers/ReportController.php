<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Exports\exportOrderReportByProduct;
use App\Exports\exportOrderReportByCustomer;
use App\Exports\exportOrderReportByStatus;
use App\Exports\exportOrderReportByDate;
use App\Models\OrderReport;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    // Order Management
    public function index()
    {
        return view('Sales_Apps.pages.report.index');
    }

    public function reportByProduct()
    {
        if (Auth::user()->authorization_level == 2) {
            $product = Product::all();
        } else {
            $product = Product::where('user_id', Auth::user()->id)->get();
        }

        $displayedProducts = [];
        $soldQuantities1 = [];
        $soldQuantities2 = [];
        $totalSales1 = [];
        $totalSales2 = [];
        $soldCount1 = 0;
        $salesCount1 = 0;
        $soldCount2 = 0;
        $salesCount2 = 0;
        $html = '';

        // Menampilkan yang Sukses
        $html .= '
            <h5 class="mt-5 mb-3 text-gray-800"><b>LAPORAN PESANAN PRODUK</b></h5>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr class="table-warning">
                            <th>SUKSES</th>
                        </tr>
                        <tr class="table-primary">
                            <th>ID Produk</th>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Jumlah Penjualan</th>
                            <th>Hasil Penjualan</th>
                        </tr>
                    </thead>
                    <tbody>
        ';

        foreach ($product as $item) {
            if (!in_array($item->id, $displayedProducts)) {
                $displayedProducts[] = $item->id; // Menambahkan ID produk ke array

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

                // Menampilkan data produk dan jumlah terjual (sukses/refund)
                $html .= '
                    <tr>
                        <td>' . $item->id . '</td>
                        <td>' . $item->product_name . '</td>
                        <td>Rp ' . number_format($item->product_price, 0, ".", ".") . '</td>
                        <td>' . $item->product_quantity . ' produk</td>
                        <td>' . $soldQuantities1[$item->id] . '</td>
                        <td>Rp ' . number_format($totalSales1[$item->id], 0, ".", ".") . '</td>
                    </tr>
                ';

                $soldCount1 += $soldQuantities1[$item->id];
                $salesCount1 += $totalSales1[$item->id];
            }
        }

        $html .= '
                    </tbody>
                    <thead>
                        <tr class="table-primary">
                            <th colspan="4" class="text-center">Total</th>
                            <th>' . $soldCount1 . ' produk</th>
                            <th>Rp ' . number_format($salesCount1, 0, ".", ".") . '</th>
                        </tr>
                    </thead>
                </table>
            </div>
        ';

        // Menampilkan yang Gagal
        $html .= '
            <div class="table-responsive mt-3">
                <table class="table table-bordered">
                    <thead>
                        <tr class="table-warning">
                            <th>GAGAL</th>
                        </tr>
                        <tr class="table-primary">
                            <th>ID Produk</th>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Jumlah Penjualan</th>
                            <th>Hasil Penjualan</th>
                        </tr>
                    </thead>
                    <tbody>
        ';

        foreach ($product as $item) {
            foreach ($item->orderDetail as $item2) {
                if ($item2->order->orderStatus->order_status == "Cancel") {
                    // Menampilkan data produk dan jumlah terjual (cancel)
                    $html .= '
                    <tr>
                        <td>' . $item->id . '</td>
                        <td>' . $item->product_name . '</td>
                        <td>Rp ' . number_format($item->product_price, 0, ".", ".") . '</td>
                        <td>' . $item->product_quantity . ' produk</td>
                        <td>' . $soldQuantities2[$item->id] . '</td>
                        <td>Rp ' . number_format($totalSales2[$item->id], 0, ".", ".") . '</td>
                    </tr>
                ';

                    $soldCount2 += $soldQuantities2[$item->id];
                    $salesCount2 += $totalSales2[$item->id];
                }
            }
        }

        $html .= '
                    </tbody>
                    <thead>
                        <tr class="table-primary">
                            <th colspan="4" class="text-center">Total</th>
                            <th>' . $soldCount2 . ' produk</th>
                            <th>Rp ' . number_format($salesCount2, 0, ".", ".") . '</th>
                        </tr>
                    </thead>
                </table>
                <form action="' . route('report.exportReportByProduct') . '" method="GET">
                    <button type="submit" class="btn btn-warning btn-user px-5">
                        Export Laporan
                    </button>
                </form>
            </div>
        ';

        return $html;
    }

    public function reportByCustomer()
    {
        if (Auth::user()->authorization_level == 2) {
            $order = Order::all();
        } else {
            $order = Order::where('user_id', Auth::user()->id)->get();
        }

        $soldCount = 0;
        $salesCount = 0;
        $html = '';

        $html .= '
            <h5 class="mt-5 mb-3 text-gray-800"><b>LAPORAN PESANAN PELANGGAN</b></h5>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr class="table-primary">
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
        ';

        foreach ($order as $item1) {
            foreach ($item1->orderDetail as $item2) {
                $html .= '
                    <tr>
                        <td>' . $item2->customer_id . '</td>
                        <td>' . $item2->customer->customer_name . '</td>
                        <td>' . date("d-m-Y", strtotime($item1->order_date)) . '</td>
                        <td>' . $item2->product->product_name . '</td>
                        <td>' . $item2->product_quantity . ' produk</td>
                        <td>Rp ' . number_format($item2->total_price, 0, ".", ".") . '</td>
                        <td>' . $item1->orderStatus->order_status . '</td>
                    </tr>
                ';

                $soldCount += $item2->product_quantity;
                $salesCount += $item2->total_price;
            }
        }

        $html .= '
                    </tbody>
                    <thead>
                        <tr class="table-primary">
                            <th colspan="4" class="text-center">Total</th>
                            <th>' . $soldCount . ' produk</th>
                            <th>Rp ' . number_format($salesCount, 0, ".", ".") . '</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
                <form action="' . route('report.exportReportByCustomer') . '" method="GET">
                    <button type="submit" class="btn btn-warning btn-user px-5">
                        Export Laporan
                    </button>
                </form>
            </div>
        ';

        return $html;
    }

    public function reportByStatus()
    {
        if (Auth::user()->authorization_level == 2) {
            $order = Order::all();
        } else {
            $order = Order::where('user_id', Auth::user()->id)->get();
        }

        $a = 0;
        $b = 0;
        $html = '';

        $html .= '
            <h5 class="mt-5 mb-3 text-gray-800"><b>LAPORAN PESANAN STATUS</b></h5>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr class="table-primary">
                            <th>ID Pesanan</th>
                            <th>Tanggal Pesanan</th>
                            <th>Status Pesanan</th>
                            <th>Jumlah Penjualan</th>
                            <th>Hasil Penjualan</th>
                        </tr>
                    </thead>
                    <tbody>
        ';

        foreach ($order as $item) {
            $product_quantity = 0;
            $total_sales = 0;
            foreach ($item->orderDetail as $data) {
                $product_quantity += $data->product_quantity;
                $total_sales += $data->total_price;
            }
            $a += $product_quantity;
            $b += $total_sales;
            $html .= '
                <tr>
                    <td>' . $item->id . '</td>
                    <td>' . date("d-m-Y", strtotime($item->order_date)) . '</td>
                    <td>' . $item->orderStatus->order_status . '</td>
                    <td>' . $product_quantity . ' produk</td>
                    <td>Rp ' . number_format($total_sales, 0, ".", ".") . '</td>
                </tr>
            ';
        }

        $html .= '
                    </tbody>
                    <thead>
                        <tr class="table-primary">
                            <th colspan="3" class="text-center">Total</th>
                            <th>' . $a . ' produk</th>
                            <th>Rp ' . number_format($b, 0, ".", ".") . '</th>
                        </tr>
                    </thead>
                </table>
                <form action="' . route('report.exportReportByStatus') . '" method="GET">
                    <button type="submit" class="btn btn-warning btn-user px-5">
                        Export Laporan
                    </button>
                </form>
            </div>
        ';

        return $html;
    }

    public function reportByDate(Request $request)
    {
        $dateStart = date("Y-m-d", strtotime($request->dateStart));
        $dateEnd = date("Y-m-d", strtotime($request->dateEnd));

        if (Auth::user()->authorization_level == 2) {
            $order = Order::whereBetween('order_date', [$dateStart, $dateEnd])
                ->get();
        } else {
            $order = Order::where('user_id', Auth::user()->id)
                ->whereBetween('order_date', [$dateStart, $dateEnd])
                ->get();
        }
        $html = '';

        $html .= '
            <h5 class="mt-5 mb-3 text-gray-800"><b>Laporan pesanan dari tanggal ' . date("d-m-Y", strtotime($dateStart)) . ' sampai ' . date("d-m-Y", strtotime($dateEnd)) . '.</b></h5>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr class="table-primary">
                            <th>ID Pesanan</th>
                            <th>Tanggal Pesanan</th>
                            <th>Jumlah Penjualan</th>
                            <th>Hasil Penjualan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
        ';

        foreach ($order as $item1) {
            $sales_amount = 0;
            $total_sales = 0;
            foreach ($item1->orderDetail as $data) {
                $sales_amount += $data->product_quantity;
                $total_sales += $data->total_price;
            }
            $html .= '
                <tr class="table-secondary">
                    <td>' . $item1->id . '</td>
                    <td>' . date("d-m-Y", strtotime($item1->order_date)) . '</td>
                    <td>' . $sales_amount . ' produk</td>
                    <td>Rp ' . number_format($total_sales, 0, ".", ".") . '</td>
                    <td>' . $item1->orderStatus->order_status . '</td>
                </tr>
                <tr>
                    <td></td>
                    <td>Produk</td>
                    <td>Jumlah Produk</td>
                    <td>Harga</td>
                    <td></td>
                </tr>
            ';

            foreach ($item1->orderDetail as $item2) {
                $html .= '
                    <tr>
                        <td></td>
                        <td>' . $item2->product->product_name . '</td>
                        <td>' . $item2->product_quantity . ' produk</td>
                        <td>Rp ' . number_format($item2->total_price, 0, ".", ".") . '</td>
                        <td></td>
                    </tr>
                ';
            }
        }

        $html .= '
                    </tbody>
                </table>
                <form action="' . route('report.exportReportByDate') . '" method="GET">
                    <input type="text" name="dateStart" value="' . $dateStart . '" hidden>
                    <input type="text" name="dateEnd" value="' . $dateEnd . '" hidden>
                    <button type="submit" class="btn btn-warning btn-user px-5">
                        Export Laporan
                    </button>
                </form>
            </div>
        ';

        return $html;
    }

    public function exportReportByProduct()
    {
        $date = Carbon::now();
        $currentDate = date("d-m-Y", strtotime($date));
        $filename = ("order_report_" . $currentDate . "_" . time() . ".xlsx");

        Excel::store(new exportOrderReportByProduct(), $filename, 'report');
        $report = OrderReport::create([
            'user_id' => Auth::user()->id,
            'report' => $filename,
            'report_date' => Carbon::now(),
        ]);
        $report->save();

        return Excel::download(new exportOrderReportByProduct(), $filename);
    }

    public function exportReportByCustomer()
    {
        $date = Carbon::now();
        $currentDate = date("d-m-Y", strtotime($date));
        $filename = ("order_report_" . $currentDate . "_" . time() . ".xlsx");

        Excel::store(new exportOrderReportByCustomer(), $filename, 'report');
        $report = OrderReport::create([
            'user_id' => Auth::user()->id,
            'report' => $filename,
            'report_date' => Carbon::now(),
        ]);
        $report->save();

        return Excel::download(new exportOrderReportByCustomer(), $filename);
    }

    public function exportReportByStatus()
    {
        $date = Carbon::now();
        $currentDate = date("d-m-Y", strtotime($date));
        $filename = ("order_report_" . $currentDate . "_" . time() . ".xlsx");

        Excel::store(new exportOrderReportByStatus(), $filename, 'report');
        $report = OrderReport::create([
            'user_id' => Auth::user()->id,
            'report' => $filename,
            'report_date' => Carbon::now(),
        ]);
        $report->save();

        return Excel::download(new exportOrderReportByStatus(), $filename);
    }

    public function exportReportByDate(Request $request)
    {
        $date = date("d-m-Y", strtotime($request->dateStart));
        $filename = ("order_report_" . $date . "_" . time() . ".xlsx");

        Excel::store(new exportOrderReportByDate($request->dateStart, $request->dateEnd), $filename, 'report');
        $report = OrderReport::create([
            'user_id' => Auth::user()->id,
            'report' => $filename,
            'report_date' => Carbon::now(),
        ]);
        $report->save();

        return Excel::download(new exportOrderReportByDate($request->dateStart, $request->dateEnd), $filename);
    }

    public function riwayatLaporan()
    {
        // Isi Logika disini
        return view('Sales_Apps.pages.report.riwayatLaporan');
    }

    // Finance Management
    public function cashFlow()
    {
        return view('Finance_Apps.pages.report.cashFlow');
    }

    public function profitLoss()
    {
        return view('Finance_Apps.pages.report.profitLoss');
    }

    public function exportBalanceSheet()
    {
    }

    public function exportCashFlow()
    {
    }

    public function exportProfitLoss()
    {
    }
}
