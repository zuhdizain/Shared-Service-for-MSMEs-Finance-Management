<table>
    <thead>
        <tr>
            <th colspan="13" align="center"><b>CASH FLOW</b></th>
        </tr>
        <tr>
            <th colspan="13" align="center"><b>TAHUN {{ $year }}</b></th>
        </tr>
        <tr></tr>
    </thead>
    <tbody>
        <tr>
            <td align="center"><b>Item</b></td>
            <td align="center"><b>Januari</b></td>
            <td align="center"><b>Februari</b></td>
            <td align="center"><b>Maret</b></td>
            <td align="center"><b>April</b></td>
            <td align="center"><b>Mei</b></td>
            <td align="center"><b>Juni</b></td>
            <td align="center"><b>Juli</b></td>
            <td align="center"><b>Agustus</b></td>
            <td align="center"><b>September</b></td>
            <td align="center"><b>Oktober</b></td>
            <td align="center"><b>November</b></td>
            <td align="center"><b>Desember</b></td>
        </tr>
        <tr>
            <td>Cash In</td>
            <td>Rp{{ number_format($ci, 0, ',', '.') }}</td>
            <td>Rp{{ number_format($total1, 0, ',', '.') }}</td>
            <td>Rp{{ number_format($total2, 0, ',', '.') }}</td>
            <td>Rp{{ number_format($total3, 0, ',', '.') }}</td>
            <td>Rp{{ number_format($total4, 0, ',', '.') }}</td>
            <td>Rp{{ number_format($total5, 0, ',', '.') }}</td>
            <td>Rp{{ number_format($total6, 0, ',', '.') }}</td>
            <td>Rp{{ number_format($total7, 0, ',', '.') }}</td>
            <td>Rp{{ number_format($total8, 0, ',', '.') }}</td>
            <td>Rp{{ number_format($total9, 0, ',', '.') }}</td>
            <td>Rp{{ number_format($total10, 0, ',', '.') }}</td>
            <td>Rp{{ number_format($total11, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Sales</td>
            <td>Rp{{ number_format($salesMonth1, 0, ',', '.') }}</td>
            <td>Rp{{ number_format($salesMonth2, 0, ',', '.') }}</td>
            <td>Rp{{ number_format($salesMonth3, 0, ',', '.') }}</td>
            <td>Rp{{ number_format($salesMonth4, 0, ',', '.') }}</td>
            <td>Rp{{ number_format($salesMonth5, 0, ',', '.') }}</td>
            <td>Rp{{ number_format($salesMonth6, 0, ',', '.') }}</td>
            <td>Rp{{ number_format($salesMonth7, 0, ',', '.') }}</td>
            <td>Rp{{ number_format($salesMonth8, 0, ',', '.') }}</td>
            <td>Rp{{ number_format($salesMonth9, 0, ',', '.') }}</td>
            <td>Rp{{ number_format($salesMonth10, 0, ',', '.') }}</td>
            <td>Rp{{ number_format($salesMonth11, 0, ',', '.') }}</td>
            <td>Rp{{ number_format($salesMonth12, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Cost of Goods Sold</td>
            <td>-Rp{{ number_format($cogsArray1, 0, ',', '.') }}</td>
            <td>-Rp{{ number_format($cogsArray2, 0, ',', '.') }}</td>
            <td>-Rp{{ number_format($cogsArray3, 0, ',', '.') }}</td>
            <td>-Rp{{ number_format($cogsArray4, 0, ',', '.') }}</td>
            <td>-Rp{{ number_format($cogsArray5, 0, ',', '.') }}</td>
            <td>-Rp{{ number_format($cogsArray6, 0, ',', '.') }}</td>
            <td>-Rp{{ number_format($cogsArray7, 0, ',', '.') }}</td>
            <td>-Rp{{ number_format($cogsArray8, 0, ',', '.') }}</td>
            <td>-Rp{{ number_format($cogsArray9, 0, ',', '.') }}</td>
            <td>-Rp{{ number_format($cogsArray10, 0, ',', '.') }}</td>
            <td>-Rp{{ number_format($cogsArray11, 0, ',', '.') }}</td>
            <td>-Rp{{ number_format($cogsArray12, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Selling and Service Expenses</td>
            <td>-Rp{{ number_format($sseArray1, 0, ',', '.') }}</td>
            <td>-Rp{{ number_format($sseArray2, 0, ',', '.') }}</td>
            <td>-Rp{{ number_format($sseArray3, 0, ',', '.') }}</td>
            <td>-Rp{{ number_format($sseArray4, 0, ',', '.') }}</td>
            <td>-Rp{{ number_format($sseArray5, 0, ',', '.') }}</td>
            <td>-Rp{{ number_format($sseArray6, 0, ',', '.') }}</td>
            <td>-Rp{{ number_format($sseArray7, 0, ',', '.') }}</td>
            <td>-Rp{{ number_format($sseArray8, 0, ',', '.') }}</td>
            <td>-Rp{{ number_format($sseArray9, 0, ',', '.') }}</td>
            <td>-Rp{{ number_format($sseArray10, 0, ',', '.') }}</td>
            <td>-Rp{{ number_format($sseArray11, 0, ',', '.') }}</td>
            <td>-Rp{{ number_format($sseArray12, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>General and Admin Cost</td>
            <td>-Rp{{ number_format($gacArray1, 0, ',', '.') }}</td>
            <td>-Rp{{ number_format($gacArray2, 0, ',', '.') }}</td>
            <td>-Rp{{ number_format($gacArray3, 0, ',', '.') }}</td>
            <td>-Rp{{ number_format($gacArray4, 0, ',', '.') }}</td>
            <td>-Rp{{ number_format($gacArray5, 0, ',', '.') }}</td>
            <td>-Rp{{ number_format($gacArray6, 0, ',', '.') }}</td>
            <td>-Rp{{ number_format($gacArray7, 0, ',', '.') }}</td>
            <td>-Rp{{ number_format($gacArray8, 0, ',', '.') }}</td>
            <td>-Rp{{ number_format($gacArray9, 0, ',', '.') }}</td>
            <td>-Rp{{ number_format($gacArray10, 0, ',', '.') }}</td>
            <td>-Rp{{ number_format($gacArray11, 0, ',', '.') }}</td>
            <td>-Rp{{ number_format($gacArray12, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td></td>
            <td><b>Rp{{ number_format($total1, 0, ',', '.') }}</b></td>
            <td><b>Rp{{ number_format($total2, 0, ',', '.') }}</b></td>
            <td><b>Rp{{ number_format($total3, 0, ',', '.') }}</b></td>
            <td><b>Rp{{ number_format($total4, 0, ',', '.') }}</b></td>
            <td><b>Rp{{ number_format($total5, 0, ',', '.') }}</b></td>
            <td><b>Rp{{ number_format($total6, 0, ',', '.') }}</b></td>
            <td><b>Rp{{ number_format($total7, 0, ',', '.') }}</b></td>
            <td><b>Rp{{ number_format($total8, 0, ',', '.') }}</b></td>
            <td><b>Rp{{ number_format($total9, 0, ',', '.') }}</b></td>
            <td><b>Rp{{ number_format($total10, 0, ',', '.') }}</b></td>
            <td><b>Rp{{ number_format($total11, 0, ',', '.') }}</b></td>
            <td><b>Rp{{ number_format($total12, 0, ',', '.') }}</b></td>
        </tr>
    </tbody>
</table>