@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Editing Task {{$task->name}}

                        <div class="position-relative">
                            <a href="{{ route('tasks.index') }}"
                               class="btn btn-dark position-absolute top-0 end-0 m-3">Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('tasks.update') }}">
                            @csrf
                            <input type="hidden" value="{{$task->id}}" name="task_id">

                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$task->name}}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('started_at') }}</label>

                                <div class="col-md-6">
                                    <input id="started_at" type="date" class="form-control @error('started_at') is-invalid @enderror" name="started_at" value="{{$task->started_at}}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="ended_at" class="col-md-4 col-form-label text-md-end">{{ __('ended_at') }}</label>

                                <div class="col-md-6">
                                    <input id="ended_at" type="date" class="form-control @error('ended_at') is-invalid @enderror" name="ended_at" value="{{$task->ended_at}}" required autocomplete="name" autofocus>

                                    @error('ended_at')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="ended_at" class="col-md-4 col-form-label text-md-end">{{ __('ended_at') }}</label>

                                <div class="col-md-6">
                                    <input id="ended_at" type="date" class="form-control @error('ended_at') is-invalid @enderror" name="ended_at" value="{{$task->ended_at}}" required autocomplete="name" autofocus>

                                    @error('ended_at')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="assignee" class="col-md-4 col-form-label text-md-end text-start">Assignee</label>
                                <div class="col-md-6">
                                    <select id="form-control" name="user_id">
                                        @foreach($users as $user)
                                            <option value= "{{ $user->id }}" {{$task->user_id == $user->id ? 'selected' : '' }}>
                                                {{ $user->name  }}
                                            </option>
                                        @endforeach
                                    </select>    </div>
                            </div>



                            <div class="row mb-3">
                                <label for="description" class="col-md-4 col-form-label text-md-end">{{ __('description') }}</label>
                                <div class="col-md-6">
                                    <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" required>{{ $task->description }}</textarea>
                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
                                    @enderror
                                </div>
                            </div>
















                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
