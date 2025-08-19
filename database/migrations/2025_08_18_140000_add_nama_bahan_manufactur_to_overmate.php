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
            $table->string('nama_bahan')->nullable()->after('item_number');
            $table->string('manufactur')->nullable()->after('nama_bahan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('overmate', function (Blueprint $table) {
            $table->dropColumn(['nama_bahan', 'manufactur']);
        });
    }
};

