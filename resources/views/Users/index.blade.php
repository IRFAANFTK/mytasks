@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Users Lists
                        <a href="/users/create"><button type="button" class="btn btn-success">Add New User</button></a>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover">

                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Department</th>
                                <th scope="col">Email</th>
                                <th scope="col">No.of tasks</th>


                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{$user->name}}</td>
                                <td>{{$user->department->name?? 'No department'}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{ $user->tasks_count}}</td>





                                <td>
                                    <a href="{{ route('users.show', $user->id) }}">
                                        <button type="button" class="btn btn-info">Show</button>
                                    </a>
                                    <a href="/users/edit/{{$user->id}}">
                                        <button type="button" class="btn btn-warning">Edit</button>
                                    </a>

                                    <form action="{{ route('users.delete', $user->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this task?')">
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
