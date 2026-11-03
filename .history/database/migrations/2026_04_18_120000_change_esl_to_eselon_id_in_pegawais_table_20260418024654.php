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
            // Drop the old esl column
            $table->dropColumn('esl');
        });

        Schema::table('pegawais', function (Blueprint $table) {
            // Add new eselon_id foreign key
            $table->unsignedBigInteger('eselon_id')->nullable()->after('tmt_jabatan');
            $table->foreign('eselon_id')->references('id')->on('eselons')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pegawais', function (Blueprint $table) {
            // Drop foreign key
            $table->dropForeign(['eselon_id']);
            $table->dropColumn('eselon_id');
        });

        Schema::table('pegawais', function (Blueprint $table) {
            // Restore esl column
            $table->string('esl', 50)->nullable();
        });
    }
};
