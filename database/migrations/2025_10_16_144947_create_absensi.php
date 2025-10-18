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
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_kelas');
            $table->unsignedBigInteger('id_guru')->nullable();
            $table->dateTime('tanggal');
            $table->timestamps();

            $table->foreign('id_kelas')->references('id')->on('kelas')->onDelete('cascade');
            $table->foreign('id_guru')->references('id')->on('guru')->onDelete('set null');

            $table->index(['id_kelas', 'tanggal']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};
