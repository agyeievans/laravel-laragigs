<?php

namespace App\Http\Controllers;

use App\Models\User;
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
}
