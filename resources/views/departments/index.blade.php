@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Departments Lists
                        <br>
                        <a href="/departments/create"><button type="button" class="btn btn-success"> Create Departments </button></a>

                    </div>

                    <div class="card-body">
                        <table class="table table-hover">

                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($departments as $department)
                                <tr>
                                    <th scope="row">{{$department->id}}</th>
                                    <td>{{$department->name}}</td>


                                    <td>
                                        <a href="{{ route('departments.show', $department->id) }}">

                                        <button type="button" class="btn btn-info">Show</button>
                                        </a>
                                        <a href="/departments/edit/{{$department->id}}">
                                            <button type="button" class="btn btn-warning">Edit</button>
                                        </a>

                                        <form action="{{ route('departments.delete', $department->id) }}" method="POST" style="display:inline;">
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
