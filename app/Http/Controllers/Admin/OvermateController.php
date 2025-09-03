<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Overmate;
use Illuminate\Http\Request;

class OvermateController extends Controller
{
    /**
     * Menampilkan daftar data overmate.
     */
    public function index(Request $request)
    {
        $query = Overmate::query();

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('item_number', 'like', "%{$search}%")
                    ->orWhere('nama_bahan', 'like', "%{$search}%")
                    ->orWhere('manufactur', 'like', "%{$search}%");
            });
        }

        // Filter by item number
        if ($request->has('item_number') && !empty($request->item_number)) {
            $query->where('item_number', $request->item_number);
        }

        // Filter by manufacturer
        if ($request->has('manufactur') && !empty($request->manufactur)) {
            $query->where('manufactur', 'like', "%{$request->manufactur}%");
        }

        $overmates = $query->orderBy('item_number')
            ->orderBy('nama_bahan')
            ->paginate(20);

        // Get unique item numbers and manufacturers for filters
        $itemNumbers = Overmate::distinct()->pluck('item_number')->sort();
        $manufacturers = Overmate::distinct()->pluck('manufactur')->sort();

        return view('overmate.index', compact('overmates', 'itemNumbers', 'manufacturers'));
    }

    /**
     * Menampilkan detail overmate berdasarkan item number.
     */
    public function show(Overmate $overmate)
    {
        $itemNumber = $overmate->item_number;
        $overmates = Overmate::where('item_number', $itemNumber)
            ->orderBy('manufactur')
            ->get();

        if ($overmates->isEmpty()) {
            abort(404, 'Item number tidak ditemukan');
        }

        return view('overmate.show', compact('overmates', 'itemNumber'));
    }

    /**
     * Form tambah Overmate.
     */
    public function create()
    {
        return view('overmate.create');
    }

    /**
     * Simpan Overmate baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_number'  => ['required', 'string', 'max:255'],
            'nama_bahan'   => ['required', 'string', 'max:255'],
            'manufactur'   => ['required', 'string', 'max:255'],
            'overmate_qty' => ['required', 'numeric'],
        ]);

        Overmate::create($validated);

        return redirect()
            ->route('overmate.index')
            ->with('status', 'Data overmate berhasil ditambahkan.');
    }

    /**
     * Hapus satu baris overmate (by id).
     */
    public function destroy(Overmate $overmate)
    {
        $overmate->delete();

        return redirect()
            ->back()
            ->with('status', 'Data overmate berhasil dihapus.');
    }

    /**
     * Form edit Overmate.
     */
    public function edit(Overmate $overmate)
    {
        return view('overmate.edit', compact('overmate'));
    }

    /**
     * Form edit Overmate by item_number.
     */
    public function editByItemNumber(string $itemNumber)
    {
        $overmate = Overmate::where('item_number', $itemNumber)->firstOrFail();
        return view('overmate.edit', compact('overmate'));
    }

    /**
     * Update Overmate.
     */
    public function update(Request $request, Overmate $overmate)
    {
        $validated = $request->validate([
            'item_number'  => ['required', 'string', 'max:255'],
            'nama_bahan'   => ['required', 'string', 'max:255'],
            'manufactur'   => ['required', 'string', 'max:255'],
            'overmate_qty' => ['required', 'numeric'],
        ]);

        $overmate->update($validated);

        return redirect()->route('overmate.index')
            ->with('status', 'Data overmate berhasil diperbarui.');
    }

    /**
     * Update Overmate by item_number.
     */
    public function updateByItemNumber(Request $request, string $itemNumber)
    {
        $overmate = Overmate::where('item_number', $itemNumber)->firstOrFail();

        $validated = $request->validate([
            'item_number'  => ['required', 'string', 'max:255'],
            'nama_bahan'   => ['required', 'string', 'max:255'],
            'manufactur'   => ['required', 'string', 'max:255'],
            'overmate_qty' => ['required', 'numeric'],
        ]);

        $overmate->update($validated);

        return redirect()->route('overmate.index')
            ->with('status', 'Data overmate berhasil diperbarui.');
    }
}
