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
            // Drop old string columns
            $table->dropColumn('jabatan');
            $table->dropColumn('formasi_jabatan');
        });

        Schema::table('pegawais', function (Blueprint $table) {
            // Add new foreign key columns
            $table->unsignedBigInteger('jabatan_id')->nullable()->after('tmt_jabatan');
            $table->unsignedBigInteger('formasi_jabatan_id')->nullable()->after('jabatan_id');

            // Add foreign keys
            $table->foreign('jabatan_id')->references('id')->on('jabatans')->cascadeOnDelete();
            $table->foreign('formasi_jabatan_id')->references('id')->on('formasi_jabatans')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pegawais', function (Blueprint $table) {
            // Drop foreign keys
            $table->dropForeign(['jabatan_id']);
            $table->dropForeign(['formasi_jabatan_id']);
            $table->dropColumn(['jabatan_id', 'formasi_jabatan_id']);
        });

        Schema::table('pegawais', function (Blueprint $table) {
            // Restore string columns
            $table->string('jabatan', 100)->nullable();
            $table->string('formasi_jabatan', 100)->nullable();
        });
    }
};
