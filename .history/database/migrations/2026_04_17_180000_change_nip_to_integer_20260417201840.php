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
            // Drop existing unique constraint
            $table->dropUnique('pegawais_nip_unique');
            // Change NIP from string to unsigned big integer
            $table->unsignedBigInteger('nip')->change();
            // Re-add unique constraint
            $table->unique('nip');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pegawais', function (Blueprint $table) {
            // Drop unique constraint
            $table->dropUnique('pegawais_nip_unique');
            // Revert back to string
            $table->string('nip', 50)->change();
            // Re-add unique constraint
            $table->unique('nip');
        });
    }
};
