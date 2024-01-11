<?php

namespace App\Http\Controllers;

use App\Mail\CCMail;
use App\Models\Division;
use App\Models\Employee;
use App\Models\Histories;
use App\Models\Order;
use App\Models\OrderReport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ViewController extends Controller
{
    // Authentication functions

    public function ccSubmit(Request $request)
    {
        // Mail::send('mail.CCMail', [
        //     'fullname' => $request->fullname,
        //     'email'    => $request->email,
        //     'subject'  => $request->subject,
        //     'msg'      => $request->msg
        // ], function ($mail) use ($request) {
        //     $mail->from(env('MAIL_FROM_ADDRESS'), $request->name);
        //     $mail->to("nadnad10.nz@gmail.com")->subject('Call Center Message');
        // });

        $data = [
            'fullname' => $request->fullname,
            'email'    => $request->email,
            'subject'  => $request->subject,
            'msg'      => $request->msg
        ];
        Mail::to('receiver@gmail.com')->send(new CCMail($data));
        return 'Terimakasih sudah menghubungi kami!';

        // return view('auth.CC');
    }

    // Dashboard functions
    public function dashboardHR()
    {
        $totalEmployee = Employee::count();
        $totalDivision = Division::count();
        $totalInactive = Histories::count();
        return view('HR_Apps.website.dashboardHR', compact('totalEmployee', 'totalDivision', 'totalInactive'));
    }

    public function dashboardInven()
    {
        return view('Inventory_Apps.website.dashboardInven');
    }

    public function dashboardSales()
    {
        // Akumulasi order bulanan
        $order = Order::where('user_id', Auth::user()->id)
            ->whereMonth('order_date', Carbon::now()->month)
            ->whereNotNull('delivery_number')
            ->get();

        // Akumulasi order
        $orderDetail = Order::where('user_id', Auth::user()->id)->get();

        // Akumulasi total order
        $totalOrder = Order::where('user_id', Auth::user()->id)
            ->whereNotNull('delivery_number')->count();

        // Akumulasi total order bulanan
        $totalOrderMonthly = count($order);
        $orderReport = OrderReport::where('user_id', Auth::user()->id)->get();

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
        $lastYearOrders = Order::where('user_id', Auth::user()->id)
            ->whereYear('order_date', Carbon::now()->year)
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

        return view('Sales_Apps.pages.dashboardSales', compact('totalSales', 'totalSalesMonthly', 'totalOrder', 'totalOrderMonthly', 'orderReport', 'totalSalesMonthlyArray'));
    }

    public function dashboardFinance()
    {
        $user = Auth::user();

        return view('Finance_Apps.pages.dashboardFinance', compact('user'));
    }

    // Profile functions
    public function profile()
    {
        return view('HR_Apps.website.myProfile');
    }

    public function profileInven()
    {
        return view('Inventory_Apps.website.myProfileInven');
    }

    public function editProfile()
    {
        return view('HR_Apps.website.editProfile');
    }

    public function editProfileInven()
    {
        return view('Inventory_Apps.website.editProfileInven');
    }

    public function getDownload($id)
    {
        $orderReport = OrderReport::find($id);
        if (Storage::disk('report')->exists($orderReport->report)) {
            return response()->download(storage_path('/app/public/report_file/' . $orderReport->report));
        }

        return redirect()->back();
    }
}
