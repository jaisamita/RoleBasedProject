<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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
        'password' => 'required|min:6|confirmed'
    
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
		'password'=>Hash::make($request->password)
		]);
		

        Mail::to($user->email)->send(new WelcomeMail());

		
		return redirect('/login')->with('success', 'Registration successful. Please login.');
	}
	
//user login function

public function login(Request $request)
{

      $request->validate([
        'email'    => 'required|email',
        'password' => 'required|min:6',
    ], [
        'email.required'    => 'Email field is required',
        'email.email'       =>   'Please enter a valid email address',
        'password.required' => 'Password field is required',
        'password.min'       => 'Password must be at least 6 characters',
        
    ]);
    $credentials = $request->only('email', 'password');

   
      
    $user = User::where('email', $request->email)->first();
	
      if (!$user) {
        return back()->withErrors([
            'email' => ' Email is not registered'
        ])->withInput();
    }


    if (!Hash::check($request->password, $user->password)) {
        return back()->withErrors([
            'password' => 'Password is incorrect'
        ])->withInput();
    }

    //login success

      Auth::login($user);
	  
    // role based conditon check
    if ($user->role === 'admin') {
        return redirect('/admin/dashboard');
    }

    return redirect('/user/dashboard');
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
    Auth::logout(); 
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
    $user = User::findOrFail($id);

    $user->update([
        'name'  => $request->name,
        'email' => $request->email,
       
    ]);

    return redirect('admin/users')->with('success', 'User updated successfully');
}

}
