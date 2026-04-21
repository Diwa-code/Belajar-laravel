<?php

use App\Http\Controllers\productController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.beranda', [
        'nama'   => 'Budi Santoso',
        'umur'   => 20,
        'alamat' => 'Jakarta',
    ]);
});// cara untuk inisiasi data untuk dipanggil ke halaman 'page.beranda'

Route::view('/about', 'pages.about', [
    'nama'   => 'Diwangga',
    'umur'   => 20,
    'alamat' => 'Bali',
]);

Route::view('/contact', 'pages.contact');//route view ini langsung mengarah atau view ke halaman contact


Route::get('/produk',[productController::class,'index']);//semua alamat yang mengarah ke /produk akan dihandle oleh route ini dan diarahkan ke controler dengan method index

Route::get('/produk/create', [productController::class,'create']);//semua alamat yang mengarah ke /produk/create akan dihandle oleh route ini dan diarahkan ke controler dengan method create

Route::post('/produk', [productController::class,'store']);// untuk mengelola data yang dikirim dari halaman form data

Route::get('/produk/{id_produk}', [productController::class,'detail']);//semua alamat yang mengarah ke /produk/{id_produk} akan dihandle oleh route ini dan diarahkan ke controler dengan method detail

Route::get('/produk/{id_produk}/edit', [productController::class,'edit']);//semua alamat yang mengarah ke /produk/{id_produk}/edit akan dihandle oleh route ini dan diarahkan ke controler dengan method edit

Route::put('/produk/{id_produk}', [productController::class,'update']);//semua alamat yang mengarah ke /produk/{id_produk} akan dihandle oleh route ini dan diarahkan ke controler dengan method update

Route::get('/produk/{id_produk}/delete', [productController::class,'destroy']);//semua alamat yang mengarah ke /produk/{id_produk} akan dihandle oleh route ini dan diarahkan ke controler dengan method destroy