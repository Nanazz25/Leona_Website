<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\KategoriSoalController;
use App\Http\Controllers\Api\BankSoalController;
use App\Http\Controllers\Api\QuizController;
use App\Http\Controllers\Api\JawabanQuizController;
use App\Http\Controllers\Api\QuizNilaiController;
use App\Http\Controllers\Api\AbsensiController;
use App\Http\Controllers\Api\AbsensiDetailController;

// AUTH
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    // USER INFO
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', fn(Request $request) => response()->json($request->user()));

    // =============== GURU ONLY ===============
    Route::middleware(['role:guru,kurikulum'])->group(function () {

        Route::apiResource('kategori-soal', KategoriSoalController::class);
        Route::apiResource('bank-soal', BankSoalController::class);

        Route::prefix('quiz')->group(function () {
            Route::post('/', [QuizController::class, 'store']);
            Route::post('/{id}/kelas', [QuizController::class, 'assignKelas']);
            Route::post('/{id}/soal', [QuizController::class, 'assignSoal']);
            Route::put('/{id}', [QuizController::class, 'update']);
            Route::delete('/{id}', [QuizController::class, 'destroy']);

            // Lihat nilai seluruh siswa
            Route::get('/{id}/nilai', [QuizNilaiController::class, 'show']);
            Route::post('/{id}/nilai/hitung', [QuizNilaiController::class, 'calculate']);
        });

        Route::prefix('absensi')->group(function () {
            // Buat sesi absensi (per kelas per tanggal)
            Route::post('/', [AbsensiController::class, 'store']);
            // Lihat daftar absensi suatu kelas
            Route::get('/', [AbsensiController::class, 'index']);
            // Detail absensi + murid
            Route::get('/{id}', [AbsensiController::class, 'show']);
            // Tambah detail absensi (kehadiran murid)
            Route::post('/{id}/detail', [AbsensiDetailController::class, 'store']);
        });
    });

    // =============== MURID ONLY ===============
    Route::middleware('role:murid')->group(function () {
        Route::prefix('quiz')->group(function () {
            Route::get('/', [QuizController::class, 'index']);
            Route::get('/{id}', [QuizController::class, 'show']);

            Route::post('/{id}/jawaban', [JawabanQuizController::class, 'store']);
            Route::get('/{id}/jawaban', [JawabanQuizController::class, 'show']);

            // Murid lihat nilai sendiri
            Route::get('/{id}/nilai', [QuizNilaiController::class, 'show']);
        });
    });
});
