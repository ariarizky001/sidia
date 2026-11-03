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
            // Rename columns from unit_kerja_satu to unit_kerja_1
            $table->renameColumn('unit_kerja_satu_id', 'unit_kerja_1_id');
            $table->renameColumn('unit_kerja_satu', 'unit_kerja_1');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pegawais', function (Blueprint $table) {
            // Rename back to old names
            $table->renameColumn('unit_kerja_1_id', 'unit_kerja_satu_id');
            $table->renameColumn('unit_kerja_1', 'unit_kerja_satu');
        });
    }
};
