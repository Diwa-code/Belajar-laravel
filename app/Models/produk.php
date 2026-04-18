<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class produk extends Model
{
    //inisialisasi tabel produk
    protected $table ="tb_produk";
    //inisialisasi primary key
    protected $primaryKey ="id_produk";

    //inisialisasi data yang dapat kita isi
    protected $fillable =['nama_produk','harga','deskripsi_produk','kategori_id'];
    //inisialisasi data yang tidak dapat kita isi
    protected $guarded =['id_produk'];
}
