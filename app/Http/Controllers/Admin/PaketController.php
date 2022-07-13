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
                'tipe' => $this->postField('tipe'),
                'jenis' => $this->postField('jenis'),
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
        $data = Paket::with('layanan')->findOrFail($id);
        $selected_layanan = [];
        foreach ($data->layanan as $v) {
            array_push($selected_layanan, $v->id);
        }
        $layanan = Layanan::all();
        return view('admin.data.paket.edit')->with(['data' => $data, 'layanan' => $layanan, 'selected_layanan' => $selected_layanan]);
    }

    public function patch()
    {
        try {
            DB::beginTransaction();

            $id = $this->postField('id');
            $paket = Paket::find($id);
            $data = [
                'nama' => $this->postField('nama'),
                'harga' => $this->postField('harga'),
                'deskripsi' => $this->postField('deskripsi'),
                'tipe' => $this->postField('tipe'),
                'jenis' => $this->postField('jenis'),
            ];
            $paket->update($data);
            $layanan = $this->postField('layanan');
            $paket->layanan()->sync($layanan);
            DB::commit();
            return redirect('/paket')->with(['success' => 'Berhasil Merubah Data...']);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(['failed' => 'Terjadi Kesalahan' . $e->getMessage()]);
        }
    }

    public function destroy()
    {
        try {
            DB::beginTransaction();
            $id = $this->postField('id');
            $paket = Paket::find($id);
            $paket->layanan()->detach();
            $paket->delete();
            DB::commit();
            return $this->jsonResponse('success', 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->jsonResponse('failed', 500);
        }
    }
}
