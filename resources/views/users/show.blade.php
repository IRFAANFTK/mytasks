@extends('layouts.app')

@section('content')
    <div class="row justify-content-center mt-3">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Informations Utilisateur</span>
                    <a href="{{ route('users.index') }}" class="btn btn-primary btn-sm">&larr; Retour</a>
                </div>

                <div class="card-body">
                    <div class="row mb-2">
                        <label class="col-md-4 col-form-label text-md-end text-start"><strong>Nom :</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $user->name }}
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label class="col-md-4 col-form-label text-md-end text-start"><strong>Email :</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $user->email }}
                        </div>
                    </div>

                    <div class="row mb-4">
                        <label class="col-md-4 col-form-label text-md-end text-start"><strong>Département :</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $user->department?->name ?? 'Pas de département' }}
                        </div>
                    </div>

                    <div class="card mt-4">
                        <div class="card-header">
                            <strong>Tâches Assignées</strong>
                        </div>
                        <div class="card-body">
                            @if ($user->tasks->count())
                                <ol class="list-group list-group-numbered">
                                    @foreach ($user->tasks as $task)
                                        <li class="list-group-item">
                                            <strong>{{ $task->name }}</strong> – {{ $task->description }}
                                            <br>
                                            <small class="text-muted">Du {{ $task->started_at }} au {{ $task->ended_at }}</small>
                                        </li>
                                    @endforeach
                                </ol>
                            @else
                                <p class="text-muted">Aucune tâche assignée.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
