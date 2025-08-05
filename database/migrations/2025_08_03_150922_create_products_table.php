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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke tabel work_orders
            $table->foreignId('work_order_id')->constrained()->onDelete('cascade');
            $table->string('item_number');        // Contoh: 14301003
            $table->text('description');          // Contoh: AIR MURNI
            $table->decimal('qty_required', 10, 3); // Contoh: 64.8
            $table->string('uom');                // Contoh: Lt, Kg
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
