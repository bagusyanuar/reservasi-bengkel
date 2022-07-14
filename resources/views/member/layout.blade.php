<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;1,100;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/bootstrap/css/bootstrap.min.css') }}">
    <link href="{{ asset('/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/sweetalert2.css') }}" rel="stylesheet">
    <script src="{{ asset('/js/sweetalert2.min.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('/slick/slick.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/slick/slick-theme.css') }}"/>
    <title>Document</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
    @yield('css')
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark" style="height: 75px; background-color: #376477; box-shadow: none !important;">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="{{ asset('/assets/icon/brand-logo.png') }}" width="30" height="30" alt="">
            <span>Bengkel Solo</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto mb-2 mb-lg-0">
                <li class="nav-item mr-1">
                    <a class="nav-link f-bold color-semi-white" aria-current="page" href="/">Beranda</a>
                </li>
                <li class="nav-item mr-1">
                    <a class="nav-link f-bold color-semi-white" aria-current="page" href="/">Produk</a>
                </li>
                <li class="nav-item mr-1">
                    <a class="nav-link f-bold color-semi-white" aria-current="page" href="/">Tentang Kami</a>
                </li>
                <li class="nav-item mr-1">
                    <a class="nav-link f-bold color-semi-white" aria-current="page" href="/">Hubungi Kami</a>
                </li>
            </ul>
            <div class="d-flex align-items-center">
                @guest()
                    <a href="/login-member" class="navbar-item f-12">
                        <i class="fa fa-user-o mr-2"></i>
                        <span>Masuk / Daftar</span>
                    </a>
                @endguest
                @auth()
                    <a href="/transaksi" class="navbar-item f-12">
                        <i class="fa fa-briefcase mr-2"></i>
                    </a>
                    <a href="/logout" class="navbar-item f-12 ml-3">
                        <i class="fa fa-power-off mr-1"></i>
                        <span>Keluar</span>
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>


<div aria-live="polite" aria-atomic="true" style="position: relative; min-height: 0;">
    <div class="toast d-none" style="position: fixed; top: 0; right: 0; z-index: 99999" data-autohide="true"
         data-delay="8000">
        <div class="toast-header">
            <img src="" class="rounded mr-2" alt="">
            <strong class="mr-auto" id="toast-title"></strong>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body" id="toast-message">
        </div>
    </div>
</div>
@yield('content')
<script src="{{ asset('/jQuery/jquery-3.4.1.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="{{ asset('/bootstrap/js/bootstrap.js') }}"></script>
<script src="{{ asset('/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/slick/slick.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.your-class').slick({
            dots: false,
            infinite: true,
            speed: 500,
            fade: true,
            cssEase: 'linear',
            autoplay: true,
            arrows: false,
            adaptiveHeight: true
        });
    });
</script>
<script src="{{ asset('/js/helper.js') }}"></script>
@yield('js')
</body>
</html>
