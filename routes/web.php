<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MataPelajaranController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MuridController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserMuridController;
use App\Http\Controllers\UserGuruController;
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

//halaman user guru
Route::prefix('user-guru')->name('userguru.')->group(function () {
    Route::get('/', [UserGuruController::class, 'index'])->name('index');
    Route::get('/form', [UserGuruController::class, 'form'])->name('form');
    Route::post('/store', [UserGuruController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [UserGuruController::class, 'form'])->name('edit');
    Route::put('/update/{id}', [UserGuruController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [UserGuruController::class, 'destroy'])->name('destroy');

    // username generator baru
    Route::get('/generate-username', [UserGuruController::class, 'generateUsername'])->name('generateUsername');
});

//halaman user murid
//halaman user murid
Route::get('/usermurid', [UserMuridController::class, 'index'])->name('usermurid.index');
Route::get('/usermurid/kelas/{jurusanId}', [UserMuridController::class, 'kelas'])->name('usermurid.kelas');
Route::get('/usermurid/murid/{kelasId}', [UserMuridController::class, 'murid'])->name('usermurid.murid');
Route::get('/usermurid/form/{kelasId}/{id?}', [UserMuridController::class, 'form'])->name('usermurid.form');
Route::post('/usermurid/store', [UserMuridController::class, 'store'])->name('usermurid.store');
Route::put('/usermurid/update/{id}', [UserMuridController::class, 'update'])->name('usermurid.update');
Route::delete('/usermurid/delete/{id}', [UserMuridController::class, 'destroy'])->name('usermurid.delete');
Route::get('/usermurid/search', [UserMuridController::class, 'searchMurid'])->name('usermurid.search');
// Route::get('/usermurid/generate-username', [UserMuridController::class, 'generateUsername'])->name('usermurid.generateUsername'); // No longer needed via AJAX
