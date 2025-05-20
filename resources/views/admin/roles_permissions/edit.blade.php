@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h4>Edit Role: {{ $role->name }}
                <div class="float-end">
                    <a href="{{ route('admin.roles_permissions.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                </div>
                </h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.roles_permissions.updateRole', $role->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Role Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $role->name }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Assign Permissions</label>
                        <div class="row">
                            @foreach ($permissions as $permission)
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               name="permissions[]"
                                               value="{{ $permission->id }}"
                                               id="perm_{{ $permission->id }}"
                                            {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="perm_{{ $permission->id }}">
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="d-flex gap-3 mt-4">
                        <button type="submit" class="btn btn-success">Save Changes</button>
                    </div>
                </form>
                <form action="{{ route('admin.roles_permissions.deleteRole', $role->id) }}" method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this role?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger">Delete Role</button>
                </form>
            </div>
        </div>
    </div>
@endsection
