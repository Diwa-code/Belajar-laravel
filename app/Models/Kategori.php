<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    //inisialisasi tabel produk
    protected $table ="tb_kategori";
    //inisialisasi primary key
    protected $primaryKey ="id_kategori";

    //inisialisasi data yang dapat kita isi
    protected $fillable =['nama_kategori','deskripsi'];
    //inisialisasi data yang tidak dapat kita isi
    protected $guarded =['id_kategori'];
}
