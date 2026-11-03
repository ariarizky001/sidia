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
        Schema::table('unit_kerjas', function (Blueprint $table) {
            $table->string('jenis_unit', 50)->nullable()->after('level');
            $table->index('jenis_unit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('unit_kerjas', function (Blueprint $table) {
            $table->dropIndex(['jenis_unit']);
            $table->dropColumn('jenis_unit');
        });
    }
};
