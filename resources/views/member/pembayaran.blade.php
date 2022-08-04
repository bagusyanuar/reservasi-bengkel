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

        .detail-info {
            color: #535961;
            font-size: 14px;
            font-weight: bold;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid mt-2" style="padding-left: 50px; padding-right: 50px; padding-top: 10px;">
        <ol class="breadcrumb breadcrumb-transparent mb-2">
            <li class="breadcrumb-item">
                <a href="/">Beranda</a>
            </li>
            <li class="breadcrumb-item">
                <a href="/transaksi">Transaksi</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Pembayaran
            </li>
        </ol>
        <div class="w-100 row product-detail" style="min-height: 350px">
            <div class="col-lg-8 col-md-6">
                <p class="card-title mb-2 card-text-title font-weight-bold"
                   style="color: #535961; font-size: 18px">Pembayaran Reservasi</p>
                <hr>
                <div class="row mb-2">
                    <div class="col-lg-6 col-md-6">
                        <div class="d-flex">
                            <div class="w-50">
                                <span class="detail-info">No. Reservasi</span>
                            </div>
                            <div class="w-50">
                                <span class="detail-info">:</span>
                                <span class="detail-info">{{ $data->no_reservasi }}</span>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="w-50">
                                <span class="detail-info">Tanggal</span>
                            </div>
                            <div class="w-50">
                                <span class="detail-info">:</span>
                                <span class="detail-info">{{ $data->tanggal }}</span>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="w-50">
                                <span class="detail-info">Paket</span>
                            </div>
                            <div class="w-50">
                                <span class="detail-info">:</span>
                                <span class="detail-info">{{ $data->paket->nama }}</span>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="w-50">
                                <span class="detail-info">Status</span>
                            </div>
                            <div class="w-50">
                                <span class="detail-info">:</span>
                                <span class="detail-info">{{ ucwords($data->status) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="card card-item" style="cursor: pointer; border-color: #376477">
                    <div class="card-header" style="background-color: #376477 ">
                        <p class="font-weight-bold mb-0" style="color: whitesmoke; font-size: 18px">Layanan Servis</p>
                    </div>
                    <div class="card-body">
                        @foreach($data->paket->layanan as $l)
                            <div style="color: #535961; font-size: 16px">
                                <i class="fa fa-check mr-2"></i>
                                <span class="font-weight-bold">{{ $l->nama }}</span>
                            </div>
                        @endforeach
                        @foreach($data->tambahan as $t)
                            <div style="color: #535961; font-size: 16px">
                                <i class="fa fa-check mr-2"></i>
                                <span class="font-weight-bold">{{ $t->layanan->nama }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card card-item mb-3" style="cursor: pointer; border-color: #376477">
                    <div class="card-header" style="background-color: #376477 ">
                        <p class="font-weight-bold mb-0" style="color: whitesmoke; font-size: 18px">Pembayaran</p>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="w-50">
                                <span class="font-weight-bold" style="color: #376477">Total</span>
                            </div>
                            <div class="w-50">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="font-weight-bold" style="color: #376477">:</span>
                                    @php
                                        $total_tambahan = 0;
                                        foreach ($data->tambahan as $dt) {
                                            $total_tambahan += ($dt->qty * $dt->harga);
                                        }
                                    @endphp
                                    <span class="font-weight-bold"
                                          style="color: #376477">Rp. {{ number_format($data->total + $total_tambahan, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                        <hr>
                        @if($data->pembayaran_lunas == null)
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="w-50">
                                    <span class="font-weight-bold" style="color: #376477">DP</span>
                                </div>
                                <div class="w-50">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="font-weight-bold" style="color: #376477">:</span>
                                        @php
                                            $total_pembayaran = $data->total + $total_tambahan;
                                            $dp = (10 * $total_pembayaran) / 100;
                                        @endphp
                                        <span class="font-weight-bold"
                                              style="color: #376477">Rp. {{ number_format($dp, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if(count($data->dp) > 0 || count($data->pelunasan) > 0)
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="w-50">
                                    <span class="font-weight-bold" style="color: #376477">Di Bayar</span>
                                </div>
                                <div class="w-50">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="font-weight-bold" style="color: #376477">:</span>
                                        <span class="font-weight-bold"
                                              style="color: #376477">Rp. {{ number_format($data->dp->sum('total') + $data->pelunasan->sum('total'), 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="w-50">
                                    <span class="font-weight-bold" style="color: #376477">Kekurangan</span>
                                </div>
                                <div class="w-50">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="font-weight-bold" style="color: #376477">:</span>
                                        <span class="font-weight-bold"
                                              style="color: #376477">Rp. {{ number_format($data->total + $total_tambahan - ($data->dp->sum('total') + $data->pelunasan->sum('total')), 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="mt-2">
                            @if($data->pembayaran_lunas == null)
                                <form method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="w-100 mb-1 d-none">
                                        <label for="dp" class="form-label" style="color: #535961; font-size: 18px">Jumlah
                                            DP</label>
                                        <input type="hidden" class="form-control" id="dp"
                                               placeholder="Gambar Bukti"
                                               value="{{ $dp }}"
                                               name="dp" required>
                                    </div>
                                    <div class="form-group w-100 mt-2">
                                        <label for="bank" style="color: #535961; font-size: 18px">Bank</label>
                                        <select class="form-control" id="bank" name="bank" required>
                                            <option value="">--pilih bank--</option>
                                            <option value="BCA">BRI (8889282920)</option>
                                            <option value="BCA">BCA (9928923884)</option>
                                            <option value="MANDIRI">MANDIRI (9912389320)</option>
                                        </select>
                                    </div>
                                    <div class="w-100 mb-2">
                                        <label for="bukti" class="form-label" style="color: #535961; font-size: 18px">Bukti
                                            Transfer</label>
                                        <input type="file" class="form-control-file" id="bukti"
                                               placeholder="Gambar Bukti"
                                               name="bukti" required>
                                    </div>
                                    <div class="w-100 mb-1">
                                        <label for="no_rekening" class="form-label"
                                               style="color: #535961; font-size: 18px">No. Rekening</label>
                                        <input type="number" class="form-control-file" id="no_rekening"
                                               placeholder="No. Rekening"
                                               name="no_rekening" required>
                                    </div>
                                    <div class="w-100 mb-1">
                                        <label for="atas_nama" class="form-label"
                                               style="color: #535961; font-size: 18px">Atas Nama</label>
                                        <input type="text" class="form-control-file" id="atas_nama"
                                               placeholder="Atas Nama"
                                               name="atas_nama" required>
                                    </div>
                                    <hr>
                                    <button id="btn-pesan" type="submit"
                                            class="btn-order-basic d-flex justify-content-center align-items-center w-100 mt-3"
                                            style="height: 60px">
                                        <span class="font-weight-bold">Bayar</span>
                                    </button>
                                </form>
                            @else
                                @if($data->status == 'reservasi')
                                    <p class="font-weight-bold"
                                       style="color: #535961; font-size: 14px; text-align: justify">
                                        NB: Anda sudah melakukan pembayaran. Silahkan menunggu, admin kami akan segera
                                        mengkonfirmasi reservasi anda
                                    </p>
                                @elseif($data->status == 'menunggu')
                                    <p class="font-weight-bold"
                                       style="color: #535961; font-size: 14px; text-align: justify">
                                        NB: Pembayaran anda sudah kami
                                        terima. {{ $data->paket->tipe == 'jemput' ? 'Mohon menunggu mekanik kami akan datang ke lokasi anda' : 'Silahkan datang ke bengkel untuk melakukan proses servis' }}
                                        dan Cetak Nota untuk menunjukan proses transaksi sudah sah.
                                    </p>
                                    <a href="/pembayaran/{{ $data->id }}/nota" target="_blank" id="btn-nota"
                                       class="btn-order-basic d-flex justify-content-center align-items-center w-100 mt-3"
                                       style="height: 60px">
                                        <span class="font-weight-bold">
                                            <i class="fa fa-print mr-2"></i>Cetak Nota
                                        </span>
                                    </a>
                                @elseif($data->status == 'proses')
                                    <p class="font-weight-bold"
                                       style="color: #535961; font-size: 14px; text-align: justify">
                                        NB: Reservasi servis anda sedang kami proses
                                    </p>
                                @elseif($data->status == 'selesai-servis')
                                    <p class="font-weight-bold"
                                       style="color: #535961; font-size: 14px; text-align: justify">
                                        NB: Proses servis anda sudah selesai. Silahkan Melakukan pelunasan pembayaran
                                        apabila masih ada kekurangan.
                                    </p>
                                @elseif($data->status == 'selesai')
                                    <p class="font-weight-bold"
                                       style="color: #535961; font-size: 14px; text-align: justify">
                                        NB: Proses Reservasi anda telah selesai. Terima kasih telah menggunakan jasa
                                        kami.
                                    </p>
                                @endif
                            @endif
                        </div>
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
    <script>
        var id = '{{ $data->id }}'

        function destroy(id) {
            AjaxPost('/product/hapus/layanan', {id}, function () {
                window.location.reload();
            });
        }

        function pesan() {
            AjaxPost('/product/checkout', {
                id: id,
                keterangan: $('#keterangan').val()
            }, function () {
                window.location.href = '/';
            });
        }

        $(document).ready(function () {
        });
    </script>
@endsection
