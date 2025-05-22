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
                <div class="card-header {{ session('dark_mode') ? 'bg-dark text-white' : ''}}">
                    Tasks
                </div>
                <div class="card-body">
                    @can('create tasks')
                        <div class="d-flex gap-2 mb-3">
                            <a href="{{ route('tasks.create') }}" class="btn btn-success btn-sm">
                                <i class="bi bi-plus-circle"></i> Add New Task
                            </a>
                            <a href="{{ route('tasks.export') }}" class="btn btn-success btn-sm">
                                <i class="bi bi-file-earmark-excel-fill"></i> Export Tasks to Excel
                            </a>
                        </div>
                    @endcan

                        <table class="table table-bordered">
                        <thead class="{{ session('dark_mode') ? 'table-secondary' : 'table-light' }}">
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
                                <td>{{ $task->user->name ?? 'No User Assigned' }}</td>
                                <td>{{ $task->created_at }}</td>
                                <td>{{ $task->updated_at }}</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-eye"></i> Show
                                        </a>
                                        @can('update tasks')
                                            <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-primary btn-sm">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </a>
                                        @endcan
                                        @can('delete tasks')
                                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this task?')">
                                                    <i class="bi bi-trash"></i> Delete
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9">
                                    <span class="text-danger"><strong>No Tasks Found</strong></span>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <!-- jQuery & DataTables Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#taskTable').DataTable({
                order: [[1, 'asc']],
                language: {
                    searchPlaceholder: "Search tasks...",
                    search: ""
                }
            });
        });
    </script>
@endsection
