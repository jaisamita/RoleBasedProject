<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Mail\WelcomeMail;

class AuthController extends Controller
{
	
	public function register_index(){
		
		    return view('auth.register');
	}
	
	
	public function login_index(){
		    return view('auth.login');
	}
	
	//register function
    
	public function register(Request $request)
{
    $request->validate([
        'name'     => 'required|string',
        'email'    => 'required|email|unique:users,email',
        'password' => 'required|min:6|confirmed',
    ], [
        'name.required'     => 'Name field is required',
        'email.required'    => 'Email field is required',
        'email.email'       => 'Please enter a valid email address',
        'email.unique'      => 'This email is already registered',
        'password.required' => 'Password field is required',
        'password.confirmed'=> 'Password confirmation does not match',
        'password.min'      => 'Password must be at least 6 characters',
    ]);

    $otp = rand(100000, 999999);

    $user = User::create([
        'name'              => $request->name,
        'email'             => $request->email,
        'password'          => Hash::make($request->password),
        'otp'               => $otp,
        'otp_expires_at'    => Carbon::now()->addMinutes(5),
        'contact_verified'  => 'No',
    ]);

    Mail::raw("Your OTP is: $otp", function ($message) use ($user) {
        $message->to($user->email)
                ->subject('Email Verification OTP');
    });
    
    return back()
    ->with('success', 'Email Verification OTP sent to your email')
    ->with('showOtp', true)
    ->with('email', $user->email);

}
  
public function verifyOtp(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'otp'   => 'required'
    ], [
        'otp.required' => 'OTP is required'
    ]);

    $user = User::where('email', $request->email)
                ->where('otp', $request->otp)
                ->where('otp_expires_at', '>', now())
                ->first();

    if (!$user) {
        return back()
            ->withErrors(['otp' => 'Invalid or expired OTP'])
            ->with('showOtp', true)
            ->with('email', $request->email);
    }

    $user->update([
        'contact_verified' => 'Yes',
        'otp' => null,
        'otp_expires_at' => null,
    ]);

    auth()->login($user);

    if ($user->role === 'admin') {
        return redirect('/admin/dashboard')->with('success', 'Login successfully');
    }

    return redirect('/user/dashboard')->with('success', 'Login successfully');
}
public function resendOtp(Request $request)
{
    $request->validate([
        'email' => 'required|email'
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return back()->withErrors([
            'email' => 'User not found'
        ]);
    }

    if ($user->contact_verified === 'Yes') {
        return back()->with('success', 'Already verified, please login');
    }

    $otp = rand(100000, 999999);

    $user->update([
        'otp' => $otp,
        'otp_expires_at' => Carbon::now()->addMinutes(5),
    ]);

    Mail::raw(
        "Your OTP is: $otp\nValid for 5 minutes.",
        function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Resend OTP Verification');
        }
    );

    return back()
        ->with('success', 'OTP resent successfully')->with('email', $user->email)
        ->with('showOtp', true)
        ->withInput();
}


