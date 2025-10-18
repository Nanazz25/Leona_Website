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
        Schema::create('mata_pelajaran_guru', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_guru');
            $table->unsignedBigInteger('id_mata_pelajaran');
            $table->timestamps();

            $table->foreign('id_guru')->references('id')->on('guru')->onDelete('cascade');
            $table->foreign('id_mata_pelajaran')->references('id')->on('mata_pelajaran')->onDelete('cascade');

            $table->index(['id_guru', 'id_mata_pelajaran']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mata_pelajaran_guru');
    }
};
