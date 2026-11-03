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
            // Drop old string columns - keep only ID columns
            $table->dropColumn([
                'golongan',
                'pendidikan',
                'status_asn',
                'unit_kerja_1',
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
            // Add back old string columns if rollback needed
            $table->string('golongan', 10)->nullable();
            $table->string('pendidikan', 50)->nullable();
            $table->string('status_asn', 50)->nullable();
            $table->string('unit_kerja_1', 100)->nullable();
            $table->string('unit_kerja_2', 100)->nullable();
            $table->string('unit_kerja_3', 100)->nullable();
        });
    }
};
