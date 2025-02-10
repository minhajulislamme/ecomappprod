<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Frontend Routes
Route::get('/frontend', function () {
    return view('frontend.frontend');
});

Route::get('/admin', function () {
    return view('admin.admin');
});

// User Routes
Route::middleware(['auth', 'verified', 'user'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Admin Routes
Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.admin');
    })->name('admin.dashboard');
});

// Super Admin Routes
Route::middleware(['auth', 'verified', 'super_admin'])->group(function () {
    Route::get('/superadmin/dashboard', function () {
        return view('superadmin.super_admin');
    })->name('superadmin.dashboard');
});

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
