<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MataPelajaranController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MuridController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use App\Models\Kelas;

Route::resource('/', DashboardController::class)->names([
    'index' => 'dashboard.index',
]);

Route::resource('guru', GuruController::class);

Route::resource('murid', MuridController::class);

Route::get('/user/get-role-data', [UserController::class, 'getRoleData'])->name('user.getRoleData');
Route::get('/user/generate-username', [UserController::class, 'generateUsername'])->name('user.generateUsername');
Route::resource('user', UserController::class);
Route::resource('jurusan', JurusanController::class);
// ✅ AJAX Route untuk hitung jumlah kelas
Route::get('/kelas/count', function (Request $request) {
    $count = Kelas::where('tingkat_kelas', $request->tingkat)
        ->where('id_jurusan', $request->jurusan)
        ->count();

    return response()->json(['count' => $count]);
});
Route::resource('kelas', KelasController::class);
Route::resource('mata_pelajaran', MataPelajaranController::class);
Route::get('/kelas/search', [KelasController::class, 'search'])->name('kelas.search');
