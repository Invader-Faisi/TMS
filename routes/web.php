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


    Route::resource('tasks', \App\Http\Controllers\TaskController::class)->only(['index','show', 'create', 'store', 'update', 'destroy']);
    Route::post('/notifications/read/{id}', function ($id) {
        auth()->user()->notifications()->where('id', $id)->update(['read_at' => now()]);
        return back();})->name('notifications.read');

    Route::middleware(['role:Admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/admin/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    });

    Route::middleware(['role:Manager'])->prefix('manager')->name('manager.')->group(function () {
        Route::get('/manager/dashboard', [\App\Http\Controllers\Manager\DashboardController::class, 'index'])->name('dashboard');
    });

    Route::middleware(['role:Member'])->prefix('member')->name('member.')->group(function () {
        Route::get('/member/dashboard', [\App\Http\Controllers\Member\DashboardController::class, 'index'])->name('dashboard');
    });

});


require __DIR__.'/auth.php';
