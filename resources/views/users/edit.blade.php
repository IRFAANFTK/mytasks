@extends('layouts.app')

@section('content')

    <div class="row justify-content-center mt-3">
        <div class="col-md-8">

            @if ($message = Session::get('success'))
                <div class="alert alert-success" role="alert">
                    {{ $message }}
                </div>
            @endif

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="float-start">
                        Modifier l'utilisateur
                    </div>
                    <div class="float-end">
                        <a href="{{ route('users.index') }}" class="btn btn-primary btn-sm">&larr; Retour</a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method("PUT")

                        <div class="mb-3 row">
                            <label for="name" class="col-md-4 col-form-label text-md-end text-start">Nom</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control @error('name') is-invalid @enderror {{ session('dark_mode') ? 'border-light' : '' }}" id="name" name="name" value="{{ $user->name }}">
                                @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="email" class="col-md-4 col-form-label text-md-end text-start">Email</label>
                            <div class="col-md-6">
                                <input type="email" class="form-control @error('email') is-invalid @enderror {{ session('dark_mode') ? 'border-light' : '' }}" id="email" name="email" value="{{ $user->email }}">
                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="department" class="col-md-4 col-form-label text-md-end text-start">Département</label>
                            <div class="col-md-6">
                                <select id="department_id" name="department_id" class="form-select {{ session('dark_mode') ? 'border-light' : '' }}">
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}" {{ old('department_id', $user->department_id) == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="role" class="col-md-4 col-form-label text-md-end text-start">Rôle</label>
                            <div class="col-md-6">
                                <select name="role" id="role" class="form-select {{ session('dark_mode') ? 'border-light' : '' }}" required>
                                    <option value="">-- Sélectionner un rôle --</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                            {{ ucfirst($role->name) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Mettre à jour">
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
