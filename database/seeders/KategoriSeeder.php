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
                'nama_kategori' => 'Buku Majalah',
                'deskripsi' => 'ini data dummy buku majalah',
                'created_at' => now()
            ]
        ]);
    }
}
