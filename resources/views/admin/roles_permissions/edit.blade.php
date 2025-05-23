@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="card {{ session('dark_mode') ? 'bg-dark text-white border-light' : '' }}">
            <div class="card-header {{ session('dark_mode') ? 'bg-dark text-white border-white' : '' }}">
                <h4>Modifier le Rôle : {{ $role->name }}
                    <div class="float-end">
                        <a href="{{ route('admin.roles_permissions.index') }}" class="btn btn-primary btn-sm">&larr; Retour</a>
                    </div>
                </h4>
            </div>
            <div class="card-body {{ session('dark_mode') ? 'bg-dark text-white' : '' }}">
                <form action="{{ route('admin.roles_permissions.updateRole', $role->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Nom du Rôle</label>
                        <input type="text" name="name" class="form-control {{ session('dark_mode') ? 'bg-dark text-white border-light' : '' }}" value="{{ $role->name }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Assigner des Permissions</label>
                        <div class="row">
                            @foreach ($permissions as $permission)
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input {{ session('dark_mode') ? 'border-light' : '' }}"
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
                        <button type="submit" class="btn btn-success">Enregistrer les Modifications</button>
                    </div>
                </form>

                <form action="{{ route('admin.roles_permissions.deleteRole', $role->id) }}" method="POST"
                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce rôle ?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger">Supprimer le Rôle</button>
                </form>
            </div>
        </div>
    </div>
@endsection
