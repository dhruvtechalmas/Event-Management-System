<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller implements HasMiddleware 
{

     public static  function middleware(): array
    {
        return [
            new Middleware('permission:permission.index', only: ['index']),
            new Middleware('permission:permission.create', only: ['create','store' ]),
            new Middleware('permission:permission.edit', only: ['edit', 'update']),
            new Middleware('permission:permission.delete', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::latest()->paginate(15);
        return view('backend.permissions.list', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedPermission = $request->validate([
            'name' => 'required|unique:permissions,name',
        ]);

        Permission::create($validatedPermission);

        return redirect()->route('permissions.index')->with([
            'message' => 'Permission Created successful!',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        $permission = Permission::findOrFail($permission->id );
        return view('backend.permissions.edit', compact('permission'));

    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        $permission = Permission::findOrFail($permission->id);

        $validatedPermission = $request->validate([
           'name' => 'required|unique:permissions,name',
        ]);

        $permission->update($validatedPermission);

        return redirect()->route('permissions.index')->with([
            'message' => 'Permission Updated successful!',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();

         return redirect()->route('permissions.index')->with([
            'message' => 'Permission Deleted successful!',
            'alert-type' => 'success'
        ]);

    }
}
