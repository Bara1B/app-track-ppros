<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            // Ensure wo_number uniqueness handled in initial migration.
            // Add indexes for frequent filters
            $table->index('due_date');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            $table->dropIndex(['due_date']);
            $table->dropIndex(['status']);
        });
    }
};
