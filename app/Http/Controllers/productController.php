<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\produk;
use App\Models\Kategori;
use Illuminate\Support\Str;

class productController extends Controller
{
    public function index(){

        
        //query untuk join table berdasarkan relasi foreign key
        $data_produk = $data_produk = Produk::join('tb_kategori', 'tb_produk.kategori_id', '=', 'tb_kategori.id_kategori')
            ->get(); 
        // $queryBuilder = DB::table('tb_produk')->get(); 
        // //query builder untuk mengambil semua data yang ada di tabel produk
        return view('pages.produk.show', compact('data_produk'));
}

/**
 * Method untuk melakukan pencarian produk berdasarkan keyword
 * @param Request $request - menangkap input 'keyword' dari URL
 */
public function search(Request $request)
{
    // Mengambil keyword yang dikirim user
    $keyword = $request->keyword;

    // Melakukan query ke database dengan kondisi LIKE pada nama_produk atau deskripsi_produk
    $data_produk = produk::where('nama_produk', 'like', "%" . $keyword . "%")
        ->orWhere('deskripsi_produk', 'like', "%" . $keyword . "%")
        ->get();

    // Mengembalikan data hasil pencarian ke halaman show.blade.php
    return view('pages.produk.show', compact('data_produk'));
}
public function create(){
    $data_kategori = Kategori::get();
    return view('pages.produk.add', compact('data_kategori'));
}

public function store(Request $request){ //parameter untuk menampung data yang dikirim dari form

    // validasi data harus di isi
    //aturan validasi dapat di lihat di website laravel, dengan keyword "available validation rules"
    $request->validate([
        'nama_produk_' => 'required',
        'harga' => 'required|numeric',
        'deskripsi_produk' => 'required',
        'stok' => 'required',
        'kategori'=> 'required',
    ],[
        'harga.numeric' => 'Harga harus berupa angka',
        'harga.required'=> 'Harga harus diisi',
        'nama_produk_.required' => 'Nama Produk harus diisi',
        'deskripsi_produk.required' => 'Deskripsi Produk harus diisi',
        'stok.required'=> 'stok harus di isi',
    ]);

    //query untuk mengambil data yang di isi dari show.blade dengna menggunakan name dari kolom pada tampilan add, name="nama_produk_"
    produk::create([
        'nama_produk' => $request->nama_produk_,
        'kode_barang' => Str::random(10),
        'harga' => $request->harga,
        'stok' => $request->stok,
        'kategori_id' => $request->kategori,
        'deskripsi_produk' => $request->deskripsi_produk,

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
    $data_kategori = Kategori::all();
    return view('pages.produk.edit', compact('data', 'data_kategori'));
}

public function update(Request $request, $id_produk){
    $request->validate([
            'nama_produk_' => 'required',
            'harga_produk' => 'required|numeric',
            'stok' => 'required|numeric',
            'kategori' => 'required',
            'deskripsi_produk' => 'required'
        ],[
            'nama_produk_.required' => 'Nama Produk harus diisi',
            'harga_produk.required' => 'Harga harus diisi',
            'harga_produk.numeric' => 'Harga harus berupa angka',
            'stok.required' => 'Stok harus diisi',
            'stok.numeric' => 'Stok harus berupa angka',
            'kategori.required' => 'Kategori harus dipilih',
            'deskripsi_produk.required' => 'Deskripsi Produk harus diisi',
        ]);
    produk::where('id_produk', $id_produk)->update([
        'nama_produk' => $request->nama_produk_,
        'harga' => $request->harga_produk,
        'stok'=> $request->stok,
        'kategori_id'=> $request->kategori,
        'deskripsi_produk' => $request->deskripsi_produk,
    ]);

    return redirect('/produk')->with('pesan', 'Data berhasil diupdate');
}

public function destroy($id_produk){
    $data = produk::findOrFail($id_produk);
    $data->delete();
    return redirect('/produk')->with('pesan', 'Data berhasil dihapus');
}

}