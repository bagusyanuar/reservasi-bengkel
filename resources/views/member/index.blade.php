@extends('member.layout')

@section('content')
    <img src="{{ asset('/assets/icon/banner5.png') }}" style="width: 100%;">
    <div class="text-center mt-3 mb-3">
        <p class="font-weight-bold" style="font-size: 16px; letter-spacing: 1px; color: #535961">Temukan Paket Layanan
            Servis Sesuai Kebutuhan Anda</p>
    </div>
    <div class="text-center mt-3 mb-3">
        <p class="font-weight-bold" style="font-size: 24px; letter-spacing: 1px; color: #535961">Paket Servis Di Bengkel
            Kami</p>
    </div>
    <div class="container-fluid">
        <div class="row justify-content-center">
            @foreach($paket as $v)
                <div class="col-lg-3 col-md-4">
                    <div class="card card-item" style="cursor: pointer; height: 400px; border-color: #376477">
                        <div class="card-body">
                            <h5 class="card-title mb-2 card-text-title font-weight-bold"
                                style="color: #535961">{{$v->nama}}</h5>
                            <p style="color: #535961; font-size: 12px">{{ $v->deskripsi }}</p>
                            <p class="card-text" style="color: #376477; font-weight: bold; font-size: 18px">
                                Rp. {{ number_format($v->harga, 0, ',', '.') }}</p>
                            <a href="/product/{{ $v->id }}/detail" data-id="{{ $v->id }}"
                               class="btn-order d-flex justify-content-center align-items-center">
                                <span class="font-weight-bold">Pilih Paket</span>
                            </a>
                            <div class="mt-3">
                                <p class="font-weight-bold" style="color: #535961; font-size: 14px">Layanan Servis</p>
                                @forelse($v->layanan as $l)
                                    <div style="color: #535961; font-size: 14px">- {{ $l->nama }}</div>
                                @empty
                                    <span style="color: #535961; font-size: 14px">
                                        Kamu Bisa Memilih Layanan Sendiri
                                    </span>
                                @endforelse
                            </div>
                            <div class="mt-3" style="color: #535961; font-size: 12px">catatan :
                                @if($v->tipe == 'datang')
                                    <span>Customer Datang Ke Bengkel</span>
                                @else
                                    <span>Customer Mengirimkan Alamat Lokasi Pengambilan Unit</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div style="height: 100px"></div>

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
