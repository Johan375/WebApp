<?php

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TodoController;
Auth::routes();
Route::resource('/todo', TodoController::class);

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile/delete', [ProfileController::class, 'destroy'])->name('profile.destroy');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['throttle:global'])->group(function () {
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{product}', [ProductController::class, 'show']);
    Route::post('/products', [ProductController::class, 'store']);
});

Route::middleware(['throttle:downloads'])->group(function () {
    Route::get('/reports/{report}/download', [ReportController::class, 'download']);
    Route::get('/albums/{album}/download', [AlbumController::class, 'download']);
});

