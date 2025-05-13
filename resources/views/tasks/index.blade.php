@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Tasks Lists

                        <a href="/tasks/create"><button type="button" class="btn btn-success">Add New Task</button></a>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover">

                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                               <th scope="col">Started_at</th>
                                <th scope="col">Ended_at</th>
                                <th scope="col">Assignee</th>
                                <th scope="col">Description</th>
                                <th scope="col">Created_at</th>
                                <th scope="col">Updated_at</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($tasks as $task)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}}</th>
                                    <td>{{$task->name}}</td>
                                    <td>{{$task->started_at}}</td>
                                    <td>{{$task->ended_at}}</td>
                                    <td>{{ optional($task->user)->name }}</td>
                                    <td>{{$task->description}}</td>
                                    <td>{{$task->created_at}}</td>
                                    <td>{{$task->updated_at}}</td>


                                    <td>
                                        <a href="{{ route('tasks.show', $task->id) }}">
                                            <button type="button" class="btn btn-info">Show</button>
                                        </a>

                                        <a href="/tasks/edit/{{$task->id}}">
                                            <button type="button" class="btn btn-warning">Edit</button>
                                        </a>

                                        <form action="{{ route('tasks.delete', $task->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">
                                                Delete
                                            </button>
                                        </form>
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
