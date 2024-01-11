@extends('Finance_Apps.layouts.app')

@section('title')
    Manajemen Keuangan
@endsection

{{-- @push('addon-style')
    <!-- Custom styles for this page -->
    <link href="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush --}}

@section('content-finance')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Input Data Keuangan</h1>
        </div>

        {{-- COGS --}}
        <div class="row">
            <div class="col-md-6 col-12">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <form method="POST" action="">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <select class="form-control" id="monthCOGS" name="month">
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

                            <h6 class="mb-3 mt-3 text-gray-800"><b>Harga Pokok Penjualan</b></h6>
                            <div class="form-row">
                                <div class="form-group col-12 col-md-6">
                                    <label for="inputRawMaterialCOGS">Bahan baku</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Rp</div>
                                        </div>
                                        <input type="number" class="form-control" name="rawMaterialCOGS" value="{{ old('rawMaterialCOGS') }}" min="0" required>
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="inputManpowerCOGS">Tenaga kerja</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Rp</div>
                                        </div>
                                        <input type="number" class="form-control" name="manpowerCOGS" value="{{ old('manpowerCOGS') }}" min="0" required>
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="inputFactoryOverheadCOGS">Overhead Pabrik</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Rp</div>
                                        </div>
                                        <input type="number" class="form-control" name="factoryOverheadCOGS" value="{{ old('factoryOverheadCOGS') }}" min="0" required>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                Submit
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <h6 class="mb-3 text-gray-800"><b>Harga Pokok Penjualan Bulan <span id="prevMonthCOGS"></span></b></h6>
                    </div>
                </div>
            </div>
        </div>

        {{-- SSE --}}
        <div class="row">
            <div class="col-md-6 col-12">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <form method="POST" action="">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <select class="form-control" id="monthSSE" name="month">
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

                            <h6 class="mb-3 mt-3 text-gray-800"><b>Biaya Penjualan & Pelayanan</b></h6>
                            <div class="form-row">
                                <div class="form-group col-12 col-md-6">
                                    <label for="inputAdmEcommerceSSE">Adm online</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Rp</div>
                                        </div>
                                        <input type="number" class="form-control" name="admEcommerceSSE" value="{{ old('admEcommerceSSE') }}" min="0" required>
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="inputMarketingSalarySSE">Gaji marketing</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Rp</div>
                                        </div>
                                        <input type="number" class="form-control" name="marketingSalarySSE" value="{{ old('marketingSalarySSE') }}" min="0" required>
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="inputMarketingOperationsSSE">Operasional marketing</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Rp</div>
                                        </div>
                                        <input type="number" class="form-control" name="marketingOperationsSSE" value="{{ old('marketingOperationsSSE') }}" min="0" required>
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="inputOtherCostSSE">Biaya lainnya</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Rp</div>
                                        </div>
                                        <input type="number" class="form-control" name="otherCostSSE" value="{{ old('otherCostSSE') }}" min="0" required>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                Submit
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <h6 class="mb-3 text-gray-800"><b>Biaya Penjualan & Pelayanan Bulan <span id="prevMonthSSE"></span></b></h6>
                    </div>
                </div>
            </div>
        </div>

        {{-- GA --}}
        <div class="row">
            <div class="col-md-6 col-12">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <form method="POST" action="">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <select class="form-control" id="monthGA" name="month">
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

                            <h6 class="mb-3 mt-3 text-gray-800"><b>Biaya Adm & Umum</b></h6>
                            <div class="form-row">
                                <div class="form-group col-12 col-md-6">
                                    <label for="inputSalariesAllowancesGA">Gaji & tunjangan</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Rp</div>
                                        </div>
                                        <input type="number" class="form-control" name="salariesAllowancesGA" value="{{ old('salariesAllowancesGA') }}" min="0" required>
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="inputElectricityWaterGA">Listrik & Air</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Rp</div>
                                        </div>
                                        <input type="number" class="form-control" name="electricityWaterGA" value="{{ old('electricityWaterGA') }}" min="0" required>
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="inputTransportationGA">Transportasi</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Rp</div>
                                        </div>
                                        <input type="number" class="form-control" name="transportationGA" value="{{ old('transportationGA') }}" min="0" required>
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="inputCommunicationGA">Komunikasi</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Rp</div>
                                        </div>
                                        <input type="number" class="form-control" name="communicationGA" value="{{ old('communicationGA') }}" min="0" required>
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="inputOfficeStationeryGA">Alat tulis kantor</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Rp</div>
                                        </div>
                                        <input type="number" class="form-control" name="officeStationeryGA" value="{{ old('officeStationeryGA') }}" min="0" required>
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="inputConsultantGA">Konsultan</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Rp</div>
                                        </div>
                                        <input type="number" class="form-control" name="consultantGA" value="{{ old('consultantGA') }}" min="0" required>
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="inputCleanlinessSecurityGA">Kebersihan & keamanan</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Rp</div>
                                        </div>
                                        <input type="number" class="form-control" name="cleanlinessSecurityGA" value="{{ old('cleanlinessSecurityGA') }}" min="0" required>
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="inputMaintenanceRenovationGA">Pemeliharaan & renovasi</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Rp</div>
                                        </div>
                                        <input type="number" class="form-control" name="maintenanceRenovationGA" value="{{ old('maintenanceRenovationGA') }}" min="0" required>
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="inputDepreciationGA">Penyusutan</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Rp</div>
                                        </div>
                                        <input type="number" class="form-control" name="depreciationGA" value="{{ old('depreciationGA') }}" min="0" required>
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="inputTaxGA">Pajak</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Rp</div>
                                        </div>
                                        <input type="number" class="form-control" name="taxGA" value="{{ old('taxGA') }}" min="0" required>
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="inputOtherCostGA">Biaya lainnya</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Rp</div>
                                        </div>
                                        <input type="number" class="form-control" name="otherCostGA" value="{{ old('otherCostGA') }}" min="0" required>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                Submit
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <h6 class="mb-3 text-gray-800"><b>Biaya Adm & Umum Bulan <span id="prevMonthGA"></span></b></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('addon-script')
    <!-- Page level plugins -->
    <script src="{{ asset('template/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('template/js/demo/datatables-demo.js') }}"></script>
    <script>
        $(document).ready(function() {
            // COGS
            $('#monthCOGS').on('change', (event) => {
                if (event.target.value == 1) {
                    $('#prevMonthCOGS').text('Januari');
                } else if (event.target.value == 2) {
                    $('#prevMonthCOGS').text('Februari');
                } else if (event.target.value == 3) {
                    $('#prevMonthCOGS').text('Maret');
                } else if (event.target.value == 4) {
                    $('#prevMonthCOGS').text('April');
                } else if (event.target.value == 5) {
                    $('#prevMonthCOGS').text('Mei');
                } else if (event.target.value == 6) {
                    $('#prevMonthCOGS').text('Juni');
                } else if (event.target.value == 7) {
                    $('#prevMonthCOGS').text('Juli');
                } else if (event.target.value == 8) {
                    $('#prevMonthCOGS').text('Agustus');
                } else if (event.target.value == 9) {
                    $('#prevMonthCOGS').text('September');
                } else if (event.target.value == 10) {
                    $('#prevMonthCOGS').text('Oktober');
                } else if (event.target.value == 11) {
                    $('#prevMonthCOGS').text('November');
                } else if (event.target.value == 12) {
                    $('#prevMonthCOGS').text('Desember');
                }
            });

            // SSE
            $('#monthSSE').on('change', (event) => {
                if (event.target.value == 1) {
                    $('#prevMonthSSE').text('Januari');
                } else if (event.target.value == 2) {
                    $('#prevMonthSSE').text('Februari');
                } else if (event.target.value == 3) {
                    $('#prevMonthSSE').text('Maret');
                } else if (event.target.value == 4) {
                    $('#prevMonthSSE').text('April');
                } else if (event.target.value == 5) {
                    $('#prevMonthSSE').text('Mei');
                } else if (event.target.value == 6) {
                    $('#prevMonthSSE').text('Juni');
                } else if (event.target.value == 7) {
                    $('#prevMonthSSE').text('Juli');
                } else if (event.target.value == 8) {
                    $('#prevMonthSSE').text('Agustus');
                } else if (event.target.value == 9) {
                    $('#prevMonthSSE').text('September');
                } else if (event.target.value == 10) {
                    $('#prevMonthSSE').text('Oktober');
                } else if (event.target.value == 11) {
                    $('#prevMonthSSE').text('November');
                } else if (event.target.value == 12) {
                    $('#prevMonthSSE').text('Desember');
                }
            });

            // GA
            $('#monthGA').on('change', (event) => {
                if (event.target.value == 1) {
                    $('#prevMonthGA').text('Januari');
                } else if (event.target.value == 2) {
                    $('#prevMonthGA').text('Februari');
                } else if (event.target.value == 3) {
                    $('#prevMonthGA').text('Maret');
                } else if (event.target.value == 4) {
                    $('#prevMonthGA').text('April');
                } else if (event.target.value == 5) {
                    $('#prevMonthGA').text('Mei');
                } else if (event.target.value == 6) {
                    $('#prevMonthGA').text('Juni');
                } else if (event.target.value == 7) {
                    $('#prevMonthGA').text('Juli');
                } else if (event.target.value == 8) {
                    $('#prevMonthGA').text('Agustus');
                } else if (event.target.value == 9) {
                    $('#prevMonthGA').text('September');
                } else if (event.target.value == 10) {
                    $('#prevMonthGA').text('Oktober');
                } else if (event.target.value == 11) {
                    $('#prevMonthGA').text('November');
                } else if (event.target.value == 12) {
                    $('#prevMonthGA').text('Desember');
                }
            });
        });
    </script>
@endpush