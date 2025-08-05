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
        Schema::create('master_products', function (Blueprint $table) {
            $table->id();
            $table->string('item_number')->unique();
            $table->string('kode')->unique(); // Kolom 'KODE' dari Excel
            $table->string('description');    // Kolom 'Description' (Nama Produk)
            $table->string('uom');            // Kolom 'Unit of Measure'
            $table->string('group');          // Kolom 'Group'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_products');
    }
};
