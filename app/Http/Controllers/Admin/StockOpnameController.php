<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StockOpname;
use App\Models\Overmate;
use App\Models\StockOpnameFile;
use App\Imports\StockOpnameImport;
use App\Exports\StockOpnameTemplateExport;
use App\Exports\StockOpnameFilledExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Helpers\NotificationHelper;

class StockOpnameController extends Controller
{
    /**
     * Menampilkan halaman utama Stock Opname dengan list file yang sudah diupload.
     */
    public function index()
    {
        $uploadedFiles = StockOpnameFile::where('status', '!=', 'deleted')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.stock_opname.index', compact('uploadedFiles'));
    }

    /**
     * Menampilkan data stock opname untuk file tertentu.
     */
    public function showData($fileId)
    {
        $stockOpnameFile = StockOpnameFile::findOrFail($fileId);

        $stockOpnames = DB::table('stock_opnames')
            ->leftJoin('overmate', 'stock_opnames.item_number', '=', 'overmate.item_number')
            ->select(
                'stock_opnames.*',
                'overmate.overmate_qty',
                DB::raw('COALESCE(stock_opnames.stok_fisik, 0) - COALESCE(stock_opnames.quantity_on_hand, 0) as selisih'),
                DB::raw('CASE WHEN (COALESCE(stock_opnames.stok_fisik, 0) - COALESCE(stock_opnames.quantity_on_hand, 0)) > COALESCE(overmate.overmate_qty, 0) THEN "Tidak" ELSE "Iya" END as masuk_kategori')
            )
            ->where('stock_opnames.file_id', $fileId)
            ->orderBy('stock_opnames.created_at', 'desc')
            ->paginate(15);

        return view('stock_opname.data', compact('stockOpnames', 'stockOpnameFile'));
    }

    /**
     * Menampilkan form upload Excel.
     */
    public function create()
    {
        // Upload form is integrated into the admin index page
        return redirect()->route('admin.stock-opname.index');
    }

    /**
     * Import data dari file Excel (.xlsx).
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:10240', // Max 10MB
        ]);

        try {
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $filename = 'stock_opname_' . time() . '_' . $originalName;
            $filePath = $file->storeAs('stock_opname', $filename, 'public');

            // Save file record
            $stockOpnameFile = StockOpnameFile::create([
                'filename' => $filename,
                'original_name' => $originalName,
                'file_path' => $filePath,
                'file_size' => $file->getSize(),
                'uploaded_by' => Auth::id(),
                'status' => 'uploaded',
            ]);

            NotificationHelper::success('File Excel berhasil diupload! Silakan klik "Import Data" untuk memproses file.');
            return redirect()->route('admin.stock-opname.index');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat upload: ' . $e->getMessage());
        }
    }

    /**
     * Import data dari file yang sudah diupload.
     */
    public function importData($fileId)
    {
        try {
            $stockOpnameFile = StockOpnameFile::findOrFail($fileId);

            if ($stockOpnameFile->status !== 'uploaded') {
                return redirect()->route('admin.stock-opname.index')
                    ->with('error', 'File sudah diimport atau tidak valid.');
            }

            // Truncate existing data for this file
            StockOpname::where('file_id', $fileId)->delete();

            // Import data from stored file
            $filePath = storage_path('app/public/' . $stockOpnameFile->file_path);
            Excel::import(new StockOpnameImport($stockOpnameFile->id), $filePath);

            // Update file status
            $stockOpnameFile->update([
                'status' => 'imported',
                'imported_at' => now(),
            ]);

            NotificationHelper::imported('Data dari file: ' . $stockOpnameFile->original_name);
            return redirect()->route('admin.stock-opname.show-data', $fileId);
        } catch (\Exception $e) {
            return redirect()->route('admin.stock-opname.index')
                ->with('error', 'Terjadi kesalahan saat import: ' . $e->getMessage());
        }
    }

    /**
     * Update stok fisik untuk item tertentu.
     */
    public function updateStokFisik(Request $request, $id)
    {
        $request->validate([
            'stok_fisik' => 'required|numeric|min:0',
        ]);

        try {
            $stockOpname = StockOpname::findOrFail($id);
            $stockOpname->update([
                'stok_fisik' => $request->stok_fisik
            ]);

            NotificationHelper::updated('Stok fisik');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat update stok fisik: ' . $e->getMessage());
        }
    }

    /**
     * Download template Excel untuk Stock Opname.
     */
    public function downloadTemplate()
    {
        $fileName = 'Template_Stock_Opname_' . date('Y-m-d_H-i-s') . '.xlsx';
        return Excel::download(new StockOpnameTemplateExport, $fileName);
    }

    /**
     * Export data stock opname yang sudah terisi sesuai template (filled).
     */
    public function exportData($fileId)
    {
        $stockOpnameFile = StockOpnameFile::findOrFail($fileId);

        $safeName = pathinfo($stockOpnameFile->original_name, PATHINFO_FILENAME);
        $fileName = 'Stock_Opname_Filled_' . $safeName . '_' . date('Y-m-d_H-i-s') . '.xlsx';

        return Excel::download(new StockOpnameFilledExport($fileId), $fileName);
    }

    /**
     * Hapus file stock opname.
     */
    public function deleteFile($fileId)
    {
        try {
            $stockOpnameFile = StockOpnameFile::findOrFail($fileId);

            // Hapus data stock opname yang terkait dengan file ini
            StockOpname::where('file_id', $fileId)->delete();

            // Hapus file fisik dari storage
            if (Storage::disk('public')->exists($stockOpnameFile->file_path)) {
                Storage::disk('public')->delete($stockOpnameFile->file_path);
            }

            // Hapus record file dari database
            $stockOpnameFile->delete();

            NotificationHelper::deleted('File: ' . $stockOpnameFile->original_name);
            return redirect()->route('admin.stock-opname.index');
        } catch (\Exception $e) {
            return redirect()->route('admin.stock-opname.index')
                ->with('error', 'Terjadi kesalahan saat hapus file: ' . $e->getMessage());
        }
    }
}
