<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (! auth()->check()) {
        return view('auth.guest');
    }

    return auth()->user()->is_admin
        ? redirect()->route('dashboard')
        : redirect()->route('holding');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

Route::get('/holding', function () {
    return view('holding');
})->middleware('auth')->name('holding');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'admin'])->name('dashboard');

Route::get('/users-data', [UserController::class, 'data'])->middleware(['auth', 'admin'])->name('users.data');
Route::resource('users', UserController::class)->middleware(['auth', 'admin']);
