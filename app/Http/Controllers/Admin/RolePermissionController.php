<?php

// app/Http/Controllers/Admin/RolePermissionController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    public function index()
    {
        $roles = Role::all();  // Get all roles
        $permissions = Permission::all();  // Get all permissions
        return view('admin.roles_permissions.index', compact('roles', 'permissions'));
    }

    public function createRole(Request $request)
    {
        $request->validate(['name' => 'required|unique:roles,name']);
        Role::create(['name' => $request->name]);
        return redirect()->route('admin.roles_permissions.index');
    }

    public function createPermission(Request $request)
    {
        $request->validate(['name' => 'required|unique:permissions,name']);
        Permission::create(['name' => $request->name]);
        return redirect()->route('admin.roles_permissions.index');
    }

    public function assignPermissionsToRole(Request $request)
    {
        // Fetch the selected role
        $role = Role::findById($request->input('roleId'));

        // Get the selected permission IDs from the form submission
        $permissions = $request->permissions;


        // Validate if the permission IDs exist
        $validPermissions = Permission::whereIn('id', $permissions)->pluck('id')->toArray();

        // Sync only valid permissions with the role
        $role->syncPermissions($validPermissions);

        return redirect()->route('admin.roles_permissions.index')->with('success', 'Permissions assigned successfully!');
    }

    public function editRole($id)
    {
        $role = Role::findById($id);
        $permissions = Permission::all();
        return view('admin.roles_permissions.edit', compact('role', 'permissions'));
    }

    public function updateRole(Request $request, $id)
    {
        $role = Role::findById($id);
        $role->name = $request->name;
        $role->save();

        $permissions = Permission:: whereIn('id', request('permissions'))->pluck('name');
        $role->syncPermissions($permissions);
        return redirect()->route('admin.roles_permissions.index')->with('success', 'Roles updated successfully!');
    }

    public function deleteRole($id)
    {
        $role = Role::findOrfail($id);
        $role->delete();

        return redirect()->route('admin.roles_permissions.index')->with('success', 'Roles deleted successfully!');

    }
}

