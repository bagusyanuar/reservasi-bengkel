<?php


namespace App\Http\Controllers\Member;


use App\Helper\CustomController;
use App\Models\Barang;
use App\Models\Category;
use App\Models\Layanan;
use App\Models\Paket;
use App\Models\ReservasiTambahan;

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
        $tambahan = ReservasiTambahan::with(['user', 'reservasi', 'layanan'])
            ->where('user_id', '=', 2)
            ->whereNull('reservasi_id')
            ->get();
        $total_tambahan = $data->harga;
        if($data->jenis === 'custom') {
            foreach ($tambahan as $t) {
                $total_tambahan += $t->harga;
            }
        }
        return view('member.product')->with(['data' => $data, 'layanan' => $layanan, 'tambahan' => $tambahan, 'total_tambahan' => $total_tambahan]);
    }

    public function add_layanan()
    {
        try {
            $layanan_id = $this->postField('layanan');
            $layanan = Layanan::find($layanan_id);
            $data = [
                'user_id' => 2,
                'reservasi_id' => null,
                'layanan_id' => $layanan_id,
                'qty' => 1,
                'harga' => $layanan->harga * 1
            ];
            ReservasiTambahan::create($data);
            return $this->jsonResponse('success', 200);
        }catch (\Exception $e) {
            return $this->jsonResponse('failed ' . $e->getMessage(), 500);
        }
    }

    public function delete_layanan()
    {
        try {
            $id = $this->postField('id');
            ReservasiTambahan::destroy($id);
            return $this->jsonResponse('success', 200);
        }catch (\Exception $e) {
            return $this->jsonResponse('failed ' . $e->getMessage(), 500);
        }
    }

    public function checkout()
    {

    }
}
