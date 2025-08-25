<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('overmate', function (Blueprint $table) {
            if (!Schema::hasColumn('overmate', 'nama_bahan')) {
                $table->string('nama_bahan')->after('item_number');
            }
            if (!Schema::hasColumn('overmate', 'manufactur')) {
                $table->string('manufactur')->after('nama_bahan');
            }
        });
    }

    public function down()
    {
        Schema::table('overmate', function (Blueprint $table) {
            $table->dropColumn(['nama_bahan', 'manufactur']);
        });
    }
};
