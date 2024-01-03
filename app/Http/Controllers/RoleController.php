<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class RoleController extends Controller
{
    public function index()
    {
        return Inertia::render('Roles/Create');
    }

    public function getRoles(Request $request): \Illuminate\Http\JsonResponse
    {
        $rolesWithPermissions = \Spatie\Permission\Models\Role::with(['permissions' => function ($query) {
            $query->select('name');
        }])->where('name', 'LIKE', "%{$request->searchString}%")->orderBy('id', 'DESC')->paginate();

        $permissions = \Spatie\Permission\Models\Permission::orderBy('id', 'DESC')->get();

        return response()->json(['rolesWithPermissions' => $rolesWithPermissions, 'permissions' => $permissions]);
    }

    public function addRole(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'role' => 'bail|required', //|unique: roles
            'permissions' => 'bail|required|min:1|array', //|unique: permissions
        ], [
            'permissions.required' => 'Please assign any permission to role.',
        ]);
        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()]);
        }

        $role = \Spatie\Permission\Models\Role::create(['name' => $request->role]);
        foreach ($request->permissions as $permission) {
            \Spatie\Permission\Models\Permission::create(['name' => $permission]);
        }

        $role->givePermissionsTo($request->permissions);

        $user = Auth::user();
        $user->assignRole($role);

        return response()->json(['success' => 'Added Role Successfully!']);
    }

    public function deleteRole($id)
    {
        $role = \Spatie\Permission\Models\Role::with('permissions')->find($id);
        $role->syncPermissions();
        $users = \App\Models\User::role($role)->get();
        foreach ($users as $user) {
            $user->removeRole($role);
        }
        $role->delete();

        return response()->json(['success' => 'Role Deleted Successfully!']);
    }
}
