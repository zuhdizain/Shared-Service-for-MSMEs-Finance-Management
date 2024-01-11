<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CETAK ABSENSI PEGAWAI</title>
</head>
<body>
    <div class="form-group">
        <h3 align="center">Laporan Absensi Pegawai</h3>
        <table class="static" align="center" rules="all" border="1px" style="width: 95%">
            <thead>
              <tr>
                <th>No.</th>
                <th>Karyawan</th>
                <th>Kontak</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($absenPerTanggal as $att)
                    <tr>
                        <th>{{ $loop->iteration }}</th>
                        <td align="center">
                            <p>{{ $att->employee->employee_name }}</p>
                            <p>{{ $att->division->division_name }}</p>
                        </td>
                        <td align="center">
                            <p>{{ $att->employee->employee_email }}</p>
                            <p>(+62) {{ $att->employee->employee_phone }}</p>
                        </td>
                        <td align="center">
                            <p>{{ $att->date }}</p>
                        </td>
                        <td align="center">
                            <p>{{ $att->description }}</p>
                        </td>
                    </tr>
                @endforeach
            </tbody>
          </table>
    </div>

    <script type="text/javascript">
        window.print();
    </script>
</body>
</html>