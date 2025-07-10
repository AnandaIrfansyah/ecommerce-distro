<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\User\HomeController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('dashboard', DashboardController::class);
});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::resource('home', HomeController::class);
});
