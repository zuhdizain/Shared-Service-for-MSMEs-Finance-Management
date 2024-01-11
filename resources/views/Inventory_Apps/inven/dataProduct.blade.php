<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- Custom fonts for this template-->
    <link href="{{ asset('template/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('template/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('template/css/style.css') }}" rel="stylesheet">

    <!-- Custom styles Data Table page -->
    <link href="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
</head>
<body>
    <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid">
            
            <!-- Page Heading -->
            
           

            <!-- DataTables Example -->
            
                <div class="card-header py-3 d-sm-flex justify-content-between">
                    <h1 class="m-0 font-weight-bold text-center mt-2">List of Product Out</h1>
                    
                </div>
                    <div class="table-responsive">
                        <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Product Out</th>
                                    <th>Customer</th>
                                    <th>Price</th>
                                    <th>Description</th>
                                    <th>Send Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($outs as $out)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
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

       
        <!-- /.container-fluid -->

    
    <!-- End of Main Content -->
</body>
</html>
