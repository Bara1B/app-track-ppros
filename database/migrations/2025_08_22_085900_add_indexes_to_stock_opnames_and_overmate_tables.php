<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // stock_opnames indexes
        Schema::table('stock_opnames', function (Blueprint $table) {
            // single and composite indexes to speed up filtering & joins
            $table->index('file_id', 'idx_stock_opnames_file_id');
            $table->index('item_number', 'idx_stock_opnames_item_number');
            $table->index('lot_serial', 'idx_stock_opnames_lot_serial');
            $table->index(['item_number', 'lot_serial'], 'idx_stock_opnames_item_lot');
        });

        // overmate_masters composite index
        if (Schema::hasTable('overmate_masters')) {
            Schema::table('overmate_masters', function (Blueprint $table) {
                $table->index(['item_number', 'lot_serial'], 'idx_overmate_masters_item_lot');
            });
        }

        // overmate single index
        if (Schema::hasTable('overmate')) {
            Schema::table('overmate', function (Blueprint $table) {
                $table->index('item_number', 'idx_overmate_item_number');
            });
        }
    }

    public function down(): void
    {
        Schema::table('stock_opnames', function (Blueprint $table) {
            $table->dropIndex('idx_stock_opnames_file_id');
            $table->dropIndex('idx_stock_opnames_item_number');
            $table->dropIndex('idx_stock_opnames_lot_serial');
            $table->dropIndex('idx_stock_opnames_item_lot');
        });

        if (Schema::hasTable('overmate_masters')) {
            Schema::table('overmate_masters', function (Blueprint $table) {
                $table->dropIndex('idx_overmate_masters_item_lot');
            });
        }

        if (Schema::hasTable('overmate')) {
            Schema::table('overmate', function (Blueprint $table) {
                $table->dropIndex('idx_overmate_item_number');
            });
        }
    }
};
