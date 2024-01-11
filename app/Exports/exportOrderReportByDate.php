<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;

class exportOrderReportByDate implements FromView
{
    private $dateStart;
    private $dateEnd;
    private $order;

    public function __construct($dateStart, $dateEnd)
    {
        $dateStart = date("Y-m-d", strtotime($dateStart));
        $dateEnd = date("Y-m-d", strtotime($dateEnd));

        if (Auth::user()->authorization_level == 2) {
            $order = Order::whereBetween('order_date', [$dateStart, $dateEnd])
                ->get();
        } else {
            $order = Order::where('user_id', Auth::user()->id)
                ->whereBetween('order_date', [$dateStart, $dateEnd])
                ->get();
        }

        $this->dateStart = $dateStart;
        $this->dateEnd = $dateEnd;
        $this->order = $order;
    }

    public function view(): View
    {
        return view('Sales_Apps.export.orderReportByDate', [
            'order' => $this->order,
            'dateStart' => $this->dateStart,
            'dateEnd' => $this->dateEnd
        ]);
    }
}
