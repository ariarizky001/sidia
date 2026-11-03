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
        Schema::create('pegawais', function (Blueprint $table) {
            $table->id();
            $table->string('nip', 50)->unique();
            $table->string('nama_lengkap', 100);
            $table->date('tgl_lahir');
            $table->date('pensiun')->nullable();
            $table->date('bup')->nullable();
            $table->string('golongan', 10);
            $table->date('tmt_golongan')->nullable();
            $table->string('jabatan', 100);
            $table->date('tmt_jabatan')->nullable();
            $table->string('pendidikan', 50);
            $table->integer('thn_lulus')->nullable();
            $table->string('status_asn', 50);
            $table->string('formasi_jabatan', 100)->nullable();
            $table->string('unit_kerja_satu', 100);
            $table->string('unit_kerja_2', 100)->nullable();
            $table->string('unit_kerja_3', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawais');
    }
};
