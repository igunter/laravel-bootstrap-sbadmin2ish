<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
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

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'admin'])->name('dashboard');
Route::get('/dashboard-data/signups', [DashboardController::class, 'signups'])->middleware(['auth', 'admin'])->name('dashboard.signups');

Route::get('/users-data', [UserController::class, 'data'])->middleware(['auth', 'admin'])->name('users.data');
Route::resource('users', UserController::class)->middleware(['auth', 'admin']);

Route::get('/activity-log-data', [ActivityLogController::class, 'data'])->middleware(['auth', 'admin'])->name('activity-log.data');
Route::get('/activity-log', [ActivityLogController::class, 'index'])->middleware(['auth', 'admin'])->name('activity-log.index');
