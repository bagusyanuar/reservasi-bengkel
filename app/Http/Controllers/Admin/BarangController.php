<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Barang;
use App\Models\Category;

class BarangController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = Barang::with('category')->get();
        return view('admin.data.barang.index')->with(['data' => $data]);
    }

    public function add_page()
    {
        $data = Category::all();
        return view('admin.data.barang.add')->with(['data' => $data]);
    }

    public function create()
    {
        try {
            $data = [
                'nama' => $this->postField('nama'),
                'category_id' => $this->postField('kategori') === '' ? null : $this->postField('kategori'),
                'harga' => $this->postField('harga'),
                'deskripsi' => $this->postField('deskripsi'),
            ];
            $nama_gambar = $this->generateImageName('gambar');

            if ($nama_gambar !== '') {
                $data['gambar'] = $nama_gambar;
                $this->uploadImage('gambar', $nama_gambar, 'barang');
            }
            Barang::create($data);
            return redirect()->back()->with(['success' => 'Berhasil Menambahkan Data...']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['failed' => 'Terjadi Kesalahan ' . $e->getMessage()]);
        }
    }

    public function edit_page($id)
    {
        $category = Category::all();
        $data = Barang::with('category')->findOrFail($id);
        return view('admin.data.barang.edit')->with(['data' => $data, 'category' => $category]);
    }

    public function patch()
    {
        try {
            $id = $this->postField('id');
            $barang = Barang::find($id);
            $data = [
                'nama' => $this->postField('nama'),
                'category_id' => $this->postField('kategori') === '' ? null : $this->postField('kategori'),
                'harga' => $this->postField('harga'),
                'deskripsi' => $this->postField('deskripsi'),
            ];
            $nama_gambar = $this->generateImageName('gambar');

            if ($nama_gambar !== '') {
                $data['gambar'] = $nama_gambar;
                $this->uploadImage('gambar', $nama_gambar, 'barang');
            }
            $barang->update($data);
            return redirect('/barang')->with(['success' => 'Berhasil Merubah Data...']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['failed' => 'Terjadi Kesalahan' . $e->getMessage()]);
        }
    }

    public function destroy()
    {
        try {
            $id = $this->postField('id');
            Barang::destroy($id);
            return $this->jsonResponse('success', 200);
        } catch (\Exception $e) {
            return $this->jsonResponse('failed', 500);
        }
    }
}
