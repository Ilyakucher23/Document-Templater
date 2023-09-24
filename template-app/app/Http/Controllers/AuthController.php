<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }
    public function registration()
    {
        return view('auth.registration');
    }
    public function regUser(Request $request)
    {
        $fields = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:4', 'confirmed']
        ]);
        // dd($fields);
        $fields['password'] = bcrypt($fields['password']);
        $user = User::create($fields);
        auth()->login($user);
        return redirect('/');
        // return redirect('/')->with('message','You are logged in!');
    }
    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
    public function logUser(Request $request)
    {
        $fields = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);
        // dd($fields);

        if (auth()->attempt($fields)) {
            $request->session()->regenerate();
            return redirect('/');
        }
        return back()->withErrors(['email'=>'Invalid User']);
    }
}
