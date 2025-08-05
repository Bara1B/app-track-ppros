<?php

namespace Database\Seeders;

use App\Models\WorkOrder;
use App\Models\Product;
use App\Models\WorkOrderTracking;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus data lama untuk menghindari duplikat
        WorkOrder::query()->delete();

        $trackingSteps = [
            'WO Diterima',
            'Timbang',
            'Selesai Timbang',
            'Pengurangan Stock', // Diubah dari 'Packing Stock'
            'Released',
            'Kirim BB',
            'Selesai',           // 'Kirim CPB/WO' dihapus dan digabung ke sini
        ];

        // === BUAT WORK ORDER 1 (Sebagian Selesai) ===
        $wo1 = WorkOrder::create([
            'wo_number' => '8004028T',
            'id_number' => '812424',
            'output' => 'gbn',
            'due_date' => now()->addDays(10),
        ]);

        // Tambah produk untuk WO 1
        $wo1->products()->createMany([
            ['item_number' => '14301003', 'description' => 'AIR MURNI', 'qty_required' => 64.8, 'uom' => 'Lt'],
            ['item_number' => '14301102', 'description' => 'ACETAMINOPHEN', 'qty_required' => 160.0, 'uom' => 'Kg'],
        ]);

        // Buat tracking progres untuk WO 1 (4 dari 8 langkah selesai)
        for ($i = 0; $i < 4; $i++) {
            WorkOrderTracking::create([
                'work_order_id' => $wo1->id,
                'status_name' => $trackingSteps[$i],
                'completed_at' => now()->subDays(4 - $i), // Tanggal mundur
            ]);
        }
        // Tambahkan sisa langkah yang belum selesai
        for ($i = 4; $i < count($trackingSteps); $i++) {
            WorkOrderTracking::create([
                'work_order_id' => $wo1->id,
                'status_name' => $trackingSteps[$i],
                'completed_at' => null, // Belum selesai
            ]);
        }

        // === BUAT WORK ORDER 2 (Semua Selesai) ===
        $wo2 = WorkOrder::create([
            'wo_number' => '8005112B',
            'id_number' => '812555',
            'output' => 'xyz',
            'due_date' => now()->addDays(5),
            'status' => 'Completed'
        ]);

        // Buat tracking progres untuk WO 2 (semua langkah selesai)
        foreach ($trackingSteps as $index => $step) {
            WorkOrderTracking::create([
                'work_order_id' => $wo2->id,
                'status_name' => $step,
                'completed_at' => now()->subDays(count($trackingSteps) - $index),
            ]);
        }
        $this->call(MasterProductSeeder::class); // Panggil seeder produk
    }
}
