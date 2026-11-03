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
        Schema::create('rombels', function (Blueprint $table) {
            $table->id();
            $table->string('nama_rombel');
            $table->unsignedBigInteger('unit_kerja_parent_id')->nullable(); // Level 2: Koordinator Wilayah Kecamatan
            $table->unsignedBigInteger('unit_kerja_id'); // Level 3: Sekolah Dasar
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('unit_kerja_parent_id')->references('id')->on('unit_kerjas')->onDelete('set null');
            $table->foreign('unit_kerja_id')->references('id')->on('unit_kerjas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rombels');
    }
};
