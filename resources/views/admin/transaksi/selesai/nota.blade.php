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
        .footer{
            position: fixed;
            bottom: 0cm;
            right: 0cm;
            height: 2cm;
        }
    </style>
</head>
<body>
<div class="text-center f-bold report-title">NOTA SERVIS BENGKEL</div>
<div class="text-center">Jl. Adi Sumarmo No. 18, Manahan, Surakarta</div>
<hr>
<div class="row">
    <div class="col-xs-2">
        <span class="f-bold">Tgl. Reservasi</span>
    </div>
    <div class="col-xs-3">
        <span>: {{ $data->tanggal }}</span>
    </div>
    <div class="col-xs-2">
        <span class="f-bold">Tipe Paket</span>
    </div>
    <div class="col-xs-3">
        <span>: {{ $data->paket->tipe == 'datang' ? 'Datang Ke Bengkel' : 'Jemput Ke Lokasi Pelanggan' }}</span>
    </div>
</div>
<div class="row">
    <div class="col-xs-2">
        <span class="f-bold">No. Reservasi</span>
    </div>
    <div class="col-xs-3">
        <span>: {{ $data->no_reservasi }}</span>
    </div>
    <div class="col-xs-2">
        <span class="f-bold">Customer</span>
    </div>
    <div class="col-xs-3">
        <span>: {{ $data->user->member->nama }}</span>
    </div>
</div>
<div class="row">
    <div class="col-xs-2">
        <span class="f-bold">Status</span>
    </div>
    <div class="col-xs-3">
        <span>: Lunas</span>
    </div>
</div>
<hr>
<table id="my-table" class="table display">
    <thead>
    <tr>
        <th width="5%" class="text-center">#</th>
        <th>Nama Layanan</th>
        <th>Qty</th>
        <th>Harga</th>
        <th>Total</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td class="text-center">1</td>
        <td>{{ $data->paket->nama }}</td>
        <td>1</td>
        <td>{{ $data->total }}</td>
        <td>{{ $data->total }}</td>
    </tr>
    @foreach($data->tambahan as $v)
        <tr>
            <td class="text-center">{{ $loop->index + 2 }}</td>
            <td>{{ $v->layanan->nama }}</td>
            <td>{{ $v->qty }}</td>
            <td>{{ $v->harga }}</td>
            <td>{{ $v->total }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<hr>
<div class="row">
    <div class="col-xs-7"></div>
    <div class="col-xs-2">
        <div class="f-bold">Sub Total</div>
    </div>
    <div class="col-xs-2">
        <div class="f-bold">: Rp. {{ number_format($data->total + $data->tambahan->sum('total'), 0, ',', '.') }}</div>
    </div>
</div>
<div class="row">
    <div class="col-xs-7"></div>
    <div class="col-xs-2">
        <div class="f-bold">DP</div>
    </div>
    <div class="col-xs-2">
        <div class="f-bold">: Rp. {{ number_format($data->dp->sum('total'), 0, ',', '.') }}</div>
    </div>
</div>
<div class="row">
    <div class="col-xs-7"></div>
    <div class="col-xs-2">
        <div class="f-bold">Pelunasan</div>
    </div>
    <div class="col-xs-2">
        <div class="f-bold">: Rp. {{ number_format($data->pelunasan->sum('total'), 0, ',', '.') }}</div>
    </div>
</div>
</body>
</html>
