<?php


namespace App\Http\Controllers\Member;


use App\Helper\CustomController;
use App\Models\Pembayaran;
use App\Models\Reservasi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index($id)
    {
        $data = Pembayaran::with(['reservasi'])
            ->where('reservasi_id', '=', $id)
            ->get();
        return view('member.pembayaran-list')->with(['data' => $data]);
    }

    public function detail($id)
    {
        $data = Reservasi::with(['user.member', 'paket.layanan', 'pembayaran_lunas', 'tambahan.layanan', 'dp', 'pelunasan'])->findOrFail($id);
        if ($this->request->method() === 'POST') {
            $bank = $this->postField('bank');
            $dp = $this->postField('dp');
            $bukti = $this->generateImageName('bukti');
            $data_pembayaran = [
                'tanggal' => Carbon::now(),
                'reservasi_id' => $data->id,
                'bank' => $bank,
                'total' => $dp,
                'status' => 'menunggu',
                'jenis' => 'dp',
                'keterangan' => 'DP Reservasi'
            ];
            if ($bukti !== '') {
                $data_pembayaran['bukti'] = $bukti;
                $this->uploadImage('bukti', $bukti, 'bukti');
            }
            Pembayaran::create($data_pembayaran);
            return redirect('/pembayaran/' . $data->id . '/detail');
        }
        return view('member.pembayaran')->with(['data' => $data]);
    }

    public function nota($id)
    {
        $data = Reservasi::with(['user.member', 'paket.layanan', 'pembayaran_lunas', 'tambahan.layanan', 'dp', 'pelunasan'])
            ->findOrFail($id);
        $html = view('member.nota')->with(['data' => $data]);
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($html)->setPaper('a5', 'landscape');
        return $pdf->stream();
    }
}
