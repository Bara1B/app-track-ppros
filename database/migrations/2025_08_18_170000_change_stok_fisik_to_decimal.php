<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('stock_opnames', function (Blueprint $table) {
            $table->decimal('stok_fisik_new', 15, 5)->nullable()->after('stok_fisik');
        });

        // Copy data from old column to new column
        DB::statement('UPDATE stock_opnames SET stok_fisik_new = stok_fisik');

        // Drop old column and rename new column
        Schema::table('stock_opnames', function (Blueprint $table) {
            $table->dropColumn('stok_fisik');
        });

        Schema::table('stock_opnames', function (Blueprint $table) {
            $table->renameColumn('stok_fisik_new', 'stok_fisik');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stock_opnames', function (Blueprint $table) {
            $table->integer('stok_fisik')->change();
        });
    }
};
