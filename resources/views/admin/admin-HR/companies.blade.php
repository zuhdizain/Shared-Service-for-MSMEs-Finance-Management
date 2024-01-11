@extends('admin.layout.main')

@section('content-admin')

    <!-- Main Content -->
    <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid">
            
            <!-- Page Heading -->
            <div class="align-items-center mb-4">
                <h3 class="h3 mb-0 text-gray-800">All Companies</h3>
                <h6 class="h6 mb-0 text-gray-800">This page is meant to show all the companies using this website.</h6>
            </div>

            <!-- DataTables Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-sm-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary mt-2">Companies list</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Company</th>
                                    <th>Kontak</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                                {{-- @foreach ($employee as $emp) --}}
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>
                                            <h6 class="font-weight-bold mt-4">PT Djarco Indonesia</h6>
                                        </td>
                                        <td>
                                            <div class="col g-3 mt-3">
                                                <h6 class="font-weight-bold">djarco@email.com</h6>
                                                <p>0123456789</p>
                                            </div>
                                        </td>
                                        <td>
                                            <a class="badge badge-primary mt-4" href="#">Employees</a>
                                            <a class="badge badge-warning mt-4" href="#">Details</a>
                                        </td>
                                    </tr>
                                {{-- @endforeach --}}
            
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