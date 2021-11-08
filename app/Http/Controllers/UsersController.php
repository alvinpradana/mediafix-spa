<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(8);
        return Inertia::render('Users/Index', compact('users'));
    }

    public function create()
    {
        return Inertia::render('Users/Create');
    }

    public function store(RegistrationRequest $request)
    {
        User::create($request->all());
        return Redirect::route('users.index');
    }

    public function profile(Request $request)
    {
        $user = auth()->user();
        return Inertia::render('Users/Profile', compact('user'));
    }

    public function edit($id)
    {
        $user = auth()->user();
        return Inertia::render('Users/Edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $attributes = $request->validate([
            'name' => ['required', 'string', 'min:3'],
            'username' => ['required', 'alpha_num', 'between:3,32', 'unique:users,username,' . auth()->id()],
            'email' => ['required', 'email', 'unique:users,email,' . auth()->id()],
            'phone' => ['required', 'string', 'min:11'],
            'workshop' => ['required', 'string', 'min:3'],
        ]);

        auth()->user()->update($attributes);
        return Redirect::route('user.profile')->with('alert_success', 'Your profile has been updated');
    }

    public function destroy()
    {
        auth()->user()->delete();
        return Redirect::route('login')->with('alert_success', 'Your account was deleted');
    }

    public function password(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'password_confirmation' => ['required', 'same:password', 'min:6'],
        ]);

        if (Hash::check($request->current_password, auth()->user()->password)) {
            auth()->user()->update($request->only('password'));

            return back()->with('alert_success', 'Your password has been updated');
        }
        throw ValidationException::withMessages([
            'current_password' => 'Your current password does not match.'
        ]);
    }
}
