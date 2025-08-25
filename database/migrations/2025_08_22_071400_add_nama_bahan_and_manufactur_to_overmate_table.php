<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('overmate', function (Blueprint $table) {
            if (!Schema::hasColumn('overmate', 'nama_bahan')) {
                $table->string('nama_bahan')->nullable()->after('item_number');
            }
            if (!Schema::hasColumn('overmate', 'manufactur')) {
                $table->string('manufactur')->nullable()->after('nama_bahan');
            }
            // Ensure overmate_qty decimal if needed (keep as is if already integer)
            // $table->decimal('overmate_qty', 15, 5)->change(); // Uncomment if you want decimal
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('overmate', function (Blueprint $table) {
            if (Schema::hasColumn('overmate', 'manufactur')) {
                $table->dropColumn('manufactur');
            }
            if (Schema::hasColumn('overmate', 'nama_bahan')) {
                $table->dropColumn('nama_bahan');
            }
        });
    }
};
