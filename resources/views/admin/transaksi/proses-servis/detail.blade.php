@extends('admin.layout')

@section('css')
    <link href="{{ asset('/adminlte/plugins/select2/select2.css') }}" rel="stylesheet">
    <style>
        .select2-selection {
            height: 40px !important;
            line-height: 40px !important;
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
            Swal.fire("Gagal!", '{{\Illuminate\Support\Facades\Session::get('failed')}}', "error")
        </script>
    @endif
    <div class="container-fluid pt-3">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <p class="font-weight-bold mb-0" style="font-size: 20px">Halaman Detail Proses Servis</p>
            <ol class="breadcrumb breadcrumb-transparent mb-0">
                <li class="breadcrumb-item">
                    <a href="/dashboard">Dashboard</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Detail Proses Servis
                </li>
            </ol>
        </div>
        <div class="w-100 p-2">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <p class="font-weight-bold">Detail Pesanan</p>
                            <div class="d-flex align-items-center mb-2">
                                <span class="w-50 font-weight-bold">Tanggal Reservasi</span>
                                <span class="w-50  font-weight-bold">: {{ $data->tanggal }}</span>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <span class="w-50 font-weight-bold">No. Reservasi</span>
                                <span class="w-50  font-weight-bold">: {{ $data->no_reservasi }}</span>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <span class="w-50 font-weight-bold">Customer</span>
                                <span class="w-50  font-weight-bold">: {{ $data->user->member->nama }}</span>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <span class="w-50 font-weight-bold">Paket</span>
                                <span class="w-50  font-weight-bold">: {{ $data->paket->nama }}</span>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <span class="w-50 font-weight-bold">Tipe Paket</span>
                                <span
                                    class="w-50  font-weight-bold">: {{ $data->paket->tipe == 'datang' ? 'Datang Ke Bengkel' : 'Jemput Ke Lokasi Pelanggan' }}</span>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <span class="w-50 font-weight-bold">Status</span>
                                <span class="w-50  font-weight-bold">: {{ $data->status }}</span>
                            </div>
                            @if($data->paket->tipe == 'jemput')
                                <div class="d-flex align-items-center mb-2">
                                    <span class="w-50 font-weight-bold">Keterangan</span>
                                    <span class="w-50  font-weight-bold">: {{ $data->keterangan }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <p class="font-weight-bold">Daftar Paket Layanan Servis</p>

                            <table id="table-data" class="display w-100 table table-bordered">
                                <thead>
                                <tr>
                                    <th width="5%" class="text-center">#</th>
                                    <th>Nama Layanan</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data->paket->layanan as $v)
                                    <tr>
                                        <td width="5%" class="text-center">{{ $loop->index + 1 }}</td>
                                        <td>{{ $v->nama }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-8 col-md-6">
                            <div class="form-group w-100">
                                <label for="layanan">Layanan</label>
                                <select class="select2" name="layanan" id="layanan" style="width: 100%;">
                                    <option value="">--Pilih Layanan--</option>
                                    @foreach($layanan as $v)
                                        <option value="{{ $v->id }}">{{ $v->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="w-100 mb-1">
                                <label for="qty" class="form-label">Qty</label>
                                <input type="number" class="form-control" id="qty" placeholder="Qty"
                                       name="qty" value="1">
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <a href="#" class="btn btn-primary text-right" id="btn-tambah-layanan">
                            <i class="fa fa-plus"></i>
                            <span>Tambah Layanan</span>
                        </a>
                    </div>
                    <hr>
                    <p class="font-weight-bold">Daftar Tambahan Layanan Servis</p>
                    <table id="table-data-2" class="display w-100 table table-bordered">
                        <thead>
                        <tr>
                            <th width="5%" class="text-center">#</th>
                            <th>Nama Layanan</th>
                            <th width="12%">Qty</th>
                            <th width="15%">Harga (Rp.)</th>
                            <th width="15%">Total (Rp.)</th>
                            <th width="12%">Action</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    <hr>
                    <div class="row">
                        <div class="col-lg-8 col-md-6"></div>
                        <div class="col-lg-4 col-md-6">
                            <div class="d-flex align-items-center">
                                <span class="font-weight-bold w-50">Sub Total</span>
                                <div class="font-weight-bold w-50 d-flex justify-content-between">
                                    <span>:</span>
                                    <span class="text-right" id="lbl-total">Rp. 0</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="font-weight-bold w-50">Uang Muka (DP)</span>
                                <div class="font-weight-bold w-50 d-flex justify-content-between">
                                    <span>:</span>
                                    <span class="text-right" id="lbl-dp">Rp. 0</span>
                                </div>
                            </div>
                            <hr>
                            <div class="d-flex align-items-center">
                                <span class="font-weight-bold w-50">Kekurangan</span>
                                <div class="font-weight-bold w-50 d-flex justify-content-between">
                                    <span>:</span>
                                    <span class="text-right" id="lbl-kurang">Rp. 0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <form action="/proses-servis/patch" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $data->id }}">
                            <div class="text-right">
                                <button type="submit" class="btn btn-success text-right">
                                    <i class="fa fa-save"></i>
                                    <span>Simpan</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script src="{{ asset('/adminlte/plugins/select2/select2.js') }}"></script>
    <script src="{{ asset('/adminlte/plugins/select2/select2.full.js') }}"></script>
    <script type="text/javascript">
        var table;
        var id = '{{ $data->id }}';
        var paket_total = '{{ $data->total }}';
        var dp = '{{ $data->pembayaran_lunas->total }}';

        function reload() {
            table.ajax.reload();
        }

        async function tambah_layanan() {
            try {
                await $.post('/proses-servis/tambah-layanan', {
                    id: id,
                    layanan_id: $('#layanan').val(),
                    qty: $('#qty').val()
                });
                reload();
                $('#layanan').val('')
                $('#qty').val(1)
            } catch (e) {
                ErrorAlert('Error', 'Terjadi Kesalahan');
            }
        }

        async function hapus_layanan(id) {
            try {
                await $.post('/proses-servis/hapus-layanan', {
                    id: id,
                });
                reload();
            } catch (e) {
                ErrorAlert('Error', 'Terjadi Kesalahan');
            }
        }

        $(document).ready(function () {
            $('.select2').select2({
                width: 'resolve'
            });
            // $('#table-data').DataTable();
            table = DataTableGenerator('#table-data-2', '/proses-servis/data/' + id, [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},
                {data: 'layanan.nama'},
                {data: 'qty'},
                {
                    data: null, render: function (data) {
                        return '<span>' + formatUang(data['harga']) + '</span>';
                    }
                },
                {
                    data: null, render: function (data) {
                        return '<span>' + formatUang(data['total']) + '</span>';
                    }
                },
                {
                    data: null, render: function (data, type, row, meta) {
                        return '<a href="#" class="btn btn-danger btn-delete-list" data-id="' + data['id'] + '"><i class="fa fa-trash"></i></a>';
                    }
                },
            ], [], function (d) {
            }, {
                dom: 'ltipr',
                "fnDrawCallback": function (oSettings) {
                    let data = this.fnGetData();
                    let tambahan_total = data.map(item => item['total']).reduce((prev, next) => prev + next, 0);
                    let harga_paket = parseInt(paket_total);
                    let total_dp = parseInt(dp);
                    let sub_total = tambahan_total + harga_paket;
                    let total = tambahan_total + harga_paket - total_dp;
                    $('#lbl-total').html('Rp. ' + formatUang(sub_total));
                    $('#lbl-dp').html('Rp. ' + formatUang(total_dp));
                    $('#lbl-kurang').html('Rp. ' + formatUang(total));
                    $('.btn-delete-list').on('click', function (e) {
                        e.preventDefault();
                        let id = this.dataset.id;
                        AlertConfirm('Apakah anda yakin menghapus?', 'Data yang dihapus tidak dapat dikembalikan!', function () {
                            hapus_layanan(id);
                        });
                    })
                }
            });

            $('#btn-tambah-layanan').on('click', function (e) {
                e.preventDefault();
                tambah_layanan();
            })
        });
    </script>
@endsection
