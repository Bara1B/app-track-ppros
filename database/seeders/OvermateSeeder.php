<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Overmate;
use Illuminate\Support\Facades\DB;

class OvermateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Truncate table first
        Overmate::truncate();

        $csvFile = database_path('seeders/overmate.csv');

        if (!file_exists($csvFile)) {
            $this->command->error("CSV file not found: {$csvFile}");
            return;
        }

        $file = fopen($csvFile, 'r');

        // Skip header row
        $header = fgetcsv($file, 0, ';');

        $batchData = [];
        $batchSize = 100;

        while (($row = fgetcsv($file, 0, ';')) !== FALSE) {
            if (count($row) >= 5) {
                // Convert comma decimal to dot decimal and preserve decimal values
                $overmateQty = str_replace(',', '.', trim($row[4]));
                $overmateQty = is_numeric($overmateQty) ? (float) $overmateQty : 0.0;

                $batchData[] = [
                    'item_number' => trim($row[0]),
                    'nama_bahan' => trim($row[1]),
                    'manufactur' => trim($row[2]),
                    'overmate_qty' => $overmateQty,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // Process in batches for better performance
                if (count($batchData) >= $batchSize) {
                    DB::table('overmate')->insert($batchData);
                    $batchData = [];
                }
            }
        }

        // Insert remaining data
        if (!empty($batchData)) {
            DB::table('overmate')->insert($batchData);
        }

        fclose($file);

        $this->command->info('Overmate data seeded successfully!');
    }
}
