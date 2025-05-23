@extends('layouts.app')

@section('content')

    <div class="row justify-content-center mt-3">
        <div class="col-md-8">

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="float-start">
                        Ajouter un nouvel utilisateur
                    </div>
                    <div class="float-end">
                        <a href="{{ route('users.index') }}" class="btn btn-primary btn-sm">&larr; Retour</a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.store') }}" method="post">
                        @csrf

                        <div class="mb-3 row">
                            <label for="name" class="col-md-4 col-form-label text-md-end text-start">Nom</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control @error('name') is-invalid @enderror {{ session('dark_mode') ? 'border-light' : '' }}" id="name" name="name" value="{{ old('name') }}">
                                @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="email" class="col-md-4 col-form-label text-md-end text-start">Email</label>
                            <div class="col-md-6">
                                <input type="email" class="form-control @error('email') is-invalid @enderror {{ session('dark_mode') ? 'border-light' : '' }}" id="email" name="email" value="{{ old('email') }}">
                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="password" class="col-md-4 col-form-label text-md-end text-start">Mot de passe</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control @error('password') is-invalid @enderror {{ session('dark_mode') ? 'border-light' : '' }}" id="password" name="password">
                                @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="department" class="col-md-4 col-form-label text-md-end text-start">Département</label>
                            <div class="col-md-6">
                                <select id="department_id" name="department_id" class="form-select {{ session('dark_mode') ? 'border-light' : '' }}">
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="role" class="col-md-4 col-form-label text-md-end text-start">Role</label>
                            <div class="col-md-6">
                            <select name="role" id="role" class="form-select {{ session('dark_mode') ? 'border-light' : '' }}" required>
                                <option value="">-- Sélectionner un rôle --</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="mb-3 row">
                            <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Ajouter l'utilisateur">
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
