@extends('layouts.app')

@section('content')

    <div class="row justify-content-center mt-3">
        <div class="col-md-8">

            @if ($message = Session::get('success'))
                <div class="alert alert-success" role="alert">
                    {{ $message }}
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <div class="float-start">
                        Edit Task
                    </div>
                    <div class="float-end">
                        <a href="{{ route('tasks.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                        @csrf
                        @method("PUT")

                        <div class="mb-3 row">
                            <label for="name" class="col-md-4 col-form-label text-md-end text-start">Name</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                       name="name" value="{{ $task->name }}">
                                @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="description"
                                   class="col-md-4 col-form-label text-md-end text-start">Description</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control @error('description') is-invalid @enderror"
                                       id="description" name="description" value="{{ $task->description }}">
                                @if ($errors->has('description'))
                                    <span class="text-danger">{{ $errors->first('description') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <br>
                            <label for="started_at"
                                   class="col-md-4 col-form-label text-md-end text-start">
                                Started At</label>

                            <div class="col-md-6">
                                <input type="date" class="form-control @error('started_at') is-invalid @enderror"
                                        name="started_at"
                                value="{{ old('started_at', \Carbon\Carbon::parse($task->started_at)->format('Y-m-d')) }}"
                                @error('started_at')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="ended_at"
                                   class="col-md-4 col-form-label text-md-end text-start">Ended At</label>
                            <div class="col-md-6">

                                <input type="date" class="form-control @error('ended_at') is-invalid @enderror"
                                       name="ended_at"
                                       value="{{ old('ended_at', \Carbon\Carbon::parse($task->ended_at)->format('Y-m-d')) }}"
                                @error('ended_at')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="assignee"
                                   class="col-md-4 col-form-label text-md-end text-start">Assignee</label>
                            <div class="col-md-6">
                                <select id="form-control" name="user_id">
                                    @foreach($users as $user)
                                        <option value= "{{ $user->id }}" {{$task->user_id == $user->id ? 'selected' : '' }}>
                                        {{ $user->name  }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Update">
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
