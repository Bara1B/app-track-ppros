<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            $table->dropColumn('id_number'); // Perintah untuk hapus kolom
        });
    }

    public function down(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            $table->string('id_number')->unique()->after('wo_number'); // Perintah untuk mengembalikan jika perlu
        });
    }
};
