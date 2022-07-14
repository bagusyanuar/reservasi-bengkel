<?php


namespace App\Http\Controllers\Member;


use App\Helper\CustomController;
use App\Models\Reservasi;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = Reservasi::with(['user.member', 'paket.layanan', 'pembayaran_lunas', 'tambahan.layanan'])
            ->where('user_id', '=', Auth::id())
            ->get();
        return view('member.transaksi')->with(['data' => $data]);
    }
}
