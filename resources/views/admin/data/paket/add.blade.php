@extends('admin.layout')

@section('css')
    <link href="{{ asset('/adminlte/plugins/select2/select2.css') }}" rel="stylesheet">
    <style>
        .select2-selection {
            height: 40px !important;
            line-height: 40px !important;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            color: black;
            font-size: 12px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #e4e4e4;
            border: 1px solid #aaa;
            border-radius: 4px;
            cursor: default;
            float: left;
            margin-right: 5px;
            margin-top: 4px;
            padding: 0 5px;
            height: 30px;
            text-align: center;
            display: flex;
            align-items: center;
        }
    </style>
@endsection

@section('content')
    @if (\Illuminate\Support\Facades\Session::has('success'))
        <script>
            Swal.fire("Berhasil!", '{{\Illuminate\Support\Facades\Session::get('success')}}', "success")
        </script>
    @endif

    @if (\Illuminate\Support\Facades\Session::has('failed'))
        <script>
            Swal.fire("Gagal", '{{\Illuminate\Support\Facades\Session::get('failed')}}', "error")
        </script>
    @endif
    <div class="container-fluid pt-3">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <p class="font-weight-bold mb-0" style="font-size: 20px">Halaman Paket Servis</p>
            <ol class="breadcrumb breadcrumb-transparent mb-0">
                <li class="breadcrumb-item">
                    <a href="/dashboard">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="/paket">Paket Servis</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Tambah
                </li>
            </ol>
        </div>
        <div class="w-100 p-2">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-6 col-sm-11">
                    <div class="card">
                        <div class="card-body">
                            <form method="post" action="/paket/create">
                                @csrf
                                <div class="w-100 mb-1">
                                    <label for="nama" class="form-label">Nama Paket</label>
                                    <input type="text" class="form-control" id="nama" placeholder="Nama Paket"
                                           name="nama">
                                </div>
                                <div class="form-group w-100">
                                    <label for="layanan">Layanan</label>
                                    <select class="select2" name="layanan[]" id="layanan" multiple="multiple" style="width: 100%;">
                                        <option value="">--Pilih Layanan--</option>
                                        @foreach($layanan as $v)
                                            <option value="{{ $v->id }}">{{ $v->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="w-100 mb-1">
                                    <label for="harga" class="form-label">Harga Paket</label>
                                    <input type="number" class="form-control" id="harga" placeholder="Harga Paket"
                                           name="harga" value="0">
                                </div>
                                <div class="form-group w-100 mb-1">
                                    <label for="tipe">Tipe Paket</label>
                                    <select class="form-control" id="tipe" name="tipe">
                                        <option value="datang">Datang Ke Bengkel</option>
                                        <option value="jemput">Jemput Ke Lokasi Pelanggan</option>
                                    </select>
                                </div>
                                <div class="form-group w-100 mb-1">
                                    <label for="jenis">Jenis Paket</label>
                                    <select class="form-control" id="jenis" name="jenis">
                                        <option value="basic">Basic</option>
                                        <option value="custom">Custom</option>
                                    </select>
                                </div>
                                <div class="w-100 mb-1">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <textarea type="text" class="form-control" id="deskripsi" placeholder="Deskripsi"
                                              name="deskripsi" rows="3"></textarea>
                                </div>
                                <div class="w-100 mb-2 mt-3 text-right">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('/adminlte/plugins/select2/select2.js') }}"></script>
    <script src="{{ asset('/adminlte/plugins/select2/select2.full.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.select2').select2({
                width: 'resolve'
            });
        });
    </script>
@endsection
