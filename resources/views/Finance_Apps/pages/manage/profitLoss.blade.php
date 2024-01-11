@extends('Finance_Apps.layouts.app')

@section('title')
    Manajemen Keuangan
@endsection

@section('content-finance')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Profit & Loss</h1>
        </div>

        <div class="row">
            <div class="col-md-6 col-12">
                <!-- COGS -->
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <form method="POST" id="financeFormCOGS" action="{{ route('finance.addProfitLossCOGS') }}">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label for="inputMonthCOGS">Bulan</label>
                                    <select class="form-control" id="inputMonthCOGS" name="month" required>
                                        <option value="">Pilih Bulan</option>
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

                            <h6 class="mb-3 text-gray-800"><b>Harga Pokok Penjualan</b></h6>
                            <div class="form-row">
                                <div class="form-group col-12 col-md-6">
                                    <label for="inputRawMaterialCOGS">Bahan baku</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Rp</div>
                                        </div>
                                        <input type="text" class="form-control rupiah" name="rawMaterialCOGS" id="inputRawMaterialCOGS" value="{{ old('rawMaterialCOGS') }}" min="0" required>
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="inputManpowerCOGS">Tenaga kerja</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Rp</div>
                                        </div>
                                        <input type="text" class="form-control rupiah" name="manpowerCOGS" id="inputManpowerCOGS" value="{{ old('manpowerCOGS') }}" min="0" required>
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="inputFactoryOverheadCOGS">Overhead Pabrik</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Rp</div>
                                        </div>
                                        <input type="text" class="form-control rupiah" name="factoryOverheadCOGS" id="inputFactoryOverheadCOGS" value="{{ old('factoryOverheadCOGS') }}" min="0" required>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block mb-1 mt-2">
                                Submit
                            </button>
                        </form>
                    </div>
                </div>

                <!-- SSE -->
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <form method="POST" id="financeFormSSE" action="{{ route('finance.addProfitLossSSE') }}">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label for="inputMonthSSE">Bulan</label>
                                    <select class="form-control" id="inputMonthSSE" name="month" required>
                                        <option value="">Pilih Bulan</option>
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
                            
                            <h6 class="mb-3 text-gray-800"><b>Biaya Penjualan & Pelayanan</b></h6>
                            <div class="form-row">
                                <div class="form-group col-12 col-md-6">
                                    <label for="inputAdmEcommerceSSE">Adm online</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Rp</div>
                                        </div>
                                        <input type="text" class="form-control rupiah" name="admEcommerceSSE" id="inputAdmEcommerceSSE" value="{{ old('admEcommerceSSE') }}" min="0" required>
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="inputMarketingSalarySSE">Gaji marketing</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Rp</div>
                                        </div>
                                        <input type="text" class="form-control rupiah" name="marketingSalarySSE" id="inputMarketingSalarySSE" value="{{ old('marketingSalarySSE') }}" min="0" required>
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="inputMarketingOperationsSSE">Operasional marketing</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Rp</div>
                                        </div>
                                        <input type="text" class="form-control rupiah" name="marketingOperationsSSE" id="inputMarketingOperationsSSE" value="{{ old('marketingOperationsSSE') }}" min="0" required>
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="inputOtherCostSSE">Biaya lainnya</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Rp</div>
                                        </div>
                                        <input type="text" class="form-control rupiah" name="otherCostSSE" id="inputOtherCostSSE" value="{{ old('otherCostSSE') }}" min="0" required>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block mb-1 mt-2">
                                Submit
                            </button>
                        </form>
                    </div>
                </div>

                <!-- GA -->
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <form method="POST" id="financeFormGA" action="{{ route('finance.addProfitLossGA') }}">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label for="inputMonthGA">Bulan</label>
                                    <select class="form-control" id="inputMonthGA" name="month" required>
                                        <option value="">Pilih Bulan</option>
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

                            <h6 class="mb-3 text-gray-800"><b>Biaya Adm & Umum</b></h6>
                            <div class="form-row">
                                <div class="form-group col-12 col-md-6">
                                    <label for="inputSalariesAllowancesGA">Gaji & tunjangan</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Rp</div>
                                        </div>
                                        <input type="text" class="form-control rupiah" name="salariesAllowancesGA" id="inputSalariesAllowancesGA" value="{{ old('salariesAllowancesGA') }}" min="0" required>
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="inputElectricityWaterGA">Listrik & Air</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Rp</div>
                                        </div>
                                        <input type="text" class="form-control rupiah" name="electricityWaterGA" id="inputElectricityWaterGA" value="{{ old('electricityWaterGA') }}" min="0" required>
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="inputTransportationGA">Transportasi</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Rp</div>
                                        </div>
                                        <input type="text" class="form-control rupiah" name="transportationGA" id="inputTransportationGA" value="{{ old('transportationGA') }}" min="0" required>
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="inputCommunicationGA">Komunikasi</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Rp</div>
                                        </div>
                                        <input type="text" class="form-control rupiah" name="communicationGA" id="inputCommunicationGA" value="{{ old('communicationGA') }}" min="0" required>
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="inputOfficeStationeryGA">Alat tulis kantor</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Rp</div>
                                        </div>
                                        <input type="text" class="form-control rupiah" name="officeStationeryGA" id="inputOfficeStationeryGA" value="{{ old('officeStationeryGA') }}" min="0" required>
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="inputConsultantGA">Konsultan</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Rp</div>
                                        </div>
                                        <input type="text" class="form-control rupiah" name="consultantGA" id="inputConsultantGA" value="{{ old('consultantGA') }}" min="0" required>
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="inputCleanlinessSecurityGA">Kebersihan & keamanan</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Rp</div>
                                        </div>
                                        <input type="text" class="form-control rupiah" name="cleanlinessSecurityGA" id="inputCleanlinessSecurityGA" value="{{ old('cleanlinessSecurityGA') }}" min="0" required>
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="inputMaintenanceRenovationGA">Pemeliharaan & renovasi</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Rp</div>
                                        </div>
                                        <input type="text" class="form-control rupiah" name="maintenanceRenovationGA" id="inputMaintenanceRenovationGA" value="{{ old('maintenanceRenovationGA') }}" min="0" required>
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="inputDepreciationGA">Penyusutan</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Rp</div>
                                        </div>
                                        <input type="text" class="form-control rupiah" name="depreciationGA" id="inputDepreciationGA" value="{{ old('depreciationGA') }}" min="0" required>
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="inputTaxGA">Pajak</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Rp</div>
                                        </div>
                                        <input type="text" class="form-control rupiah" name="taxGA" id="inputTaxGA" value="{{ old('taxGA') }}" min="0" required>
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="inputOtherCostGA">Biaya lainnya</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Rp</div>
                                        </div>
                                        <input type="text" class="form-control rupiah" name="otherCostGA" id="inputOtherCostGA" value="{{ old('otherCostGA') }}" min="0" required>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block mb-1 mt-2">
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

                        <h6 class="mb-3 text-gray-800"><b>Profit & Loss Bulan <span class="prevMonth"></span> <span id="year"></span></b></h6>
                        <div class="table-responsive mt-4">
                            <table class="table">
                                <thead class="table-primary">
                                    <th class="text-center"><b>Keterangan</b></th>
                                    <th><b><span class="prevMonth"></b></th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="2" class="table-secondary"><b>HPP</b></td>
                                    </tr>
                                    <tr>
                                        <td style="text-indent: 40px;">BI. Bahan baku</td>
                                        <td id="rawMaterialCOGS">Rp 0</td>
                                    </tr>
                                    <tr>
                                        <td style="text-indent: 40px">BI. Tenaga kerja</td>
                                        <td id="manpowerCOGS">Rp 0</td>
                                    </tr>
                                    <tr>
                                        <td style="text-indent: 40px;">BI. Overhead pabrik</td>
                                        <td id="factoryOverheadCOGS">Rp 0</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="table-secondary"><b>BI. Penjualan</b></td>
                                    </tr>
                                    <tr>
                                        <td style="text-indent: 40px">BI. Adm e-commerce</td>
                                        <td id="admEcommerceSSE">Rp 0</td>
                                    </tr>
                                    <tr>
                                        <td style="text-indent: 40px">BI. Gaji marketing</td>
                                        <td id="marketingSalarySSE">Rp 0</td>
                                    </tr>
                                    <tr>
                                        <td style="text-indent: 40px">Operasional marketing</td>
                                        <td id="marketing_operationsSSE">Rp 0</td>
                                    </tr>
                                    <tr>
                                        <td style="text-indent: 40px">BI. Lain marketing</td>
                                        <td id="otherCostsSSE">Rp 0</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="table-secondary"><b>BI. Adm & Umum</b></td>
                                    </tr>
                                    <tr>
                                        <td style="text-indent: 40px">BI. Gaji & tunjangan</td>
                                        <td id="salariesAllowancesGAC">Rp 0</td>
                                    </tr>
                                    <tr>
                                        <td style="text-indent: 40px">BI. Listrik dan air</td>
                                        <td id="electricityWaterGAC">Rp 0</td>
                                    </tr>
                                    <tr>
                                        <td style="text-indent: 40px">BI. Transportasi</td>
                                        <td id="transportationGAC">Rp 0</td>
                                    </tr>
                                    <tr>
                                        <td style="text-indent: 40px">BI. Komunikasi</td>
                                        <td id="communicationGAC">Rp 0</td>
                                    </tr>
                                    <tr>
                                        <td style="text-indent: 40px">BI. ATK</td>
                                        <td id="officeStationeryGAC">Rp 0</td>
                                    </tr>
                                    <tr>
                                        <td style="text-indent: 40px">BI. Konsultan</td>
                                        <td id="consultantGAC">Rp 0</td>
                                    </tr>
                                    <tr>
                                        <td style="text-indent: 40px">BI. Kebersihan & keamanan</td>
                                        <td id="cleanlinessSecurityGAC">Rp 0</td>
                                    </tr>
                                    <tr>
                                        <td style="text-indent: 40px">BI. Pemeliharaan & renovasi</td>
                                        <td id="maintenanceRenovationGAC">Rp 0</td>
                                    </tr>
                                    <tr>
                                        <td style="text-indent: 40px">BI. Penyusutan</td>
                                        <td id="depreciationGAC">Rp 0</td>
                                    </tr>
                                    <tr>
                                        <td style="text-indent: 40px">BI. Pajak</td>
                                        <td id="taxGAC">Rp 0</td>
                                    </tr>
                                    <tr>
                                        <td style="text-indent: 40px">BI. Adm & umum lainnya</td>
                                        <td id="otherCostGAC">Rp 0</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
                
        <!-- Profit & Loss Preview -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <form class="form mt-4" id="form">
                    <div class="form-row">
                        <div class="form-group col-12 col-md-3">
                            <label for="">Tahun</label>
                            <select class="form-control" id="inputYear" required>
                                <option value="">Pilih Tahun</option>
                                @foreach ($years as $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>                        
                        </div>
                        <div class="col-12 col-md-2 mt-3">
                            <button type="submit" class="btn btn-primary btn-user btn-block mt-3">
                                Tampilkan Laporan
                            </button>
                        </div>
                    </div>
                </form>

                <div class="table-responsive mt-5">
                    <div id="profit-loss-report"></div>
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

            // Left card COGS
            $('#inputMonthCOGS').on('change', (event) => {
                // Get data preview
                $.ajax({
                    type: "GET",
                    url: "/finance/profit-loss/get-profit-loss-cogs/" + event.target.value,
                    success: function(res) {
                        if (res.status && res.data.cogs) {
                            var action = "{{ route('finance.updateProfitLossCOGS') }}?cogsID=" + res.data.cogs.id;
                            $('#financeFormCOGS').attr('action', action);

                            $('#inputRawMaterialCOGS').val(res.data.cogs.raw_material);
                            $('#inputManpowerCOGS').val(res.data.cogs.manpower);
                            $('#inputFactoryOverheadCOGS').val(res.data.cogs.factory_overhead);
                        } else if (!res.status || res.data.cogs === null) {
                            $('#financeFormCOGS').attr('action', "{{ route('finance.addProfitLossCOGS') }}");
                            
                            $('#inputRawMaterialCOGS').val('');
                            $('#inputManpowerCOGS').val('');
                            $('#inputFactoryOverheadCOGS').val('');
                        }
                    }
                });
            });

            // Left card SSE
            $('#inputMonthSSE').on('change', (event) => {
                // Get data preview
                $.ajax({
                    type: "GET",
                    url: "/finance/profit-loss/get-profit-loss-sse/" + event.target.value,
                    success: function(res) {
                        if (res.status && res.data.sse) {
                            var action = "{{ route('finance.updateProfitLossSSE') }}?sseID=" + res.data.sse.id;
                            $('#financeFormSSE').attr('action', action);

                            $('#inputAdmEcommerceSSE').val(res.data.sse.adm_ecommerce);
                            $('#inputMarketingSalarySSE').val(res.data.sse.marketing_salary);
                            $('#inputMarketingOperationsSSE').val(res.data.sse.marketing_operations);
                            $('#inputOtherCostSSE').val(res.data.sse.other_cost);
                        } else if (!res.status || res.data.sse === null) {
                            $('#financeFormSSE').attr('action', "{{ route('finance.addProfitLossSSE') }}");
                            
                            $('#inputAdmEcommerceSSE').val('');
                            $('#inputMarketingSalarySSE').val('');
                            $('#inputMarketingOperationsSSE').val('');
                            $('#inputOtherCostSSE').val('');
                        }
                    }
                });
            });

            // Left card GA
            $('#inputMonthGA').on('change', (event) => {
                // Get data preview
                $.ajax({
                    type: "GET",
                    url: "/finance/profit-loss/get-profit-loss-ga/" + event.target.value,
                    success: function(res) {
                        if (res.status && res.data.gac) {
                            var action = "{{ route('finance.updateProfitLossGA') }}?gacID=" + res.data.gac.id;
                            $('#financeFormGA').attr('action', action);

                            $('#inputSalariesAllowancesGA').val(res.data.gac.salaries_and_allowances);
                            $('#inputElectricityWaterGA').val(res.data.gac.electricity_and_water);
                            $('#inputTransportationGA').val(res.data.gac.transportation);
                            $('#inputCommunicationGA').val(res.data.gac.communication);
                            $('#inputOfficeStationeryGA').val(res.data.gac.office_stationery);
                            $('#inputConsultantGA').val(res.data.gac.consultant);
                            $('#inputCleanlinessSecurityGA').val(res.data.gac.cleanliness_and_security);
                            $('#inputMaintenanceRenovationGA').val(res.data.gac.maintenance_and_renovation);
                            $('#inputDepreciationGA').val(res.data.gac.depreciation);
                            $('#inputTaxGA').val(res.data.gac.tax);
                            $('#inputOtherCostGA').val(res.data.gac.other_cost);
                        } else if (!res.status || res.data.gac === null) {
                            $('#financeFormGA').attr('action', "{{ route('finance.addProfitLossGA') }}");
                            
                            $('#inputSalariesAllowancesGA').val('');
                            $('#inputElectricityWaterGA').val('');
                            $('#inputTransportationGA').val('');
                            $('#inputCommunicationGA').val('');
                            $('#inputOfficeStationeryGA').val('');
                            $('#inputConsultantGA').val('');
                            $('#inputCleanlinessSecurityGA').val('');
                            $('#inputMaintenanceRenovationGA').val('');
                            $('#inputDepreciationGA').val('');
                            $('#inputTaxGA').val('');
                            $('#inputOtherCostGA').val('');
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
                    url: "/finance/profit-loss/get-profit-loss/" + event.target.value,
                    success: function(res) {
                        if (res.status && (res.data.cogs && res.data.sse && res.data.gac)) {
                            $('#rawMaterialCOGS').html(formatRupiah(res.data.cogs.raw_material));
                            $('#manpowerCOGS').html(formatRupiah(res.data.cogs.manpower));
                            $('#factoryOverheadCOGS').html(formatRupiah(res.data.cogs.factory_overhead));
                            $('#admEcommerceSSE').html(formatRupiah(res.data.sse.adm_ecommerce));
                            $('#marketingSalarySSE').html(formatRupiah(res.data.sse.marketing_salary));
                            $('#marketing_operationsSSE').html(formatRupiah(res.data.sse.marketing_operations));
                            $('#otherCostsSSE').html(formatRupiah(res.data.sse.other_cost));
                            $('#salariesAllowancesGAC').html(formatRupiah(res.data.gac.salaries_and_allowances));
                            $('#electricityWaterGAC').html(formatRupiah(res.data.gac.electricity_and_water));
                            $('#transportationGAC').html(formatRupiah(res.data.gac.transportation));
                            $('#communicationGAC').html(formatRupiah(res.data.gac.communication));
                            $('#officeStationeryGAC').html(formatRupiah(res.data.gac.office_stationery));
                            $('#consultantGAC').html(formatRupiah(res.data.gac.consultant));
                            $('#cleanlinessSecurityGAC').html(formatRupiah(res.data.gac.cleanliness_and_security));
                            $('#maintenanceRenovationGAC').html(formatRupiah(res.data.gac.maintenance_and_renovation));
                            $('#depreciationGAC').html(formatRupiah(res.data.gac.depreciation));
                            $('#taxGAC').html(formatRupiah(res.data.gac.tax));
                            $('#otherCostGAC').html(formatRupiah(res.data.gac.other_cost));
                        } else if (!res.status || (res.data.cogs === null && res.data.sse === null && res.data.gac === null)) {
                            $('#rawMaterialCOGS').html("Rp 0");
                            $('#manpowerCOGS').html("Rp 0");
                            $('#factoryOverheadCOGS').html("Rp 0");
                            $('#admEcommerceSSE').html("Rp 0");
                            $('#marketingSalarySSE').html("Rp 0");
                            $('#marketing_operationsSSE').html("Rp 0");
                            $('#otherCostsSSE').html("Rp 0");
                            $('#salariesAllowancesGAC').html("Rp 0");
                            $('#electricityWaterGAC').html("Rp 0");
                            $('#transportationGAC').html("Rp 0");
                            $('#communicationGAC').html("Rp 0");
                            $('#officeStationeryGAC').html("Rp 0");
                            $('#consultantGAC').html("Rp 0");
                            $('#cleanlinessSecurityGAC').html("Rp 0");
                            $('#maintenanceRenovationGAC').html("Rp 0");
                            $('#depreciationGAC').html("Rp 0");
                            $('#taxGAC').html("Rp 0");
                            $('#otherCostGAC').html("Rp 0");
                        }
                    }
                });
            });

            // Format rupiah
            $('.rupiah').on('input', function() {
                var formattedValue = inputFormatRupiah($(this).val());
                $(this).val(formattedValue);
            });

            // Create profit & loss report
            $('#form').on('submit', function(e) {
                e.preventDefault();
                var yearInput = $('#inputYear').val();
                
                $.ajax({
                    type: "POST",
                    url: "/finance/profit-loss/report",
                    data: {
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                        "year": yearInput,
                    },
                    success: function(data) {
                        $('#profit-loss-report').html(data);
                    }
                });
            });
        });
    </script>
@endpush