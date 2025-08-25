<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'wo_prefix',
                'value' => '86',
                'type' => 'string',
                'group' => 'wo',
                'description' => 'Prefix nomor awal untuk Work Order (contoh: 86 untuk WO-86-001)',
            ],
            [
                'key' => 'wo_tracking_enabled',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'wo',
                'description' => 'Mengaktifkan fitur tracking progress work order',
            ],
            [
                'key' => 'stock_opname_enabled',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'stock_opname',
                'description' => 'Mengaktifkan fitur stock opname dan inventory',
            ],
            [
                'key' => 'overmate_enabled',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'overmate',
                'description' => 'Mengaktifkan fitur overmate dan material management',
            ],
        ];

        foreach ($settings as $setting) {
            DB::table('settings')->updateOrInsert(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
