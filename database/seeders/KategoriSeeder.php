<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tb_kategori')->insert([
            [
                'nama_kategori' => 'Elektronik',
                'deskripsi' => 'ini data dummy Barang Elektronik',
                'created_at' => now()
            ],
            [
                'nama_kategori' => 'Alat Rumah Tangga',
                'deskripsi' => 'ini data dummy Alat Rumah Tangga',
                'created_at' => now()
            ]
        ]);
    }
}
