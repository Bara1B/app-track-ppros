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
        Schema::create('overmate_masters', function (Blueprint $table) {
            $table->id();
            $table->string('item_number');
            $table->string('nama_bahan');
            $table->string('manufacturer');
            $table->string('lot_serial');
            $table->decimal('overmate', 10, 5);
            $table->string('uom'); // Unit of Measure (Tara)
            $table->timestamps();
            // Bikin kombinasi unik biar datanya ga dobel
            $table->unique(['item_number', 'manufacturer', 'lot_serial']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('overmate_masters');
    }
};
