<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasterProduct;

class WorkOrderDataController extends Controller
{
    public function index(Request $request)
    {
        $query = MasterProduct::query();

        // Simple filters
        if ($request->filled('item_number')) {
            $query->where('item_number', 'like', '%' . $request->item_number . '%');
        }
        if ($request->filled('kode')) {
            $query->where('kode', 'like', '%' . $request->kode . '%');
        }
        if ($request->filled('description')) {
            $query->where('description', 'like', '%' . $request->description . '%');
        }

        $products = $query
            ->orderByRaw('LENGTH(kode) ASC')
            ->orderBy('kode')
            ->orderBy('item_number')
            ->paginate(20)
            ->withQueryString();

        return view('work_orders.data', compact('products'));
    }

    public function import(Request $request)
    {
        abort(404, 'Upload dimatikan. Data Work Order diambil dari Master Product seeder.');
    }

    public function create()
    {
        return view('work_orders.data_create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_number' => ['required','string','max:255'],
            'kode'        => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'uom'         => ['nullable','string','max:50'],
            'group'       => ['nullable','string','max:100'],
        ]);

        MasterProduct::create($validated);

        return redirect()->route('work-orders.data.index')
            ->with('status', 'Master Product berhasil ditambahkan.');
    }

    public function destroy(MasterProduct $product)
    {
        $product->delete();
        return redirect()->back()->with('status', 'Master Product berhasil dihapus.');
    }

    public function edit(MasterProduct $product)
    {
        return view('work_orders.data_edit', compact('product'));
    }

    public function update(Request $request, MasterProduct $product)
    {
        $validated = $request->validate([
            'item_number' => ['required','string','max:255'],
            'kode'        => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'uom'         => ['nullable','string','max:50'],
            'group'       => ['nullable','string','max:100'],
        ]);

        $product->update($validated);

        return redirect()->route('work-orders.data.index')
            ->with('status', 'Master Product berhasil diperbarui.');
    }
}
