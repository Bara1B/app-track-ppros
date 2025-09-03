<?php

namespace App\Http\Controllers;

use App\Models\StockOpname;
use App\Models\StockOpnameFile;
use App\Exports\StockOpnameFilledExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class StockOpnameController extends Controller
{
    /**
     * Menampilkan halaman utama Stock Opname dengan list file yang sudah diupload.
     * Hanya untuk view, tidak bisa edit.
     */
    public function index()
    {
        $uploadedFiles = StockOpnameFile::where('status', '!=', 'deleted')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('stock_opname.index', compact('uploadedFiles'));
    }

    /**
     * Menampilkan data stock opname untuk file tertentu.
     * Hanya untuk view, tidak bisa edit.
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
     * Export data stock opname ke Excel.
     */
    public function exportData($fileId)
    {
        $stockOpnameFile = StockOpnameFile::findOrFail($fileId);

        $safeName = pathinfo($stockOpnameFile->original_name, PATHINFO_FILENAME);
        $fileName = 'Stock_Opname_Filled_' . $safeName . '_' . date('Y-m-d_H-i-s') . '.xlsx';

        return Excel::download(new StockOpnameFilledExport($fileId), $fileName);
    }
}
