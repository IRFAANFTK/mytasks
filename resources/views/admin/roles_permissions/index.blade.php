<!-- resources/views/admin/roles_permissions/index.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Roles & Permissions Management</h1>


        <div class="card mb-4">
            <div class="card-header">
                <h5>Create Role</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.roles_permissions.createRole') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="role-name" class="form-label">Role Name</label>
                        <input type="text" class="form-control" name="name" id="role-name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Role</button>
                </form>
            </div>
        </div>


        <div class="card mb-4">
            <div class="card-header">
                <h5>Create Permission</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.roles_permissions.createPermission') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="permission-name" class="form-label">Permission Name</label>
                        <input type="text" class="form-control" name="name" id="permission-name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Permission</button>
                </form>
            </div>
        </div>


        <div class="card mb-4">
            <div class="card-header">
                <h5>Roles</h5>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach ($roles as $role)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $role->name }}
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.roles_permissions.editRole', $role->id) }}" class="btn btn-primary btn-sm">
                                    Edit
                                </a>

                                <form action="{{ route('admin.roles_permissions.deleteRole', $role->id) }}" method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this role?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>


                            <span class="badge bg-info">{{ $role->permissions->count() }} Permissions</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>


        <div class="card mb-4">
            <div class="card-header">
                <h5>Permissions</h5>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach ($permissions as $permission)
                        <li class="list-group-item">
                            {{ $permission->name }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>


        <div class="card mb-4">
            <div class="card-header">
                <h5>Assign Permissions to Role</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.roles_permissions.assignPermissionsToRole') }}" method="POST">
                    @csrf
                    <div class="mb-3">

                        <label for="role" class="form-label">Select Role </label>
                        <select name="roleId" id="role" class="form-select">
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">

                        <label for="permissions" class="form-label">Select Permissions</label>
                        <select name="permissions[]" id="permissions" class="form-select" multiple>
                            @foreach ($permissions as $permission)
                                <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Assign Permissions</button>
                </form>
            </div>
        </div>

    </div>
@endsection
