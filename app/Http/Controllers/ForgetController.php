<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Mail\WelcomeMail;

class ForgetController extends Controller
{
    public function sendForgotOtp(Request $request)
{
       $request->validate([
        'email' => 'required|email'
    ], [
        'email.required' => 'Email is required',
        'email.email' => 'Enter a valid email ',
    ]);


    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return back()->withErrors(['email' => 'Email not registered']);
    }

    $otp = rand(100000, 999999);

    $user->update([
        'otp' => $otp,
        'otp_expires_at' => Carbon::now()->addMinutes(5),
    ]);

    session(['forgot_email' => $user->email]);

    Mail::raw("Your password reset OTP is: $otp", function ($m) use ($user) {
        $m->to($user->email)->subject('Reset Password OTP');
    });

    return back()->with('showOtp', true)->with('success', 'OTP sent  Successfully');
}
public function verifyForgotOtp(Request $request)
{
       $request->validate([
        'otp' => 'required'
    ], [
        'otp.required' => 'OTP is required'
    ]);


    $user = User::where('email', session('forgot_email'))->first();

    if (
        !$user ||
        $user->otp != trim($request->otp) ||
        Carbon::now()->gt($user->otp_expires_at)
    ) {
        return back()
            ->withErrors(['otp' => 'Invalid or expired OTP'])
            ->with('showOtp', true);
    }

    session(['otp_verified' => true]);

    return redirect()->route('forgot.reset.form')->with('success', 'OTP verified successfully. Please reset your password.');;
}
public function resetPassword(Request $request)
{
    if (!session('otp_verified')) {
        return redirect('/forgot-password');
    }

    $request->validate([
        'password' => 'required|min:6|confirmed'
    ]);

    $user = User::where('email', session('forgot_email'))->first();

    $user->update([
        'password' => Hash::make($request->password),
        'otp' => null,
        'otp_expires_at' => null
    ]);

    session()->forget(['forgot_email', 'otp_verified']);

    return redirect('/login')->with('success', 'Password reset successfully');
}


public function forgetform(){

  return view('auth.forget');
}


public function resendLoginOtp()
{
    $email = session('otp_email');

    if (!$email) {
        return redirect('/login')
            ->withErrors(['email' => 'Session expired, please login again']);
    }

    $user = User::where('email', $email)->first();

    if (!$user) {
        return redirect('/login');
    }

    $otp = rand(100000, 999999);

    $user->update([
        'otp' => $otp,
        'otp_expires_at' => Carbon::now()->addMinutes(5),
    ]);

    Mail::raw("Your OTP is: $otp", function ($m) use ($user) {
        $m->to($user->email)->subject('Login OTP');
    });

    return back()
        ->with('showOtp', true)
        ->with('success', 'OTP resent successfully');
}

}
