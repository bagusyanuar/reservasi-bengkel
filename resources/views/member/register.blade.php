<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/sweetalert2.css') }}" rel="stylesheet">
    <script src="{{ asset('/js/sweetalert2.min.js')}}"></script>
    <title>Document</title>
</head>
<body>
@if (\Illuminate\Support\Facades\Session::has('failed'))
    <script>
        Swal.fire("Gagal", '{{\Illuminate\Support\Facades\Session::get('failed')}}', "error")
    </script>
@endif
<div class="w-100 pt-5 login-body">
    <div class="row justify-content-center w-100 mt-5">
        <div class="col-lg-6 col-md-6 col-sm-11">
            <div class="card">
                <div class="card-body">
                    <img src="{{ asset('/assets/icon/logo.png') }}" class="w-100 login-icon mb-3"/>
                    <p class="f-bold mb-2 text-center" style="font-size: 18px">Silahkan Login</p>
                    <form method="post">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="w-100 mb-1">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" placeholder="Username"
                                           name="username">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="w-100 mb-1">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" placeholder="Password"
                                           name="password">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="w-100 mb-1">
                                    <label for="nama" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="nama" placeholder="Nama Lengkap"
                                           name="nama">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="w-100 mb-1">
                                    <label for="no_hp" class="form-label">No. Handphone</label>
                                    <input type="number" class="form-control" id="no_hp" placeholder="No. Handphone"
                                           name="no_hp">
                                </div>
                            </div>
                        </div>
                        <div class="w-100 mb-1">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea rows="3" class="form-control" id="alamat" placeholder="Alamat"
                                      name="alamat"></textarea>
                        </div>
                        <div class="w-100 mb-2 mt-3">
                            <button type="submit" class="btn btn-primary w-100">Daftar</button>
                        </div>
                        <div class="w-100" style="text-align: end">
                            <a class="text-right" href="/login-member">Sudah Punya Akun?</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
