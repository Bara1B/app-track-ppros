<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\WorkOrder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Panggil seeder untuk data master dan user terlebih dahulu.
        // Ini memastikan semua data pendukung sudah ada.
        $this->call([
            MasterProductSeeder::class,
            OvermateMasterSeeder::class,
            OvermateSeeder::class,
            // UsersTableSeeder::class, // Tidak perlu dipanggil jika user sudah dibuat di sini
            SettingsSeeder::class,
        ]);

        // 2. Buat user admin/biasa HANYA JIKA BELUM ADA
        User::firstOrCreate(
            ['email' => 'admin@phapros.co.id'],
            [
                'name' => 'Admin Phapros',
                'role' => 'admin',
                'password' => Hash::make('12345678'),
            ]
        );

        User::firstOrCreate(
            ['email' => 'user@phapros.co.id'],
            [
                'name' => 'User Biasa',
                'role' => 'user',
                'password' => Hash::make('12345678'),
            ]
        );

        // 3. Hapus data transaksional lama
        // (Ini lebih aman daripada truncate dan disable foreign key)
        WorkOrder::query()->delete();

        // 4. Definisikan langkah-langkah tracking
        $trackingSteps = [
            'WO Diterima',
            'Timbang',
            'Selesai Timbang',
            'Potong Stock',
            'Released', // Saya ganti 'Rilis' menjadi 'Released' agar konsisten
            'Kirim BB',
            'Kirim CPB/WO',
        ];

        // === BUAT WORK ORDER 1 (Sebagian Selesai) ===
        $wo1 = WorkOrder::create([
            'wo_number' => '86002001T',
            'output' => 'Antimo Tablet',
            'due_date' => now()->addDays(10),
            'status' => 'On Progress',
        ]);

        // Buat semua tracking untuk WO 1 dalam satu loop yang bersih
        foreach ($trackingSteps as $index => $step) {
            $wo1->tracking()->create([
                'status_name' => $step,
                // Buat 4 langkah pertama selesai
                'completed_at' => ($index < 4) ? now()->subDays(4 - $index) : null,
            ]);
        }
    }
}
