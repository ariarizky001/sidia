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
            // Tambah kolom formasi_jabatan jika belum ada
            if (!Schema::hasColumn('pegawais', 'formasi_jabatan')) {
                $table->enum('formasi_jabatan', ['guru_kelas_sd', 'guru_penjas_sd', 'guru_agama_sd'])
                      ->nullable()
                      ->after('unit_kerja_id')
                      ->comment('Tipe guru: guru_kelas_sd | guru_penjas_sd | guru_agama_sd');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pegawais', function (Blueprint $table) {
            if (Schema::hasColumn('pegawais', 'formasi_jabatan')) {
                $table->dropColumn('formasi_jabatan');
            }
        });
    }
};
