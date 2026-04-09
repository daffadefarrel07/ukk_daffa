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
        $this->call(KategoriSeeder::class);

        // Uncomment untuk test users/siswa
        // \App\Models\User::factory(10)->create();
    }
}
