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
                <div class="card-header">Departments List</div>
                <div class="card-body">
                    @can('create department')
                    <a href="{{ route('departments.create') }}" class="btn btn-success btn-sm my-2"><i
                            class="bi bi-plus-circle"></i> Add New Department</a>
                    @endcan

                    <table id="departmentIrfaan" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">S#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Actions</th>

                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($departments as $department)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $department->name }}</td>
                                <td>
                                    <form action="{{ route('departments.destroy', $department->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')


                                        <a href="{{ route('departments.show', $department->id) }}"
                                           class="btn btn-warning btn-sm"><i class="bi bi-eye"></i> Show</a>

                                        @can('update department')
                                        <a href="{{ route('departments.edit', $department->id) }}"
                                           class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>
                                        @endcan


                                        @can('delete department')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Do you want to delete this department?');"><i
                                                class="bi bi-trash"></i> Delete
                                            @endcan

                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <td colspan="6">
                                <span class="text-danger">
                                    <strong>No Department Found!</strong>
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

            $('#departmentIrfaan').DataTable({

                order: [[1, 'asc']]

            });

        });

    </script>


@endsection
