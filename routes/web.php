<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', [\App\Http\Controllers\Member\HomepageController::class, 'index']);
Route::match(['post', 'get'], '/login-member', [\App\Http\Controllers\AuthController::class, 'login_member']);
Route::match(['post', 'get'], '/register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::match(['post', 'get'], '/login-admin', [\App\Http\Controllers\AuthController::class, 'login']);
Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'logout']);
Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index']);
Route::get('/tentang', [\App\Http\Controllers\Member\HomepageController::class, 'about']);
Route::get('/hubungi', [\App\Http\Controllers\Member\HomepageController::class, 'contact']);

Route::get('/product/{id}/detail', [\App\Http\Controllers\Member\HomepageController::class, 'product_page']);
Route::post('/product/add/layanan', [\App\Http\Controllers\Member\HomepageController::class, 'add_layanan']);
Route::post('/product/hapus/layanan', [\App\Http\Controllers\Member\HomepageController::class, 'delete_layanan']);
Route::get('/product/data', [\App\Http\Controllers\Member\ProductController::class, 'get_product_by_name']);
Route::post('/product/checkout', [\App\Http\Controllers\Member\HomepageController::class, 'checkout']);
Route::get('/pembayaran/{id}', [\App\Http\Controllers\Member\PembayaranController::class, 'index']);
Route::match(['post', 'get'],'/pembayaran/{id}/detail', [\App\Http\Controllers\Member\PembayaranController::class, 'detail']);
Route::get('/pembayaran/{id}/nota', [\App\Http\Controllers\Member\PembayaranController::class, 'nota']);
Route::get('/transaksi', [\App\Http\Controllers\Member\TransaksiController::class, 'index']);

Route::group(['prefix' => 'admin'], function () {
    Route::get( '/', [\App\Http\Controllers\Admin\AdminController::class, 'index']);
    Route::get( '/tambah', [\App\Http\Controllers\Admin\AdminController::class, 'add_page']);
    Route::post( '/create', [\App\Http\Controllers\Admin\AdminController::class, 'create']);
    Route::get( '/edit/{id}', [\App\Http\Controllers\Admin\AdminController::class, 'edit_page']);
    Route::post( '/patch', [\App\Http\Controllers\Admin\AdminController::class, 'patch']);
    Route::post( '/delete', [\App\Http\Controllers\Admin\AdminController::class, 'destroy']);
});

Route::group(['prefix' => 'member'], function () {
    Route::get( '/', [\App\Http\Controllers\Admin\MemberController::class, 'index']);
    Route::get( '/tambah', [\App\Http\Controllers\Admin\MemberController::class, 'add_page']);
    Route::post( '/create', [\App\Http\Controllers\Admin\MemberController::class, 'create']);
    Route::get( '/edit/{id}', [\App\Http\Controllers\Admin\MemberController::class, 'edit_page']);
    Route::post( '/patch', [\App\Http\Controllers\Admin\MemberController::class, 'patch']);
    Route::post( '/delete', [\App\Http\Controllers\Admin\MemberController::class, 'destroy']);
});

Route::group(['prefix' => 'layanan'], function () {
    Route::get( '/', [\App\Http\Controllers\Admin\LayananController::class, 'index']);
    Route::get( '/tambah', [\App\Http\Controllers\Admin\LayananController::class, 'add_page']);
    Route::post( '/create', [\App\Http\Controllers\Admin\LayananController::class, 'create']);
    Route::get( '/edit/{id}', [\App\Http\Controllers\Admin\LayananController::class, 'edit_page']);
    Route::post( '/patch', [\App\Http\Controllers\Admin\LayananController::class, 'patch']);
    Route::post( '/delete', [\App\Http\Controllers\Admin\LayananController::class, 'destroy']);
});

Route::group(['prefix' => 'paket'], function () {
    Route::get( '/', [\App\Http\Controllers\Admin\PaketController::class, 'index']);
    Route::get( '/tambah', [\App\Http\Controllers\Admin\PaketController::class, 'add_page']);
    Route::post( '/create', [\App\Http\Controllers\Admin\PaketController::class, 'create']);
    Route::get( '/edit/{id}', [\App\Http\Controllers\Admin\PaketController::class, 'edit_page']);
    Route::post( '/patch', [\App\Http\Controllers\Admin\PaketController::class, 'patch']);
    Route::post( '/delete', [\App\Http\Controllers\Admin\PaketController::class, 'destroy']);
});

