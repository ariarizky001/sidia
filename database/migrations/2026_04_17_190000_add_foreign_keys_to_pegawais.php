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
            // Add new foreign key columns
            $table->unsignedBigInteger('golongan_id')->nullable()->after('tmt_golongan');
            $table->unsignedBigInteger('status_asn_id')->nullable()->after('thn_lulus');
            $table->unsignedBigInteger('jenjang_pendidikan_id')->nullable()->after('status_asn_id');
            $table->unsignedBigInteger('unit_kerja_satu_id')->nullable()->after('jenjang_pendidikan_id');
            $table->unsignedBigInteger('unit_kerja_2_id')->nullable()->after('unit_kerja_satu_id');
            $table->unsignedBigInteger('unit_kerja_3_id')->nullable()->after('unit_kerja_2_id');
        });

        Schema::table('pegawais', function (Blueprint $table) {
            // Add foreign key constraints
            $table->foreign('golongan_id')->references('id')->on('golongans')->onDelete('set null');
            $table->foreign('status_asn_id')->references('id')->on('status_asns')->onDelete('set null');
            $table->foreign('jenjang_pendidikan_id')->references('id')->on('jenjang_pendidikans')->onDelete('set null');
            $table->foreign('unit_kerja_satu_id')->references('id')->on('unit_kerjas')->onDelete('set null');
            $table->foreign('unit_kerja_2_id')->references('id')->on('unit_kerjas')->onDelete('set null');
            $table->foreign('unit_kerja_3_id')->references('id')->on('unit_kerjas')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pegawais', function (Blueprint $table) {
            // Drop foreign keys
            $table->dropForeign('pegawais_golongan_id_foreign');
            $table->dropForeign('pegawais_status_asn_id_foreign');
            $table->dropForeign('pegawais_jenjang_pendidikan_id_foreign');
            $table->dropForeign('pegawais_unit_kerja_satu_id_foreign');
            $table->dropForeign('pegawais_unit_kerja_2_id_foreign');
            $table->dropForeign('pegawais_unit_kerja_3_id_foreign');
        });

        Schema::table('pegawais', function (Blueprint $table) {
            // Drop columns
            $table->dropColumn([
                'golongan_id',
                'status_asn_id',
                'jenjang_pendidikan_id',
                'unit_kerja_satu_id',
                'unit_kerja_2_id',
                'unit_kerja_3_id',
            ]);
        });
    }
};
