@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1 class="section-title">Gestion des Rôles et Permissions</h1>

        {{-- Créer un Rôle --}}
        <div class="card mb-4">
            <div class="card-header">
                <h5>Créer un Rôle</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.roles_permissions.createRole') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="role-name" class="form-label">Nom du Rôle</label>
                        <input type="text" class="form-control" name="name" id="role-name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Créer le Rôle</button>
                </form>
            </div>
        </div>

        {{-- Créer une Permission --}}
        <div class="card mb-4">
            <div class="card-header">
                <h5>Créer une Permission</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.roles_permissions.createPermission') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="permission-name" class="form-label">Nom de la Permission</label>
                        <input type="text" class="form-control" name="name" id="permission-name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Créer la Permission</button>
                </form>
            </div>
        </div>

        {{-- Rôles --}}
        <div class="card mb-4">
            <div class="card-header">
                <h5>Rôles</h5>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach ($roles as $role)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $role->name }}
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.roles_permissions.editRole', $role->id) }}" class="btn btn-primary btn-sm">Modifier</a>
                                <form action="{{ route('admin.roles_permissions.deleteRole', $role->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce rôle ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Supprimer</button>
                                </form>
                            </div>
                            <span class="badge bg-info">{{ $role->permissions->count() }} Permissions</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- Permissions --}}
        <div class="card mb-4">
            <div class="card-header">
                <h5>Permissions</h5>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach ($permissions as $permission)
                        <li class="list-group-item">{{ $permission->name }}</li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- Assigner des Permissions --}}
        <div class="card mb-4">
            <div class="card-header">
                <h5>Assigner des Permissions à un Rôle</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.roles_permissions.assignPermissionsToRole') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="role" class="form-label">Sélectionner un Rôle</label>
                        <select name="roleId" id="role" class="form-select">
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="permissions" class="form-label">Sélectionner des Permissions</label>
                        <select name="permissions[]" id="permissions" class="form-select" multiple>
                            @foreach ($permissions as $permission)
                                <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Assigner les Permissions</button>
                </form>
            </div>
        </div>
    </div>
@endsection
