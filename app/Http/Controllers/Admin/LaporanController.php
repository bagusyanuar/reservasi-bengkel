<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Pembayaran;
use App\Models\Reservasi;

class LaporanController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function laporan_reservasi()
    {
        return view('admin.laporan.reservasi.index');
    }

    public function laporan_reservasi_data()
    {
        try {
            $tgl1 = $this->field('tgl1');
            $tgl2 = $this->field('tgl2');
            $data = Reservasi::with(['user.member', 'paket'])
                ->whereBetween('tanggal', [$tgl1, $tgl2])
                ->get();
            return $this->basicDataTables($data);
        }catch (\Exception $e) {
            return $this->basicDataTables([]);
        }
    }

    public function laporan_reservasi_cetak()
    {
        $tgl1 = $this->field('tgl1');
        $tgl2 = $this->field('tgl2');
        $data = Reservasi::with(['user.member', 'paket'])
            ->whereBetween('tanggal', [$tgl1, $tgl2])
            ->get();
        return $this->convertToPdf('admin.laporan.reservasi.cetak', [
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
            'data' => $data
        ]);
    }

    public function laporan_pembayaran()
    {
        return view('admin.laporan.pembayaran.index');
    }

    public function laporan_pembayaran_data()
    {
        try {
            $tgl1 = $this->field('tgl1');
            $tgl2 = $this->field('tgl2');
            $data = Pembayaran::with(['reservasi.user.member'])
                ->whereBetween('tanggal', [$tgl1, $tgl2])
                ->where('status', '=', 'terima')
                ->get();
            return $this->basicDataTables($data);
        }catch (\Exception $e) {
            return $this->basicDataTables([]);
        }
    }

    public function laporan_pembayaran_cetak()
    {
        $tgl1 = $this->field('tgl1');
        $tgl2 = $this->field('tgl2');
        $data = Pembayaran::with(['reservasi.user.member'])
            ->whereBetween('tanggal', [$tgl1, $tgl2])
            ->where('status', '=', 'terima')
            ->get();
        return $this->convertToPdf('admin.laporan.pembayaran.cetak', [
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
            'data' => $data
        ]);
    }
}
