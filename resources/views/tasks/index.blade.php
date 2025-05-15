@extends('layouts.app')


@section('content')

    <div class="row justify-content-center mt-3">
        <div class="col-md-12">

            @if ($message = Session::get('success'))
                <div class="alert alert-success" role="alert">
                    {{ $message }}
                </div>
            @endif

            <div class="card">
                <div class="card-header">Tasks List</div>
                <div class="card-body">
                    <a href="{{ route('tasks.create') }}" class="btn btn-success btn-sm my-2"><i
                            class="bi bi-plus-circle"></i> Add New Task</a>
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">S#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Started at</th>
                            <th scope="col">Ended at</th>
                            <th scope="col">Assignee</th>
                            <th scope="col">Created at</th>
                            <th scope="col">Updated at</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($tasks as $task)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $task->name }}</td>
                                <td>{{ $task->description }}</td>
                                <td>{{ $task->started_at }}</td>
                                <td>{{ $task->ended_at }}</td>
                                <td>{{ $task->user ? $task->user->name : 'No User Assigned' }}</td>
                                <td>{{ $task->created_at }}</td>
                                <td>{{ $task->updated_at }}</td>
                                <td>
                                    <form action="{{ route('tasks.destroy', $task->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')

                                        <a href="{{ route('tasks.show', $task->id) }}"
                                           class="btn btn-warning btn-sm"><i class="bi bi-eye"></i> Show</a>

                                        <a href="{{ route('tasks.edit', $task->id) }}"
                                           class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>

                                        <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Do you want to delete this task?');"><i
                                                class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <td colspan="6">
                                <span class="text-danger">
                                    <strong>No Tasks Found!</strong>
                                </span>
                            </td>
                        @endforelse
                        </tbody>
                    </table>

                    {{ $tasks->links() }}

                </div>
            </div>
        </div>
    </div>

@endsection
