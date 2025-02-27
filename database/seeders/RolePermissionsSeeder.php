<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userPermissions = [
            Permission::create(['name' => 'users_view']),  
            Permission::create(['name' => 'users_edit']),
            Permission::create(['name' => 'users_create']),
            Permission::create(['name' => 'users_delete']),
            Permission::create(['name' => 'users_restore']),
        ];
        $roleAdmin = Role::create(['name' => 'Administrator', 'home_page' => '/'])->givePermissionTo(Permission::all());
        $roleUser = Role::create(['name' => 'User', 'home_page' => '/'])->givePermissionTo(['users_view']);
    }
}
