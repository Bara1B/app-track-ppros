<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OvermateMaster;
use Illuminate\Support\Facades\DB;

class OvermateMasterSeeder extends Seeder
{
    public function run(): void
    {
        // Kosongin tabel dulu biar ga dobel
        DB::table('overmate_masters')->truncate();

        // Buka file CSV-nya
        $csvFile = fopen(database_path("seeders/overmate_masters.csv"), "r");

        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ";")) !== FALSE) { // Pake titik koma (;)
            if (!$firstline) {
                $itemNumber   = trim($data[0] ?? '');
                $namaBahan    = trim($data[1] ?? '');
                $manufacturer = trim($data[2] ?? '');
                $lotSerial    = trim($data[3] ?? '');
                $overmateStr  = trim($data[4] ?? '0');
                $uom          = trim($data[5] ?? '');

                if ($itemNumber === '' || $lotSerial === '') {
                    $firstline = false;
                    continue;
                }

                $overmate = (float) str_replace(',', '.', $overmateStr);

                OvermateMaster::updateOrCreate(
                    [
                        'item_number'  => $itemNumber,
                        'manufacturer' => $manufacturer,
                        'lot_serial'   => $lotSerial,
                    ],
                    [
                        'nama_bahan' => $namaBahan,
                        'overmate'   => $overmate,
                        'uom'        => $uom,
                    ]
                );
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}
