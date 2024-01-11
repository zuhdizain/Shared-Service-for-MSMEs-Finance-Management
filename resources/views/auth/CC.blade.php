<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="website apps for Final Task">
    <meta name="Nadya Zahra" content="website apps for MSMEs">

    <title>HR Apps - Call Center</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('template/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('template/css/sb-admin-2.min.css') }}" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container mt-2">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="col">
                        <div class="p-5">
                            <div class="text-center">
                                <h3 class="h3 text-gray-900"><b>Welcome!</h3>
                                <h6 class="h6 text-gray-900">Aplikasi Manajemen untuk UMKM Indonesia</h6>
                            </div>
                            <form class="user" method="POST" action="{{ route('contact.submit') }}" enctype="multipart/form-data">
                                @csrf
                                <hr>
                                <h6 class="h6 text-gray-900 text-center mb-3">Mohon isi form berikut untuk menyampaikan keluhan Anda.</h6>

                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" required data-error="Mohon isi nama lengkap Anda"
                                        id="name" name="fullname" placeholder="Nama Lengkap">
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" required data-error="Mohon isi alamat email Anda"
                                        id="email" name="email" placeholder="Alamat Email">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" required data-error="Mohon isi subject pesan Anda"
                                        id="subject" name="subject" placeholder="Subject Pesan">
                                </div>
                                <div class="form-group">
                                    <textarea type="text" class="form-control" required data-error="Mohon isi pesan Anda"
                                        id="message" name="msg" rows="5">
                                    </textarea>
                                </div>

                                <button class="btn btn-primary btn-user btn-block" id="submit" type="submit">
                                    Kirim Pesan
                                </button>
                                <hr>

                            </form>
                            
                            <div class="text-center small">
                                Sudah memiliki akun? <a href="{{ url('/') }}">Login disini</a>.
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>

    </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('template/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('template/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('template/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('template/js/sb-admin-2.min.js') }}"></script>

</body>

</html>