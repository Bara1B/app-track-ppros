<?php

namespace App\Http\Controllers;

use App\Models\WorkOrder;
use App\Models\WorkOrderTracking; // <-- Jangan lupa import class ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\MasterProduct;
use App\Helpers\NotificationHelper;


class WorkOrderController extends Controller
{
    // Method show() yang sudah ada ...
    public function show(WorkOrder $workOrder)
    {
        $workOrder->load(['products', 'tracking']);
        $masterProducts = MasterProduct::orderBy('description')->get();

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
            'due_date'     => 'required|date',
            'product_kode' => 'nullable|string|exists:master_products,kode',
        ]);

        $updateData = [
            'due_date' => $validated['due_date'],
        ];

        // Jika ada product_kode yang dikirim, ikut update output-nya
        if (!empty($validated['product_kode'])) {
            $product = MasterProduct::where('kode', $validated['product_kode'])->firstOrFail();
            $updateData['output'] = $product->description;
        }

        $workOrder->update($updateData);

        NotificationHelper::updated('Work Order');
        return redirect(route('dashboard'));
    }

    public function destroy(WorkOrder $workOrder)
    {
        $workOrder->delete();
        NotificationHelper::deleted('Work Order');
        return redirect(route('dashboard'));
    }

    // Method store() yang sudah ada ...
    public function store(Request $request)
    {
        // 1. Validasi input baru dari form
        $validated = $request->validate([
            'product_kode' => 'required|string|exists:master_products,kode',
            'sequence'     => 'required|integer|min:1|max:999',
            'output'       => 'required|string',
            'due_date'     => 'required|date',
        ]);

        // Ambil data produk dari master
        $product = \App\Models\MasterProduct::where('kode', $validated['product_kode'])->firstOrFail();

        // 2. Prefix tahun untuk nomor WO bisa diubah via setting UI
        $prefix = \App\Models\Setting::getValue('wo_prefix', '86');
        $suffix = substr($product->item_number, -1);
        $paddedSequence = str_pad((string) $validated['sequence'], 3, '0', STR_PAD_LEFT);
        $woNumber = $prefix . $validated['product_kode'] . $paddedSequence . $suffix;

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
            'WO Diterima',
            'Mulai Timbang',
            'Selesai Timbang',
            'Potong Stock',
            'Released',
            'Kirim BB',
            'Kirim CPB/WO',
        ];

        foreach ($trackingSteps as $step) {
            $workOrder->tracking()->create([
                'status_name' => $step,
                'completed_at' => ($step === 'WO Diterima') ? now() : null,
            ]);
        }

        // 6. Redirect ke halaman detail
        NotificationHelper::created('Work Order');
        return redirect()->route('work-order.show', $workOrder);
    }

    // TAMBAHKAN METHOD INI DI BAWAHNYA
    /**
     * Memverifikasi dan menyelesaikan satu langkah tracking.
     */
    // app/Http/Controllers/WorkOrderController.php

    public function completeStep(Request $request, WorkOrderTracking $tracking)
    {
        Log::info('--- MEMULAI PROSES VERIFIKASI UNTUK TRACKING ID: ' . $tracking->id . ' ---');

        // Validasi data
        $validated = $request->validate([
            'completed_date' => 'required|date',
            'notes'          => 'nullable|string|max:255',
        ]);

        Log::info('Data yang akan di-update:', $validated);

        try {
            Log::info('Mencoba menjalankan $tracking->update()...');

            // Perintah untuk update database
            // Map completed_date (input form) ke kolom completed_at di database
            $tracking->update([
                'completed_at' => $validated['completed_date'],
                'notes' => $validated['notes'] ?? null,
            ]);

            Log::info('Perintah update BERHASIL dijalankan tanpa error.');

            // LANGKAH KRITIS: Kita baca lagi datanya langsung dari database setelah update
            $dataTerbaru = WorkOrderTracking::find($tracking->id);
            Log::info('Verifikasi data langsung dari DB. Kolom "notes" sekarang berisi: "' . $dataTerbaru->notes . '" dan "completed_at" berisi: "' . $dataTerbaru->completed_at . '"');
        } catch (\Exception $e) {
            Log::info('!!! TERJADI ERROR SAAT PROSES UPDATE !!!');
            Log::info($e->getMessage());
        }

        $workOrder = $tracking->workOrder;
        $allStepsCompleted = $workOrder->tracking()->whereNull('completed_at')->doesntExist();

        if ($allStepsCompleted) {
            Log::info('Semua langkah selesai, mengupdate status Work Order utama.');
            $workOrder->update([
                'status' => 'Completed',
                'completed_on' => $validated['completed_date']
            ]);
        }

        Log::info('--- PROSES SELESAI, MENGARAHKAN KEMBALI KE BROWSER ---');

        // Handle AJAX request
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Status '{$tracking->status_name}' berhasil diverifikasi!"
            ]);
        }

        // Use manual close notification for verification
        session()->flash('success', "Status '{$tracking->status_name}' berhasil diverifikasi!");
        session()->flash('verification', true);
        return redirect()->to(url()->previous());
    }

    /**
     * Menampilkan form untuk membuat Work Order secara borongan (bulk).
     */
    public function bulkCreate()
    {
        $products = MasterProduct::orderBy('kode')->get();
        return view('work_orders.bulk-create', compact('products'));
    }

    /**
     * Menyimpan beberapa Work Order baru sekaligus.
     */
    public function bulkStore(Request $request)
    {
        $validated = $request->validate([
            'product_kode'   => 'required|string|exists:master_products,kode',
            'due_date'       => 'required|date',
            'start_sequence' => 'required|integer|min:1',
            'quantity'       => 'required|integer|min:1|max:50',
        ]);

        $product = MasterProduct::where('kode', $validated['product_kode'])->firstOrFail();
        $prefix = \App\Models\Setting::getValue('wo_prefix', '86');
        $suffix = substr($product->item_number, -1);

        $trackingSteps = [
            'WO Diterima',
            'Mulai Timbang',
            'Selesai Timbang',
            'Potong Stock',
            'Released',
            'Kirim BB',
            'Kirim CPB/WO',
        ];

        // Loop buat nge-generate WO sebanyak quantity, mulai dari nomor urut yang diinput
        for ($i = 0; $i < $validated['quantity']; $i++) {
            $newSequence = $validated['start_sequence'] + $i;
            $paddedSequence = str_pad($newSequence, 3, '0', STR_PAD_LEFT);
            $woNumber = $prefix . $validated['product_kode'] . $paddedSequence . $suffix;

            // Cek dulu biar ga ada nomor WO duplikat
            $isExist = WorkOrder::where('wo_number', $woNumber)->exists();
            if ($isExist) {
                // Kalo udah ada, kasih error dan stop prosesnya
                return back()->withInput()->withErrors(['start_sequence' => 'Nomor WO ' . $woNumber . ' sudah ada. Silakan mulai dari nomor urut lain.']);
            }

            $workOrder = WorkOrder::create([
                'wo_number' => $woNumber,
                'output' => $product->description,
                'due_date' => $validated['due_date'],
                'status' => 'On Progress',
            ]);

            // Bikin timeline tracking buat tiap WO
            foreach ($trackingSteps as $step) {
                $workOrder->tracking()->create([
                    'status_name' => $step,
                    'completed_at' => ($step === 'WO Diterima') ? now() : null,
                ]);
            }
        }

        NotificationHelper::success($validated['quantity'] . ' Work Order baru berhasil dibuat!');
        return redirect(route('dashboard'));
    }

    public function bulkDestroy(Request $request)
    {
        // Validasi kalo yang dikirim beneran ID
        $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'exists:work_orders,id',
        ]);

        // Hapus semua WO yang ID-nya ada di dalem list
        WorkOrder::whereIn('id', $request->ids)->delete();

        return redirect(route('dashboard'))->with('success', 'Work Order yang dipilih berhasil dihapus.');
    }

    public function bulkUpdateDueDate(Request $request)
    {
        $validated = $request->validate([
            'ids'          => 'required|array',
            'ids.*'        => 'exists:work_orders,id',
            'new_due_date' => 'required|date',
        ]);

        WorkOrder::whereIn('id', $validated['ids'])->update([
            'due_date' => $validated['new_due_date'],
        ]);

        return redirect(route('dashboard'))->with('success', 'Due date untuk Work Order yang dipilih berhasil di-update.');
    }

    public function updateTrackingDate(Request $request, WorkOrderTracking $tracking)
    {
        $validated = $request->validate([
            'completed_date' => 'required|date',
            'notes' => 'nullable|string|max:255',
        ]);

        $tracking->update([
            'completed_at' => $validated['completed_date'],
            'notes' => $validated['notes'] ?? $tracking->notes, // Keep existing notes if not provided
        ]);

        return redirect()->to(url()->previous() . '#track-' . $tracking->id)
            ->with('success', 'Data tracking untuk ' . $tracking->status_name . ' berhasil di-update.');
    }
}
