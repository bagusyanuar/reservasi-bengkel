<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Layanan;
use App\Models\Paket;
use Illuminate\Support\Facades\DB;

class PaketController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = Paket::with('layanan')->get();
//        return $data->toArray();
        return view('admin.data.paket.index')->with(['data' => $data]);
    }

    public function add_page()
    {
        $layanan = Layanan::all();
        return view('admin.data.paket.add')->with(['layanan' => $layanan]);
    }

    public function create()
    {
        try {
            DB::beginTransaction();
            $data = [
                'nama' => $this->postField('nama'),
                'harga' => $this->postField('harga'),
                'deskripsi' => $this->postField('deskripsi'),
            ];
            $layanan = $this->postField('layanan');
            $paket = Paket::create($data);
            $paket->layanan()->attach($layanan);
            DB::commit();
            return redirect()->back()->with(['success' => 'Berhasil Menambahkan Data...']);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(['failed' => 'Terjadi Kesalahan ' . $e->getMessage()]);
        }
    }

    public function edit_page($id)
    {
        $data = Paket::findOrFail($id);
        return view('admin.data.paket.edit')->with(['data' => $data]);
    }

    public function patch()
    {
        try {
            $id = $this->postField('id');
            $category = Paket::find($id);
            $data = [
                'nama' => $this->postField('nama'),
            ];

            $category->update($data);
            return redirect('/paket')->with(['success' => 'Berhasil Merubah Data...']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['failed' => 'Terjadi Kesalahan' . $e->getMessage()]);
        }
    }

    public function destroy()
    {
        try {
            $id = $this->postField('id');
            Paket::destroy($id);
            return $this->jsonResponse('success', 200);
        } catch (\Exception $e) {
            return $this->jsonResponse('failed', 500);
        }
    }
}
