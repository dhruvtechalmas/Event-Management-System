<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;


class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(5);
        $roles = Role::all();
        return view('backend.users.users-list', compact('users', 'roles'));

    }

    public function create()
    {
        $roles = Role::all();
        return view('backend.users.add-user', compact('roles'));
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8',
            'role_id' => 'required|exists:roles,id',
        ]);
        // Create a new user
        $user = User::create($validatedData);

        $role = Role::findById($request->role_id);

        $user->assignRole($role->name);

        // Redirect to the users list with a success message Tostr message
        return redirect()->route('users.index')->with([
            'message' => 'User Created successful!',
            'alert-type' => 'success'
        ]);
    }

    public function show(User $user)
    {
        return view('backend.users.user-details', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('backend.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        // Validate the request data    
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:20',
            'password' => 'nullable|string|min:8',
            'role_id' => 'required|exists:roles,id',
        ]);

        // Find the user and update their information
        $user->update($validatedData);
        $role = Role::findById($request->role_id);
        $user->syncRoles([$role->name]);

        // Redirect to the users list with a success message Tostr message
        return redirect()->route('users.index')->with([
            'message' => 'User Updated successful!',
            'alert-type' => 'success'
        ]);

    }

    public function destroy(User $user)
    {
        $user->delete();

        // Redirect to the users list with a success message Tostr message
        return redirect()->route('users.index')->with([
            'message' => 'User Deleted successful!',
            'alert-type' => 'success'
        ]);
    }
}
