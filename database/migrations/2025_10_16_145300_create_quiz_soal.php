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
        Schema::create('quiz_soal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_quiz');
            $table->unsignedBigInteger('id_bank_soal');
            $table->integer('point')->default(1);
            $table->timestamps();

            $table->foreign('id_quiz')->references('id')->on('quiz')->onDelete('cascade');
            $table->foreign('id_bank_soal')->references('id')->on('bank_soal')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_soal');
    }
};
