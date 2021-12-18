<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\RegistrationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [AuthController::class,'users'])->name('users.dashboard');
Route::get('/admin', [AdminAuthController::class,'users'])->name('admin.dashboard');
Route::post('/admin', [AdminAuthController::class,'users'])->name('admin.dashboard');

Route::get('/register', [RegistrationController::class,'create'])->name('user.register');
Route::post('register', [RegistrationController::class,'store'])->name('user.register');

Route::get('/login', [AuthController::class,'create'])->name('user.login');
Route::post('/login', [AuthController::class,'store'])->name('user.login');
Route::get('/logout', [AuthController::class,'destroy'])->name('user.logout');

Route::get('/admin/login', [AdminAuthController::class,'create'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class,'store'])->name('admin.login');
Route::get('/admin/logout', [AdminAuthController::class,'destroy'])->name('admin.logout');

Route::get('/auth/google', [AuthController::class,'socialRedirect'])->name('user.social.redirect');
Route::get('/auth/google/callback', [AuthController::class,'socialCallback'])->name('user.social.callback');
