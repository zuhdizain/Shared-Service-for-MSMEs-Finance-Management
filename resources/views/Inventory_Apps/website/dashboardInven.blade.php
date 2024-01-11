@extends('Inventory_Apps/layout/main')

@section('content-inventory')

    <!-- Main Content -->
    <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Welcome, Mas Ganteng!</h1>
            </div>

            <!-- Content Row -->
            <div class="row">

                <!-- Jumlah Pegawai Card -->
               
                <div class="col mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Total Product</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{$total_products}}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-box fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Styles -->
               

                <!-- Pegawai Masuk Card -->
                <div class="col mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Total Assets</div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-auto">
                                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">Rp.{{$total}}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-regular fa-dollar-sign fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               

                <!-- Jumlah Divisi Card -->
                <div class="col mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Total Goods</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{$total_goods}} KG</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-list-alt fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Row -->
            <div class="row">

                <!-- Content Column -->
                <div class="col-lg-6 mb-3">

                    <!-- To Do List -->
                    
                    <div class="card shadow mb-3">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Confirmation</h6>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <tbody>
                                    @foreach ($confirms as $con)
                                    <tr>
                                        <td>{{$con->confirm}}</td>
                                        <td> 
                                            <form method="POST" action="{{ route('confirm.destroy', $con->id) }}">
                                                @csrf
                                                @method('delete')
                                            <button value="delete" type="submit" class="btn btn-success btn-circle btn-sm">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <form method="POST" action="{{ route('confirm.store') }}" enctype="multipart/form-data">
                                            @csrf
                                            <td> 
                                                <input type="text" name="confirm" class="form-control bg-light border-0 small" placeholder="New Activity.."
                                                    aria-label="Search" aria-describedby="basic-addon2">
                                            </td>
                                            <td>
                                                <button class="btn btn-success btn-circle btn-sm" type="submit">
                                                    <i class="fas fa-check"></i>
                                            </button>
                                            </td>
                                        </form>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

                

          
                <div class="col-lg-6 mb-3">

                    <!-- Company's Event -->
                    <div class="card shadow mb-3">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Request From Production</h6>
                        </div>
                        <div class="card-body">

                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>Kebutuhan Telur, Terigu, Aci</td>
                                        <td> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Kebutuhan Padi, Gula, Terigu, Asem Jawa</td>
                                        <td>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>

                </div>
            </div>

           

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

@endsection