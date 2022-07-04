@extends('member.layout')

@section('content')
    <div class="container-fluid mt-2" style="padding-left: 50px; padding-right: 50px; padding-top: 10px;">
        <ol class="breadcrumb breadcrumb-transparent mb-2">
            <li class="breadcrumb-item">
                <a href="/dashboard">Dashboard</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ $data->nama }}
            </li>
        </ol>
        <div class="w-100 row product-detail">
            <div class="col-lg-4 col-md-4">
                <img src="{{ asset('/assets/barang'). '/' . $data->gambar }}" height="400"
                     alt="Gambar Produk" class="mr-3 w-100">
            </div>
            <div class="col-lg-5 col-md-5">
                <div class="flex-grow-1">
                    <div class="font-weight-bold" style="font-size: 24px">{{ $data->nama }}</div>
                    <div style="font-size: 14px; color: #777777">{{ $data->category->nama }}</div>
                    <div class="font-weight-bold" style="font-size: 24px">Rp. {{ $data->harga }}</div>
                    <div style="text-align: justify">{{ $data->deskripsi }}</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3">
                <div style="border: solid 1px #777777; border-radius: 5px; padding: 10px;">
                    <p class="font-weight-bold">Atur Jumlah</p>
                    <div class="d-flex mb-2">
                        <a href="#" class="btn btn-sm btn-outline-primary mr-1"><i class="fa fa-minus"></i></a>
                        <input class="form-control form-control-sm text-right" type="number" id="qty" name="qty"
                               value="0">
                        <a href="#" class="btn btn-sm btn-primary ml-1"><i class="fa fa-plus"></i></a>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="mr-1" style="color: #777777">Subtotal</div>
                        <div class="flex-grow-1 text-right" style="font-size: 20px; font-weight: bold">
                            Rp. {{ $data->harga }}</div>
                    </div>
                    <div class="w-100 mt-2 mb-1">
                        <a href="#" class="btn btn-primary w-100">Tambah Keranjang</a>
                    </div>
                    <div class="w-100">
                        <a href="#" class="btn btn-outline-primary w-100">Beli Sekarang</a>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection
