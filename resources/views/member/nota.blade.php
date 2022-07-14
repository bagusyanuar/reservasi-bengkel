<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="css/bootstrap3.min.css" rel="stylesheet">
    <style>
        .report-title {
            font-size: 14px;
            font-weight: bolder;
        }
        .f-bold {
            font-weight: bold;
        }
        .footer {
            position: fixed;
            bottom: 0cm;
            right: 0cm;
            height: 2cm;
        }
        .w-50 {
            width: 50%;
        }
        .font-weight-bold {
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .d-flex {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>
<body>
<div class="text-center f-bold report-title">NOTA RESERVASI BENGKEL OKE</div>
<div class="text-center">
    <span>Jl. Adi Sumarmo No. 18, Manahan, Surakarta</span>
</div>
<hr>
<div class="row">
    <div class="col-xs-2 f-bold">No. Reservasi</div>
    <div class="col-xs-3 f-bold">: {{ $data->no_reservasi }}</div>
    <div class="col-xs-2">Tanggal</div>
    <div class="col-xs-3">: {{ $data->tanggal }}</div>
</div>
<div class="row">
    <div class="col-xs-2">Nama</div>
    <div class="col-xs-3">: {{ $data->user->member->nama }}</div>
    <div class="col-xs-2">Paket</div>
    <div class="col-xs-3">: {{ $data->paket->nama }}</div>
</div>
{{--<div class="row">--}}
{{--    <div class="col-xs-2">Status</div>--}}
{{--    <div class="col-xs-3">: {{ ucwords($data->status) }}</div>--}}
{{--</div>--}}
<hr>
<table id="my-table" class="table display">
    <thead>
    <tr>
        <th width="5%" class="text-center">#</th>
        <th>Layanan Servis</th>
    </tr>
    </thead>
    <tbody>
    @php
        $layanan = [];
        foreach ($data->paket->layanan as $l) {
            array_push($layanan, [
                'nama' => $l->nama
            ]);
        }

        foreach ($data->tambahan as $t) {
            array_push($layanan, [
                'nama' => $t->layanan->nama
            ]);
        }
    @endphp
    @foreach($layanan as $v)
        <tr>
            <td class="text-center">{{ $loop->index + 1 }}</td>
            <td>{{ $v['nama'] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<hr>
@php
    $total_tambahan = 0;
    foreach ($data->tambahan as $dt) {
        $total_tambahan += ($dt->qty * $dt->harga);
    }
@endphp
<div class="row">
    <div class="col-xs-7"></div>
    <div class="col-xs-2">
        <div class="f-bold">Total</div>
    </div>
    <div class="col-xs-2">
        <div class="f-bold">: Rp. {{ number_format($data->total + $total_tambahan, 0, ',', '.') }}</div>
    </div>
</div>
<div class="row">
    <div class="col-xs-7"></div>
    <div class="col-xs-2">
        <div class="f-bold">Di Bayar</div>
    </div>
    <div class="col-xs-2">
        <div class="f-bold">: Rp. {{ number_format($data->dp->sum('total') + $data->pelunasan->sum('total'), 0, ',', '.') }}</div>
    </div>
</div>
<div class="row">
    <div class="col-xs-7"></div>
    <div class="col-xs-2">
        <div class="f-bold">Kekurangan</div>
    </div>
    <div class="col-xs-2">
        <div class="f-bold">: Rp. {{ number_format($data->total + $total_tambahan - ($data->dp->sum('total') + $data->pelunasan->sum('total')), 0, ',', '.') }}</div>
    </div>
</div>
</body>
</html>
