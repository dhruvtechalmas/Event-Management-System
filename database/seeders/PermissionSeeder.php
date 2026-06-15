<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [

            // Dashboard
            'dashboard.index',

            // Users
            'user.index',
            'user.create',
            'user.edit',
            'user.delete',
            'user.view',

            // Roles
            'role.index',
            'role.create',
            'role.edit',
            'role.delete',
            'role.view',

            // Permissions
            'permission.index',
            'permission.create',
            'permission.edit',
            'permission.delete',
            'permission.view',

            // Events
            'event.index',
            'event.create',
            'event.edit',
            'event.delete',
            'event.view',

            // Tasks
            'task.index',
            'task.create',
            'task.edit',
            'task.delete',
            'task.view',

            // Participants
            'participant.index',
            'participant.create',
            'participant.edit',
            'participant.delete',
            'participant.view',

            // Calendar
            'calendar.index',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }
    }
}