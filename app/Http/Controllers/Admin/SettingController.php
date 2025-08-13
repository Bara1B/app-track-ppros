<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

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
}
