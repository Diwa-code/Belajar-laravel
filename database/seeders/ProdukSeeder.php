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
    public function run(): void{

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

    
        DB::table('tb_produk')->insert([[
            'nama_produk' => 'Iphone 18 ProMax',
            'kode_barang'=> '001',
            'harga' => '20000000',
            'deskripsi_produk' => 'Iphone Keluaran terbaru dengan kualitas terbaik',
            'stok' => '25',
            'kategori_id' => '1',
            'created_at' => now()
        ],
        [
            'nama_produk' => 'sapu terbang',
            'kode_barang'=> '002',
            'harga' => '210000',
            'deskripsi_produk' => 'Sapu modern bisa terbang',
            'stok' => '25',
            'kategori_id' => '2',
            'created_at' => now()
        ]
        ],

    );
    }
}