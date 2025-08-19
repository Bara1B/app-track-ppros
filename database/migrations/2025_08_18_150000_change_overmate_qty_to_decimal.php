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
            $table->decimal('overmate_qty', 10, 5)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('overmate', function (Blueprint $table) {
            $table->integer('overmate_qty')->change();
        });
    }
};

