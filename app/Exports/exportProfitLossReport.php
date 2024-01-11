<?php

namespace App\Exports;

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

class exportProfitLossReport implements FromView, ShouldAutoSize, WithStyles
{
    private $year;
    private $salesMonth1, $salesMonth2, $salesMonth3, $salesMonth4, $salesMonth5, $salesMonth6, $salesMonth7, $salesMonth8, $salesMonth9, $salesMonth10, $salesMonth11, $salesMonth12;
    private $cogsArray1, $cogsArray2, $cogsArray3, $cogsArray4, $cogsArray5, $cogsArray6, $cogsArray7, $cogsArray8, $cogsArray9, $cogsArray10, $cogsArray11, $cogsArray12;

    public function __construct($year)
    {
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
        $totalHPP = [];
        for ($i = 1; $i <= 12; $i++) {
            $found = false;

            foreach ($cogs as $data) {
                if ($data->month == $i) {
                    $cogsArray[] = $data;
                    $totalHPP[] = ($data->raw_material + $data->manpower + $data->factory_overhead);
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                $cogsArray[] = null;
                $totalHPP[] = null;
            }
        }

        // sse
        $sseArray = [];
        $totalSSE = [];
        for ($i = 1; $i <= 12; $i++) {
            $found = false;

            foreach ($sse as $data) {
                if ($data->month == $i) {
                    $sseArray[] = $data;
                    $totalSSE[] = ($data->adm_ecommerce + $data->marketing_salary + $data->marketing_operations + $data->other_cost);
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                $sseArray[] = 0;
                $totalSSE[] = 0;
            }
        }

        // gac
        $gacArray = [];
        $totalGAC = [];
        for ($i = 1; $i <= 12; $i++) {
            $found = false;

            foreach ($gac as $data) {
                if ($data->month == $i) {
                    $gacArray[] = $data;
                    $totalGAC[] = ($data->salaries_and_allowances + $data->electricity_and_water + $data->transportation + $data->communication + $data->office_stationery + $data->consultant + $data->cleanliness_and_security + $data->maintenance_and_renovation + $data->depreciation + $data->tax + $data->other_cost);
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                $gacArray[] = 0;
                $totalGAC[] = 0;
            }
        }

        // cogs
        $salesMonth1 = $salesMonth["01"];
        $salesMonth2 = $salesMonth["02"];
        $salesMonth3 = $salesMonth["03"];
        $salesMonth4 = $salesMonth["04"];
        $salesMonth5 = $salesMonth["05"];
        $salesMonth6 = $salesMonth["06"];
        $salesMonth7 = $salesMonth["07"];
        $salesMonth8 = $salesMonth["08"];
        $salesMonth9 = $salesMonth["09"];
        $salesMonth10 = $salesMonth["10"];
        $salesMonth11 = $salesMonth["11"];
        $salesMonth12 = $salesMonth["12"];

        // raw_material
        $cogsArray1 = $cogsArray[0];
        $cogsArray2 = $cogsArray[1];
        $cogsArray3 = $cogsArray[2];
        $cogsArray4 = $cogsArray[3];
        $cogsArray5 = $cogsArray[4];
        $cogsArray6 = $cogsArray[5];
        $cogsArray7 = $cogsArray[6];
        $cogsArray8 = $cogsArray[7];
        $cogsArray9 = $cogsArray[8];
        $cogsArray10 = $cogsArray[9];
        $cogsArray11 = $cogsArray[10];
        $cogsArray12 = $cogsArray[11];

        // net
        $net1 = ($salesMonth["01"] - $totalHPP[0] - $totalSSE[0] - $totalGAC[0]);
        $net2 = $salesMonth["02"] ? $net1 + ($salesMonth["02"] - $totalHPP[1] - $totalSSE[1] - $totalGAC[1]) : 0;
        $net3 = $salesMonth["03"] ? $net2 + ($salesMonth["03"] - $totalHPP[2] - $totalSSE[2] - $totalGAC[2]) : 0;
        $net4 = $salesMonth["04"] ? $net3 + ($salesMonth["04"] - $totalHPP[3] - $totalSSE[3] - $totalGAC[3]) : 0;
        $net5 = $salesMonth["05"] ? $net4 + ($salesMonth["05"] - $totalHPP[4] - $totalSSE[4] - $totalGAC[4]) : 0;
        $net6 = $salesMonth["06"] ? $net5 + ($salesMonth["06"] - $totalHPP[5] - $totalSSE[5] - $totalGAC[5]) : 0;
        $net7 = $salesMonth["07"] ? $net6 + ($salesMonth["07"] - $totalHPP[6] - $totalSSE[6] - $totalGAC[6]) : 0;
        $net8 = $salesMonth["08"] ? $net7 + ($salesMonth["08"] - $totalHPP[7] - $totalSSE[7] - $totalGAC[7]) : 0;
        $net9 = $salesMonth["09"] ? $net8 + ($salesMonth["09"] - $totalHPP[8] - $totalSSE[8] - $totalGAC[8]) : 0;
        $net10 = $salesMonth["10"] ? $net9 + ($salesMonth["10"] - $totalHPP[9] - $totalSSE[9] - $totalGAC[9]) : 0;
        $net11 = $salesMonth["11"] ? $net10 + ($salesMonth["11"] - $totalHPP[10] - $totalSSE[10] - $totalGAC[10]) : 0;
        $net12 = $salesMonth["12"] ? $net11 + ($salesMonth["12"] - $totalHPP[11] - $totalSSE[11] - $totalGAC[11]) : 0;

        // gross
        $gross1 = $salesMonth["01"] - $totalHPP[0];
        $gross2 = $salesMonth["02"] ? $net1 + ($salesMonth["02"] - $totalHPP[1]) : 0;
        $gross3 = $salesMonth["03"] ? $net2 + ($salesMonth["03"] - $totalHPP[2]) : 0;
        $gross4 = $salesMonth["04"] ? $net3 + ($salesMonth["04"] - $totalHPP[3]) : 0;
        $gross5 = $salesMonth["05"] ? $net4 + ($salesMonth["05"] - $totalHPP[4]) : 0;
        $gross6 = $salesMonth["06"] ? $net5 + ($salesMonth["06"] - $totalHPP[5]) : 0;
        $gross7 = $salesMonth["07"] ? $net6 + ($salesMonth["07"] - $totalHPP[6]) : 0;
        $gross8 = $salesMonth["08"] ? $net7 + ($salesMonth["08"] - $totalHPP[7]) : 0;
        $gross9 = $salesMonth["09"] ? $net8 + ($salesMonth["09"] - $totalHPP[8]) : 0;
        $gross10 = $salesMonth["10"] ? $net9 + ($salesMonth["10"] - $totalHPP[9]) : 0;
        $gross11 = $salesMonth["11"] ? $net10 + ($salesMonth["11"] - $totalHPP[10]) : 0;
        $gross12 = $salesMonth["12"] ? $net11 + ($salesMonth["12"] - $totalHPP[11]) : 0;

        // operating
        $operatingIncome1 = ($salesMonth["01"] - $totalHPP[0] - $totalSSE[0]);
        $operatingIncome2 = $net1 + ($salesMonth["02"] - $totalHPP[1] - $totalSSE[1]);
        $operatingIncome3 = $net2 + ($salesMonth["03"] - $totalHPP[2] - $totalSSE[2]);
        $operatingIncome4 = $net3 + ($salesMonth["04"] - $totalHPP[3] - $totalSSE[3]);
        $operatingIncome5 = $net4 + ($salesMonth["05"] - $totalHPP[4] - $totalSSE[4]);
        $operatingIncome6 = $net5 + ($salesMonth["06"] - $totalHPP[5] - $totalSSE[5]);
        $operatingIncome7 = $net6 + ($salesMonth["07"] - $totalHPP[6] - $totalSSE[6]);
        $operatingIncome8 = $net7 + ($salesMonth["08"] - $totalHPP[7] - $totalSSE[7]);
        $operatingIncome9 = $net8 + ($salesMonth["09"] - $totalHPP[8] - $totalSSE[8]);
        $operatingIncome10 = $net9 + ($salesMonth["10"] - $totalHPP[9] - $totalSSE[9]);
        $operatingIncome11 = $net10 + ($salesMonth["11"] - $totalHPP[10] - $totalSSE[10]);
        $operatingIncome12 = $net11 + ($salesMonth["12"] - $totalHPP[11] - $totalSSE[11]);

        $this->year = $year;

        // sales
        $this->salesMonth1 = $salesMonth1;
        $this->salesMonth2 = $salesMonth2;
        $this->salesMonth3 = $salesMonth3;
        $this->salesMonth4 = $salesMonth4;
        $this->salesMonth5 = $salesMonth5;
        $this->salesMonth6 = $salesMonth6;
        $this->salesMonth7 = $salesMonth7;
        $this->salesMonth8 = $salesMonth8;
        $this->salesMonth9 = $salesMonth9;
        $this->salesMonth10 = $salesMonth10;
        $this->salesMonth11 = $salesMonth11;
        $this->salesMonth12 = $salesMonth12;

        // cogs
        $this->cogsArray1 = $cogsArray1;
        $this->cogsArray2 = $cogsArray2;
        $this->cogsArray3 = $cogsArray3;
        $this->cogsArray4 = $cogsArray4;
        $this->cogsArray5 = $cogsArray5;
        $this->cogsArray6 = $cogsArray6;
        $this->cogsArray7 = $cogsArray7;
        $this->cogsArray8 = $cogsArray8;
        $this->cogsArray9 = $cogsArray9;
        $this->cogsArray10 = $cogsArray10;
        $this->cogsArray11 = $cogsArray11;
        $this->cogsArray12 = $cogsArray12;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            'A4:M35' => [
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
                        'argb' => 'a3b6ee', // dark blue
                    ],
                ],
            ],
            'A5' => [
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => [
                        'argb' => 'dddde2', // grey
                    ],
                ],
            ],
            'A7:M7' => [
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => [
                        'argb' => 'fceec9', // yellow
                    ],
                ],
            ],
            'A8' => [
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => [
                        'argb' => 'dddde2', // grey
                    ],
                ],
            ],
        ];
    }

    public function view(): View
    {
        return view('Finance_Apps.export.profitLossReport', [
            'year'          => $this->year,
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
        ]);
    }
}
