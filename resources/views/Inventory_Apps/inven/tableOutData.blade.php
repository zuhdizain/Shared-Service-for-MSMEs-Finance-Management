@extends('Inventory_Apps/layout/main')

@section('content-inventory')

    <!-- Main Content -->
    <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid">
            
            <!-- Page Heading -->
            <div class="align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Product Out</h1>
                <div class="my-2"></div>
            </div>
           

            <!-- DataTables Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-sm-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary mt-2">List of Product Out</h6>
                    <button type='button' id='export_button' class="btn btn-primary mr-2 shadow-sm">
                        <span class="icon text-white-50">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span class="text edit-sp">Export</span>
                    </button>
                    <a href="{{ route('out.create') }}" class="btn btn-primary mr-2 shadow-sm">
                        <span class="icon text-white-50">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span class="text edit-sp">Add Product Out</span>
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center" id="dataTable"  width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Product Code</th>
                                    <th>Product Out</th>
                                    <th>Customer</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Description</th>
                                    <th>Send Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($outs as $out)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>
                                            <div class="col g-3 mt-3">
                                                <h6 class="font-weight-bold">{{ $out->product_code }}</h6>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="row profile">
                                    
                                                <div class="col g-3 mt-3">
                                                    <h5 class="font-weight-bold">{{ $out->out }}</h5>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="col g-3 mt-3">
                                                <h6 class="font-weight-bold">{{ $out->customer }}</h6>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="col g-3 mt-3">
                                                <h6 class="font-weight-bold">Rp.{{ $out->price }}</h6>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="col g-3 mt-3">
                                                <h6 class="font-weight-bold">{{ $out->quantity }} Pcs</h6>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="col g-3 mt-3">
                                                <h6 class="font-weight-bold">{{ $out->desc }}</h6>
                                            </div>
                                        </td>
                                    <td>
                                        <div class="col g-3 mt-3">
                                            <h6 class="font-weight-bold">{{ $out->date }}</h6>
                                        </div>
                                    </td>
                                    <td>
                                        <form action="{{ route('out.destroy', $out->id) }}" method="POST" onsubmit="return confirm('Do you want delete this product out?')">
                                        <a class="btn btn-primary" href="{{route('out.edit', $out->id)}}">Edit</a>
                                        @csrf
                                        @method('delete')
                                        
                                        <button class="btn btn-danger" href="#">Delete</button>
                                        </form>
                                    </td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>    

                        {{-- Export Table --}}
                        <table class="table table-bordered text-center" id="exportTable" width="100%" cellspacing="0" hidden>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Product Code</th>
                                    <th>Product Out</th>
                                    <th>Customer</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Description</th>
                                    <th>Send Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($outs as $out)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>
                                            <div class="col g-3 mt-3">
                                                <h6 class="font-weight-bold">{{ $out->product_code }}</h6>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="row profile">
                                    
                                                <div class="col g-3 mt-3">
                                                    <h5 class="font-weight-bold">{{ $out->out }}</h5>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="col g-3 mt-3">
                                                <h6 class="font-weight-bold">{{ $out->customer }}</h6>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="col g-3 mt-3">
                                                <h6 class="font-weight-bold">{{ $out->price }}</h6>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="col g-3 mt-3">
                                                <h6 class="font-weight-bold">{{ $out->quantity }} Pcs</h6>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="col g-3 mt-3">
                                                <h6 class="font-weight-bold">{{ $out->desc }}</h6>
                                            </div>
                                        </td>
                                    <td>
                                        <div class="col g-3 mt-3">
                                            <h6 class="font-weight-bold">{{ $out->date }}</h6>
                                        </div>
                                    </td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

@endsection

@push('script')
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    <script>
        function html_table_to_excel(type) {
            var data = document.getElementById('exportTable');
            var file = XLSX.utils.table_to_book(data, {
                sheet: "sheet1"
            });
            XLSX.write(file, {
                bookType: type,
                bookSST: true,
                type: 'base64'
            });
            var today = new Date();
            var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate() + '-' + today.getHours() +
                '-' + today.getMinutes() + '-' + today.getSeconds();
            XLSX.writeFile(file, 'DataProductOut ' + date + "." + type);
        }
        const export_button = document.getElementById('export_button');
        export_button.addEventListener('click', () => {
            html_table_to_excel('xlsx');
        });
    </script>
@endpush