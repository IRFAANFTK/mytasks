@extends('layouts.app')

@section('content')



    <div class="position-relative">
        <a href="{{ route('tasks.index') }}"
           class="btn btn-dark position-absolute top-0 end-0 m-3">Back</a>
    </div>

    <div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="card shadow-lg" style="width: 30rem;">
            <div class="card-body text-center">
                <h3 class="card-title mb-4">User Details</h3>
                <h5 class="card-subtitle mb-3 text-primary">{{ $task->name }}</h5>
                <p class="card-text"><strong>started_at:</strong> {{ $task->started_at }}</p>
                <p class="card-text"><strong>ended_at:</strong> {{ $task->ended_at }}</p>
                <p class="card-text"><strong>assign:</strong> {{ optional($task->user)->name }} </p>
                <p class="card-text"><strong>description:</strong> {{ $task->description }}</p>

            </div>
        </div>
    </div>
@endsection
