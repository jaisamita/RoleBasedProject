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
	//register web
	public function register_index(){
		
		    return view('auth.register');
	}
	
	//login web
	public function login_index(){
		    return view('auth.login');
	}
	
	//register function
    public function register(Request $request)
	{
	  $request->validate([
        'name'     => 'required|string|min:3',
        'email'    => 'required|email|unique:users,email',
        'password' => 'required|min:6|confirmed',
        
    
    ], [
        'name.required'     => 'Name field is required',
        'email.required'    => 'Email field is required',
        'email.email'       =>   'Please enter a valid email address',
        'email.unique'       =>   'This  emailId is already registered',
        'password.required' => 'Password field is required',
        'password.confirmed' =>'Password confirmation does not match',
        'password.min'       => 'Password must be at least 6 characters',
        
    ]);
		
		$user = User::create([
		'name'=>$request->name,
		'email'=>$request->email,
		'password'=>Hash::make($request->password),
        'contact_verified' => 'No',
		]);
		

       // Mail::to($user->email)->send(new WelcomeMail());

		
		return redirect('/login')->with('success', 'Registration successful. Please login.');
	}
	
public function login(Request $request)
{
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

    
    if (!$request->filled('otp')) {

        $otp = rand(100000, 999999);

        $user->update([
            'otp' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(5),
        ]);

        Mail::raw(
            "Your OTP is: $otp\nValid for 5 minutes.",
            function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Login OTP Verification');
            }
        );

        return back()
            ->with('success', 'OTP sent to your email')
            ->with('showOtp', true)
            ->withInput();
    }


    if (
        $user->otp !== $request->otp ||
        Carbon::now()->gt($user->otp_expires_at)
    ) {
        return back()
            ->withErrors(['otp' => 'Invalid or expired OTP'])
            ->with('showOtp', true)
            ->withInput();
    }

    $user->update([
        'otp' => null,
        'otp_expires_at' => null,
        'contact_verified' => 'Yes'
    ]);
}

    auth()->login($user);

    if ($user->role === 'admin') {
        return redirect('/admin/dashboard')
            ->with('success', 'Login successful');
    }

    return redirect('/user/dashboard')
        ->with('success', 'Login successful');
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
        ->with('success', 'OTP resent successfully')
        ->with('showOtp', true)
        
        ->withInput();
}

//user dashboard
public function admin_index(){
	
	return view('admin.dashboard');
	
}
//admin dashboard
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
public function updateProfile_ad(Request $request)
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

    return redirect('/admin/dashboard')
        ->with('success', 'Profile updated successfully');
}
}


