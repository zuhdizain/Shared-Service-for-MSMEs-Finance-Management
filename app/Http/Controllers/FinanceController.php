<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CurrentAsset;
use App\Models\NonCurrentAsset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FinanceController extends Controller
{
    public function index()
    {
        return view('Finance_Apps.pages.manage.index');
    }

    private function strToIntr($str)
    {
        $string = str_replace('.', '', $str);
        $integer = (int)$string;

        return $integer;
    }

    // Balance Sheet
    public function balanceSheet()
    {
        return view('Finance_Apps.pages.report.balanceSheet');
    }

    public function getCAandNCA($month)
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

    public function addCAandNCA(Request $request)
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

    public function updateCAandNCA(Request $request)
    {
        // Get data
        $caID = $request->input('caID');
        $ncaID = $request->input('ncaID');
        $current_asset = CurrentAsset::where('id', $caID)->first();
        $non_current_asset = NonCurrentAsset::where('id', $ncaID)->first();

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
        $ca = CurrentAsset::where('user_id', Auth::user()->id)
            ->whereBetween('created_at', [$request->dateStart, $request->dateEnd])
            ->get();
        $nca = NonCurrentAsset::where('user_id', Auth::user()->id)
            ->whereBetween('created_at', [$request->dateStart, $request->dateEnd])
            ->get();
        $html = '';

        $html .= '
            <h6 class="mb-3 text-gray-800 text-center"><b>BALANCE SHEET</b></h6>
            <h6 class="mb-3 text-gray-800 text-center"><b>PER TANGGAL </b></h6>
            <table class="table">
                <thead class="table-primary">
                    <th><b>Aset Lancar</b></th>
                    <th><b><span class="prevMonthCA"></b></th>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-indent: 40px;">Kas dan setara kas</td>
                        <td id="cashCA">Rp 0</td>
                    </tr>
                    <tr>
                        <td style="text-indent: 40px;">Piutang usaha</td>
                        <td id="accountsReceivableCA">Rp 0</td>
                    </tr>
                    <tr>
                        <td style="text-indent: 40px;">Persediaan</td>
                        <td id="suppliesCA">Rp 0</td>
                    </tr>
                    <tr>
                        <td style="text-indent: 40px;">Aset lancar lainnya</td>
                        <td id="otherCA">Rp 0</td>
                    </tr>
                    <tr>
                        <td><b>Jumlah aset lancar</b></td>
                        <td id="totalCA"><b>Rp 0</b></td>
                    </tr>
                    <tr>
                        <td class="table-primary"><b>Aset Tidak Lancar</b></td>
                        <td class="table-primary"></td>
                    </tr>
                    <tr>
                        <td style="text-indent: 40px;">Aset tetap</td>
                        <td id="fixedAssetsNCA">Rp 0</td>
                    </tr>
                    <tr>
                        <td style="text-indent: 40px;">Akumulasi penyusutan</td>
                        <td id="depreciationNCA">Rp 0</td>
                    </tr>
                    <tr>
                        <td><b>Jumlah aset tidak lancar</b></td>
                        <td id="totalNCA"><b>Rp 0</b></td>
                    </tr>
                    <tr>
                        <td class="table-warning"><b>Jumlah aset</b></td>
                        <td class="table-warning" id="totalAsset"><b>Rp 0</b></td>
                    </tr>
                </tbody>
            </table>
        ';

        return $html;
    }
}
