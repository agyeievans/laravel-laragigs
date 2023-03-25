<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Logout;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //show register/ create form
    public function create(){
        return view('users.register');
    }

    // create new user
    public function store(Request $request){
        $formFields = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => 'required|confirmed|min:6'
        ]);

        // Hash password
        $formFields['password'] = bcrypt($formFields['password']);

        // automatically login after creating user
        $user = User::create($formFields);

        // login
        auth()->login($user);

        return redirect('/')->with('message', 'Your account has been created and logged in.');
    }

    // logout user
    public function logout(Request $request){
        auth()->logout();

        // invalidate user session and regenerate csrf token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'Your account has been logged out.');
    }

    // show login form
    public function login(){
        return view('users.login');
    }

    // authenticate user
    public function authenticate(Request $request){
        $formFields = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);

        if(auth()->attempt($formFields)){
            // regenerate session id
            $request->session()->regenerate();

            return redirect('/')->with('message', 'Your account has been login');
        }

        return back()->withErrors(['email' => 'invalid credentials'])->onlyInput('email');
    }
}
