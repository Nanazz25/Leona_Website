<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('absensi_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_absensi');
            $table->unsignedBigInteger('id_murid');
            $table->enum('kehadiran', ['hadir', 'izin', 'sakit', 'alfa']);
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('id_absensi')->references('id')->on('absensi')->onDelete('cascade');
            $table->foreign('id_murid')->references('id')->on('murid')->onDelete('cascade');

            $table->unique(['id_absensi', 'id_murid']); // biar murid gak double di sesi yang sama
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi_detail');
    }
};
