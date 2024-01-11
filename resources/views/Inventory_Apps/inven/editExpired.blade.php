@extends('Inventory_Apps.layout.main')

@section('content-inventory')

    <!-- Main Content -->
    <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="col mb-4">
                <h3 class="h3 mb-0 text-gray-800">Do you want edit some data product expired?</h3>
                <h6 class="h6 mb-0 text-gray-800">Please edit product expired data to the following form and fill in accordance with the available data formats.</h6>
            </div>

            <form method="POST" action="{{ route('expired.update', [$expireds->id]) }}" enctype="multipart/form-data">
                
                @csrf
                @method('PUT')
                

                <!-- Tambah Data Product -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-sm-flex justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary mt-2">Edit Data Product</h6>
                        <div class="row float-right">
                            <div class="my-2"></div>
                            <button href="#" class="btn btn-success mr-2 shadow-sm" type="submit">
                                <span class="icon text-white-50">
                                    <i class="fas fa-check"></i>
                                </span>
                                <span class="text">Save</span>
                            </button>
                            <div class="my-2"></div>
                            <a href="{{ route('expired.index') }}" class="btn btn-danger mr-3 shadow-sm">
                                <span class="icon text-white-50">
                                    <i class="fas fa-ban"></i>
                                </span>
                                <span class="text">Cancel</span>
                            </a>
                        </div>
                    </div>

                    <div class="card-body container">
                        <!-- Form Create Product(s) -->

                            <div class="align-items-center">
                                <div class="form-group row">
                                    <label for="product" class="form-label font-weight-bold col-sm-2">
                                        Product Expired</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="expired" class="form-control bg-light border-0 small" value="{{ $expireds->expired }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="date" class="form-label font-weight-bold col-sm-2">
                                        Price</label>
                                    <div class="col-sm-10">
                                        <input type="number" name="price" class="form-control bg-light border-0 small" value="{{ $expireds->price }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="desc" class="form-label font-weight-bold col-sm-2">
                                        Description</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="desc" class="form-control bg-light border-0 small" value="{{ $expireds->desc }}">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            
                        </form>
                        <!-- End Form -->
                    </div>
                    <!-- End Card Body -->
                </div>

            </form>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

@endsection