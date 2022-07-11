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
<div class="text-center f-bold report-title">LAPORAN PEMBAYARAN RESERVgit  BENGKEL</div>
<div class="text-center">Periode Laporan {{ $tgl1 }} - {{ $tgl2 }} </div>
<hr>
<table id="my-table" class="table display">
    <thead>
    <tr>
        <th width="5%" class="text-center">#</th>
        <th>Tanggal</th>
        <th>Via</th>
        <th>No. Reservasi</th>
        <th>Customer</th>
        <th>Total</th>
        <th>Jenis</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $v)
        <tr>
            <td width="5%" class="text-center">{{ $loop->index + 1 }}</td>
            <td>{{ $v->tanggal }}</td>
            <td>{{ $v->bank }}</td>
            <td>{{ $v->reservasi->no_reservasi }}</td>
            <td>{{ $v->reservasi->user->member->nama }}</td>
            <td>{{ $v->total }}</td>
            <td>{{ $v->jenis }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<div class="row">
    <div class="col-xs-6"></div>
    <div class="col-xs-2">
        <span class="f-bold">Total Pendapatan</span>
    </div>
    <div class="col-xs-3">: {{ number_format($data->sum('total'), 0, '.', ',') }}</div>
</div>
<hr>
<div class="row">
    <div class="col-xs-8"></div>
    <div class="col-xs-3">
        <div class="text-center">Admin</div>
        <br>
        <br>
        <br>
        <div class="text-center">(..............)</div>
    </div>
</div>
</body>
</html>
