<?php


namespace App\Http\Controllers\Member;


use App\Helper\CustomController;
use App\Models\Barang;
use App\Models\Category;
use App\Models\Layanan;
use App\Models\Paket;
use App\Models\Reservasi;
use App\Models\ReservasiTambahan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomepageController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $paket = Paket::with('layanan')->orderBy('jenis', 'ASC')->get();
        return view('member.index')->with([
            'paket' => $paket,
        ]);
    }

    public function product_page($id)
    {
        $data = Paket::with('layanan')->findOrFail($id);
        $layanan = Layanan::all();
        $tambahan = [];
        $total_tambahan = $data->harga;
        if ($data->jenis === 'custom' && Auth::check()) {
            $tambahan = ReservasiTambahan::with(['user', 'reservasi', 'layanan'])
                ->where('user_id', '=', Auth::id())
                ->whereNull('reservasi_id')
                ->get();
            foreach ($tambahan as $t) {
                $total_tambahan += $t->harga;
            }
        }
        return view('member.product')->with(['data' => $data, 'layanan' => $layanan, 'tambahan' => $tambahan, 'total_tambahan' => $total_tambahan]);
    }

    public function add_layanan()
    {
        try {
            if (!Auth::check()) {
                return $this->jsonResponse('Silahkan Login Terlebih Dahulu', 202);
            }
            $layanan_id = $this->postField('layanan');
            $layanan = Layanan::find($layanan_id);
            $data = [
                'user_id' => Auth::id(),
                'reservasi_id' => null,
                'layanan_id' => $layanan_id,
                'qty' => 1,
                'harga' => $layanan->harga * 1
            ];
            ReservasiTambahan::create($data);
            return $this->jsonResponse('success', 200);
        } catch (\Exception $e) {
            return $this->jsonResponse('failed ' . $e->getMessage(), 500);
        }
    }

    public function delete_layanan()
    {
        try {
            $id = $this->postField('id');
            ReservasiTambahan::destroy($id);
            return $this->jsonResponse('success', 200);
        } catch (\Exception $e) {
            return $this->jsonResponse('failed ' . $e->getMessage(), 500);
        }
    }

    public function checkout()
    {
        try {
            if (!Auth::check()) {
                return $this->jsonResponse('Silahkan Login Terlebih Dahulu', 202);
            }
            $id = $this->postField('id');
            DB::beginTransaction();
            $paket = Paket::find($id);
            $no_reservasi = 'RS-' . \date('YmdHis');
            $data_reservasi = [
                'user_id' => Auth::id(),
                'tanggal' => Carbon::now(),
                'no_reservasi' => $no_reservasi,
                'paket_id' => $paket->id,
                'status' => 'reservasi',
                'total' => $paket->harga,
                'keterangan' => $this->postField('keterangan'),
            ];
            $reservasi = Reservasi::create($data_reservasi);
            $tambahan = ReservasiTambahan::with(['user', 'reservasi', 'layanan'])
                ->where('user_id', '=', Auth::id())
                ->whereNull('reservasi_id')
                ->get();
            foreach ($tambahan as $t) {
                $t->update(['reservasi_id' => $reservasi->id]);
            }
            DB::commit();
            return $this->jsonResponse('success', 200);
        }catch (\Exception $e) {
            return $this->jsonResponse('failed ' . $e->getMessage(), 500);
        }
    }

    public function about()
    {
        return view('member.tentang');
    }

    public function contact()
    {
        return view('member.hubungi');
    }
}
