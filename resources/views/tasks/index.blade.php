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
                    @can('create tasks')
                    <a href="{{ route('tasks.create') }}" class="btn btn-success btn-sm my-2"><i
                            class="bi bi-plus-circle"></i> Add New Task</a>
                    @endcan
                    <table class="table table-striped table-bordered">
                    <table id="taskTable" class="table table-striped table-bordered">
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
                            <th scope="col">Actions</th>
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


                                        @can('update tasks')
                                           class="btn btn-warning btn-sm" ><i class="bi bi-eye"></i> Show</a>        <br>
                                        <br>
                                        <a href="{{ route('tasks.edit', $task->id) }}"
                                           class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>
                                        @endcan


                                        @can('delete tasks')
                                           class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i>  Edit <br></a> <br>

                                        <br>
                                        <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Do you want to delete this task?');"><i
                                                class="bi bi-trash"></i> Delete

                                        </button>
                                            @endcan
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



                </div>
            </div>
        </div>
    </div>








    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>



    <script>

        $(document).ready(function () {

            $('#taskTable').DataTable({

                order: [[1, 'asc']]

            });

        });

    </script>

@endsection
