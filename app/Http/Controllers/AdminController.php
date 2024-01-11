<?php

namespace App\Http\Controllers;

use App\Models\Confirm;
use App\Models\Division;
use App\Models\Employee;
use App\Models\Good;
use App\Models\Histories;
use App\Models\Order;
use App\Models\OrderReport;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboardAdmin() {
        // HR
        $totalEmployee = Employee::count();
        $totalDivision = Division::count();
        $totalInactive = Histories::count();

        // Inventory
        $confirms = Confirm::all();

        $products = Product::all();
        $total_products = 0;
        foreach($products as $tot){
            $total_products += $tot->quantity; 
        }

        $goods = Good::all();
        $total_goods = 0;
        foreach($goods as $goo){
            $total_goods += $goo->quan; 
        }

        $goods = Good::all();
        $total_assets_goods = 0;
        foreach($goods as $goo){
            $total_assets_goods += $goo->price; 
        }

        $products = Product::all();
        $total_assets_products = 0;
        foreach($products as $tot){
            $total_assets_products += $tot->price; 
        }

        $total = $total_assets_goods + $total_assets_products;

        // Sales
        // Akumulasi order bulanan
        $order = Order::whereMonth('order_date', Carbon::now()->month)
            ->whereNotNull('delivery_number')
            ->get();

        // Akumulasi order
        $orderDetail = Order::all();

        // Akumulasi total order
        $totalOrder = Order::whereNotNull('delivery_number')->count();
        
        // Akumulasi total order bulanan
        $totalOrderMonthly = count($order);
        $orderReport = OrderReport::all();

        // Akumulasi total penjualan
        $totalSales = 0;
        foreach ($orderDetail as $data1) {
            foreach ($data1->orderDetail as $data2) {
                if ($data1->orderStatus->order_status != "Cancel") {
                    $totalSales += $data2->total_price;
                }
            }
        }

        // Akumulasi total penjualan perbulan
        $totalSalesMonthly = 0;
        foreach ($order as $data1) {
            foreach ($data1->orderDetail as $data2) {
                if ($data1->orderStatus->order_status != "Cancel") {
                    $totalSalesMonthly += $data2->total_price;
                }
            }
        }

        // Mendapatkan data pesanan untuk setahun terakhir
        $lastYearOrders = Order::whereYear('order_date', Carbon::now()->year)
            ->whereNotNull('delivery_number')
            ->get();

        // Buat array kosong untuk menyimpan total sales tiap bulan
        $totalSalesMonthlyArray = array_fill(0, 12, 0);

        // Lakukan looping pada data pesanan setahun terakhir
        foreach ($lastYearOrders as $data1) {
            foreach ($data1->orderDetail as $data2) {
                if ($data1->orderStatus->order_status != "Cancel") {
                    // Ambil bulan dari tanggal pesanan
                    $month = Carbon::parse($data1->order_date)->month;
                    // Tambahkan total sales pesanan ke bulan yang bersangkutan dalam array
                    $totalSalesMonthlyArray[$month - 1] += $data2->total_price;
                }
            }
        }

        return view('admin.website.dashboard', compact('totalEmployee', 'totalDivision', 'totalInactive', 'confirms', 'total_products', 'total_goods', 'total', 'totalSales', 'totalSalesMonthly', 'totalOrder', 'totalOrderMonthly', 'orderReport', 'totalSalesMonthlyArray'));
    }

    public function companyList() {
        return view('admin.admin-HR.companies');
    }
}
