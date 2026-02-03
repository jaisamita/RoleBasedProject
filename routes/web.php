<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgetController;
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


//register
Route::get('/register', [AuthController::class, 'register_index']);
Route::post('/register', [AuthController::class, 'register'])->name('register'); 

Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('otp.verify');
Route::post('/resend-otp', [AuthController::class, 'resendOtp'])->name('resend.otp');

Route::get('/', [AuthController::class, 'login_index'])->name('login');

Route::get('/login', [AuthController::class, 'login_index'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/login/verify-otp', [AuthController::class, 'verifyLoginOtp'])
    ->name('login.verify.otp');

Route::post('/login/resend-otp', [AuthController::class, 'resendLoginOtp'])
    ->name('login.resend.otp');

Route::get('/forgot-password', [ForgetController::class, 'forgetform'])->name('forget');

Route::post('/forgot/send-otp', [ForgetController::class, 'sendForgotOtp'])
    ->name('forgot.send.otp');

Route::post('/forgot/verify-otp', [ForgetController::class, 'verifyForgotOtp'])
    ->name('forgot.verify.otp');

Route::get('/forgot/reset-password', function () {
    return view('auth.reset-password');})->name('forgot.reset.form');

Route::post('/forgot/reset-password', [ForgetController::class, 'resetPassword'])
    ->name('forgot.reset');

Route::post('/forgot/reset-password', [ForgetController::class, 'resetPassword'])
    ->name('forgot.reset.password');


//middleware user /admin
Route::middleware(['auth'])->group(function () {

    Route::get('/user/dashboard',[AuthController::class,'user_index']);
	Route::get('/users/{id}/edit', [AuthController::class, 'edit']);
    Route::put('/users/{id}', [AuthController::class, 'update']);
    Route::delete('/users/{id}', [AuthController::class, 'destroy']);

});

Route::middleware('auth')->group(function () {
  Route::get('/user/profile/edit', [AuthController::class, 'editProfile'])
  ->name('user.profile.edit');
Route::post('/user/profile/update', [AuthController::class, 'updateProfile'])
->name('user.profile.update');
});

Route::middleware(['auth','is_admin'])->group(function () {
Route::put('/admin/profile/update', [AdminUsersController::class, 'update']);
Route::delete('/users/{id}', [AuthController::class, 'destroy']);
});

//restricted for normal user
Route::middleware(['auth','is_admin'])->group(function () {
	Route::get('/admin/dashboard',[AuthController::class, 'admin_index']);

	Route::get('/admin/users', [AdminUsersController::class, 'index'])
        ->name('admin.users');
    

});

    Route::middleware(['auth'])->post('/logout', [AuthController::class, 'logout'])->name('logout');

