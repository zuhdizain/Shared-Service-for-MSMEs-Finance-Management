@extends('Inventory_Apps/layout/main')

@section('content-inventory')

    <!-- Main Content -->
    <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid">
            
            <!-- Page Heading -->
            <div class="align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Product Return Data</h1>
                <div class="my-2"></div>
            </div>

            <!-- DataTables Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-sm-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary mt-2">List of Product Return</h6>
                    <a href="{{ route('retur.create') }}" class="btn btn-primary mr-2 shadow-sm">
                        <span class="icon text-white-50">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span class="text edit-sp">Add Product Return</span>
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Product Code</th>
                                    <th>Product Return</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Return Date</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($returns as $retur)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>
                                            <div class="col g-3 mt-3">
                                                <h6 class="font-weight-bold">{{ $retur->product_code }}</h6>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="row profile">
                                    
                                                <div class="col g-3 mt-3">
                                                    <h5 class="font-weight-bold">{{ $retur->return }}</h5>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="col g-3 mt-3">
                                                <h6 class="font-weight-bold"> Rp.{{ $retur->price }}</h6>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="col g-3 mt-3">
                                                <h6 class="font-weight-bold">{{ $retur->quantity }} Pcs</h6>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="col g-3 mt-3">
                                                <h6 class="font-weight-bold">{{$retur->date}}</h6>
                                            </div>
                                        </td>
                                    <td>
                                        <div class="col g-3 mt-3">
                                            <h6 class="font-weight-bold">{{ $retur->desc }}</h6>
                                        </div>
                                    </td>
                                    <td>
                                        <form action="{{ route('retur.destroy', $retur->id) }}" method="POST" onsubmit="return confirm('Do you want delete this product return?')">
                                        <a class="btn btn-primary" href="{{route('retur.edit', $retur->id)}}">Edit</a>
                                        @csrf
                                        @method('delete')
                                        
                                        <button class="btn btn-danger" href="#">Delete</button>
                                        
                                        </form>
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