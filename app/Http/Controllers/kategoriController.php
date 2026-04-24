<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\produk;
use App\Models\Kategori;

class kategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //query untuk mengambil semua data yang ada di tabel kategori
        $data_kategori = Kategori::get();

        return view('pages.kategori.show', compact('data_kategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.kategori.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required',
            'deskripsi' => 'required'
        ], [
            'nama_kategori.required' => 'Nama Kategori harus diisi',
            'deskripsi.required' => 'Deskripsi harus diisi'
        ]);

        Kategori::create([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi' => $request->deskripsi
        ]);

        return redirect('/kategori')->with('pesan', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id_kategori)
    {
        $data_kategori = Kategori::findOrFail($id_kategori);
        return view('pages.kategori.detail', compact('data_kategori'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id_kategori)
    {
        $data_kategori = Kategori::findOrFail($id_kategori);
        return view('pages.kategori.edit', compact('data_kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id_kategori)
    {
        $request->validate([
            'nama_kategori' => 'required',
            'deskripsi' => 'required'
        ], [
            'nama_kategori.required' => 'Nama Kategori harus diisi',
            'deskripsi.required' => 'Deskripsi harus diisi'
        ]);
        Kategori::findOrFail($id_kategori)->update([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi' => $request->deskripsi
        ]);

        return redirect('/kategori')->with('pesan', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id_kategori)
    {
        $kategori = Kategori::findOrFail($id_kategori);
        $kategori->delete();
        return redirect('/kategori')->with('pesan', 'Data berhasil dihapus');
    }

    /**
     * Method untuk melakukan pencarian kategori berdasarkan kata kunci (keyword).
     * 
     * Penjelasan Teknis:
     * 1. $request->keyword: Mengambil data string dari input form pencarian.
     * 2. Operator 'LIKE': Digunakan dalam SQL untuk mencari pola tertentu dalam kolom. Berbeda dengan '=' 
     *    yang mencari kecocokan persis, 'LIKE' memungkinkan pencarian yang lebih fleksibel.
     * 3. Wildcard '%': 
     *    - "%keyword%": Mencari kata di posisi manapun (depan, tengah, atau belakang).
     *    - "keyword%": Hanya mencari kata yang diawali dengan keyword tersebut.
     *    - "%keyword": Hanya mencari kata yang diakhiri dengan keyword tersebut.
     * 4. orWhere: Menambahkan kondisi "ATAU", sehingga pencarian dilakukan di kolom 'nama_kategori' 
     *    ATAU kolom 'deskripsi'.
     */
    public function search(Request $request)
    {
        $keyword = $request->keyword;
        $data_kategori = Kategori::where('nama_kategori', 'like', "%" . $keyword . "%")
            ->orWhere('deskripsi', 'like', "%" . $keyword . "%")
            ->get();
        return view('pages.kategori.show', compact('data_kategori'));
    }
}


