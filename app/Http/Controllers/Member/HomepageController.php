<?php


namespace App\Http\Controllers\Member;


use App\Helper\CustomController;
use App\Models\Barang;
use App\Models\Category;

class HomepageController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $category = Category::all();
        $data = Barang::with('category')->get();
        return view('member.index')->with([
            'categories' => $category,
            'data' => $data
        ]);
    }

    public function product_page($id)
    {
        $data = Barang::findOrFail($id);
        return view('member.product')->with(['data' => $data]);
    }
}
