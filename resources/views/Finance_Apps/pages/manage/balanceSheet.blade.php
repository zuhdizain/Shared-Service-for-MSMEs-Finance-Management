@extends('Finance_Apps.layouts.app')

@section('title')
    Manajemen Keuangan
@endsection

@section('content-finance')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Balance Sheet</h1>
        </div>

        <div class="row">
            <div class="col-md-6 col-12">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <form method="POST" id="financeForm" action="{{ route('finance.addBalanceSheet') }}">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label for="inputMonth">Bulan</label>
                                    <select class="form-control" id="inputMonth" name="month" required>
                                        <option value="0">Pilih Bulan</option>
                                        <option value="1">Januari</option>
                                        <option value="2">Februari</option>
                                        <option value="3">Maret</option>
                                        <option value="4">April</option>
                                        <option value="5">Mei</option>
                                        <option value="6">Juni</option>
                                        <option value="7">Juli</option>
                                        <option value="8">Agustus</option>
                                        <option value="9">September</option>
                                        <option value="10">Oktober</option>
                                        <option value="11">November</option>
                                        <option value="12">Desember</option>
                                    </select>
                                </div>
                            </div>

                            <!-- CA -->
                            <h6 class="mb-3 text-gray-800"><b>Aset Lancar</b></h6>
                            <div class="form-row">
                                <div class="form-group col-12 col-md-6">
                                    <label for="inputCashCA">Kas</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Rp</div>
                                        </div>
                                        <input type="text" class="form-control rupiah" name="cashCA" id="inputCashCA" value="{{ old('cashCA') }}" min="0" required>
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="inputAccountsReceivableCA">Piutang usaha</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Rp</div>
                                        </div>
                                        <input type="text" class="form-control rupiah" name="accountsReceivableCA" id="inputAccountsReceivableCA" value="{{ old('accountsReceivableCA') }}" min="0" required>
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="inputSuppliesCA">Persediaan</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Rp</div>
                                        </div>
                                        <input type="text" class="form-control rupiah" name="suppliesCA" id="inputSuppliesCA" value="{{ old('suppliesCA') }}" min="0" required>
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="inputOtherCA">Aset lancar lainnya</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Rp</div>
                                        </div>
                                        <input type="text" class="form-control rupiah" name="otherCA" id="inputOtherCA" value="{{ old('otherCA') }}" min="0" required>
                                    </div>
                                </div>
                            </div>

                            <!-- NCA -->
                            <h6 class="mb-3 mt-4 text-gray-800"><b>Aset Tidak Lancar</b></h6>
                            <div class="form-row">
                                <div class="form-group col-12 col-md-6">
                                    <label for="inputFixedAssetsNCA">Asset tetap</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Rp</div>
                                        </div>
                                        <input type="text" class="form-control rupiah" name="fixedAssetsNCA" id="inputFixedAssetsNCA" value="{{ old('fixedAssetsNCA') }}" min="0" required>
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="inputDepreciationNCA">Akumulasi penyusutan</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Rp</div>
                                        </div>
                                        <input type="text" class="form-control rupiah" name="depreciationNCA" id="inputDepreciationNCA" value="{{ old('depreciationNCA') }}" min="0" required>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block mb-2 mt-4">
                                Submit
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="previewMonth">Bulan</label>
                                <select class="form-control" id="previewMonth">
                                    <option value="0">Pilih Bulan</option>
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Maret</option>
                                    <option value="4">April</option>
                                    <option value="5">Mei</option>
                                    <option value="6">Juni</option>
                                    <option value="7">Juli</option>
                                    <option value="8">Agustus</option>
                                    <option value="9">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>
                        </div>
                        
                        <h6 class="mb-3 text-gray-800"><b>Aset Bulan <span class="prevMonth"></span> <span id="year"></span></b></h6>
                        <div class="table-responsive mt-4">
                            <table class="table">
                                <thead class="table-primary">
                                    <th><b>Aset Lancar</b></th>
                                    <th><b><span class="prevMonth"></b></th>
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
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Balance Sheet Preview -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <form class="form mt-4" id="form">
                    <div class="form-row">
                        <div class="form-group col-12 col-md-3">
                            <label for="">Mulai dari</label>
                            <input type="date" class="form-control" id="dateStart" value="{{ old('dateStart') }}" required>
                        </div>
                        <div class="form-group col-12 col-md-3">
                                <label for="">Sampai dengan</label>
                            <input type="date" class="form-control" id="dateEnd" value="{{ old('dateEnd') }}" required>
                        </div>
                        <div class="col-12 col-md-2 mt-3">
                            <button type="submit" class="btn btn-primary btn-user btn-block mt-3">
                                Tampilkan Laporan
                            </button>
                        </div>
                    </div>
                </form>

                <div class="table-responsive mt-5">
                    <div id="balance-sheet-report"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('addon-script')
    <script>
        function inputFormatRupiah(num) {
            var number_string = num.replace(/[^,\d]/g, '').toString(),
                split         = number_string.split(','),
                sisa          = split[0].length % 3,
                rupiah        = split[0].substr(0, sisa),
                ribuan        = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return rupiah;
        }

        function formatRupiah(angka) {
            var formatter = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });

            return formatter.format(angka);
        }

        $(document).ready(function() {
            var date = new Date();
            var year = date.getFullYear();

            // Left card
            $('#inputMonth').on('change', (event) => {
                // Get data preview
                $.ajax({
                    type: "GET",
                    url: "/finance/balance-sheet/get-balance-sheet/" + event.target.value,
                    success: function(res) {
                        if (res.status && (res.data.ca && res.data.nca)) {
                            var action = "{{ route('finance.updateBalanceSheet') }}?caID=" + res.data.ca.id + "&ncaID=" + res.data.nca.id;
                            $('#financeForm').attr('action', action);

                            $('#inputCashCA').val(res.data.ca.cash);
                            $('#inputAccountsReceivableCA').val(res.data.ca.accounts_receivable);
                            $('#inputSuppliesCA').val(res.data.ca.supplies);
                            $('#inputOtherCA').val(res.data.ca.other_current_assets);
                            $('#inputFixedAssetsNCA').val(res.data.nca.fixed_assets);
                            $('#inputDepreciationNCA').val(res.data.nca.depreciation);
                        } else if (!res.status || (res.data.ca === null && res.data.nca === null)) {
                            $('#financeForm').attr('action', "{{ route('finance.addBalanceSheet') }}");
                            
                            $('#inputCashCA').val('');
                            $('#inputAccountsReceivableCA').val('');
                            $('#inputSuppliesCA').val('');
                            $('#inputOtherCA').val('');
                            $('#inputFixedAssetsNCA').val('');
                            $('#inputDepreciationNCA').val('');
                        }
                    }
                });
            });

            // Right card
            $('#previewMonth').on('change', (event) => {
                $('#year').text(year);
                if (event.target.value == 1) {
                    $('.prevMonth').text('Januari');
                } else if (event.target.value == 2) {
                    $('.prevMonth').text('Februari');
                } else if (event.target.value == 3) {
                    $('.prevMonth').text('Maret');
                } else if (event.target.value == 4) {
                    $('.prevMonth').text('April');
                } else if (event.target.value == 5) {
                    $('.prevMonth').text('Mei');
                } else if (event.target.value == 6) {
                    $('.prevMonth').text('Juni');
                } else if (event.target.value == 7) {
                    $('.prevMonth').text('Juli');
                } else if (event.target.value == 8) {
                    $('.prevMonth').text('Agustus');
                } else if (event.target.value == 9) {
                    $('.prevMonth').text('September');
                } else if (event.target.value == 10) {
                    $('.prevMonth').text('Oktober');
                } else if (event.target.value == 11) {
                    $('.prevMonth').text('November');
                } else if (event.target.value == 12) {
                    $('.prevMonth').text('Desember');
                } else {
                    $('.prevMonth').text('');
                    $('#year').text('');
                }

                // Get data preview
                $.ajax({
                    type: "GET",
                    url: "/finance/balance-sheet/get-balance-sheet/" + event.target.value,
                    success: function(res) {
                        if (res.status && (res.data.ca && res.data.nca)) {
                            var action = "{{ route('finance.updateBalanceSheet') }}?caID=" + res.data.ca.id + "&ncaID=" + res.data.nca.id;
                            $('#financeForm').attr('action', action);

                            $('#cashCA').html(formatRupiah(res.data.ca.cash));
                            $('#accountsReceivableCA').html(formatRupiah(res.data.ca.accounts_receivable));
                            $('#suppliesCA').html(formatRupiah(res.data.ca.supplies));
                            $('#otherCA').html(formatRupiah(res.data.ca.other_current_assets));
                            $('#fixedAssetsNCA').html(formatRupiah(res.data.nca.fixed_assets));
                            $('#depreciationNCA').html(formatRupiah(res.data.nca.depreciation));
                        } else if (!res.status || (res.data.ca === null && res.data.nca === null)) {
                            $('#financeForm').attr('action', "{{ route('finance.addBalanceSheet') }}");
                            
                            $('#cashCA').html("Rp 0");
                            $('#accountsReceivableCA').html("Rp 0");
                            $('#suppliesCA').html("Rp 0");
                            $('#otherCA').html("Rp 0");
                            $('#fixedAssetsNCA').html("Rp 0");
                            $('#depreciationNCA').html("Rp 0");
                        }
                    }
                });
            });

            // Format rupiah
            $('.rupiah').on('input', function() {
                var formattedValue = inputFormatRupiah($(this).val());
                $(this).val(formattedValue);
            });

            // Create balance sheet report
            $('#form').on('submit', function(e) {
                e.preventDefault();
                var dateStart = $('#dateStart').val();
                var dateEnd = $('#dateEnd').val();
                
                $.ajax({
                    type: "POST",
                    url: "/finance/balance-sheet/report",
                    data: {
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                        "dateStart": dateStart,
                        "dateEnd": dateEnd,
                    },
                    success: function(data) {
                        $('#balance-sheet-report').html(data);
                    }
                });
            });
        });
    </script>
@endpush