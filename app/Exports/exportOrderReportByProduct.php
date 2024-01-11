<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;

class exportOrderReportByProduct implements FromView
{
    private $product, $displayedProducts, $soldQuantities1, $soldQuantities2, $totalSales1, $totalSales2, $soldCount1, $soldCount2, $salesCount1, $salesCount2;

    public function __construct()
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
        $soldCount2 = 0;
        $salesCount1 = 0;
        $salesCount2 = 0;

        $this->product = $product;
        $this->displayedProducts = $displayedProducts;
        $this->soldQuantities1 = $soldQuantities1;
        $this->soldQuantities2 = $soldQuantities2;
        $this->totalSales1 = $totalSales1;
        $this->totalSales2 = $totalSales2;
        $this->soldCount1 = $soldCount1;
        $this->soldCount2 = $soldCount2;
        $this->salesCount1 = $salesCount1;
        $this->salesCount2 = $salesCount2;
    }

    public function view(): View
    {
        return view('Sales_Apps.export.orderReportByProduct', [
            'product' => $this->product,
            'displayedProducts' => $this->displayedProducts,
            'soldQuantities1' => $this->soldQuantities1,
            'soldQuantities2' => $this->soldQuantities2,
            'totalSales1' => $this->totalSales1,
            'totalSales2' => $this->totalSales2,
            'soldCount1' => $this->soldCount1,
            'soldCount2' => $this->soldCount2,
            'salesCount1' => $this->salesCount1,
            'salesCount2' => $this->salesCount2,
        ]);
    }
}
