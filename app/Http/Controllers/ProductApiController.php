<?php

namespace App\Http\Controllers;

use App\Models\MasterProduct;
use App\Models\WorkOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductApiController extends Controller
{
    /**
     * Mengambil detail produk berdasarkan KODE.
     * Digunakan untuk mengisi nama produk secara otomatis.
     */
    public function getProductDetail(string $kode)
    {
        $product = MasterProduct::where('kode', $kode)->first();

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        return response()->json($product);
    }

    /**
     * Menghitung nomor urut (sequence) WO berikutnya.
     */
    public function getNextSequence(string $kode)
    {
        $year = '96'; // Menggunakan tahun tetap '86' sesuai permintaan
        $prefix = $year . $kode;

        // Cari nomor WO terakhir dengan prefix yang sama
        $lastWo = WorkOrder::where('wo_number', 'like', $prefix . '%')
            ->orderBy('wo_number', 'desc')
            ->first();

        $nextSequence = 1;
        if ($lastWo) {
            // Ambil 3 angka urutan dari nomor WO, misal dari '86002058T' ambil '058'
            $lastSequence = (int)substr($lastWo->wo_number, 5, 3);
            $nextSequence = $lastSequence + 1;
        }

        // Format menjadi 3 digit dengan angka nol di depan (e.g., 1 -> "001")
        return response()->json([
            'sequence' => str_pad($nextSequence, 3, '0', STR_PAD_LEFT)
        ]);
    }
}
