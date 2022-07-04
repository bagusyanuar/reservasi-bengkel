<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Layanan;

class LayananController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = Layanan::all();
        return view('admin.data.layanan.index')->with(['data' => $data]);
    }

    public function add_page()
    {
        return view('admin.data.layanan.add');
    }

    public function create()
    {
        try {
            $data = [
                'nama' => $this->postField('nama'),
                'harga' => $this->postField('harga'),
            ];
            Layanan::create($data);
            return redirect()->back()->with(['success' => 'Berhasil Menambahkan Data...']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['failed' => 'Terjadi Kesalahan ' . $e->getMessage()]);
        }
    }

    public function edit_page($id)
    {
        $data = Layanan::findOrFail($id);
        return view('admin.data.layanan.edit')->with(['data' => $data]);
    }

    public function patch()
    {
        try {
            $id = $this->postField('id');
            $layanan = Layanan::find($id);
            $data = [
                'nama' => $this->postField('nama'),
                'harga' => $this->postField('harga'),
            ];

            $layanan->update($data);
            return redirect('/layanan')->with(['success' => 'Berhasil Merubah Data...']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['failed' => 'Terjadi Kesalahan' . $e->getMessage()]);
        }
    }

    public function destroy()
    {
        try {
            $id = $this->postField('id');
            Layanan::destroy($id);
            return $this->jsonResponse('success', 200);
        } catch (\Exception $e) {
            return $this->jsonResponse('failed', 500);
        }
    }
}
