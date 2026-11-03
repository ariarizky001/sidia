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
        Schema::table('jenjang_pendidikans', function (Blueprint $table) {
            // Add kode column after id if not exists
            if (!Schema::hasColumn('jenjang_pendidikans', 'kode')) {
                $table->string('kode', 10)->unique()->after('id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jenjang_pendidikans', function (Blueprint $table) {
            if (Schema::hasColumn('jenjang_pendidikans', 'kode')) {
                $table->dropColumn('kode');
            }
        });
    }
};
