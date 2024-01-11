<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;

class exportOrderReportByStatus implements FromView
{
    private $order;

    public function __construct()
    {
        if (Auth::user()->authorization_level == 2) {
            $order = Order::all();
        } else {
            $order = Order::where('user_id', Auth::user()->id)->get();
        }

        $this->order = $order;
    }

    public function view(): View
    {
        return view('Sales_Apps.export.orderReportByStatus', [
            'order' => $this->order,
        ]);
    }
}
