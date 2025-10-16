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
        Schema::create('jawaban_quiz', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_quiz');
            $table->unsignedBigInteger('id_quiz_soal');
            $table->unsignedBigInteger('id_murid');
            $table->enum('jawaban_siswa', ['A', 'B', 'C', 'D']);
            $table->boolean('benar')->default(false);
            $table->integer('point_didapat')->default(0);
            $table->timestamps();

            $table->foreign('id_quiz')->references('id')->on('quiz')->onDelete('cascade');
            $table->foreign('id_quiz_soal')->references('id')->on('quiz_soal')->onDelete('cascade');
            $table->foreign('id_murid')->references('id')->on('murid')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban_quiz');
    }
};
