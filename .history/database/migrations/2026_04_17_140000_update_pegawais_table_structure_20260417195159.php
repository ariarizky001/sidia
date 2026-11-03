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
            // Change bup from date to integer
            $table->integer('bup')->nullable()->change();
            
            // Add new columns
            $table->string('esl', 50)->nullable()->after('tmt_jabatan');
            $table->date('tmt_cpns')->nullable()->after('esl');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pegawais', function (Blueprint $table) {
            $table->dropColumn(['esl', 'tmt_cpns']);
            $table->date('bup')->nullable()->change();
        });
    }
};
