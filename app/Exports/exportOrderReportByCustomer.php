<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;

class exportOrderReportByCustomer implements FromView
{
    private $order, $soldCount, $salesCount;

    public function __construct()
    {
        if (Auth::user()->authorization_level == 2) {
            $order = Order::all();
        } else {
            $order = Order::where('user_id', Auth::user()->id)->get();
        }
        
        $soldCount = 0;
        $salesCount = 0;

        $this->order = $order;
        $this->soldCount = $soldCount;
        $this->salesCount = $salesCount;
    }

    public function view(): View
    {
        return view('Sales_Apps.export.orderReportByCustomer', [
            'order' => $this->order,
            'soldCount' => $this->soldCount,
            'salesCount' => $this->salesCount,
        ]);
    }
}
