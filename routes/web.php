<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');


Route::middleware(['auth'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware(['role:Admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/admin/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    });

    Route::middleware(['role:Manager'])->prefix('manager')->name('manager.')->group(function () {
        Route::get('/manager/dashboard', fn () => view('manager.dashboard'))->name('dashboard');
    });

    Route::middleware(['role:Member'])->prefix('member')->name('member.')->group(function () {
        Route::get('/member/dashboard', fn () => view('member.dashboard'))->name('dashboard');
    });

});


require __DIR__.'/auth.php';
