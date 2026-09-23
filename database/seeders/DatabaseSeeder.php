<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{   
    // Seeder utama menyiapkan akun admin dan data menu awal aplikasi.
    use withoutModelEvents;

    /**
     * Seeds the application's database.
     */
    public function run(): void
    {
        // Buat akun admin default dengan password yang sudah di-hash.
        User::create([
            'name' => 'Admin Toko',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password123'),
        ]);

        // Jalankan seeder menu agar katalog memiliki data awal.
        $this->call([
            FoodSeeder::class,
        ]);
    }
}