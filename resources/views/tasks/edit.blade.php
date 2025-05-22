@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Edit Task</h5>
                <a href="{{ route('tasks.index') }}" class="btn btn-sm btn-primary">← Back</a>
            </div>
            <div class="card-body">
                <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror {{ session('dark_mode') ? 'bg-dark text-white' : '' }}" name="name" value="{{ old('name', $task->name ?? '') }}">

                        @error('name')
                        <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror {{ session('dark_mode') ? 'bg-dark text-white' : '' }}">{{ old('description', $task->description ?? '') }}</textarea>

                        @error('description')
                        <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="started_at" class="form-label">Started At</label>
                        <input type="date" class="form-control @error('started_at') is-invalid @enderror {{ session('dark_mode') ? 'bg-dark text-white' : '' }}" name="started_at" value="{{ old('started_at', isset($task) ? \Carbon\Carbon::parse($task->started_at)->format('Y-m-d') : '') }}">

                        @error('started_at')
                        <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="ended_at" class="form-label">Ended At</label>
                        <input type="date" class="form-control @error('ended_at') is-invalid @enderror {{ session('dark_mode') ? 'bg-dark text-white' : '' }}" name="ended_at" value="{{ old('ended_at', isset($task) ? \Carbon\Carbon::parse($task->ended_at)->format('Y-m-d') : '') }}">

                        @error('ended_at')
                        <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="user_id" class="form-label">Assignee</label>
                        <select class="form-select {{ session('dark_mode') ? 'bg-dark text-white' : '' }}" name="user_id">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id', $task->user_id ?? '') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="priority" class="form-label">Priority</label>
                        <select name="priority" class="form-select {{ session('dark_mode') ? 'bg-dark text-white' : '' }}">
                            <option value="Low" {{ old('priority') == 'Low' ? 'selected' : '' }}>Low</option>
                            <option value="Medium" {{ old('priority') == 'Medium' ? 'selected' : '' }}>Medium</option>
                            <option value="High" {{ old('priority') == 'High' ? 'selected' : '' }}>High</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="progress" class="form-label">Progress (%)</label>
                        <div class="d-flex align-items-center gap-3">
                            <input type="range" class="form-range" name="progress" id="progress" min="0" max="100" value="{{ old('progress', $task->progress ?? 0) }}">
                            <span id="progressValue" class="fw-bold">{{ old('progress', $task->progress ?? 0) }}</span>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const slider = document.getElementById('progress');
            const output = document.getElementById('progressValue');
            if (slider && output) {
                output.innerText = slider.value;
                slider.addEventListener('input', function () {
                    output.innerText = this.value;
                });
            }
        });
    </script>
@endsection
