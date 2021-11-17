<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Requests\ImageRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\RegistrationRequest;
use Illuminate\Validation\ValidationException;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Users/Index', [
            'users' => User::query()
                ->when($request['search'], function ($query, $search) {
                    $query->where('name', 'like', '%' . $search . '%')
                        ->orWhere('username', 'like', '%' . $search . '%')
                        ->orWhere('phone', 'like', '%' . $search . '%')
                        ->orWhere('workshop', 'like', '%' . $search . '%');
                })
                ->latest()
                ->paginate(8)
                ->onEachSide(1)
                ->through(fn($user) => [
                    'name' => $user->name,
                    'username' => $user->username,
                    'phone' => $user->phone,
                    'workshop' => $user->workshop,
                    'user_added' => $user->user_added,
                ]),
                'filters' => $request->only(['search'])
        ]);
    }

    public function create()
    {
        $user = auth()->user()->username;
        return Inertia::render('Users/Create', compact('user'));
    }

    public function store(RegistrationRequest $request)
    {
        User::create($request->all());

        return Redirect::route('users.index')->with('alert_success', 'User created successfully.');
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

    public function update(Request $request)
    {
        $attr = $request->validate([
            'name' => ['required', 'string', 'min:3'],
            'email' => ['required', 'email', 'unique:users,email,' . auth()->id()],
            'phone' => ['required', 'min:11'],
            'workshop' => ['required', 'string', 'min:3'],
        ]);

        auth()->user()->update($attr);
        return Redirect::route('user.profile')->with('alert_success', 'Your profile has been updated');
    }

    public function destroy()
    {
        auth()->user()->delete();
        return Redirect::route('login')->with('alert_success', 'Your account has been deleted.');
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

            return back()->with('alert_success', 'Your password has been updated.');
        }
        throw ValidationException::withMessages([
            'current_password' => 'Your current password does not match.'
        ]);
    }

    public function storeImage(ImageRequest $request)
    {
        if ($request->hasFile('image')) {
            $image_path = $request->file('image')->store('image', 'public');
            auth()->user()->update(['image' => $image_path]);
        }

        return redirect()->back()->with('alert_success', 'Your profile image has been updated.');
    }
}
