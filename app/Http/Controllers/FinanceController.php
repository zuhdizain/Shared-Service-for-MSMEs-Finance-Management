<?php

namespace App\Http\Controllers;

use App\Exports\exportBalanceSheetReport;
use App\Http\Controllers\Controller;
use App\Models\CashIn;
use App\Models\CostOfGoodsSold;
use App\Models\CurrentAsset;
use App\Models\GeneralAdminCost;
use App\Models\NonCurrentAsset;
use App\Models\OrderDetail;
use App\Models\SellingServiceExpenses;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class FinanceController extends Controller
{
    private function strToIntr($str)
    {
        $string = str_replace('.', '', $str);
        $integer = (int)$string;

        return $integer;
    }

    // Balance Sheet
    public function balanceSheet()
    {
        return view('Finance_Apps.pages.manage.balanceSheet');
    }

    public function getBalanceSheet($month)
    {
        $year = date("Y");

        if ($month != 0) {
            // Get CA
            $ca = CurrentAsset::where('user_id', Auth::user()->id)
                ->where('month', $month)
                ->whereYear('created_at', '=', $year)
                ->first();

            // Get NCA
            $nca = NonCurrentAsset::where('user_id', Auth::user()->id)
                ->where('month', $month)
                ->whereYear('created_at', '=', $year)
                ->first();

            return response()->json([
                'status'    => true,
                'data'      => [
                    'ca'    => $ca,
                    'nca'   => $nca,
                ],
            ]);
        } else {
            return response()->json([
                'status'    => false,
            ]);
        }
    }

    public function addBalanceSheet(Request $request)
    {
        // Validation data
        $validation = $request->validate([
            'month'                 => 'required',
            'cashCA'                => 'required',
            'accountsReceivableCA'  => 'required',
            'suppliesCA'            => 'required',
            'otherCA'               => 'required',
            'fixedAssetsNCA'        => 'required',
            'depreciationNCA'       => 'required',
        ]);

        // Insert CA
        CurrentAsset::create([
            'user_id'               => Auth::user()->id,
            'month'                 => $this->strToIntr($validation['month']),
            'cash'                  => $this->strToIntr($validation['cashCA']),
            'accounts_receivable'   => $this->strToIntr($validation['accountsReceivableCA']),
            'supplies'              => $this->strToIntr($validation['suppliesCA']),
            'other_current_assets'  => $this->strToIntr($validation['otherCA']),
        ])->save();

        // Insert NCA
        NonCurrentAsset::create([
            'user_id'       => Auth::user()->id,
            'month'         => $this->strToIntr($validation['month']),
            'fixed_assets'  => $this->strToIntr($validation['fixedAssetsNCA']),
            'depreciation'  => $this->strToIntr($validation['depreciationNCA']),
        ])->save();

        return redirect()->back();
    }

    public function updateBalanceSheet(Request $request)
    {
        // Get data
        $caID = $request->input('caID');
        $ncaID = $request->input('ncaID');
        $current_asset = CurrentAsset::where('id', $caID)->first();
        $non_current_asset = NonCurrentAsset::where('id', $ncaID)->first();

        // Validation data
        $validation = $request->validate([
            'cashCA'                => 'required',
            'accountsReceivableCA'  => 'required',
            'suppliesCA'            => 'required',
            'otherCA'               => 'required',
            'fixedAssetsNCA'        => 'required',
            'depreciationNCA'       => 'required',
        ]);

        // Update CA
        $current_asset->update([
            'cash'                  => $this->strToIntr($validation['cashCA']),
            'accounts_receivable'   => $this->strToIntr($validation['accountsReceivableCA']),
            'supplies'              => $this->strToIntr($validation['suppliesCA']),
            'other_current_assets'  => $this->strToIntr($validation['otherCA']),
        ]);

        // Update NCA
        $non_current_asset->update([
            'fixed_assets'  => $this->strToIntr($validation['fixedAssetsNCA']),
            'depreciation'  => $this->strToIntr($validation['depreciationNCA']),
        ]);

        return redirect()->back();
    }

    public function balanceSheetReport(Request $request)
    {
        // Get data
        $dateStart = DateTime::createFromFormat('Y-m-d', $request->dateStart);
        $dateEnd = DateTime::createFromFormat('Y-m-d', $request->dateEnd);
        $monthStart = (int)$dateStart->format('m');
        $monthEnd = (int)$dateEnd->format('m');
        $months = range($monthStart, $monthEnd);
        $year = (int)$dateEnd->format('Y');
        $html = '';

        $cashCA = 0;
        $accountsReceivableCA = 0;
        $suppliesCA = 0;
        $otherCA = 0;
        $totalCA = 0;

        $fixedAssetsNCA = 0;
        $depreciationNCA = 0;
        $totalNCA = 0;

        foreach ($months as $month) {
            $ca = CurrentAsset::where('user_id', Auth::user()->id)
                ->where('month', $month)
                ->whereYear('created_at', '=', $year)
                ->first();

            $nca = NonCurrentAsset::where('user_id', Auth::user()->id)
                ->where('month', $month)
                ->whereYear('created_at', '=', $year)
                ->first();

            if ($ca) {
                $cashCA += $ca->cash;
                $accountsReceivableCA += $ca->accounts_receivable;
                $suppliesCA += $ca->supplies;
                $otherCA += $ca->other_current_assets;
            }

            if ($nca) {
                $fixedAssetsNCA += $nca->fixed_assets;
                $depreciationNCA += $nca->depreciation;
            }
        }

        $totalCA = $cashCA + $accountsReceivableCA + $suppliesCA + $otherCA;
        $totalNCA = $fixedAssetsNCA - $depreciationNCA;
        $totalAsset = $totalCA + $totalNCA;

        $html .= '
            <h6 class="mb-3 text-gray-800 text-center"><b>BALANCE SHEET</b></h6>
            <h6 class="mb-3 text-gray-800 text-center"><b>PER TANGGAL ' . date("d/m/Y", strtotime($request->dateStart)) . ' - ' . date("d/m/Y", strtotime($request->dateEnd)) . '</b></h6>
            <table class="table">
                <thead class="table-primary">
                    <th colspan="2"><b>Aset Lancar</b></th>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-indent: 40px;">Kas dan setara kas</td>
                        <td>Rp ' .  number_format($cashCA, 0, ',', '.') . '</td>
                    </tr>
                    <tr>
                        <td style="text-indent: 40px;">Piutang usaha</td>
                        <td>Rp ' .  number_format($accountsReceivableCA, 0, ',', '.') . '</td>
                    </tr>
                    <tr>
                        <td style="text-indent: 40px;">Persediaan</td>
                        <td>Rp ' .  number_format($suppliesCA, 0, ',', '.') . '</td>
                    </tr>
                    <tr>
                        <td style="text-indent: 40px;">Aset lancar lainnya</td>
                        <td>Rp ' .  number_format($otherCA, 0, ',', '.') . '</td>
                    </tr>
                    <tr>
                        <td class="table-warning"><b>Jumlah aset lancar</b></td>
                        <td class="table-warning"><b>Rp ' .  number_format($totalCA, 0, ',', '.') . '</b></td>
                    </tr>
                    <tr>
                        <td class="table-primary"><b>Aset Tidak Lancar</b></td>
                        <td class="table-primary"></td>
                    </tr>
                    <tr>
                        <td style="text-indent: 40px;">Aset tetap</td>
                        <td>Rp ' .  number_format($fixedAssetsNCA, 0, ',', '.') . '</td>
                    </tr>
                    <tr>
                        <td style="text-indent: 40px;">Akumulasi penyusutan</td>
                        <td>(Rp ' .  number_format($depreciationNCA, 0, ',', '.') . ')</td>
                    </tr>
                    <tr>
                        <td class="table-warning"><b>Jumlah aset tidak lancar</b></td>
                        <td class="table-warning"><b>Rp ' .  number_format($totalNCA, 0, ',', '.') . '</b></td>
                    </tr>
                    <tr>
                        <td class="table-info"><b>Jumlah aset</b></td>
                        <td class="table-info" id="totalAsset"><b>Rp ' .  number_format($totalAsset, 0, ',', '.') . '</b></td>
                    </tr>
                </tbody>
            </table>
            <form action="' . route('report.exportBalanceSheet') . '" method="GET">
                <input type="text" name="dateStart" value="' . $request->dateStart . '" hidden>
                <input type="text" name="dateEnd" value="' . $request->dateEnd . '" hidden>
                <button type="submit" class="btn btn-warning btn-user px-5">
                    Export Laporan
                </button>
            </form>
        ';

        return $html;
    }

    // Profit & Loss
    public function profitLoss()
    {
        $years = CostOfGoodsSold::selectRaw('DISTINCT YEAR(created_at) as year')
            ->pluck('year');

        return view('Finance_Apps.pages.manage.profitLoss', compact('years'));
    }

    public function getProfitLoss($month)
    {
        $year = date("Y");

        if ($month != 0) {
            // Get COGS
            $cogs = CostOfGoodsSold::where('user_id', Auth::user()->id)
                ->where('month', $month)
                ->whereYear('created_at', '=', $year)
                ->first();

            // Get SSE
            $sse = SellingServiceExpenses::where('user_id', Auth::user()->id)
                ->where('month', $month)
                ->whereYear('created_at', '=', $year)
                ->first();

            // Get GAC
            $gac = GeneralAdminCost::where('user_id', Auth::user()->id)
                ->where('month', $month)
                ->whereYear('created_at', '=', $year)
                ->first();

            return response()->json([
                'status'    => true,
                'data'      => [
                    'cogs'  => $cogs,
                    'sse'   => $sse,
                    'gac'   => $gac,
                ],
            ]);
        } else {
            return response()->json([
                'status'    => false,
            ]);
        }
    }

    public function getProfitLossCOGS($month)
    {
        $year = date("Y");

        if ($month != 0) {
            // Get COGS
            $cogs = CostOfGoodsSold::where('user_id', Auth::user()->id)
                ->where('month', $month)
                ->whereYear('created_at', '=', $year)
                ->first();

            return response()->json([
                'status'    => true,
                'data'      => [
                    'cogs'  => $cogs
                ],
            ]);
        } else {
            return response()->json([
                'status'    => false,
            ]);
        }
    }

    public function addProfitLossCOGS(Request $request)
    {
        // Validation data
        $validation = $request->validate([
            'month'                 => 'required',
            'rawMaterialCOGS'       => 'required',
            'manpowerCOGS'          => 'required',
            'factoryOverheadCOGS'   => 'required',
        ]);

        // Insert COGS
        CostOfGoodsSold::create([
            'user_id'           => Auth::user()->id,
            'month'             => $this->strToIntr($validation['month']),
            'raw_material'      => $this->strToIntr($validation['rawMaterialCOGS']),
            'manpower'          => $this->strToIntr($validation['manpowerCOGS']),
            'factory_overhead'  => $this->strToIntr($validation['factoryOverheadCOGS']),
        ])->save();

        return redirect()->back();
    }

    public function updateProfitLossCOGS(Request $request)
    {
        // Get data
        $cogsID = $request->input('cogsID');
        $cost_of_goods_sold = CostOfGoodsSold::where('id', $cogsID)->first();

        // Validation data
        $validation = $request->validate([
            'rawMaterialCOGS'       => 'required',
            'manpowerCOGS'          => 'required',
            'factoryOverheadCOGS'   => 'required',
        ]);

        // Update COGS
        $cost_of_goods_sold->update([
            'raw_material'      => $this->strToIntr($validation['rawMaterialCOGS']),
            'manpower'          => $this->strToIntr($validation['manpowerCOGS']),
            'factory_overhead'  => $this->strToIntr($validation['factoryOverheadCOGS']),
        ]);

        return redirect()->back();
    }

    public function getProfitLossSSE($month)
    {
        $year = date("Y");

        if ($month != 0) {
            // Get SSE
            $sse = SellingServiceExpenses::where('user_id', Auth::user()->id)
                ->where('month', $month)
                ->whereYear('created_at', '=', $year)
                ->first();

            return response()->json([
                'status'    => true,
                'data'      => [
                    'sse'  => $sse
                ],
            ]);
        } else {
            return response()->json([
                'status'    => false,
            ]);
        }
    }

    public function addProfitLossSSE(Request $request)
    {
        // Validation data
        $validation = $request->validate([
            'month'                     => 'required',
            'admEcommerceSSE'           => 'required',
            'marketingSalarySSE'        => 'required',
            'marketingOperationsSSE'    => 'required',
            'otherCostSSE'              => 'required',
        ]);

        // Insert SSE
        SellingServiceExpenses::create([
            'user_id'               => Auth::user()->id,
            'month'                 => $this->strToIntr($validation['month']),
            'adm_ecommerce'         => $this->strToIntr($validation['admEcommerceSSE']),
            'marketing_salary'      => $this->strToIntr($validation['marketingSalarySSE']),
            'marketing_operations'  => $this->strToIntr($validation['marketingOperationsSSE']),
            'other_cost'            => $this->strToIntr($validation['otherCostSSE']),
        ])->save();

        return redirect()->back();
    }

    public function updateProfitLossSSE(Request $request)
    {
        // Get data
        $sseID = $request->input('sseID');
        $selling_service_expenses = SellingServiceExpenses::where('id', $sseID)->first();

        // Validation data
        $validation = $request->validate([
            'admEcommerceSSE'           => 'required',
            'marketingSalarySSE'        => 'required',
            'marketingOperationsSSE'    => 'required',
            'otherCostSSE'              => 'required',
        ]);

        // Update SSE
        $selling_service_expenses->update([
            'adm_ecommerce'         => $this->strToIntr($validation['admEcommerceSSE']),
            'marketing_salary'      => $this->strToIntr($validation['marketingSalarySSE']),
            'marketing_operations'  => $this->strToIntr($validation['marketingOperationsSSE']),
            'other_cost'            => $this->strToIntr($validation['otherCostSSE']),
        ]);

        return redirect()->back();
    }

    public function getProfitLossGA($month)
    {
        $year = date("Y");

        if ($month != 0) {
            // Get GAC
            $gac = GeneralAdminCost::where('user_id', Auth::user()->id)
                ->where('month', $month)
                ->whereYear('created_at', '=', $year)
                ->first();

            return response()->json([
                'status'    => true,
                'data'      => [
                    'gac'  => $gac
                ],
            ]);
        } else {
            return response()->json([
                'status'    => false,
            ]);
        }
    }

    public function addProfitLossGA(Request $request)
    {
        // Validation data
        $validation = $request->validate([
            'month'                     => 'required',
            'salariesAllowancesGA'      => 'required',
            'electricityWaterGA'        => 'required',
            'transportationGA'          => 'required',
            'communicationGA'           => 'required',
            'officeStationeryGA'        => 'required',
            'consultantGA'              => 'required',
            'cleanlinessSecurityGA'     => 'required',
            'maintenanceRenovationGA'   => 'required',
            'depreciationGA'            => 'required',
            'taxGA'                     => 'required',
            'otherCostGA'               => 'required',
        ]);

        // Insert GAC
        GeneralAdminCost::create([
            'user_id'                   => Auth::user()->id,
            'month'                     => $this->strToIntr($validation['month']),
            'salaries_and_allowances'   => $this->strToIntr($validation['salariesAllowancesGA']),
            'electricity_and_water'     => $this->strToIntr($validation['electricityWaterGA']),
            'transportation'            => $this->strToIntr($validation['transportationGA']),
            'communication'             => $this->strToIntr($validation['communicationGA']),
            'office_stationery'         => $this->strToIntr($validation['officeStationeryGA']),
            'consultant'                => $this->strToIntr($validation['consultantGA']),
            'cleanliness_and_security'  => $this->strToIntr($validation['cleanlinessSecurityGA']),
            'maintenance_and_renovation' => $this->strToIntr($validation['maintenanceRenovationGA']),
            'depreciation'              => $this->strToIntr($validation['depreciationGA']),
            'tax'                       => $this->strToIntr($validation['taxGA']),
            'other_cost'                => $this->strToIntr($validation['otherCostGA']),
        ])->save();

        return redirect()->back();
    }

    public function updateProfitLossGA(Request $request)
    {
        // Get data
        $gacID = $request->input('gacID');
        $general_admin_cost = GeneralAdminCost::where('id', $gacID)->first();

        // Validation data
        $validation = $request->validate([
            'salariesAllowancesGA'      => 'required',
            'electricityWaterGA'        => 'required',
            'transportationGA'          => 'required',
            'communicationGA'           => 'required',
            'officeStationeryGA'        => 'required',
            'consultantGA'              => 'required',
            'cleanlinessSecurityGA'     => 'required',
            'maintenanceRenovationGA'   => 'required',
            'depreciationGA'            => 'required',
            'taxGA'                     => 'required',
            'otherCostGA'               => 'required',
        ]);

        // Update GAC
        $general_admin_cost->update([
            'salaries_and_allowances'   => $this->strToIntr($validation['salariesAllowancesGA']),
            'electricity_and_water'     => $this->strToIntr($validation['electricityWaterGA']),
            'transportation'            => $this->strToIntr($validation['transportationGA']),
            'communication'             => $this->strToIntr($validation['communicationGA']),
            'office_stationery'         => $this->strToIntr($validation['officeStationeryGA']),
            'consultant'                => $this->strToIntr($validation['consultantGA']),
            'cleanliness_and_security'  => $this->strToIntr($validation['cleanlinessSecurityGA']),
            'maintenance_and_renovation' => $this->strToIntr($validation['maintenanceRenovationGA']),
            'depreciation'              => $this->strToIntr($validation['depreciationGA']),
            'tax'                       => $this->strToIntr($validation['taxGA']),
            'other_cost'                => $this->strToIntr($validation['otherCostGA']),
        ]);

        return redirect()->back();
    }

    public function profitLossReport(Request $request)
    {
        // Get data
        $sales = OrderDetail::select('order_details.*', 'orders.order_date')
            ->join('orders', 'orders.id', '=', 'order_details.order_id')
            ->whereYear('orders.order_date', '=', $request->year)
            ->get();
        $cogs = CostOfGoodsSold::where('user_id', Auth::user()->id)
            ->whereYear('created_at', '=', $request->year)
            ->get();
        $sse = SellingServiceExpenses::where('user_id', Auth::user()->id)
            ->whereYear('created_at', '=', $request->year)
            ->get();
        $gac = GeneralAdminCost::where('user_id', Auth::user()->id)
            ->whereYear('created_at', '=', $request->year)
            ->get();
        $html = '';

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
                $sseArray[] = null;
                $totalSSE[] = null;
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
                $gacArray[] = null;
                $totalGAC[] = null;
            }
        }

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

        $html .= '
            <h6 class="mb-3 text-gray-800 text-center"><b>PROFIT & LOSS</b></h6>
            <h6 class="mb-3 text-gray-800 text-center"><b>TAHUN ' . $request->year . '</b></h6>

            <div class="table-responsive" style="width:2500px">
                <table class="table table-bordered">
                    <thead class="table-primary">
                        <th class="text-center" style="width:16%"><b>Keterangan</b></th>
                        <th class="text-center" style="width:7%"><b>Januari</b></th>
                        <th class="text-center" style="width:7%"><b>Februari</b></th>
                        <th class="text-center" style="width:7%"><b>Maret</b></th>
                        <th class="text-center" style="width:7%"><b>April</b></th>
                        <th class="text-center" style="width:7%"><b>Mei</b></th>
                        <th class="text-center" style="width:7%"><b>Juni</b></th>
                        <th class="text-center" style="width:7%"><b>Juli</b></th>
                        <th class="text-center" style="width:7%"><b>Agustus</b></th>
                        <th class="text-center" style="width:7%"><b>September</b></th>
                        <th class="text-center" style="width:7%"><b>Oktober</b></th>
                        <th class="text-center" style="width:7%"><b>November</b></th>
                        <th class="text-center" style="width:7%"><b>Desember</b></th>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="13" class="table-secondary"><b>Penjualan</b></td>
                        </tr>
                        <tr>
                            <td style="text-indent: 40px;">Sales</td>
                            <td>Rp ' . number_format($salesMonth["01"], 0, ',', '.') . '</td>
                            <td>Rp ' . number_format($salesMonth["02"], 0, ',', '.') . '</td>
                            <td>Rp ' . number_format($salesMonth["03"], 0, ',', '.') . '</td>
                            <td>Rp ' . number_format($salesMonth["04"], 0, ',', '.') . '</td>
                            <td>Rp ' . number_format($salesMonth["05"], 0, ',', '.') . '</td>
                            <td>Rp ' . number_format($salesMonth["06"], 0, ',', '.') . '</td>
                            <td>Rp ' . number_format($salesMonth["07"], 0, ',', '.') . '</td>
                            <td>Rp ' . number_format($salesMonth["08"], 0, ',', '.') . '</td>
                            <td>Rp ' . number_format($salesMonth["09"], 0, ',', '.') . '</td>
                            <td>Rp ' . number_format($salesMonth["10"], 0, ',', '.') . '</td>
                            <td>Rp ' . number_format($salesMonth["11"], 0, ',', '.') . '</td>
                            <td>Rp ' . number_format($salesMonth["12"], 0, ',', '.') . '</td>
                        </tr>
                        <tr>
                            <td class="table-warning"><b>Total Sales</b></td>
                            <td class="table-warning"><b>Rp ' . number_format($salesMonth["01"], 0, ',', '.') . '</b></td>
                            <td class="table-warning"><b>Rp ' . number_format($salesMonth["02"], 0, ',', '.') . '</b></td>
                            <td class="table-warning"><b>Rp ' . number_format($salesMonth["03"], 0, ',', '.') . '</b></td>
                            <td class="table-warning"><b>Rp ' . number_format($salesMonth["04"], 0, ',', '.') . '</b></td>
                            <td class="table-warning"><b>Rp ' . number_format($salesMonth["05"], 0, ',', '.') . '</b></td>
                            <td class="table-warning"><b>Rp ' . number_format($salesMonth["06"], 0, ',', '.') . '</b></td>
                            <td class="table-warning"><b>Rp ' . number_format($salesMonth["07"], 0, ',', '.') . '</b></td>
                            <td class="table-warning"><b>Rp ' . number_format($salesMonth["08"], 0, ',', '.') . '</b></td>
                            <td class="table-warning"><b>Rp ' . number_format($salesMonth["09"], 0, ',', '.') . '</b></td>
                            <td class="table-warning"><b>Rp ' . number_format($salesMonth["10"], 0, ',', '.') . '</b></td>
                            <td class="table-warning"><b>Rp ' . number_format($salesMonth["11"], 0, ',', '.') . '</b></td>
                            <td class="table-warning"><b>Rp ' . number_format($salesMonth["12"], 0, ',', '.') . '</b></td>
                        </tr>
                        <tr>
                            <td colspan="13" class="table-secondary"><b>HPP</b></td>
                        </tr>
                        <tr>
                            <td style="text-indent: 40px;">BI. Bahan baku</td>
                            <td>Rp ' . (isset($cogsArray[0]) ? number_format($cogsArray[0]->raw_material, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($cogsArray[1]) ? number_format($cogsArray[1]->raw_material, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($cogsArray[2]) ? number_format($cogsArray[2]->raw_material, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($cogsArray[3]) ? number_format($cogsArray[3]->raw_material, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($cogsArray[4]) ? number_format($cogsArray[4]->raw_material, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($cogsArray[5]) ? number_format($cogsArray[5]->raw_material, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($cogsArray[6]) ? number_format($cogsArray[6]->raw_material, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($cogsArray[7]) ? number_format($cogsArray[7]->raw_material, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($cogsArray[8]) ? number_format($cogsArray[8]->raw_material, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($cogsArray[9]) ? number_format($cogsArray[9]->raw_material, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($cogsArray[10]) ? number_format($cogsArray[10]->raw_material, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($cogsArray[11]) ? number_format($cogsArray[11]->raw_material, 0, ',', '.') : "0") . '</td>
                        </tr>
                        <tr>
                            <td style="text-indent: 40px">BI. Tenaga kerja</td>
                            <td>Rp ' . (isset($cogsArray[0]) ? number_format($cogsArray[0]->manpower, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($cogsArray[1]) ? number_format($cogsArray[1]->manpower, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($cogsArray[2]) ? number_format($cogsArray[2]->manpower, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($cogsArray[3]) ? number_format($cogsArray[3]->manpower, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($cogsArray[4]) ? number_format($cogsArray[4]->manpower, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($cogsArray[5]) ? number_format($cogsArray[5]->manpower, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($cogsArray[6]) ? number_format($cogsArray[6]->manpower, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($cogsArray[7]) ? number_format($cogsArray[7]->manpower, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($cogsArray[8]) ? number_format($cogsArray[8]->manpower, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($cogsArray[9]) ? number_format($cogsArray[9]->manpower, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($cogsArray[10]) ? number_format($cogsArray[10]->manpower, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($cogsArray[11]) ? number_format($cogsArray[11]->manpower, 0, ',', '.') : "0") . '</td>
                        </tr>
                        <tr>
                            <td style="text-indent: 40px;">BI. Overhead pabrik</td>
                            <td>Rp ' . (isset($cogsArray[0]) ? number_format($cogsArray[0]->factory_overhead, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($cogsArray[1]) ? number_format($cogsArray[1]->factory_overhead, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($cogsArray[2]) ? number_format($cogsArray[2]->factory_overhead, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($cogsArray[3]) ? number_format($cogsArray[3]->factory_overhead, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($cogsArray[4]) ? number_format($cogsArray[4]->factory_overhead, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($cogsArray[5]) ? number_format($cogsArray[5]->factory_overhead, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($cogsArray[6]) ? number_format($cogsArray[6]->factory_overhead, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($cogsArray[7]) ? number_format($cogsArray[7]->factory_overhead, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($cogsArray[8]) ? number_format($cogsArray[8]->factory_overhead, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($cogsArray[9]) ? number_format($cogsArray[9]->factory_overhead, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($cogsArray[10]) ? number_format($cogsArray[10]->factory_overhead, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($cogsArray[11]) ? number_format($cogsArray[11]->factory_overhead, 0, ',', '.') : "0") . '</td>
                        </tr>
                        <tr>
                            <td class="table-warning"><b>Total HPP</b></td>
                            <td class="table-warning"><b>(Rp ' . (isset($totalHPP[0]) ? number_format($totalHPP[0], 0, ',', '.') : "0") . ')</b></td>
                            <td class="table-warning"><b>(Rp ' . (isset($totalHPP[1]) ? number_format($totalHPP[1], 0, ',', '.') : "0") . ')</b></td>
                            <td class="table-warning"><b>(Rp ' . (isset($totalHPP[2]) ? number_format($totalHPP[2], 0, ',', '.') : "0") . ')</b></td>
                            <td class="table-warning"><b>(Rp ' . (isset($totalHPP[3]) ? number_format($totalHPP[3], 0, ',', '.') : "0") . ')</b></td>
                            <td class="table-warning"><b>(Rp ' . (isset($totalHPP[4]) ? number_format($totalHPP[4], 0, ',', '.') : "0") . ')</b></td>
                            <td class="table-warning"><b>(Rp ' . (isset($totalHPP[5]) ? number_format($totalHPP[5], 0, ',', '.') : "0") . ')</b></td>
                            <td class="table-warning"><b>(Rp ' . (isset($totalHPP[6]) ? number_format($totalHPP[6], 0, ',', '.') : "0") . ')</b></td>
                            <td class="table-warning"><b>(Rp ' . (isset($totalHPP[7]) ? number_format($totalHPP[7], 0, ',', '.') : "0") . ')</b></td>
                            <td class="table-warning"><b>(Rp ' . (isset($totalHPP[8]) ? number_format($totalHPP[8], 0, ',', '.') : "0") . ')</b></td>
                            <td class="table-warning"><b>(Rp ' . (isset($totalHPP[9]) ? number_format($totalHPP[9], 0, ',', '.') : "0") . ')</b></td>
                            <td class="table-warning"><b>(Rp ' . (isset($totalHPP[10]) ? number_format($totalHPP[10], 0, ',', '.') : "0") . ')</b></td>
                            <td class="table-warning"><b>(Rp ' . (isset($totalHPP[11]) ? number_format($totalHPP[11], 0, ',', '.') : "0") . ')</b></td>
                        </tr>
                        <tr>
                            <td class="table-info"><b>Gross Profit/Loss</b></td>
                            <td class="table-info"><b>Rp ' . (number_format($gross1, 0, ',', '.')) . '</b></td>
                            <td class="table-info"><b>Rp ' . (number_format($gross2, 0, ',', '.')) . '</b></td>
                            <td class="table-info"><b>Rp ' . (number_format($gross3, 0, ',', '.')) . '</b></td>
                            <td class="table-info"><b>Rp ' . (number_format($gross4, 0, ',', '.')) . '</b></td>
                            <td class="table-info"><b>Rp ' . (number_format($gross5, 0, ',', '.')) . '</b></td>
                            <td class="table-info"><b>Rp ' . (number_format($gross6, 0, ',', '.')) . '</b></td>
                            <td class="table-info"><b>Rp ' . (number_format($gross7, 0, ',', '.')) . '</b></td>
                            <td class="table-info"><b>Rp ' . (number_format($gross8, 0, ',', '.')) . '</b></td>
                            <td class="table-info"><b>Rp ' . (number_format($gross9, 0, ',', '.')) . '</b></td>
                            <td class="table-info"><b>Rp ' . (number_format($gross10, 0, ',', '.')) . '</b></td>
                            <td class="table-info"><b>Rp ' . (number_format($gross11, 0, ',', '.')) . '</b></td>
                            <td class="table-info"><b>Rp ' . (number_format($gross12, 0, ',', '.')) . '</b></td>
                        </tr>
                        <tr>
                            <td colspan="13" class="table-secondary"><b>BI. Penjualan</b></td>
                        </tr>
                        <tr>
                            <td style="text-indent: 40px;">BI. Adm e-commerce</td>
                            <td>Rp ' . (isset($sseArray[0]) ? number_format($sseArray[0]->adm_ecommerce, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($sseArray[1]) ? number_format($sseArray[1]->adm_ecommerce, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($sseArray[2]) ? number_format($sseArray[2]->adm_ecommerce, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($sseArray[3]) ? number_format($sseArray[3]->adm_ecommerce, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($sseArray[4]) ? number_format($sseArray[4]->adm_ecommerce, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($sseArray[5]) ? number_format($sseArray[5]->adm_ecommerce, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($sseArray[6]) ? number_format($sseArray[6]->adm_ecommerce, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($sseArray[7]) ? number_format($sseArray[7]->adm_ecommerce, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($sseArray[8]) ? number_format($sseArray[8]->adm_ecommerce, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($sseArray[9]) ? number_format($sseArray[9]->adm_ecommerce, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($sseArray[10]) ? number_format($sseArray[10]->adm_ecommerce, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($sseArray[11]) ? number_format($sseArray[11]->adm_ecommerce, 0, ',', '.') : "0") . '</td>
                        </tr>
                        <tr>
                            <td style="text-indent: 40px;">BI. Gaji marketing</td>
                            <td>Rp ' . (isset($sseArray[0]) ? number_format($sseArray[0]->marketing_salary, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($sseArray[1]) ? number_format($sseArray[1]->marketing_salary, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($sseArray[2]) ? number_format($sseArray[2]->marketing_salary, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($sseArray[3]) ? number_format($sseArray[3]->marketing_salary, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($sseArray[4]) ? number_format($sseArray[4]->marketing_salary, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($sseArray[5]) ? number_format($sseArray[5]->marketing_salary, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($sseArray[6]) ? number_format($sseArray[6]->marketing_salary, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($sseArray[7]) ? number_format($sseArray[7]->marketing_salary, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($sseArray[8]) ? number_format($sseArray[8]->marketing_salary, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($sseArray[9]) ? number_format($sseArray[9]->marketing_salary, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($sseArray[10]) ? number_format($sseArray[10]->marketing_salary, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($sseArray[11]) ? number_format($sseArray[11]->marketing_salary, 0, ',', '.') : "0") . '</td>
                        </tr>
                        <tr>
                            <td style="text-indent: 40px;">Operasional marketing</td>
                            <td>Rp ' . (isset($sseArray[0]) ? number_format($sseArray[0]->marketing_operations, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($sseArray[1]) ? number_format($sseArray[1]->marketing_operations, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($sseArray[2]) ? number_format($sseArray[2]->marketing_operations, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($sseArray[3]) ? number_format($sseArray[3]->marketing_operations, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($sseArray[4]) ? number_format($sseArray[4]->marketing_operations, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($sseArray[5]) ? number_format($sseArray[5]->marketing_operations, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($sseArray[6]) ? number_format($sseArray[6]->marketing_operations, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($sseArray[7]) ? number_format($sseArray[7]->marketing_operations, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($sseArray[8]) ? number_format($sseArray[8]->marketing_operations, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($sseArray[9]) ? number_format($sseArray[9]->marketing_operations, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($sseArray[10]) ? number_format($sseArray[10]->marketing_operations, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($sseArray[11]) ? number_format($sseArray[11]->marketing_operations, 0, ',', '.') : "0") . '</td>
                        </tr>
                        <tr>
                            <td style="text-indent: 40px;">BI. Lain marketing</td>
                            <td>Rp ' . (isset($sseArray[0]) ? number_format($sseArray[0]->other_cost, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($sseArray[1]) ? number_format($sseArray[1]->other_cost, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($sseArray[2]) ? number_format($sseArray[2]->other_cost, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($sseArray[3]) ? number_format($sseArray[3]->other_cost, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($sseArray[4]) ? number_format($sseArray[4]->other_cost, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($sseArray[5]) ? number_format($sseArray[5]->other_cost, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($sseArray[6]) ? number_format($sseArray[6]->other_cost, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($sseArray[7]) ? number_format($sseArray[7]->other_cost, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($sseArray[8]) ? number_format($sseArray[8]->other_cost, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($sseArray[9]) ? number_format($sseArray[9]->other_cost, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($sseArray[10]) ? number_format($sseArray[10]->other_cost, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($sseArray[11]) ? number_format($sseArray[11]->other_cost, 0, ',', '.') : "0") . '</td>
                        </tr>
                        <tr>
                            <td class="table-warning"><b>Total Sales & Service Expenses</b></td>
                            <td class="table-warning"><b>(Rp ' . (isset($totalSSE[0]) ? number_format($totalSSE[0], 0, ',', '.') : "0") . ')</b></td>
                            <td class="table-warning"><b>(Rp ' . (isset($totalSSE[1]) ? number_format($totalSSE[1], 0, ',', '.') : "0") . ')</b></td>
                            <td class="table-warning"><b>(Rp ' . (isset($totalSSE[2]) ? number_format($totalSSE[2], 0, ',', '.') : "0") . ')</b></td>
                            <td class="table-warning"><b>(Rp ' . (isset($totalSSE[3]) ? number_format($totalSSE[3], 0, ',', '.') : "0") . ')</b></td>
                            <td class="table-warning"><b>(Rp ' . (isset($totalSSE[4]) ? number_format($totalSSE[4], 0, ',', '.') : "0") . ')</b></td>
                            <td class="table-warning"><b>(Rp ' . (isset($totalSSE[5]) ? number_format($totalSSE[5], 0, ',', '.') : "0") . ')</b></td>
                            <td class="table-warning"><b>(Rp ' . (isset($totalSSE[6]) ? number_format($totalSSE[6], 0, ',', '.') : "0") . ')</b></td>
                            <td class="table-warning"><b>(Rp ' . (isset($totalSSE[7]) ? number_format($totalSSE[7], 0, ',', '.') : "0") . ')</b></td>
                            <td class="table-warning"><b>(Rp ' . (isset($totalSSE[8]) ? number_format($totalSSE[8], 0, ',', '.') : "0") . ')</b></td>
                            <td class="table-warning"><b>(Rp ' . (isset($totalSSE[9]) ? number_format($totalSSE[9], 0, ',', '.') : "0") . ')</b></td>
                            <td class="table-warning"><b>(Rp ' . (isset($totalSSE[10]) ? number_format($totalSSE[10], 0, ',', '.') : "0") . ')</b></td>
                            <td class="table-warning"><b>(Rp ' . (isset($totalSSE[11]) ? number_format($totalSSE[11], 0, ',', '.') : "0") . ')</b></td>
                        </tr>
                        <tr>
                            <td class="table-info"><b>Operating Income (After Sales and Service Exp.)</b></td>
                            <td class="table-info"><b>Rp ' . (number_format($operatingIncome1, 0, ',', '.')) . '</b></td>
                            <td class="table-info"><b>Rp ' . (number_format($operatingIncome2, 0, ',', '.')) . '</b></td>
                            <td class="table-info"><b>Rp ' . (number_format($operatingIncome3, 0, ',', '.')) . '</b></td>
                            <td class="table-info"><b>Rp ' . (number_format($operatingIncome4, 0, ',', '.')) . '</b></td>
                            <td class="table-info"><b>Rp ' . (number_format($operatingIncome5, 0, ',', '.')) . '</b></td>
                            <td class="table-info"><b>Rp ' . (number_format($operatingIncome6, 0, ',', '.')) . '</b></td>
                            <td class="table-info"><b>Rp ' . (number_format($operatingIncome7, 0, ',', '.')) . '</b></td>
                            <td class="table-info"><b>Rp ' . (number_format($operatingIncome8, 0, ',', '.')) . '</b></td>
                            <td class="table-info"><b>Rp ' . (number_format($operatingIncome9, 0, ',', '.')) . '</b></td>
                            <td class="table-info"><b>Rp ' . (number_format($operatingIncome10, 0, ',', '.')) . '</b></td>
                            <td class="table-info"><b>Rp ' . (number_format($operatingIncome11, 0, ',', '.')) . '</b></td>
                            <td class="table-info"><b>Rp ' . (number_format($operatingIncome12, 0, ',', '.')) . '</b></td>
                        </tr>
                        <tr>
                            <td colspan="13" class="table-secondary"><b>BI. Adm & Umum</b></td>
                        </tr>
                        <tr>
                            <td style="text-indent: 40px;">BI. Gaji & tunjangan</td>
                            <td>Rp ' . (isset($gacArray[0]) ? number_format($gacArray[0]->salaries_and_allowances, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[1]) ? number_format($gacArray[1]->salaries_and_allowances, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[2]) ? number_format($gacArray[2]->salaries_and_allowances, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[3]) ? number_format($gacArray[3]->salaries_and_allowances, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[4]) ? number_format($gacArray[4]->salaries_and_allowances, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[5]) ? number_format($gacArray[5]->salaries_and_allowances, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[6]) ? number_format($gacArray[6]->salaries_and_allowances, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[7]) ? number_format($gacArray[7]->salaries_and_allowances, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[8]) ? number_format($gacArray[8]->salaries_and_allowances, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[9]) ? number_format($gacArray[9]->salaries_and_allowances, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[10]) ? number_format($gacArray[10]->salaries_and_allowances, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[11]) ? number_format($gacArray[11]->salaries_and_allowances, 0, ',', '.') : "0") . '</td>
                        </tr>
                        <tr>
                            <td style="text-indent: 40px;">BI. Listrik dan air</td>
                            <td>Rp ' . (isset($gacArray[0]) ? number_format($gacArray[0]->electricity_and_water, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[1]) ? number_format($gacArray[1]->electricity_and_water, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[2]) ? number_format($gacArray[2]->electricity_and_water, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[3]) ? number_format($gacArray[3]->electricity_and_water, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[4]) ? number_format($gacArray[4]->electricity_and_water, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[5]) ? number_format($gacArray[5]->electricity_and_water, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[6]) ? number_format($gacArray[6]->electricity_and_water, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[7]) ? number_format($gacArray[7]->electricity_and_water, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[8]) ? number_format($gacArray[8]->electricity_and_water, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[9]) ? number_format($gacArray[9]->electricity_and_water, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[10]) ? number_format($gacArray[10]->electricity_and_water, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[11]) ? number_format($gacArray[11]->electricity_and_water, 0, ',', '.') : "0") . '</td>
                        </tr>
                        <tr>
                            <td style="text-indent: 40px;">BI. Transportasi</td>
                            <td>Rp ' . (isset($gacArray[0]) ? number_format($gacArray[0]->transportation, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[1]) ? number_format($gacArray[1]->transportation, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[2]) ? number_format($gacArray[2]->transportation, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[3]) ? number_format($gacArray[3]->transportation, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[4]) ? number_format($gacArray[4]->transportation, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[5]) ? number_format($gacArray[5]->transportation, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[6]) ? number_format($gacArray[6]->transportation, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[7]) ? number_format($gacArray[7]->transportation, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[8]) ? number_format($gacArray[8]->transportation, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[9]) ? number_format($gacArray[9]->transportation, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[10]) ? number_format($gacArray[10]->transportation, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[11]) ? number_format($gacArray[11]->transportation, 0, ',', '.') : "0") . '</td>
                        </tr>
                        <tr>
                            <td style="text-indent: 40px;">BI. Komunikasi</td>
                            <td>Rp ' . (isset($gacArray[0]) ? number_format($gacArray[0]->communication, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[1]) ? number_format($gacArray[1]->communication, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[2]) ? number_format($gacArray[2]->communication, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[3]) ? number_format($gacArray[3]->communication, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[4]) ? number_format($gacArray[4]->communication, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[5]) ? number_format($gacArray[5]->communication, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[6]) ? number_format($gacArray[6]->communication, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[7]) ? number_format($gacArray[7]->communication, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[8]) ? number_format($gacArray[8]->communication, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[9]) ? number_format($gacArray[9]->communication, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[10]) ? number_format($gacArray[10]->communication, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[11]) ? number_format($gacArray[11]->communication, 0, ',', '.') : "0") . '</td>
                        </tr>
                        <tr>
                            <td style="text-indent: 40px;">BI. ATK</td>
                            <td>Rp ' . (isset($gacArray[0]) ? number_format($gacArray[0]->office_stationery, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[1]) ? number_format($gacArray[1]->office_stationery, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[2]) ? number_format($gacArray[2]->office_stationery, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[3]) ? number_format($gacArray[3]->office_stationery, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[4]) ? number_format($gacArray[4]->office_stationery, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[5]) ? number_format($gacArray[5]->office_stationery, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[6]) ? number_format($gacArray[6]->office_stationery, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[7]) ? number_format($gacArray[7]->office_stationery, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[8]) ? number_format($gacArray[8]->office_stationery, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[9]) ? number_format($gacArray[9]->office_stationery, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[10]) ? number_format($gacArray[10]->office_stationery, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[11]) ? number_format($gacArray[11]->office_stationery, 0, ',', '.') : "0") . '</td>
                        </tr>
                        <tr>
                            <td style="text-indent: 40px;">BI. Konsultan</td>
                            <td>Rp ' . (isset($gacArray[0]) ? number_format($gacArray[0]->consultant, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[1]) ? number_format($gacArray[1]->consultant, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[2]) ? number_format($gacArray[2]->consultant, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[3]) ? number_format($gacArray[3]->consultant, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[4]) ? number_format($gacArray[4]->consultant, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[5]) ? number_format($gacArray[5]->consultant, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[6]) ? number_format($gacArray[6]->consultant, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[7]) ? number_format($gacArray[7]->consultant, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[8]) ? number_format($gacArray[8]->consultant, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[9]) ? number_format($gacArray[9]->consultant, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[10]) ? number_format($gacArray[10]->consultant, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[11]) ? number_format($gacArray[11]->consultant, 0, ',', '.') : "0") . '</td>
                        </tr>
                        <tr>
                            <td style="text-indent: 40px;">BI. Kebersihan & keamanan</td>
                            <td>Rp ' . (isset($gacArray[0]) ? number_format($gacArray[0]->cleanliness_and_security, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[1]) ? number_format($gacArray[1]->cleanliness_and_security, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[2]) ? number_format($gacArray[2]->cleanliness_and_security, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[3]) ? number_format($gacArray[3]->cleanliness_and_security, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[4]) ? number_format($gacArray[4]->cleanliness_and_security, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[5]) ? number_format($gacArray[5]->cleanliness_and_security, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[6]) ? number_format($gacArray[6]->cleanliness_and_security, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[7]) ? number_format($gacArray[7]->cleanliness_and_security, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[8]) ? number_format($gacArray[8]->cleanliness_and_security, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[9]) ? number_format($gacArray[9]->cleanliness_and_security, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[10]) ? number_format($gacArray[10]->cleanliness_and_security, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[11]) ? number_format($gacArray[11]->cleanliness_and_security, 0, ',', '.') : "0") . '</td>
                        </tr>
                        <tr>
                            <td style="text-indent: 40px;">BI. Pemeliharaan & renovasi</td>
                            <td>Rp ' . (isset($gacArray[0]) ? number_format($gacArray[0]->maintenance_and_renovation, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[1]) ? number_format($gacArray[1]->maintenance_and_renovation, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[2]) ? number_format($gacArray[2]->maintenance_and_renovation, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[3]) ? number_format($gacArray[3]->maintenance_and_renovation, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[4]) ? number_format($gacArray[4]->maintenance_and_renovation, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[5]) ? number_format($gacArray[5]->maintenance_and_renovation, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[6]) ? number_format($gacArray[6]->maintenance_and_renovation, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[7]) ? number_format($gacArray[7]->maintenance_and_renovation, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[8]) ? number_format($gacArray[8]->maintenance_and_renovation, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[9]) ? number_format($gacArray[9]->maintenance_and_renovation, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[10]) ? number_format($gacArray[10]->maintenance_and_renovation, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[11]) ? number_format($gacArray[11]->maintenance_and_renovation, 0, ',', '.') : "0") . '</td>
                        </tr>
                        <tr>
                            <td style="text-indent: 40px;">BI. Penyusutan</td>
                            <td>Rp ' . (isset($gacArray[0]) ? number_format($gacArray[0]->depreciation, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[1]) ? number_format($gacArray[1]->depreciation, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[2]) ? number_format($gacArray[2]->depreciation, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[3]) ? number_format($gacArray[3]->depreciation, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[4]) ? number_format($gacArray[4]->depreciation, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[5]) ? number_format($gacArray[5]->depreciation, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[6]) ? number_format($gacArray[6]->depreciation, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[7]) ? number_format($gacArray[7]->depreciation, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[8]) ? number_format($gacArray[8]->depreciation, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[9]) ? number_format($gacArray[9]->depreciation, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[10]) ? number_format($gacArray[10]->depreciation, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[11]) ? number_format($gacArray[11]->depreciation, 0, ',', '.') : "0") . '</td>
                        </tr>
                        <tr>
                            <td style="text-indent: 40px;">BI. Pajak</td>
                            <td>Rp ' . (isset($gacArray[0]) ? number_format($gacArray[0]->tax, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[1]) ? number_format($gacArray[1]->tax, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[2]) ? number_format($gacArray[2]->tax, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[3]) ? number_format($gacArray[3]->tax, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[4]) ? number_format($gacArray[4]->tax, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[5]) ? number_format($gacArray[5]->tax, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[6]) ? number_format($gacArray[6]->tax, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[7]) ? number_format($gacArray[7]->tax, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[8]) ? number_format($gacArray[8]->tax, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[9]) ? number_format($gacArray[9]->tax, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[10]) ? number_format($gacArray[10]->tax, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[11]) ? number_format($gacArray[11]->tax, 0, ',', '.') : "0") . '</td>
                        </tr>
                        <tr>
                            <td style="text-indent: 40px;">BI. Adm & umum lainnya</td>
                            <td>Rp ' . (isset($gacArray[0]) ? number_format($gacArray[0]->other_cost, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[1]) ? number_format($gacArray[1]->other_cost, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[2]) ? number_format($gacArray[2]->other_cost, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[3]) ? number_format($gacArray[3]->other_cost, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[4]) ? number_format($gacArray[4]->other_cost, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[5]) ? number_format($gacArray[5]->other_cost, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[6]) ? number_format($gacArray[6]->other_cost, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[7]) ? number_format($gacArray[7]->other_cost, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[8]) ? number_format($gacArray[8]->other_cost, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[9]) ? number_format($gacArray[9]->other_cost, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[10]) ? number_format($gacArray[10]->other_cost, 0, ',', '.') : "0") . '</td>
                            <td>Rp ' . (isset($gacArray[11]) ? number_format($gacArray[11]->other_cost, 0, ',', '.') : "0") . '</td>
                        </tr>
                        <tr>
                            <td class="table-warning"><b>Total Adm & Umum</b></td>
                            <td class="table-warning"><b>(Rp ' . (isset($totalGAC[0]) ? number_format($totalGAC[0], 0, ',', '.') : "0") . ')</b></td>
                            <td class="table-warning"><b>(Rp ' . (isset($totalGAC[1]) ? number_format($totalGAC[1], 0, ',', '.') : "0") . ')</b></td>
                            <td class="table-warning"><b>(Rp ' . (isset($totalGAC[2]) ? number_format($totalGAC[2], 0, ',', '.') : "0") . ')</b></td>
                            <td class="table-warning"><b>(Rp ' . (isset($totalGAC[3]) ? number_format($totalGAC[3], 0, ',', '.') : "0") . ')</b></td>
                            <td class="table-warning"><b>(Rp ' . (isset($totalGAC[4]) ? number_format($totalGAC[4], 0, ',', '.') : "0") . ')</b></td>
                            <td class="table-warning"><b>(Rp ' . (isset($totalGAC[5]) ? number_format($totalGAC[5], 0, ',', '.') : "0") . ')</b></td>
                            <td class="table-warning"><b>(Rp ' . (isset($totalGAC[6]) ? number_format($totalGAC[6], 0, ',', '.') : "0") . ')</b></td>
                            <td class="table-warning"><b>(Rp ' . (isset($totalGAC[7]) ? number_format($totalGAC[7], 0, ',', '.') : "0") . ')</b></td>
                            <td class="table-warning"><b>(Rp ' . (isset($totalGAC[8]) ? number_format($totalGAC[8], 0, ',', '.') : "0") . ')</b></td>
                            <td class="table-warning"><b>(Rp ' . (isset($totalGAC[9]) ? number_format($totalGAC[9], 0, ',', '.') : "0") . ')</b></td>
                            <td class="table-warning"><b>(Rp ' . (isset($totalGAC[10]) ? number_format($totalGAC[10], 0, ',', '.') : "0") . ')</b></td>
                            <td class="table-warning"><b>(Rp ' . (isset($totalGAC[11]) ? number_format($totalGAC[11], 0, ',', '.') : "0") . ')</b></td>
                        </tr>
                        <tr>
                            <td class="table-info"><b>Net Operating Income</b></td>
                            <td class="table-info"><b>Rp ' . (number_format($net1, 0, ',', '.')) . '</b></td>
                            <td class="table-info"><b>Rp ' . (number_format($net2, 0, ',', '.')) . '</b></td>
                            <td class="table-info"><b>Rp ' . (number_format($net3, 0, ',', '.')) . '</b></td>
                            <td class="table-info"><b>Rp ' . (number_format($net4, 0, ',', '.')) . '</b></td>
                            <td class="table-info"><b>Rp ' . (number_format($net5, 0, ',', '.')) . '</b></td>
                            <td class="table-info"><b>Rp ' . (number_format($net6, 0, ',', '.')) . '</b></td>
                            <td class="table-info"><b>Rp ' . (number_format($net7, 0, ',', '.')) . '</b></td>
                            <td class="table-info"><b>Rp ' . (number_format($net8, 0, ',', '.')) . '</b></td>
                            <td class="table-info"><b>Rp ' . (number_format($net9, 0, ',', '.')) . '</b></td>
                            <td class="table-info"><b>Rp ' . (number_format($net10, 0, ',', '.')) . '</b></td>
                            <td class="table-info"><b>Rp ' . (number_format($net11, 0, ',', '.')) . '</b></td>
                            <td class="table-info"><b>Rp ' . (number_format($net12, 0, ',', '.')) . '</b></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <form action="' . route('report.exportProfitLoss') . '" method="GET">
                <input type="text" name="year" value="' . $request->year . '" hidden>
                <button type="submit" class="btn btn-warning btn-user px-5">
                    Export Laporan
                </button>
            </form>
        ';

        return $html;
    }

    // Cash Flow
    public function cashFlow()
    {
        $year = date("Y");
        $years = CashIn::pluck('year');

        // Get CI
        $ci = CashIn::where('user_id', Auth::user()->id)
            ->where('year', $year)
            ->first();

        return view('Finance_Apps.pages.manage.cashFlow', compact('year', 'years', 'ci'));
    }

    public function getCashFlow($year)
    {
        // Get CI
        $ci = CashIn::where('user_id', Auth::user()->id)
            ->where('year', $year)
            ->first();

        if ($ci) {
            return response()->json([
                'status'    => true,
                'data'      => [
                    'ci'    => $ci,
                ],
            ]);
        } else {
            return response()->json([
                'status'    => false,
            ]);
        }
    }

    public function addCashFlow(Request $request)
    {
        // Validation data
        $validation = $request->validate([
            'cashCI'    => 'required',
        ]);

        $year = date("Y");

        // Insert CI
        CashIn::create([
            'user_id'   => Auth::user()->id,
            'year'      => $year,
            'cash'      => $this->strToIntr($validation['cashCI']),
        ])->save();

        return redirect()->back();
    }

    public function updateCashFlow(Request $request)
    {
        // Get data
        $ciID = $request->input('ciID');
        $cash_in = CashIn::where('id', $ciID)->first();

        // Validation data
        $validation = $request->validate([
            'cashCI'    => 'required',
        ]);

        // Update CI
        $cash_in->update(['cash' => $this->strToIntr($validation['cashCI'])]);

        return redirect()->back();
    }

    public function cashFlowReport(Request $request)
    {
        // Get data
        $ci = CashIn::where('user_id', Auth::user()->id)
            ->where('year', $request->year)
            ->first();
        $sales = OrderDetail::select('order_details.*', 'orders.order_date')
            ->join('orders', 'orders.id', '=', 'order_details.order_id')
            ->whereYear('orders.order_date', '=', $request->year)
            ->get();
        $cogs = CostOfGoodsSold::where('user_id', Auth::user()->id)
            ->whereYear('created_at', '=', $request->year)
            ->get();
        $sse = SellingServiceExpenses::where('user_id', Auth::user()->id)
            ->whereYear('created_at', '=', $request->year)
            ->get();
        $gac = GeneralAdminCost::where('user_id', Auth::user()->id)
            ->whereYear('created_at', '=', $request->year)
            ->get();
        $html = '';

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
                $cogsArray[] = null;
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
                $sseArray[] = null;
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
                $gacArray[] = null;
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

        $html .= '
            <h6 class="mb-3 text-gray-800 text-center"><b>CASH FLOW</b></h6>
            <h6 class="mb-3 text-gray-800 text-center"><b>TAHUN ' . $request->year . '</b></h6>

            <div class="table-responsive" style="width:2500px">
                <table class="table table-bordered">
                    <thead class="table-primary">
                        <th class="text-center" style="width:16%"><b>Item</b></th>
                        <th class="text-center" style="width:7%"><b>Januari</b></th>
                        <th class="text-center" style="width:7%"><b>Februari</b></th>
                        <th class="text-center" style="width:7%"><b>Maret</b></th>
                        <th class="text-center" style="width:7%"><b>April</b></th>
                        <th class="text-center" style="width:7%"><b>Mei</b></th>
                        <th class="text-center" style="width:7%"><b>Juni</b></th>
                        <th class="text-center" style="width:7%"><b>Juli</b></th>
                        <th class="text-center" style="width:7%"><b>Agustus</b></th>
                        <th class="text-center" style="width:7%"><b>September</b></th>
                        <th class="text-center" style="width:7%"><b>Oktober</b></th>
                        <th class="text-center" style="width:7%"><b>November</b></th>
                        <th class="text-center" style="width:7%"><b>Desember</b></th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Cash In</td>
                            <td>Rp ' . number_format($ci->cash, 0, ',', '.') . '</td>
                            <td>Rp ' . number_format($total1, 0, ',', '.') . '</td>
                            <td>Rp ' . number_format($total2, 0, ',', '.') . '</td>
                            <td>Rp ' . number_format($total3, 0, ',', '.') . '</td>
                            <td>Rp ' . number_format($total4, 0, ',', '.') . '</td>
                            <td>Rp ' . number_format($total5, 0, ',', '.') . '</td>
                            <td>Rp ' . number_format($total6, 0, ',', '.') . '</td>
                            <td>Rp ' . number_format($total7, 0, ',', '.') . '</td>
                            <td>Rp ' . number_format($total8, 0, ',', '.') . '</td>
                            <td>Rp ' . number_format($total9, 0, ',', '.') . '</td>
                            <td>Rp ' . number_format($total10, 0, ',', '.') . '</td>
                            <td>Rp ' . number_format($total11, 0, ',', '.') . '</td>
                        </tr>
                        <tr>
                            <td>Sales</td>
                            <td>Rp ' . number_format($salesMonth["01"], 0, ',', '.') . '</td>
                            <td>Rp ' . number_format($salesMonth["02"], 0, ',', '.') . '</td>
                            <td>Rp ' . number_format($salesMonth["03"], 0, ',', '.') . '</td>
                            <td>Rp ' . number_format($salesMonth["04"], 0, ',', '.') . '</td>
                            <td>Rp ' . number_format($salesMonth["05"], 0, ',', '.') . '</td>
                            <td>Rp ' . number_format($salesMonth["06"], 0, ',', '.') . '</td>
                            <td>Rp ' . number_format($salesMonth["07"], 0, ',', '.') . '</td>
                            <td>Rp ' . number_format($salesMonth["08"], 0, ',', '.') . '</td>
                            <td>Rp ' . number_format($salesMonth["09"], 0, ',', '.') . '</td>
                            <td>Rp ' . number_format($salesMonth["10"], 0, ',', '.') . '</td>
                            <td>Rp ' . number_format($salesMonth["11"], 0, ',', '.') . '</td>
                            <td>Rp ' . number_format($salesMonth["12"], 0, ',', '.') . '</td>
                        </tr>
                        <tr>
                            <td>Cost of Goods Sold (COGS)</td>
                            <td>(Rp ' . number_format($cogsArray[0], 0, ',', '.') . ')</td>
                            <td>(Rp ' . number_format($cogsArray[1], 0, ',', '.') . ')</td>
                            <td>(Rp ' . number_format($cogsArray[2], 0, ',', '.') . ')</td>
                            <td>(Rp ' . number_format($cogsArray[3], 0, ',', '.') . ')</td>
                            <td>(Rp ' . number_format($cogsArray[4], 0, ',', '.') . ')</td>
                            <td>(Rp ' . number_format($cogsArray[5], 0, ',', '.') . ')</td>
                            <td>(Rp ' . number_format($cogsArray[6], 0, ',', '.') . ')</td>
                            <td>(Rp ' . number_format($cogsArray[7], 0, ',', '.') . ')</td>
                            <td>(Rp ' . number_format($cogsArray[8], 0, ',', '.') . ')</td>
                            <td>(Rp ' . number_format($cogsArray[9], 0, ',', '.') . ')</td>
                            <td>(Rp ' . number_format($cogsArray[10], 0, ',', '.') . ')</td>
                            <td>(Rp ' . number_format($cogsArray[11], 0, ',', '.') . ')</td>
                        </tr>
                        <tr>
                            <td>Selling & Service Expenses (SSE)</td>
                            <td>(Rp ' . number_format($sseArray[0], 0, ',', '.') . ')</td>
                            <td>(Rp ' . number_format($sseArray[1], 0, ',', '.') . ')</td>
                            <td>(Rp ' . number_format($sseArray[2], 0, ',', '.') . ')</td>
                            <td>(Rp ' . number_format($sseArray[3], 0, ',', '.') . ')</td>
                            <td>(Rp ' . number_format($sseArray[4], 0, ',', '.') . ')</td>
                            <td>(Rp ' . number_format($sseArray[5], 0, ',', '.') . ')</td>
                            <td>(Rp ' . number_format($sseArray[6], 0, ',', '.') . ')</td>
                            <td>(Rp ' . number_format($sseArray[7], 0, ',', '.') . ')</td>
                            <td>(Rp ' . number_format($sseArray[8], 0, ',', '.') . ')</td>
                            <td>(Rp ' . number_format($sseArray[9], 0, ',', '.') . ')</td>
                            <td>(Rp ' . number_format($sseArray[10], 0, ',', '.') . ')</td>
                            <td>(Rp ' . number_format($sseArray[11], 0, ',', '.') . ')</td>
                        </tr>
                        <tr>
                            <td>General & Admin Cost (G&A)</td>
                            <td>(Rp ' . number_format($gacArray[0], 0, ',', '.') . ')</td>
                            <td>(Rp ' . number_format($gacArray[1], 0, ',', '.') . ')</td>
                            <td>(Rp ' . number_format($gacArray[2], 0, ',', '.') . ')</td>
                            <td>(Rp ' . number_format($gacArray[3], 0, ',', '.') . ')</td>
                            <td>(Rp ' . number_format($gacArray[4], 0, ',', '.') . ')</td>
                            <td>(Rp ' . number_format($gacArray[5], 0, ',', '.') . ')</td>
                            <td>(Rp ' . number_format($gacArray[6], 0, ',', '.') . ')</td>
                            <td>(Rp ' . number_format($gacArray[7], 0, ',', '.') . ')</td>
                            <td>(Rp ' . number_format($gacArray[8], 0, ',', '.') . ')</td>
                            <td>(Rp ' . number_format($gacArray[9], 0, ',', '.') . ')</td>
                            <td>(Rp ' . number_format($gacArray[10], 0, ',', '.') . ')</td>
                            <td>(Rp ' . number_format($gacArray[11], 0, ',', '.') . ')</td>
                        </tr>
                        <tr class="table-warning">
                            <td></td>
                            <td><b>Rp ' . number_format($total1, 0, ',', '.') . '</b></td>
                            <td><b>Rp ' . number_format($total2, 0, ',', '.') . '</b></td>
                            <td><b>Rp ' . number_format($total3, 0, ',', '.') . '</b></td>
                            <td><b>Rp ' . number_format($total4, 0, ',', '.') . '</b></td>
                            <td><b>Rp ' . number_format($total5, 0, ',', '.') . '</b></td>
                            <td><b>Rp ' . number_format($total6, 0, ',', '.') . '</b></td>
                            <td><b>Rp ' . number_format($total7, 0, ',', '.') . '</b></td>
                            <td><b>Rp ' . number_format($total8, 0, ',', '.') . '</b></td>
                            <td><b>Rp ' . number_format($total9, 0, ',', '.') . '</b></td>
                            <td><b>Rp ' . number_format($total10, 0, ',', '.') . '</b></td>
                            <td><b>Rp ' . number_format($total11, 0, ',', '.') . '</b></td>
                            <td><b>Rp ' . number_format($total12, 0, ',', '.') . '</b></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <form action="' . route('report.exportCashFlow') . '" method="GET">
                <input type="text" name="year" value="' . $request->year . '" hidden>
                <button type="submit" class="btn btn-warning btn-user px-5">
                    Export Laporan
                </button>
            </form>
        ';

        return $html;
    }
}
