<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tb_produk')->insert([
            'nama_produk' => 'Majalah Anak-anak',
            'harga' => '210000',
            'deskripsi_produk' => 'ini data dummy majalah anak-anak',
            'kategori_id' => '2',
            'created_at' => now()
        ]);
    }
}