@extends('admin.layout')

@section('css')
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
            <p class="font-weight-bold mb-0" style="font-size: 20px">Halaman Detail Reservasi</p>
            <ol class="breadcrumb breadcrumb-transparent mb-0">
                <li class="breadcrumb-item">
                    <a href="/dashboard">Dashboard</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Detail Reservasi
                </li>
            </ol>
        </div>
        <div class="w-100 p-2">
            <div class="card">
                <div class="card-body">
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
                    <hr>
                    <p class="font-weight-bold">Daftar Layanan Servis</p>
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
                    <div class="mt-3">
                        <form action="/reservasi/patch" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $data->id }}">
                            <div class="text-right">
                                <button type="submit" class="btn btn-success text-right">
                                    <i class="fa fa-save"></i>
                                    <span>Proses</span>
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
    <script type="text/javascript">
        $(document).ready(function () {
            $('#table-data').DataTable();
        });
    </script>
@endsection
