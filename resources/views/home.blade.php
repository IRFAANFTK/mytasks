@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="text-center mb-3">
                    <h3 class="card-title ">CREATED
                        <i class=""></i>
                    </h3>
                </div>
                    @foreach($createdTasks as $task)
                    <div class="card" style="width: 18rem;border-color: #0dcaf0">
                        <div class="card-body">
                            <b>
                            <h5 class="card-title">{{$task->name}}</b>
                            </h5>
                            <p class="card-text">Tasks that are just added to the system and not yet started.</p>
                            <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-primary">
                                <i class="bi bi-eye"></i> View
                            </a>
                            <a href="{{ route('tasks.start', $task->id) }}" class="btn btn-success">
                                <i class=""></i> Start
                            </a>
                        </div>
                    </div>
                    <br>
                    @endforeach
            </div>
            <div class="col-md-4">
                <div class="text-center mb-3">
                    <h3 class="card-title">IN PROGRESS
                        <i class="bi bi-arrow-repeat"></i>
                    </h3>
                </div>
                @foreach($inProgressTasks as $task)
                <div class="card" style="width: 18rem;border-color: #0dcaf0">
                    <div class="card-body">
                        <b>
                            <h5 class="card-title"> {{$task->name}}</b>
                            </h5>
                        <p class="card-text">Tasks currently being worked on.</p>
                        <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-info">
                            <i class="bi bi-eye"></i> View
                        </a>
                        <a href="{{ route('tasks.end', $task->id) }}" class="btn btn-dark"">
                            <i class=""></i> End
                        </a>
                    </div>
                </div>
                <br>
                @endforeach
            </div>
            <div class="col-md-4">
                <div class="text-center mb-3">
                    <h3 class="card-title">DONE
                        <i class="bi bi-check-all" style="color: green" ></i>
                    </h3>
                </div>
                @foreach( $doneTasks  as $task)
                <div class="card" style="width: 18rem;border-color: green">
                    <div class="card-body">
                        <b>
                        <h5 class="card-title"> {{$task->name}}</b>
                            <i class="bi bi-check-all" style="color: green" ></i>
                        </h5>
                        <p class="card-text">Tasks that are completed.</p>
                        <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-success">
                            <i class="bi bi-eye"></i> View
                        </a>

                        <a href="{{ route('tasks.delete', $task->id) }}" class="btn btn-danger">
                            <i class=""></i> Delete
                        </a>
                        <div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">100%</div>
                    </div>
                </div>
                    <br>
                @endforeach
            </div>
        </div>
    </div>
@endsection
















