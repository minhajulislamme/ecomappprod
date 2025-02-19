<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController\AdminController;
use App\Http\Controllers\UserController\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Frontend Routes
Route::get('/', function () {
    return view('frontend.index');
})->name('home');



// User Routes
Route::middleware(['auth', 'verified', 'user'])->group(function () {
   
    Route::get('/dashboard', [UserController::class, 'UserDashboard'])->name('user.dashboard');
    Route::get('/logout', [UserController::class, 'UserLogout'])->name('user.logout');
    Route::post('/profile/update', [UserController::class, 'UserProfileUpdate'])->name('user.profile.update');
    Route::post('/password/update', [UserController::class, 'UserPasswordUpdate'])->name('user.password.update');
   
});

// Admin Routes all the routes that are only accessible by the admin will be defined her
Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
    Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/update', [AdminController::class, 'AdminProfileUpdate'])->name('admin.profile.update');
    Route::get('/admin/password', [AdminController::class, 'AdminPassword'])->name('admin.password');
    Route::post('/admin/password/update', [AdminController::class, 'AdminPasswordUpdate'])->name('admin.password.update');

    });




    
// Super Admin Routes - define super admin accessible routes here
Route::middleware(['auth', 'verified', 'super_admin'])->group(function () {
    Route::get('/superadmin/dashboard', function () {
        return view('superadmin.super_admin');
    })->name('superadmin.dashboard');
});


// All public route
// admin login routes will be defined here
Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login');
Route::post('/admin/login/store', [AdminController::class, 'AdminLoginStore'])->name('admin.login.store');


// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
