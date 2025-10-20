<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::resource('/', DashboardController::class)->names(names: [
    'index' => 'dashboard.index',
]);
