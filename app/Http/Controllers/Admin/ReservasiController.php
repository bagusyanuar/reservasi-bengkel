<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Paket;
use App\Models\Pembayaran;
use App\Models\Reservasi;
use Illuminate\Support\Facades\DB;

class ReservasiController extends CustomController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = Reservasi::with(['pembayaran_lunas', 'user.member', 'paket'])->whereHas('pembayaran_lunas', function ($q){
            return $q->where('total', '>', 0)
                ->where('status', '=', 'menunggu');
        })->get();
        return view('admin.transaksi.reservasi.index')->with(['data' => $data]);
    }

    public function detail($id)
    {
        $data = Reservasi::with(['pembayaran_lunas', 'user.member', 'paket'])->whereHas('pembayaran_lunas', function ($q){
            return $q->where('total', '>', 0)
                ->where('status', '=', 'menunggu');
        })->findOrFail($id);
        return view('admin.transaksi.reservasi.detail')->with(['data' => $data]);
    }

    public function patch()
    {
        try {
            DB::beginTransaction();
            $id = $this->postField('id');
            $reservasi = Reservasi::find($id);
            $data = [
                'status' => $this->postField('status'),
            ];
            $reservasi->update($data);
            $pembayaran = Pembayaran::where('reservasi_id', '=', $id);
            $pembayaran->update([
                'status' => $this->postField('status') === 'menunggu' ? 'terima' : 'tolak'
            ]);
            DB::commit();
            return redirect('/penerimaan-reservasi')->with(['success' => 'Berhasil Merubah Data...']);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(['failed' => 'Terjadi Kesalahan' . $e->getMessage()]);
        }
    }
}
