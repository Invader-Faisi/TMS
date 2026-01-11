<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.users.index', [
            'users' => User::latest()->get()
        ]);
    }

    public function create(User $user)
    {
        return view('admin.users.create', compact('user'));
    }

    public function store(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', Rules\Password::defaults()],
            'role' => 'required|in:Admin,Manager,Member'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        return redirect()
            ->route('admin.users.create')
            ->with('toastr', [
                'type' => 'success',
                'message' => 'User added successfully',
                'title' => 'Success'
            ]);
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:Admin,Manager,Member'
        ]);

        $user->update([
            'role' => $request->role
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('toastr', [
                'type' => 'success',
                'message' => 'User role updated successfully',
                'title' => 'Updated'
            ]);
    }
}
