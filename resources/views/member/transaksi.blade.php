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
                <a href="/dashboard">Dashboard</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Riwayat Reservasi
            </li>
        </ol>
        <div class="w-100 row product-detail" style="min-height: 350px">
            <div class="col-lg-12 col-md-12">
                <p class="card-title mb-2 card-text-title font-weight-bold"
                   style="color: #535961; font-size: 18px">Riwayat Reservasi</p>
                <hr>
                <table id="table-data" class="display w-100 table table-bordered">
                    <thead>
                    <tr>
                        <th width="5%" class="text-center">#</th>
                        <th>Tanggal</th>
                        <th>No. Reservasi</th>
                        <th>Paket</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th width="12%" class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $v)
                        <tr>
                            <td width="5%" class="text-center">{{ $loop->index + 1 }}</td>
                            <td>{{ $v->tanggal }}</td>
                            <td>{{ $v->no_reservasi }}</td>
                            <td>{{ $v->paket->nama }}</td>
                            @php
                                $total_tambahan = 0;
                                foreach ($v->tambahan as $dt) {
                                    $total_tambahan += ($dt->qty * $dt->harga);
                                }
                            @endphp
                            <td>{{ number_format($v->total + $total_tambahan, 0, ',', '.') }}</td>
                            <td>{{ $v->status }}</td>
                            <td class="text-center">
                                <a href="/transaksi/detail/{{ $v->id }}" class="btn btn-sm btn-info btn-edit"
                                   data-id="{{ $v->id }}"><i class="fa fa-info"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
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
            $('#table-data').DataTable();
        });
    </script>
@endsection
