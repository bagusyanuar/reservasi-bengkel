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
            <p class="font-weight-bold mb-0" style="font-size: 20px">Halaman Daftar Proses Servis</p>
            <ol class="breadcrumb breadcrumb-transparent mb-0">
                <li class="breadcrumb-item">
                    <a href="/dashboard">Dashboard</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Daftar Proses Servis
                </li>
            </ol>
        </div>
        <div class="w-100 p-2">
            <table id="table-data" class="display w-100 table table-bordered">
                <thead>
                <tr>
                    <th width="5%" class="text-center">#</th>
                    <th>Tanggal</th>
                    <th>No. Reservasi</th>
                    <th>Customer</th>
                    <th>Paket</th>
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
                        <td>{{ $v->user->member->nama }}</td>
                        <td>{{ $v->paket->nama }}</td>
                        <td>{{ $v->status }}</td>
                        <td class="text-center">
                            <a href="/proses-servis/detail/{{ $v->id }}" class="btn btn-sm btn-info btn-edit"
                               data-id="{{ $v->id }}"><i class="fa fa-info"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
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
