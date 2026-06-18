<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Models\Role;


class UserController extends Controller implements HasMiddleware
{
    public static  function middleware(): array
    {
        return [
            new Middleware('permission:user.index', only: ['index']),
            new Middleware('permission:user.create', only: ['create','store' ]),
            new Middleware('permission:user.edit', only: ['edit', 'update']),
            new Middleware('permission:user.delete', only: ['destroy']),
            new Middleware('permission:user.view', only: ['show']),
        ];
    }

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

    public function store(StoreUserRequest $request)
    {
        // Create a new user
        $user = User::create($request->validated());

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

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());

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
