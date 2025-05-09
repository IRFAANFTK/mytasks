@extends('layouts.app')

@section('content')

    <div class="row justify-content-center mt-3">
        <div class="col-md-8">

            <div class="card">
                        <div class="card-header">
                            <div class="float-start">
                                Users Information
                            </div>
                            <div class="float-end">
                                <a href="{{ route('users.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start"><strong>Name:</strong></label>
                                <div class="col-md-6" style="line-height: 35px;">
                                    {{ $user->name }}
                                </div>
                            </div>

                            <div class="row">
                                <label for="email" class="col-md-4 col-form-label text-md-end text-start"><strong>Email:</strong></label>
                                <div class="col-md-6" style="line-height: 35px;">
                                    {{ $user->email }}
                                </div>
                            </div>

                            <div class="row">
                                <label for="department" class="col-md-4 col-form-label text-md-end text-start"><strong>Department:</strong></label>
                                <div class="col-md-6" style="line-height: 35px;">
                                    {{ $user->department->name}}
                                </div>
                            </div>



                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="float-start">
                        Users Information
                    </div>
                    <div class="float-end">
                        <a href="{{ route('users.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                    </div>
                </div>
                <div class="card-body">

                    <ol class="list-group list-group-numbered">
                        @foreach($user->tasks as $task)
                        <li class="list-group-item">  <div>
                            <strong>{{$task->title}}</strong><br>
                             <small>{{$task->description}}</small> </li>@endforeach

                    </ol>
                    @if($user->tasks->isEmpty())
        <p class="text-muted mt-2"> No Tasks available.</p>
    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
