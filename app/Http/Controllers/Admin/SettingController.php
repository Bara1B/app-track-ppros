<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class SettingController extends Controller
{
    public function edit()
    {
        $prefix = Setting::firstOrCreate(['key' => 'wo_year_prefix'], ['value' => '86']);
        return view('admin.settings.edit', ['prefix' => $prefix]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'wo_year_prefix' => 'required|string|max:4',
        ]);

        Setting::updateOrCreate(
            ['key' => 'wo_year_prefix'],
            ['value' => $data['wo_year_prefix']]
        );

        return redirect()->route('settings.edit')->with('success', 'Prefix tahun WO berhasil disimpan.');
    }

    public function reset(Request $request)
    {
        // Validasi konfirmasi pengetikan kata HAPUS
        $validated = $request->validate([
            'confirm' => 'required|in:HAPUS',
        ], [
            'confirm.in' => 'Ketik HAPUS untuk mengkonfirmasi.',
        ]);

        // Jalankan migrasi ulang dan seed ulang (full reset)
        Artisan::call('migrate:fresh', ['--force' => true]);
        Artisan::call('db:seed', ['--force' => true]);

        return redirect()->route('settings.edit')->with('success', 'Semua tabel telah direset (migrate:fresh + seed).');
    }
}
