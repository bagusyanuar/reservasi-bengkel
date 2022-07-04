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


Route::get('/product/{id}/detail', [\App\Http\Controllers\Member\HomepageController::class, 'product_page']);
Route::get('/product/data', [\App\Http\Controllers\Member\ProductController::class, 'get_product_by_name']);


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

Route::group(['prefix' => 'category'], function () {
    Route::get( '/', [\App\Http\Controllers\Admin\CategoryController::class, 'index']);
    Route::get( '/tambah', [\App\Http\Controllers\Admin\CategoryController::class, 'add_page']);
    Route::post( '/create', [\App\Http\Controllers\Admin\CategoryController::class, 'create']);
    Route::get( '/edit/{id}', [\App\Http\Controllers\Admin\CategoryController::class, 'edit_page']);
    Route::post( '/patch', [\App\Http\Controllers\Admin\CategoryController::class, 'patch']);
    Route::post( '/delete', [\App\Http\Controllers\Admin\CategoryController::class, 'destroy']);
});

Route::group(['prefix' => 'barang'], function () {
    Route::get( '/', [\App\Http\Controllers\Admin\BarangController::class, 'index']);
    Route::get( '/tambah', [\App\Http\Controllers\Admin\BarangController::class, 'add_page']);
    Route::post( '/create', [\App\Http\Controllers\Admin\BarangController::class, 'create']);
    Route::get( '/edit/{id}', [\App\Http\Controllers\Admin\BarangController::class, 'edit_page']);
    Route::post( '/patch', [\App\Http\Controllers\Admin\BarangController::class, 'patch']);
    Route::post( '/delete', [\App\Http\Controllers\Admin\BarangController::class, 'destroy']);
});

