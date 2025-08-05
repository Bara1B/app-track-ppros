<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MasterProduct;
use Illuminate\Support\Facades\DB;

class MasterProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('master_products')->truncate();

        $csvFile = fopen(database_path("seeders/master_products.csv"), "r");

        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ";")) !== FALSE) {
            // ==== PERUBAHAN DI SINI ====
            // Hanya proses baris jika bukan baris pertama DAN jika kolom item_number (data[0])
            // dan kode (data[1]) tidak kosong.
            if (!$firstline && !empty($data[0]) && !empty($data[1])) {
                MasterProduct::create([
                    "item_number" => $data[0],
                    "kode"        => $data[1],
                    "description" => $data[2] ?? '', // Gunakan ?? '' untuk kolom yang boleh kosong
                    "uom"         => $data[3] ?? '',
                    "group"       => $data[4] ?? ''
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}
