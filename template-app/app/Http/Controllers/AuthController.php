<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

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
        Storage::makeDirectory("userfiles/{$user->id}");
        return redirect('/')->with('message','auth.acc_create_suc');
        // return redirect('/')->with('message','You are logged in!');
    }
    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('message',trans('auth.acc_logout'));
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
            return redirect('/')->with('message',trans('auth.acc_login'));
        }
        return back()->withErrors(['email' => trans('auth.acc_invalid_user')]);
    }
    public function createUserFolder()
    {
    }
}
