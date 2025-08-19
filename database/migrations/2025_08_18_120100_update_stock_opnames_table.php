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
        Schema::dropIfExists('stock_opnames');

        Schema::create('stock_opnames', function (Blueprint $table) {
            $table->id();
            $table->string('location_system');
            $table->string('item_number');
            $table->string('description');
            $table->string('manufacturer');
            $table->string('lot_serial');
            $table->string('reference');
            $table->integer('quantity_on_hand');
            $table->string('unit_of_measure');
            $table->date('expired_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_opnames');

        // Restore previous structure
        Schema::create('stock_opnames', function (Blueprint $table) {
            $table->id();
            $table->string('location_system');
            $table->string('item_number');
            $table->string('nama_bahan');
            $table->decimal('overmate_qty', 10, 5);
            $table->decimal('physical_stock', 10, 5);
            $table->timestamps();
        });
    }
};

