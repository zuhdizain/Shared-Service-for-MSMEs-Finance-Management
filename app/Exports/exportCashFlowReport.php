<?php

namespace App\Exports;

use App\Models\CashIn;
use App\Models\CostOfGoodsSold;
use App\Models\GeneralAdminCost;
use App\Models\OrderDetail;
use App\Models\SellingServiceExpenses;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class exportCashFlowReport implements FromView, ShouldAutoSize, WithStyles
{
    private $year, $ci;
    private $total1, $total2, $total3, $total4, $total5, $total6, $total7, $total8, $total9, $total10, $total11, $total12;
    private $salesMonth1, $salesMonth2, $salesMonth3, $salesMonth4, $salesMonth5, $salesMonth6, $salesMonth7, $salesMonth8, $salesMonth9, $salesMonth10, $salesMonth11, $salesMonth12;
    private $cogsArray1, $cogsArray2, $cogsArray3, $cogsArray4, $cogsArray5, $cogsArray6, $cogsArray7, $cogsArray8, $cogsArray9, $cogsArray10, $cogsArray11, $cogsArray12;
    private $sseArray1, $sseArray2, $sseArray3, $sseArray4, $sseArray5, $sseArray6, $sseArray7, $sseArray8, $sseArray9, $sseArray10, $sseArray11, $sseArray12;
    private $gacArray1, $gacArray2, $gacArray3, $gacArray4, $gacArray5, $gacArray6, $gacArray7, $gacArray8, $gacArray9, $gacArray10, $gacArray11, $gacArray12;

    public function __construct($year)
    {
        $ci = CashIn::where('user_id', Auth::user()->id)
            ->where('year', $year)
            ->first();
        $sales = OrderDetail::select('order_details.*', 'orders.order_date')
            ->join('orders', 'orders.id', '=', 'order_details.order_id')
            ->whereYear('orders.order_date', '=', $year)
            ->get();
        $cogs = CostOfGoodsSold::where('user_id', Auth::user()->id)
            ->whereYear('created_at', '=', $year)
            ->get();
        $sse = SellingServiceExpenses::where('user_id', Auth::user()->id)
            ->whereYear('created_at', '=', $year)
            ->get();
        $gac = GeneralAdminCost::where('user_id', Auth::user()->id)
            ->whereYear('created_at', '=', $year)
            ->get();

        // sales
        $salesMonth = [];
        for ($i = 1; $i <= 12; $i++) {
            $salesMonth[str_pad($i, 2, '0', STR_PAD_LEFT)] = 0;
        }

        foreach ($sales as $sale) {
            $month = (new DateTime($sale->order_date))->format('m');
            $totalSales = $sale->total_price;

            $salesMonth[$month] += $totalSales;
        }

        // cogs
        $cogsArray = [];
        for ($i = 1; $i <= 12; $i++) {
            $found = false;

            foreach ($cogs as $data) {
                if ($data->month == $i) {
                    $cogsArray[] = ($data->raw_material + $data->manpower + $data->factory_overhead);
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                $cogsArray[] = 0;
            }
        }

        // sse
        $sseArray = [];
        for ($i = 1; $i <= 12; $i++) {
            $found = false;

            foreach ($sse as $data) {
                if ($data->month == $i) {
                    $sseArray[] = ($data->adm_ecommerce + $data->marketing_salary + $data->marketing_operations + $data->other_cost);
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                $sseArray[] = 0;
            }
        }

        // gac
        $gacArray = [];
        for ($i = 1; $i <= 12; $i++) {
            $found = false;

            foreach ($gac as $data) {
                if ($data->month == $i) {
                    $gacArray[] = ($data->salaries_and_allowances + $data->electricity_and_water + $data->transportation + $data->communication + $data->office_stationery + $data->consultant + $data->cleanliness_and_security + $data->maintenance_and_renovation + $data->depreciation + $data->tax + $data->other_cost);
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                $gacArray[] = 0;
            }
        }

        // total
        $total1 = $salesMonth["01"] ? ($ci->cash + $salesMonth["01"] - $cogsArray[0] - $sseArray[0] - $gacArray[0]) : 0;
        $total2 = $salesMonth["02"] ? ($total1 + $salesMonth["02"] - $cogsArray[1] - $sseArray[1] - $gacArray[1]) : 0;
        $total3 = $salesMonth["03"] ? ($total2 + $salesMonth["03"] - $cogsArray[2] - $sseArray[2] - $gacArray[2]) : 0;
        $total4 = $salesMonth["04"] ? ($total3 + $salesMonth["04"] - $cogsArray[3] - $sseArray[3] - $gacArray[3]) : 0;
        $total5 = $salesMonth["05"] ? ($total4 + $salesMonth["05"] - $cogsArray[4] - $sseArray[4] - $gacArray[4]) : 0;
        $total6 = $salesMonth["06"] ? ($total5 + $salesMonth["06"] - $cogsArray[5] - $sseArray[5] - $gacArray[5]) : 0;
        $total7 = $salesMonth["07"] ? ($total6 + $salesMonth["07"] - $cogsArray[6] - $sseArray[6] - $gacArray[6]) : 0;
        $total8 = $salesMonth["08"] ? ($total7 + $salesMonth["08"] - $cogsArray[7] - $sseArray[7] - $gacArray[7]) : 0;
        $total9 = $salesMonth["09"] ? ($total8 + $salesMonth["09"] - $cogsArray[8] - $sseArray[8] - $gacArray[8]) : 0;
        $total10 = $salesMonth["10"] ? ($total9 + $salesMonth["10"] - $cogsArray[9] - $sseArray[9] - $gacArray[9]) : 0;
        $total11 = $salesMonth["11"] ? ($total10 + $salesMonth["11"] - $cogsArray[10] - $sseArray[10] - $gacArray[10]) : 0;
        $total12 = $salesMonth["12"] ? ($total11 + $salesMonth["12"] - $cogsArray[11] - $sseArray[11] - $gacArray[11]) : 0;

        $this->year = $year;
        $this->ci = $ci->cash;

        // total
        $this->total1 = $total1;
        $this->total2 = $total2;
        $this->total3 = $total3;
        $this->total4 = $total4;
        $this->total5 = $total5;
        $this->total6 = $total6;
        $this->total7 = $total7;
        $this->total8 = $total8;
        $this->total9 = $total9;
        $this->total10 = $total10;
        $this->total11 = $total11;
        $this->total12 = $total12;

        // sales
        $this->salesMonth1 = $salesMonth["01"];
        $this->salesMonth2 = $salesMonth["02"];
        $this->salesMonth3 = $salesMonth["03"];
        $this->salesMonth4 = $salesMonth["04"];
        $this->salesMonth5 = $salesMonth["05"];
        $this->salesMonth6 = $salesMonth["06"];
        $this->salesMonth7 = $salesMonth["07"];
        $this->salesMonth8 = $salesMonth["08"];
        $this->salesMonth9 = $salesMonth["09"];
        $this->salesMonth10 = $salesMonth["10"];
        $this->salesMonth11 = $salesMonth["11"];
        $this->salesMonth12 = $salesMonth["12"];

        // cogs
        $this->cogsArray1 = $cogsArray[0];
        $this->cogsArray2 = $cogsArray[1];
        $this->cogsArray3 = $cogsArray[2];
        $this->cogsArray4 = $cogsArray[3];
        $this->cogsArray5 = $cogsArray[4];
        $this->cogsArray6 = $cogsArray[5];
        $this->cogsArray7 = $cogsArray[6];
        $this->cogsArray8 = $cogsArray[7];
        $this->cogsArray9 = $cogsArray[8];
        $this->cogsArray10 = $cogsArray[9];
        $this->cogsArray11 = $cogsArray[10];
        $this->cogsArray12 = $cogsArray[11];

        // sse
        $this->sseArray1 = $sseArray[0];
        $this->sseArray2 = $sseArray[1];
        $this->sseArray3 = $sseArray[2];
        $this->sseArray4 = $sseArray[3];
        $this->sseArray5 = $sseArray[4];
        $this->sseArray6 = $sseArray[5];
        $this->sseArray7 = $sseArray[6];
        $this->sseArray8 = $sseArray[7];
        $this->sseArray9 = $sseArray[8];
        $this->sseArray10 = $sseArray[9];
        $this->sseArray11 = $sseArray[10];
        $this->sseArray12 = $sseArray[11];

        // gac
        $this->gacArray1 = $gacArray[0];
        $this->gacArray2 = $gacArray[1];
        $this->gacArray3 = $gacArray[2];
        $this->gacArray4 = $gacArray[3];
        $this->gacArray5 = $gacArray[4];
        $this->gacArray6 = $gacArray[5];
        $this->gacArray7 = $gacArray[6];
        $this->gacArray8 = $gacArray[7];
        $this->gacArray9 = $gacArray[8];
        $this->gacArray10 = $gacArray[9];
        $this->gacArray11 = $gacArray[10];
        $this->gacArray12 = $gacArray[11];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            'A4:M10' => [
                'borders' => [
                    'outline' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => [
                            'argb' => '000000'
                        ],
                    ],
                    'inside' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => [
                            'argb' => '000000'
                        ],
                    ],
                ],
            ],
            'A4:M4' => [
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => [
                        'argb' => 'a3b6ee',
                    ],
                ],
            ],
            'A10:M10' => [
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => [
                        'argb' => 'fceec9',
                    ],
                ],
            ],
        ];
    }

    public function view(): View
    {
        return view('Finance_Apps.export.cashFlowReport', [
            'year'          => $this->year,
            'ci'            => $this->ci,
            'total1'        => $this->total1,
            'total2'        => $this->total2,
            'total3'        => $this->total3,
            'total4'        => $this->total4,
            'total5'        => $this->total5,
            'total6'        => $this->total6,
            'total7'        => $this->total7,
            'total8'        => $this->total8,
            'total9'        => $this->total9,
            'total10'       => $this->total10,
            'total11'       => $this->total11,
            'total12'       => $this->total12,
            'salesMonth1'   => $this->salesMonth1,
            'salesMonth2'   => $this->salesMonth2,
            'salesMonth3'   => $this->salesMonth3,
            'salesMonth4'   => $this->salesMonth4,
            'salesMonth5'   => $this->salesMonth5,
            'salesMonth6'   => $this->salesMonth6,
            'salesMonth7'   => $this->salesMonth7,
            'salesMonth8'   => $this->salesMonth8,
            'salesMonth9'   => $this->salesMonth9,
            'salesMonth10'  => $this->salesMonth10,
            'salesMonth11'  => $this->salesMonth11,
            'salesMonth12'  => $this->salesMonth12,
            'cogsArray1'    => $this->cogsArray1,
            'cogsArray2'    => $this->cogsArray2,
            'cogsArray3'    => $this->cogsArray3,
            'cogsArray4'    => $this->cogsArray4,
            'cogsArray5'    => $this->cogsArray5,
            'cogsArray6'    => $this->cogsArray6,
            'cogsArray7'    => $this->cogsArray7,
            'cogsArray8'    => $this->cogsArray8,
            'cogsArray9'    => $this->cogsArray9,
            'cogsArray10'   => $this->cogsArray10,
            'cogsArray11'   => $this->cogsArray11,
            'cogsArray12'   => $this->cogsArray12,
            'sseArray1'     => $this->sseArray1,
            'sseArray2'     => $this->sseArray2,
            'sseArray3'     => $this->sseArray3,
            'sseArray4'     => $this->sseArray4,
            'sseArray5'     => $this->sseArray5,
            'sseArray6'     => $this->sseArray6,
            'sseArray7'     => $this->sseArray7,
            'sseArray8'     => $this->sseArray8,
            'sseArray9'     => $this->sseArray9,
            'sseArray10'    => $this->sseArray10,
            'sseArray11'    => $this->sseArray11,
            'sseArray12'    => $this->sseArray12,
            'gacArray1'     => $this->gacArray1,
            'gacArray2'     => $this->gacArray2,
            'gacArray3'     => $this->gacArray3,
            'gacArray4'     => $this->gacArray4,
            'gacArray5'     => $this->gacArray5,
            'gacArray6'     => $this->gacArray6,
            'gacArray7'     => $this->gacArray7,
            'gacArray8'     => $this->gacArray8,
            'gacArray9'     => $this->gacArray9,
            'gacArray10'    => $this->gacArray10,
            'gacArray11'    => $this->gacArray11,
            'gacArray12'    => $this->gacArray12
        ]);
    }
}
