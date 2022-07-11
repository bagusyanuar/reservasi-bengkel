@extends('admin.layout')

@section('css')
@endsection

@section('content')
    @if (\Illuminate\Support\Facades\Session::has('success'))
        <script>
            Swal.fire("Berhasil!", '{{\Illuminate\Support\Facades\Session::get('success')}}', "success")
        </script>
    @endif
    <div class="container-fluid pt-3">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <p class="font-weight-bold mb-0" style="font-size: 20px">Halaman Laporan Pembayaran</p>
            <ol class="breadcrumb breadcrumb-transparent mb-0">
                <li class="breadcrumb-item">
                    <a href="/dashboard">Dashboard</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Daftar Laporan Pembayaran
                </li>
            </ol>
        </div>
        <div class="w-100 p-2">
            <p class="font-weight-bold mb-0">Filter Tanggal</p>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex align-items-center w-50">
                    <input type="date" class="form-control" name="tgl1" id="tgl1" value="{{ date('Y-m-d') }}">
                    <span class="font-weight-bold mr-2 ml-2">S/D</span>
                    <input type="date" class="form-control" name="tgl2" id="tgl2" value="{{ date('Y-m-d') }}">
                </div>
                <div class="text-right">
                    <a href="#" class="btn btn-primary" id="btn-cetak">
                        <i class="fa fa-print mr-2"></i>
                        <span>Cetak</span>
                    </a>
                </div>
            </div>
            <table id="table-data" class="display w-100 table table-bordered">
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
                </tbody>
            </table>
            <div class="text-right mt-3">
                <span class="mr-2 font-weight-bold">Total Pendapatan : </span>
                <span class="font-weight-bold" id="lbl-total">Rp. 0</span>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script type="text/javascript">
        var table;
        function reload() {
            table.ajax.reload();
        }

        $(document).ready(function () {
            table = DataTableGenerator('#table-data', '/laporan-pembayaran/data', [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},
                {data: 'tanggal'},
                {data: 'bank'},
                {data: 'reservasi.no_reservasi'},
                {data: 'reservasi.user.member.nama'},
                {data: 'total'},
                {data: 'jenis'},
            ], [], function (d) {
                d.tgl1 = $('#tgl1').val();
                d.tgl2 = $('#tgl2').val();
            }, {
                dom: 'ltipr',
                "fnDrawCallback": function( oSettings ) {
                    let data = this.fnGetData();
                    let total = data.map(item => item['total']).reduce((prev, next) => prev + next, 0);
                    $('#lbl-total').html('Rp. '+total);
                }
            });
            $('#tgl1').on('change', function (e) {
                reload();
            });
            $('#tgl2').on('change', function (e) {
                reload();
            });
            $('#btn-cetak').on('click', function (e) {
                e.preventDefault();
                let tgl1 = $('#tgl1').val();
                let tgl2 = $('#tgl2').val();
                window.open('/laporan-pembayaran/cetak?tgl1=' + tgl1 + '&tgl2=' + tgl2, '_blank');
            })
        });
    </script>
@endsection
