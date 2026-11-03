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
        Schema::table('golongans', function (Blueprint $table) {
            if (!Schema::hasColumn('golongans', 'kode')) {
                $table->string('kode', 10)->unique()->after('id');
            }
            if (!Schema::hasColumn('golongans', 'urutan')) {
                $table->integer('urutan')->default(0)->after('nama_golongan');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('golongans', function (Blueprint $table) {
            if (Schema::hasColumn('golongans', 'kode')) {
                $table->dropColumn('kode');
            }
            if (Schema::hasColumn('golongans', 'urutan')) {
                $table->dropColumn('urutan');
            }
        });
    }
};
