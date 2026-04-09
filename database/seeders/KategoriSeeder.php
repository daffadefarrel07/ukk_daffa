<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            'Berita',
            'Fasilitas',
            'Kebersihan',
            'Keamanan',
            'Lainnya',
        ];

        foreach ($kategoris as $nama) {
            Kategori::firstOrCreate(
                ['ket_kategori' => $nama],
                ['ket_kategori' => $nama]
            );
        }
    }
}

