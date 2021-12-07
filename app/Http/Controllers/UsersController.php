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
                ->paginate(6)
                ->onEachSide(1)
                ->through(fn($user) => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'username' => $user->username,
                    'phone' => $user->phone,
                    'workshop' => $user->workshop,
                ]),
                'filters' => $request->only(['search'])
        ]);
    }

    public function create()
    {
        return Inertia::render('Users/Create');
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
            'username' => ['required', 'alpha_num','between:3,32,', 'unique:users,username,' . auth()->id()],
            'email' => ['required', 'email', 'unique:users,email,' . auth()->id()],
            'phone' => ['required', 'min:11'],
            'workshop' => ['required', 'string', 'min:3'],
        ]);

        $request->user()->update($attr);
        return Redirect::route('user.profile')->with('alert_success', 'Your profile has been updated');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
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
            $request->user()->update($request->only('password'));

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
            $request->user()->update(['image' => $image_path]);
        }

        return redirect()->back()->with('alert_success', 'Your profile image has been updated.');
    }

    public function destroyByAdmin($username)
    {
        if (auth()->user()->is_admin == 1) {
            User::where('users.username', '=', $username)->delete();

            return redirect()->back()->with('alert_success', 'User has been deleted successfully');
        }

        return redirect()->back()->with('alert_error', 'You cannot delete this user!');
    }

    public function showByAdmin($username)
    {
        $user = User::where('username', $username)->first();

        if (auth()->user()->is_admin == 1) {
            return Inertia::render('Users/Show', compact('user'));
        }
        return back();
    }

    public function editUserPasswordByAdmin(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'password_confirmation' => ['required', 'same:password', 'min:6'],
        ]);

        $password = bcrypt($request->password);

        if (auth()->user()->is_admin == 1) {
            User::where('username', $request->username)->update(['password' => $password]);
            return back()->with('alert_success', 'Password has been updated successfully.');
        }
        return back();
    }
}
