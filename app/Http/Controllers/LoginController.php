<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class LoginController extends Controller
{
    public function index()
    {
        return Inertia::render('Users/Login');
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($attributes)) {
            return Redirect::route('dashboard')->with('alert_success', 'You are logged in.');
        }
        
        throw ValidationException::withMessages([
            'email' => 'Your email or password is invalid.',
            'password' => 'Your email or password is invalid.',
        ]);
    }
}
