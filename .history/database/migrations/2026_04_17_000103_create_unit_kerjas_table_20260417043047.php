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
        Schema::create('unit_kerjas', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->integer('level')->default(1); // 1: Induk, 2: Korwil/Bidang, 3: Sekolah/Seksi
            $table->timestamps();

            // Self-referencing foreign key
            $table->foreign('parent_id')
                ->references('id')
                ->on('unit_kerjas')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_kerjas');
    }
};
