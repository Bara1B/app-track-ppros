<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StockOpname;
use App\Models\OvermateMaster; // <-- Tambahin ini
use Illuminate\Http\Request;

class StockOpnameController extends Controller
{
    /**
     * Menampilkan halaman utama Stock Opname.
     */
    public function index()
    {
        $stockOpnames = StockOpname::latest()->paginate(15);
        return view('admin.stock_opname.index', compact('stockOpnames'));
    }

    /**
     * Menampilkan form untuk input data Stock Opname baru.
     */
    public function create()
    {
        // Ambil semua data dari "kamus" overmate buat ditampilin di dropdown
        $overmateMasters = OvermateMaster::orderBy('item_number')->get();
        return view('admin.stock_opname.create', compact('overmateMasters'));
    }

    /**
     * Menyimpan data Stock Opname baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'location_system'   => 'required|string|max:255',
            'overmate_master_id' => 'required|exists:overmate_masters,id',
            'physical_stock'    => 'required|numeric',
        ]);

        // Ambil detail data dari "kamus"
        $masterData = OvermateMaster::findOrFail($validated['overmate_master_id']);

        StockOpname::create([
            'location_system' => $validated['location_system'],
            'item_number'     => $masterData->item_number,
            'nama_bahan'      => $masterData->nama_bahan,
            'overmate_qty'    => $masterData->overmate,
            'physical_stock'  => $validated['physical_stock'],
        ]);

        return redirect()->route('stock-opname.index')->with('success', 'Data stock opname berhasil disimpan.');
    }

    public function getOvermateDetails(OvermateMaster $master)
    {
        return response()->json([
            'nama_bahan' => $master->nama_bahan,
            'overmate' => $master->overmate,
        ]);
    }
}
