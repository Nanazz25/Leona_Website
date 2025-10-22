<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuruController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MuridController;
use App\Http\Controllers\UserController;

Route::resource('/', DashboardController::class)->names(names: [
    'index' => 'dashboard.index',
]);
Route::resource('guru', GuruController::class);
Route::resource('murid', MuridController::class);
Route::resource('user', UserController::class);
