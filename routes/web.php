<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminUsersController;
use Illuminate\Support\Facades\Mail;

use App\Mail\WelcomeMail;
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



Route::get('/', [AuthController::class, 'login_index'])->name('login');
//for login
Route::get('/login', [AuthController::class, 'login_index'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

//register
Route::get('/register', [AuthController::class, 'register_index']);
Route::post('/register', [AuthController::class, 'register'])->name('register'); 



//middleware user /admin
Route::middleware(['auth'])->group(function () {

    Route::get('/user/dashboard',[AuthController::class,'user_index']);
	Route::get('/users/{id}/edit', [AuthController::class, 'edit']);
    Route::put('/users/{id}', [AuthController::class, 'update']);
    Route::delete('/users/{id}', [AuthController::class, 'destroy']);

    
	
});
Route::middleware(['auth','is_admin'])->group(function () {
    Route::delete('/users/{id}', [AuthController::class, 'destroy']);
});

//restricted for normal user
Route::middleware(['auth','is_admin'])->group(function () {
	Route::get('/admin/dashboard',[AuthController::class, 'admin_index']);

	Route::get('/admin/users', [AdminUsersController::class, 'index'])
        ->name('admin.users');
});

    Route::middleware(['auth'])->post('/logout', [AuthController::class, 'logout'])->name('logout');

