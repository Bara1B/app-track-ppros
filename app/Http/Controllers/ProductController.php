<?php

namespace App\Http\Controllers;

use App\Models\WorkOrder;
use App\Models\MasterProduct;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function store(Request $request, WorkOrder $workOrder)
    {
        $validated = $request->validate([
            'master_product_id' => 'required|exists:master_products,id',
            'qty_required' => 'required|numeric|min:0',
        ]);

        $masterProduct = MasterProduct::find($validated['master_product_id']);

        // Simpan ke tabel 'products' yang terhubung dengan Work Order
        $workOrder->products()->create([
            'item_number' => $masterProduct->item_number,
            'description' => $masterProduct->description,
            'qty_required' => $validated['qty_required'],
            'uom' => $masterProduct->uom,
        ]);

        return back()->with('product_success', 'Komponen berhasil ditambahkan.');
    }
}
