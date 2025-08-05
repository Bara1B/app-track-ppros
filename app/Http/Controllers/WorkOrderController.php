<?php

namespace App\Http\Controllers;

use App\Models\WorkOrder;
use App\Models\WorkOrderTracking; // <-- Jangan lupa import class ini
use Illuminate\Http\Request;
use App\Models\MasterProduct;


class WorkOrderController extends Controller
{
    // Method show() yang sudah ada ...
    public function show(WorkOrder $workOrder)
    {
        $workOrder->load(['products', 'tracking']);

        // Ambil semua master produk untuk dropdown form
        $masterProducts = MasterProduct::orderBy('description')->get();

        return view('tracking.show', compact('workOrder', 'masterProducts'));
    }

    // Method create() yang sudah ada ...
    public function create()
    {
        // Ambil semua produk buat ditampilin di dropdown
        $products = MasterProduct::orderBy('kode')->get();

        // Pastikan 'products' ada di dalam compact()
        return view('work_orders.create', compact('products'));
    }

    // Jangan lupa tambahkan ini di atas jika belum ada

    public function edit(WorkOrder $workOrder)
    {
        // Ambil semua produk dari master
        $products = MasterProduct::orderBy('kode')->get();

        // Kirim data WO dan data produk ke view
        return view('work_orders.edit', compact('workOrder', 'products'));
    }

    public function update(Request $request, WorkOrder $workOrder)
    {
        $validated = $request->validate([
            'product_kode' => 'required|string|exists:master_products,kode', // Validasi kode produk
            'due_date'     => 'required|date',
        ]);

        // Cari nama produk (description) berdasarkan kode yang dipilih
        $product = MasterProduct::where('kode', $validated['product_kode'])->firstOrFail();

        // HATI-HATI: Kita TIDAK mengubah nomor WO. Kita hanya update output & due date.
        $workOrder->update([
            'output' => $product->description,
            'due_date' => $validated['due_date'],
        ]);

        return redirect()->route('dashboard')->with('success', 'Work Order berhasil di-update!');
    }

    public function destroy(WorkOrder $workOrder)
    {
        $workOrder->delete();
        return redirect()->route('dashboard')->with('success', 'Work Order berhasil dihapus!');
    }

    // Method store() yang sudah ada ...
    public function store(Request $request)
    {
        // 1. Validasi input baru dari form
        $validated = $request->validate([
            'product_kode' => 'required|string|exists:master_products,kode',
            'sequence'     => 'required|string|digits:3',
            'output'       => 'required|string',
            'due_date'     => 'required|date',
        ]);

        // Ambil data produk dari master
        $product = \App\Models\MasterProduct::where('kode', $validated['product_kode'])->firstOrFail();

        // 2. Buat nomor WO di backend buat mastiin datanya bener
        $year = '86';
        $suffix = substr($product->item_number, -1);
        $woNumber = $year . $validated['product_kode'] . $validated['sequence'] . $suffix;

        // 3. Cek lagi kalo nomor WO ini udah ada, biar makin aman
        $isExist = \App\Models\WorkOrder::where('wo_number', $woNumber)->exists();
        if ($isExist) {
            return back()->withInput()->withErrors(['sequence' => 'Kombinasi produk dan nomor urut ini sudah ada.']);
        }

        // 4. Simpan data Work Order utama
        $workOrder = WorkOrder::create([
            'wo_number' => $woNumber,
            'output' => $validated['output'],
            'due_date' => $validated['due_date'],
            'status' => 'On Progress',
        ]);

        // 5. Buat timeline tracking awal
        $trackingSteps = [
            'WO Diterima', 'Timbang', 'Selesai Timbang', 'Pengurangan Stock',
            'Released', 'Kirim BB', 'Selesai',
        ];

        foreach ($trackingSteps as $step) {
            $workOrder->tracking()->create([
                'status_name' => $step,
                'completed_at' => null,
            ]);
        }

        // 6. Redirect ke halaman detail
        return redirect()->route('work-order.show', $workOrder)
            ->with('success', 'Work Order berhasil dibuat! Sekarang tambahkan komponen produk.');
    }

    // TAMBAHKAN METHOD INI DI BAWAHNYA
    /**
     * Memverifikasi dan menyelesaikan satu langkah tracking.
     */
    public function completeStep(WorkOrderTracking $tracking)
    {
        // 1. Update kolom 'completed_at' dengan waktu saat ini
        $tracking->update(['completed_at' => now()]);

        // 2. Cek apakah semua langkah sudah selesai
        $workOrder = $tracking->workOrder;
        $allStepsCompleted = $workOrder->tracking()->whereNull('completed_at')->doesntExist();

        if ($allStepsCompleted) {
            $workOrder->update(['status' => 'Completed']);
        }

        // 3. Kembali ke halaman tracking dengan pesan sukses
        return back()->with('success', "Status '{$tracking->status_name}' berhasil diverifikasi!");
    }
}
