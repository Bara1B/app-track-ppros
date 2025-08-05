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
        Schema::create('work_orders', function (Blueprint $table) {
            $table->id();
            $table->string('wo_number')->unique(); // Contoh: 8004028T
            $table->string('id_number')->unique();   // Contoh: 812424
            $table->string('output')->nullable();    // Contoh: gbn
            $table->date('due_date');                // Dari gambar 1
            $table->string('status')->default('On Progress');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_orders');
    }
};
