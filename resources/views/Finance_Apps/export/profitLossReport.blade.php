<table>
    <thead>
        <tr>
            <th colspan="14" align="center">PROFIT AND LOSS</th>
        </tr>
        <tr>
            <th colspan="14" align="center">TAHUN {{ $year }}</th>
        </tr>
        <tr></tr>
    </thead>
    <tbody>
        <tr>
            <td align="center"><b>Keterangan</b></td>
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
            <td colspan="13"><b>Penjualan</b></td>
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
            <td><b>Total Sales</b></td>
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
            <td colspan="13"><b>HPP</b></td>
        </tr>
        <tr>
            <td>BI. Bahan baku</td>
            <td>Rp{{ isset($cogsArray1) ? number_format($cogsArray1->raw_material, 0, ',', '.') : 0 }}</td>
            <td>Rp{{ isset($cogsArray2) ? number_format($cogsArray2->raw_material, 0, ',', '.') : 0 }}</td>
            <td>Rp{{ isset($cogsArray3) ? number_format($cogsArray3->raw_material, 0, ',', '.') : 0 }}</td>
            <td>Rp{{ isset($cogsArray4) ? number_format($cogsArray4->raw_material, 0, ',', '.') : 0 }}</td>
            <td>Rp{{ isset($cogsArray5) ? number_format($cogsArray5->raw_material, 0, ',', '.') : 0 }}</td>
            <td>Rp{{ isset($cogsArray6) ? number_format($cogsArray6->raw_material, 0, ',', '.') : 0 }}</td>
            <td>Rp{{ isset($cogsArray7) ? number_format($cogsArray7->raw_material, 0, ',', '.') : 0 }}</td>
            <td>Rp{{ isset($cogsArray8) ? number_format($cogsArray8->raw_material, 0, ',', '.') : 0 }}</td>
            <td>Rp{{ isset($cogsArray9) ? number_format($cogsArray9->raw_material, 0, ',', '.') : 0 }}</td>
            <td>Rp{{ isset($cogsArray10) ? number_format($cogsArray10->raw_material, 0, ',', '.') : 0 }}</td>
            <td>Rp{{ isset($cogsArray11) ? number_format($cogsArray11->raw_material, 0, ',', '.') : 0 }}</td>
            <td>Rp{{ isset($cogsArray12) ? number_format($cogsArray12->raw_material, 0, ',', '.') : 0 }}</td>
        </tr>
    </tbody>
</table>