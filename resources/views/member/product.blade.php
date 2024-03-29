@extends('member.layout')

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
    <div class="container-fluid mt-2" style="padding-left: 50px; padding-right: 50px; padding-top: 10px;">
        <ol class="breadcrumb breadcrumb-transparent mb-2">
            <li class="breadcrumb-item">
                <a href="/">Beranda</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ $data->nama }}
            </li>
        </ol>
        <div class="w-100 row product-detail" style="min-height: 350px">
            <div class="col-lg-8 col-md-6">
                <h5 class="card-title mb-2 card-text-title font-weight-bold"
                    style="color: #535961; font-size: 18px">{{$data->nama}}</h5>
                <p style="color: #535961; font-size: 14px">{{ $data->deskripsi }}</p>
                <div class="card card-item" style="cursor: pointer; border-color: #376477">
                    <div class="card-header" style="background-color: #376477 ">
                        <p class="font-weight-bold mb-0" style="color: whitesmoke; font-size: 18px">Layanan Servis</p>
                    </div>
                    <div class="card-body">
                        @if($data->jenis === 'basic')
                            @foreach($data->layanan as $v)
                                <div style="color: #535961; font-size: 16px">
                                    <i class="fa fa-check mr-2"></i>
                                    <span class="font-weight-bold">{{ $v->nama }}</span>
                                </div>
                            @endforeach
                        @else
                            @auth
                                <div class="row">
                                    <div class="col-lg-8 col-md-6">
                                        <div class="form-group w-100">
                                            <label for="layanan">Layanan</label>
                                            <select class="select2" name="layanan" id="layanan" style="width: 100%;">
                                                <option value="">--Pilih Layanan--</option>
                                                @foreach($layanan as $l)
                                                    <option value="{{ $l->id }}"
                                                            data-harga="{{ $l->harga }}">{{ $l->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="w-100 mb-1">
                                            <label for="harga" class="form-label">Harga</label>
                                            <input type="number" class="form-control" id="harga" placeholder="Harga"
                                                   name="harga" value="0" readonly="readonly">
                                        </div>
                                        <div class="w-100 mb-2 mt-2 text-right">
                                            <a href="#" id="btn-add" class="btn btn-success"><i
                                                    class="fa fa-plus mr-2"></i>Tambah</a>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <table id="table-data" class="display w-100 table table-bordered">
                                    <thead>
                                    <tr>
                                        <th width="5%" class="text-center">#</th>
                                        <th>Nama Layanan</th>
                                        <th width="15%">Harga</th>
                                        <th width="12%" class="text-center">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($tambahan as $t)
                                        <tr>
                                            <td width="5%" class="text-center">{{ $loop->index + 1 }}</td>
                                            <td>{{ $t->layanan->nama }}</td>
                                            <td>{{ number_format($t->layanan->harga, 0, ',', '.') }}</td>
                                            <td class="text-center">
                                                <a href="#" class="btn btn-sm btn-danger btn-delete"
                                                   data-id="{{ $t->id }}"><i
                                                        class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endauth
                            @guest
                                <p style="color: #535961; font-size: 14px">
                                    Kamu bisa menambah jenis layanan yang kamu inginkan setelah kamu melakukan login. <a
                                        href="/login-member" class="font-weight-bold"
                                        style="color: #535961; font-size: 14px">
                                        Login Sekarang
                                    </a>
                                </p>
                            @endguest
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card card-item mb-3" style="cursor: pointer; border-color: #376477">
                    <div class="card-header" style="background-color: #376477 ">
                        <p class="font-weight-bold mb-0" style="color: whitesmoke; font-size: 18px">Total Layanan</p>
                    </div>
                    <div class="card-body">
                        <div class="form-group w-100 mb-1">
                            <label for="jenis_kendaraan">Jenis Kendaraan</label>
                            <select class="form-control" id="jenis_kendaraan" name="jenis_kendaraan">
                                <option value="motor">Motor</option>
                                <option value="mobil">Mobil</option>
                            </select>
                        </div>
                        <div class="w-100 mb-1">
                            <label for="plat" class="form-label">Plat Nomor</label>
                            <input type="text" class="form-control" id="plat" placeholder="Plat Nomor"
                                   name="plat">
                        </div>
                        @if($data->tipe == 'jemput')
                            <div class="w-100 mb-2">
                                <label for="keterangan" class="form-label">Lokasi Pengambilan</label>
                                <textarea rows="3" class="form-control" id="keterangan" placeholder="Lokasi Pengambilan"
                                          name="keterangan"></textarea>
                            </div>
                        @endif
                        <hr>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="w-50">
                                <span class="font-weight-bold" style="color: #376477">Total</span>
                            </div>
                            <div class="w-50">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="font-weight-bold" style="color: #376477">:</span>
                                    @if($data->jenis === 'basic')
                                        <span class="font-weight-bold"
                                              style="color: #376477">Rp. {{ number_format($data->harga, 0, ',', '.') }}</span>
                                    @else
                                        <span class="font-weight-bold"
                                              style="color: #376477">Rp. {{ number_format($total_tambahan, 0, ',', '.') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @auth
                    <a id="btn-pesan" href="#"
                       class="btn-order-basic d-flex justify-content-center align-items-center" style="height: 60px">
                        <span class="font-weight-bold">Pesan sekarang</span>
                    </a>
                @endauth
            </div>


        </div>
    </div>
    <div class="footer"></div>
@endsection

@section('js')
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script src="{{ asset('/adminlte/plugins/select2/select2.js') }}"></script>
    <script src="{{ asset('/adminlte/plugins/select2/select2.full.js') }}"></script>
    <script>
        var jenis = '{{ $data->jenis }}';
        var id = '{{ $data->id }}'

        function destroy(id) {
            AjaxPost('/product/hapus/layanan', {id}, function () {
                window.location.reload();
            });
        }

        async function pesan() {
            try {
                let response = await $.post('/product/checkout', {
                    id: id,
                    keterangan: $('#keterangan').val(),
                    jenis_kendaraan: $('#jenis_kendaraan').val(),
                    plat: $('#plat').val(),
                });
                if (response['status'] === 200) {
                    let id = response['payload'];
                    window.location.href = '/pembayaran/' + id + '/detail';
                } else {
                    window.location.href = '/login';
                }
            } catch (e) {
                ErrorAlert('Error', 'Terjadi Kesalahan')
            }
        }

        $(document).ready(function () {
            $('.select2').select2({
                width: 'resolve'
            });

            if (jenis === 'custom') {
                $('#table-data').DataTable({
                    dom: 'ltipr',
                });
            }

            $('#layanan').on('change', function () {
                let harga = $(this).find(':selected').attr('data-harga');
                $('#harga').val(harga);
            })

            $('#btn-add').on('click', function (e) {
                e.preventDefault();
                AjaxPost('/product/add/layanan', {
                    layanan: $('#layanan').val()
                }, function () {
                    window.location.reload();
                }, function () {
                    ErrorAlert('Error', 'Silahkan Login Terlebih Dahulu');
                });
            });

            $('.btn-delete').on('click', function (e) {
                e.preventDefault();
                let id = this.dataset.id;
                AlertConfirm('Apakah anda yakin menghapus layanan?', 'Data yang dihapus tidak dapat dikembalikan!', function () {
                    destroy(id);
                })
            });

            $('#btn-pesan').on('click', function (e) {
                e.preventDefault();
                pesan();
            });
        });
    </script>
@endsection
