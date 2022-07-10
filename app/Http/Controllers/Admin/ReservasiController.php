<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Layanan;
use App\Models\Paket;
use App\Models\Pembayaran;
use App\Models\Reservasi;
use App\Models\ReservasiTambahan;
use Illuminate\Support\Facades\DB;

class ReservasiController extends CustomController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = Reservasi::with(['pembayaran_lunas', 'user.member', 'paket'])->whereHas('pembayaran_lunas', function ($q) {
            return $q->where('total', '>', 0)
                ->where('status', '=', 'menunggu');
        })
            ->where('status', '=', 'reservasi')
            ->get();
        return view('admin.transaksi.penerimaan-reservasi.index')->with(['data' => $data]);
    }

    public function detail($id)
    {
        $data = Reservasi::with(['pembayaran_lunas', 'user.member', 'paket'])->whereHas('pembayaran_lunas', function ($q) {
            return $q->where('total', '>', 0)
                ->where('status', '=', 'menunggu');
        })
            ->where('status', '=', 'reservasi')
            ->findOrFail($id);
        return view('admin.transaksi.penerimaan-reservasi.detail')->with(['data' => $data]);
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

    public function reservasi()
    {
        $data = Reservasi::with(['user.member', 'paket'])
            ->where('status', '=', 'menunggu')
            ->get();
        return view('admin.transaksi.reservasi.index')->with(['data' => $data]);
    }

    public function detail_reservasi($id)
    {
        $data = Reservasi::with(['user.member', 'paket.layanan'])
            ->where('status', '=', 'menunggu')
            ->findOrFail($id);
        return view('admin.transaksi.reservasi.detail')->with(['data' => $data]);
    }

    public function patch_reservasi()
    {
        try {
            $id = $this->postField('id');
            $reservasi = Reservasi::find($id);
            $data = [
                'status' => 'proses',
            ];
            $reservasi->update($data);
            return redirect('/reservasi')->with(['success' => 'Berhasil Merubah Data...']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['failed' => 'Terjadi Kesalahan' . $e->getMessage()]);
        }
    }

    public function servis()
    {
        $data = Reservasi::with(['user.member', 'paket'])
            ->where('status', '=', 'proses')
            ->get();
        return view('admin.transaksi.proses-servis.index')->with(['data' => $data]);
    }

    public function detail_servis($id)
    {
        $data = Reservasi::with(['user.member', 'paket.layanan', 'tambahan', 'pembayaran_lunas'])
            ->where('status', '=', 'proses')
            ->findOrFail($id);
        $layanan = Layanan::all();
        return view('admin.transaksi.proses-servis.detail')->with(['data' => $data, 'layanan' => $layanan]);
    }

    public function layanan_tambahan_data($id)
    {
        try {
            $data = ReservasiTambahan::with(['reservasi', 'layanan'])
                ->where('reservasi_id', '=', $id)
                ->get();
            return $this->basicDataTables($data);
        } catch (\Exception $e) {
            return $this->basicDataTables([]);
        }
    }

    public function layanan_tambahan_tambah()
    {
        try {
            $layanan = Layanan::find($this->postField('layanan_id'));
            $qty = (int)$this->postField('qty');
            $data = [
                'reservasi_id' => $this->postField('id'),
                'layanan_id' => $layanan->id,
                'harga' => $layanan->harga,
                'qty' => $qty,
                'total' => $qty * $layanan->harga
            ];
            ReservasiTambahan::create($data);
            return $this->jsonResponse('success', 200);
        } catch (\Exception $e) {
            return $this->jsonResponse('gagal ' . $e->getMessage(), 500);
        }
    }

    public function layanan_tambahan_hapus()
    {
        try {
            $id = $this->postField('id');
            ReservasiTambahan::destroy($id);
            return $this->jsonResponse('success', 200);
        } catch (\Exception $e) {
            return $this->jsonResponse('gagal ' . $e->getMessage(), 500);
        }
    }

    public function patch_servis()
    {
        try {
            $id = $this->postField('id');
            $reservasi = Reservasi::find($id);
            $data = [
                'status' => 'selesai-servis',
            ];
            $reservasi->update($data);
            return redirect('/proses-servis')->with(['success' => 'Berhasil Merubah Data...']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['failed' => 'Terjadi Kesalahan' . $e->getMessage()]);
        }
    }

    public function servis_selesai()
    {
        $data = Reservasi::with(['user.member', 'paket'])
            ->where('status', '=', 'selesai-servis')
            ->get();
        return view('admin.transaksi.servis-selesai.index')->with(['data' => $data]);
    }

    public function detail_servis_selesai($id)
    {
        $data = Reservasi::with(['user.member', 'paket.layanan', 'tambahan', 'pembayaran_lunas'])
            ->where('status', '=', 'selesai-servis')
            ->findOrFail($id);
        $layanan = Layanan::all();
        return view('admin.transaksi.servis-selesai.detail')->with(['data' => $data, 'layanan' => $layanan]);
    }

    public function patch_servis_selesai()
    {
        try {
            $id = $this->postField('id');
            $reservasi = Reservasi::find($id);
            $data = [
                'status' => 'selesai-servis',
            ];
            $reservasi->update($data);
            return redirect('/proses-servis')->with(['success' => 'Berhasil Merubah Data...']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['failed' => 'Terjadi Kesalahan' . $e->getMessage()]);
        }
    }
}
