<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i=1; $i<50; $i++){
            $harga = array_rand([5000 => 5000,6000 => 6000, 7000 => 7000]);
            Barang::create([
                'kode_barang' => "BRG00$i",
                'nama_barang' => "Barang 00$i",
                'harga_jual' => $harga + 2000,
                'harga_beli' => $harga,
                'satuan' => array_rand(["Liter"=> "Liter", "Pcs" => "Pcs", "Kg" => "Kg"]),
                'kategori' => array_rand(["cair" => "Cair", "Padat" => "Padat"]),
            ]);
        };
    }
}
