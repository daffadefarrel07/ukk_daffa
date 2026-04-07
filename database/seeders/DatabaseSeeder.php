<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
public function run(): void
    {
        // Delegate admin creation to AdminSeeder
        $this->call(AdminSeeder::class);

        \App\Models\Kategori::create(['ket_kategori' => 'Berita']);
        \App\Models\Kategori::create(['ket_kategori' => 'Fasilitas']);
        \App\Models\Kategori::create(['ket_kategori' => 'Kebersihan']);
        \App\Models\Kategori::create(['ket_kategori' => 'Keamanan']);
        \App\Models\Kategori::create(['ket_kategori' => 'Lainnya']);

        // Uncomment untuk test users/siswa
        // \App\Models\User::factory(10)->create();
    }
}
