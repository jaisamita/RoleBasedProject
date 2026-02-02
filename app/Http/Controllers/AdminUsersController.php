<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminUsersController extends Controller
{
    public function index()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        
        return view('admin.users', compact('users'));
    }

    public function update(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email'
    ]);

    auth()->user()->update($request->only('name','email'));

    return back()->with('success','Profile updated successfully');
}

}
