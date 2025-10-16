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
        Schema::create('quiz_nilai', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_quiz');
            $table->unsignedBigInteger('id_murid');
            $table->integer('total_point')->default(0);
            $table->integer('max_point')->default(0);
            $table->dateTime('dikerjakan_pada')->nullable();
            $table->timestamps();

            $table->foreign('id_quiz')->references('id')->on('quiz')->onDelete('cascade');
            $table->foreign('id_murid')->references('id')->on('murid')->onDelete('cascade');

            $table->index(['id_quiz', 'id_murid']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_nilai');
    }
};
