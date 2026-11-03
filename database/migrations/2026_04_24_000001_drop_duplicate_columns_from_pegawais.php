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
            // Drop duplicate string columns
            $table->dropColumn([
                'golongan',
                'pendidikan',
                'status_asn',
                'unit_kerja_satu',
                'unit_kerja_2',
                'unit_kerja_3',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pegawais', function (Blueprint $table) {
            // Restore columns if needed
            $table->string('golongan', 10)->after('tmt_golongan');
            $table->string('pendidikan', 50)->after('thn_lulus');
            $table->string('status_asn', 50)->after('jenjang_pendidikan_id');
            $table->string('unit_kerja_satu', 100)->after('unit_kerja_3_id');
            $table->string('unit_kerja_2', 100)->nullable()->after('unit_kerja_satu');
            $table->string('unit_kerja_3', 100)->nullable()->after('unit_kerja_2');
        });
    }
};
