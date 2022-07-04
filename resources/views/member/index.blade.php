@extends('member.layout')

@section('content')
    <div class="banner-container">
        <div class="your-class" style="width: 100%">
            <img src="{{ asset('/assets/icon/banner-1.jpg') }}" alt="Gambar Banner" class="banner-item">
            <img src="{{ asset('/assets/icon/banner-2.webp') }}" alt="Gambar Banner" class="banner-item">
            <img src="{{ asset('/assets/icon/banner-3.jpg') }}" alt="Gambar Banner" class="banner-item">
        </div>
        <div class="banner-text-container">
            <div class="d-flex justify-content-center align-items-center" style="height: 300px">
                <p class="banner-text" style="opacity: 1">Selamat Datang Web Di E-Commerce </p>
            </div>
        </div>
    </div>
    <div class="pl-5 pl-5 pt-2 pb-2 mt-3">
        <div class="row w-100">
            <div class="col-lg-2">
                <p class="font-weight-bold">Kategori</p>
                <ul class="list-group">
                    @foreach($paket as $v)
                        <a href="/">
                            <li class="list-group-item">{{ $v->nama }}</li>
                        </a>
                    @endforeach
                </ul>
            </div>
            <div class="col-lg-10">
                <div class="d-flex mb-3">
                    <div class="flex-grow-1 mr-2">
                        <input type="text" class="form-control" id="filter" placeholder="Cari Nama barang"
                               name="filter">
                    </div>
                    <div>
                        <a href="#" class="btn btn-primary" id="btn-search"><i
                                class="fa fa-search mr-1"></i><span>Cari</span></a>
                    </div>
                </div>

                <div class="panel-product" id="panel-product">
                    <div class="row">
{{--                        @foreach($data as $v)--}}
{{--                            <div class="col-lg-3 col-md-4 mb-4">--}}
{{--                                <div class="card card-item" data-id="{{ $v->id }}" style="cursor: pointer">--}}
{{--                                    <img class="card-img-top" src="{{ asset('/assets/barang'). "/" . $v->gambar }}"--}}
{{--                                         alt="Card image cap" height="150">--}}
{{--                                    <div class="card-body">--}}
{{--                                        <h5 class="card-title">{{ $v->nama }}</h5>--}}
{{--                                        <p class="card-text">Rp. {{ $v->harga }}</p>--}}
{{--                                        <a href="#" class="btn btn-sm btn-primary">Tambah Keranjang</a>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        @endforeach--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>

        function emptyElementProduct() {
            return '<div class="col-lg-12 col-md-12" >' +
                '<div class="d-flex align-items-center justify-content-center" style="height: 600px"><p class="font-weight-bold">Tidak Ada Produk</p></div>' +
                '</div>';
        }

        function singleProductElement(data) {
            return '<div class="col-lg-3 col-md-4 mb-4">' +
                '<div class="card card-item" data-id="' + data['id'] + '" style="cursor: pointer">' +
                '<img class="card-img-top"  src="/assets/barang/' + data['gambar'] + '" alt="Card image cap" height="150"/>' +
                '<div class="card-body">' +
                '<h5 class="card-title">' + data['nama'] + '</h5>' +
                '<p class="card-text">Rp. ' + data['harga'] + '</p>' +
                '<a href="#" class="btn btn-sm btn-primary">Tambah Keranjang</a>' +
                '</div>' +
                '</div>' +
                '</div>';
        }

        function createElementProduct(data) {
            let child = '';
            $.each(data, function (k, v) {
                child += singleProductElement(v);
            });
            return '<div class="row">' + child + '</div>';
        }

        async function getProductByName() {
            let el = $('#panel-product');
            el.empty();
            el.append(createLoader());
            let name = $('#filter').val();
            try {
                let response = await $.get('/product/data?name=' + name);
                el.empty();
                if (response['status'] === 200) {
                    if (response['payload'].length > 0) {
                        el.append(createElementProduct(response['payload']));
                        $('.card-item').on('click', function () {
                            let id = this.dataset.id;
                            window.location.href = '/product/' + id + '/detail';
                        });
                    } else {
                        el.append(emptyElementProduct());
                    }
                }
            } catch (e) {
                console.log(e);
            }
        }

        $(document).ready(function () {
            $('.card-item').on('click', function () {
                let id = this.dataset.id;
                window.location.href = '/product/' + id + '/detail';
            });

            $('#btn-search').on('click', function (e) {
                e.preventDefault();
                getProductByName();
            })
        });
    </script>
@endsection