public function login(Request $request)
{
    
    if ($request->filled('otp')) {
        $request->validate([
            'otp' => 'required'
        ]);
        $user = User::where('email', session('otp_email'))->first();
        if (
            !$user ||
            $user->otp != trim($request->otp) ||
            Carbon::now()->gt($user->otp_expires_at)
        ) {
            return back()
                ->withErrors(['otp' => 'Invalid or expired OTP'])
                ->with('showOtp', true);
        }

       
        $user->update([
            'otp' => null,
            'otp_expires_at' => null,
            'contact_verified' => 'Yes'
        ]);

        auth()->login($user);

        return redirect('/user/dashboard')
            ->with('success', 'Login successful');
    }

    $request->validate(
        [
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ],
        [
            'email.required'    => 'Email field is required',
            'email.email'       => 'Please enter a valid email address',
            'password.required' => 'Password field is required',
            'password.min'      => 'Password must be at least 6 characters',
        ]
    );

    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return back()->withErrors([
            'email' => 'Email is not registered'
        ])->withInput();
    }

    if (!Hash::check($request->password, $user->password)) {
        return back()->withErrors([
            'password' => 'Password is incorrect'
        ])->withInput();
    }


   
    if ($user->contact_verified === 'No') {

        $otp = rand(100000, 999999);

        $user->update([
            'otp' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(5),
        ]);

        session(['otp_email' => $user->email]);

        Mail::raw("Your OTP is: $otp", function ($m) use ($user) {
            $m->to($user->email)->subject('OTP Verification');
        });

        return back()
            ->with('showOtp', true)
            ->with('success', 'OTP sent to your email');
    }

    auth()->login($user);

    if ($user->role === 'admin') {
        return redirect('/admin/dashboard')->with('success', 'Login successfully');
    }

    return redirect('/user/dashboard')->with('success', 'Login successfully');
}
public function verifyLoginOtp(Request $request)
{
    $request->validate([
        'otp' => 'required'
    ]);

    $user = User::where('email', session('otp_email'))->first();

    if (
        !$user ||
        $user->otp != trim($request->otp) ||
        Carbon::now()->gt($user->otp_expires_at)
    ) {
        return back()
            ->withErrors(['otp' => 'Invalid or expired OTP'])
            ->with('showOtp', true);
    }

    
    $user->update([
        'otp' => null,
        'otp_expires_at' => null,
        'contact_verified' => 'Yes'
    ]);

    session()->forget('otp_email');

    auth()->login($user);

    //auth()->login($user);

    if ($user->role === 'admin') {
        return redirect('/admin/dashboard')->with('success', 'Login successfully');
    }

    return redirect('/user/dashboard')->with('success', 'Login successfully');
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
        $m->to($user->email)->subject('OTP Verification');
    });

    return back()
        ->with('showOtp', true)
        ->with('success', 'OTP resent successfully');
}

//user dashboard
public function admin_index(){
	
	return view('admin.dashboard');
	
}
public function user_index(){
	
  return view('user.dashboard');
	
}
//logout function

	
	public function logout(Request $request)
{
    if (!auth()->check()) {
        return redirect('/login');
    }
    auth()->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login')->with('success', 'Logged out successfully');
}

//user delete by id
	public function destroy($id)
{
    $user = User::find($id);

    if (!$user) {
        return response()->json([
            'status' => 'error',
            'message' => 'User not found'
        ]);
    }

    $user->delete();

    return response()->json([
        'status' => 'success',
        'message' => 'User deleted successfully'
    ]);
}


public function edit($id)
{
    $user = User::findOrFail($id);
    return view('admin.users.edit', compact('user'));
}
public function update(Request $request, $id)
{
   
    $request->validate([
        'name' => 'string|max:255',
        'email' => ['email',
        ],
    ]);


    $user = User::findOrFail($id);
    $user->update([
        'name'  => $request->name,
        'email' => $request->email,
    ]);

    
    return redirect()->route('admin.users') ->with('success', 'User updated successfully');
}

//user edit profile index
public function editProfile()
{
    return view('user.edit-profile');
}
public function editProfile2()
{
    return view('admin.edit-profile');
}
//update profile
public function updateProfile(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email',
    ], [
        'name.required' => 'Name is required',
        'email.required'=> 'Email is required',
        'email.email'   => 'Enter a valid email',
    ]);

    $user = auth()->user();
    $user->name  = $request->name;
    $user->email = $request->email;
    $user->save();

    return redirect('/user/dashboard')
        ->with('success', 'Profile updated successfully');
}
// public function updateProfile_ad(Request $request)
// {
//     $request->validate([
//         'name' => 'required',
//         'email' => 'required|email',
//     ], [
//         'name.required' => 'Name is required',
//         'email.required'=> 'Email is required',
//         'email.email'   => 'Enter a valid email',
//     ]);

//     $user = auth()->user();
//     $user->name  = $request->name;
//     $user->email = $request->email;
//     $user->save();

//     return redirect('/admin/dashboard')
//         ->with('success', 'Profile updated successfully');
// }
}



