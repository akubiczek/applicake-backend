<?php

use App\Models\Permission;
use App\Models\Role;

class RolesAndPermissionsSeeder extends \App\Services\TenantAwareSeeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'read users']);
        Permission::create(['name' => 'update users']);
        Permission::create(['name' => 'delete users']);

        Permission::create(['name' => 'create recruitments']);
        Permission::create(['name' => 'read all recruitments']);
        Permission::create(['name' => 'update any recruitment']);

        Permission::create(['name' => 'read granted recruitments']);

        // create roles and assign created permissions
        Role::create(['name' => 'recruiter'])
            ->givePermissionTo(['create recruitments', 'read all recruitments', 'update any recruitment']);
        Role::create(['name' => 'team-member'])->givePermissionTo(['read granted recruitments']);

        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());
    }
}
