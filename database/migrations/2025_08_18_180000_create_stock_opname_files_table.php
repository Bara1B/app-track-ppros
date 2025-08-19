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
        Schema::create('stock_opname_files', function (Blueprint $table) {
            $table->id();
            $table->string('filename'); // Generated filename
            $table->string('original_name'); // Original Excel filename
            $table->string('file_path'); // Storage path
            $table->bigInteger('file_size'); // File size in bytes
            $table->unsignedBigInteger('uploaded_by')->nullable(); // User ID
            $table->enum('status', ['uploaded', 'imported', 'deleted'])->default('uploaded');
            $table->timestamp('imported_at')->nullable();
            $table->timestamps();

            $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('set null');
        });

        // Add file_id to stock_opnames table
        Schema::table('stock_opnames', function (Blueprint $table) {
            $table->unsignedBigInteger('file_id')->nullable()->after('id');
            $table->foreign('file_id')->references('id')->on('stock_opname_files')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stock_opnames', function (Blueprint $table) {
            $table->dropForeign(['file_id']);
            $table->dropColumn('file_id');
        });

        Schema::dropIfExists('stock_opname_files');
    }
};

