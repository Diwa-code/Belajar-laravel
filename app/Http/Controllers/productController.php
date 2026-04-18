<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\produk;

class productController extends Controller
{
    public function index(){
        //query untuk mengambil semua data yang ada di tabel produk dengan equilent
        $data_produk = produk::get(); 
        // $queryBuilder = DB::table('tb_produk')->get(); 
        // //query builder untuk mengambil semua data yang ada di tabel produk
        return view('pages.produk.show', compact('data_produk'));
}
public function create(){
    return view('pages.produk.add');
}

public function store(Request $request){ //parameter untuk menampung data yang dikirim dari form

    // validasi data harus di isi
    //aturan validasi dapat di lihat di website laravel, dengan keyword "available validation rules"
    $request->validate([
        'nama_produk_' => 'required',
        'harga' => 'required|numeric',
        'deskripsi_produk' => 'required'
    ],[
        'harga.numeric' => 'Harga harus berupa angka',
        'harga.required'=> 'Harga harus diisi',
        'nama_produk_.required' => 'Nama Produk harus diisi',
        'deskripsi_produk.required' => 'Deskripsi Produk harus diisi',
    ]);

    //query untuk mengambil data yang di isi dari show.blade dengna menggunakan name dari kolom pada tampilan add, name="nama_produk_"
    produk::create([
        'nama_produk' => $request->nama_produk_,
        'harga' => $request->harga,
        'deskripsi_produk' => $request->deskripsi_produk,
        'kategori_id' => '1'
    ]);

    //untuk menampilkan kembali ke halaman produk setalah data ditambah
    return redirect('/produk')->with('pesan', 'Data berhasil ditambahkan');
}

public function detail($id_produk){
    $data_produk = produk::findOrFail($id_produk);
    return view('pages.produk.detail', compact('data_produk'));
}

public function edit($id_produk){
    $data = produk::findOrFail($id_produk);
    return view('pages.produk.edit', compact('data'));
}

public function update(Request $request, $id_produk){
    $request->validate([
        'nama_produk_' => 'required',
        'harga_produk' => 'required|numeric',
        'deskripsi_produk' => 'required'
    ],[
        'harga_produk.numeric' => 'Harga harus berupa angka',
        'nama_produk_.required' => 'Nama Produk harus diisi',
        'deskripsi_produk.required' => 'DeskripsiProduk harus diisi',
        'harga_produk.required' => 'Harga harus diisi',
    ]);

    produk::where('id_produk', $id_produk)->update([
        'nama_produk' => $request->nama_produk_,
        'harga' => $request->harga_produk,
        'deskripsi_produk' => $request->deskripsi_produk,
    ]);

    return redirect('/produk')->with('pesan', 'Data berhasil diupdate');
}

}
