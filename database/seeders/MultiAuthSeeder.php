<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class MultiAuthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        $adminUser = User::create([
            'name' => 'Hassam',
            'email' => 'spickyyy@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
        $adminRole = Role::create([
            'name' => 'Admin',
            'guard_name' => 'web',
        ]);
        $adminPermissions = Permission::create([
            'name' => 'do-anything',
            'guard_name' => 'web',
        ]);
        $adminRole->givePermissionTo($adminPermissions);
        $adminUser->assignRole($adminRole);

        $vendorUser = User::create([
            'name' => 'Tom',
            'email' => 'vendor@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
        $vendorRole = Role::create([
            'name' => 'Vendor',
            'guard_name' => 'web',
        ]);
        $vendorPermissions = [
            'create-gig',
            'edit-gig',
            'update-gig',
            'delete-gig',
        ];
        foreach ($vendorPermissions as $permission) {
            $permissionModel = Permission::create([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
            $vendorRole->givePermissionTo($permissionModel);
        }
        $vendorUser->assignRole($vendorRole);

        $customerUser = User::create([
            'name' => 'Bob',
            'email' => 'customer@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
        $customerRole = Role::create([
            'name' => 'Customer',
            'guard_name' => 'web',
        ]);
        $customerPermissions = [
            'add-order',
            'remove-order',
            'see-order',
            'see-basket',
            'make-payment',
        ];
        foreach ($customerPermissions as $customerPermission) {
            $permissionModel = Permission::create([
                'name' => $customerPermission,
                'guard_name' => 'web',
            ]);
            $customerRole->givePermissionTo($permissionModel);
        }
        $customerUser->assignRole($customerRole);
    }
}