Route::group(['prefix' => 'penerimaan-reservasi'], function () {
    Route::get( '/', [\App\Http\Controllers\Admin\ReservasiController::class, 'index']);
    Route::get( '/detail/{id}', [\App\Http\Controllers\Admin\ReservasiController::class, 'detail']);
    Route::post( '/patch', [\App\Http\Controllers\Admin\ReservasiController::class, 'patch']);
});

Route::group(['prefix' => 'reservasi'], function () {
    Route::get( '/', [\App\Http\Controllers\Admin\ReservasiController::class, 'reservasi']);
    Route::get( '/detail/{id}', [\App\Http\Controllers\Admin\ReservasiController::class, 'detail_reservasi']);
    Route::post( '/patch', [\App\Http\Controllers\Admin\ReservasiController::class, 'patch_reservasi']);
});

Route::group(['prefix' => 'proses-servis'], function () {
    Route::get( '/', [\App\Http\Controllers\Admin\ReservasiController::class, 'servis']);
    Route::get( '/detail/{id}', [\App\Http\Controllers\Admin\ReservasiController::class, 'detail_servis']);
    Route::get( '/data/{id}', [\App\Http\Controllers\Admin\ReservasiController::class, 'layanan_tambahan_data']);
    Route::post( '/tambah-layanan', [\App\Http\Controllers\Admin\ReservasiController::class, 'layanan_tambahan_tambah']);
    Route::post( '/hapus-layanan', [\App\Http\Controllers\Admin\ReservasiController::class, 'layanan_tambahan_hapus']);
    Route::post( '/patch', [\App\Http\Controllers\Admin\ReservasiController::class, 'patch_servis']);
});

Route::group(['prefix' => 'selesai-servis'], function () {
    Route::get( '/', [\App\Http\Controllers\Admin\ReservasiController::class, 'servis_selesai']);
    Route::get( '/detail/{id}', [\App\Http\Controllers\Admin\ReservasiController::class, 'detail_servis_selesai']);
    Route::post( '/patch', [\App\Http\Controllers\Admin\ReservasiController::class, 'patch_servis_selesai']);
});

Route::group(['prefix' => 'reservasi-selesai'], function () {
    Route::get( '/', [\App\Http\Controllers\Admin\ReservasiController::class, 'selesai']);
    Route::get( '/detail/{id}', [\App\Http\Controllers\Admin\ReservasiController::class, 'detail_selesai']);
    Route::get( '/nota/{id}', [\App\Http\Controllers\Admin\ReservasiController::class, 'cetak_nota']);
});

Route::group(['prefix' => 'laporan-reservasi'], function () {
    Route::get( '/', [\App\Http\Controllers\Admin\LaporanController::class, 'laporan_reservasi']);
    Route::get( '/data', [\App\Http\Controllers\Admin\LaporanController::class, 'laporan_reservasi_data']);
    Route::get( '/cetak', [\App\Http\Controllers\Admin\LaporanController::class, 'laporan_reservasi_cetak']);
});

Route::group(['prefix' => 'laporan-pembayaran'], function () {
    Route::get( '/', [\App\Http\Controllers\Admin\LaporanController::class, 'laporan_pembayaran']);
    Route::get( '/data', [\App\Http\Controllers\Admin\LaporanController::class, 'laporan_pembayaran_data']);
    Route::get( '/cetak', [\App\Http\Controllers\Admin\LaporanController::class, 'laporan_pembayaran_cetak']);
});
//
//Route::group(['prefix' => 'barang'], function () {
//    Route::get( '/', [\App\Http\Controllers\Admin\BarangController::class, 'index']);
//    Route::get( '/tambah', [\App\Http\Controllers\Admin\BarangController::class, 'add_page']);
//    Route::post( '/create', [\App\Http\Controllers\Admin\BarangController::class, 'create']);
//    Route::get( '/edit/{id}', [\App\Http\Controllers\Admin\BarangController::class, 'edit_page']);
//    Route::post( '/patch', [\App\Http\Controllers\Admin\BarangController::class, 'patch']);
//    Route::post( '/delete', [\App\Http\Controllers\Admin\BarangController::class, 'destroy']);
//});

