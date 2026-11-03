<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('unit_kerjas', function (Blueprint $table) {
            $table->dropIndex(['jenis_unit']);
            $table->dropColumn('jenis_unit');
        });

        Schema::table('unit_kerjas', function (Blueprint $table) {
            $table->unsignedBigInteger('jenis_unit_id')->nullable()->after('level');
            $table->foreign('jenis_unit_id')->references('id')->on('jenis_units')->onDelete('set null');
            $table->index('jenis_unit_id');
        });
    }

    public function down(): void
    {
        Schema::table('unit_kerjas', function (Blueprint $table) {
            $table->dropForeign(['jenis_unit_id']);
            $table->dropIndex(['jenis_unit_id']);
            $table->dropColumn('jenis_unit_id');
        });

        Schema::table('unit_kerjas', function (Blueprint $table) {
            $table->string('jenis_unit', 50)->nullable()->after('level');
            $table->index('jenis_unit');
        });
    }
};
