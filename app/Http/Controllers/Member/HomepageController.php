<?php


namespace App\Http\Controllers\Member;


use App\Helper\CustomController;
use App\Models\Barang;
use App\Models\Category;
use App\Models\Paket;

class HomepageController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $paket = Paket::all();
        return view('member.index')->with([
            'paket' => $paket,
        ]);
    }

    public function product_page($id)
    {
        $data = Barang::findOrFail($id);
        return view('member.product')->with(['data' => $data]);
    }
}
