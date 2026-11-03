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
        Schema::table('pegawais', function (Blueprint $table) {
            // Rename the column
            $table->renameColumn('unit_kerja_satu_id', 'unit_kerja_1_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pegawais', function (Blueprint $table) {
            // Rename back
            $table->renameColumn('unit_kerja_1_id', 'unit_kerja_satu_id');
        });
    }
};
