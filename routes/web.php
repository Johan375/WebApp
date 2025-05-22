<?php

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TodoController;

// Auth routes
Auth::routes();

// User To-Do routes (only for users)
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::resource('/todo', TodoController::class);
});

// Admin routes (only for admins)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::post('/admin/users/{user}/activate', [AdminController::class, 'activate'])->name('admin.users.activate');
    Route::post('/admin/users/{user}/deactivate', [AdminController::class, 'deactivate'])->name('admin.users.deactivate');
    Route::delete('/admin/users/{user}', [AdminController::class, 'destroy'])->name('admin.users.destroy');
    Route::get('/admin/users/{user}/todos', [AdminController::class, 'userTodos'])->name('admin.users.todos');
});


// Only authenticated users can access To-Do routes
Route::middleware(['auth'])->group(function () {
    Route::resource('/todo', TodoController::class);
    // You can also move profile routes here if you want them protected
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Public routes
Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Throttled routes
Route::middleware(['throttle:global'])->group(function () {
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{product}', [ProductController::class, 'show']);
    Route::post('/products', [ProductController::class, 'store']);
});

Route::middleware(['throttle:downloads'])->group(function () {
    Route::get('/reports/{report}/download', [ReportController::class, 'download']);
    Route::get('/albums/{album}/download', [AlbumController::class, 'download']);
});