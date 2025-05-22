@extends('layouts.app')
@section('content')

    <div class="row justify-content-center mt-3">
        <div class="col-md-8">

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="float-start">
                        Add New Department
                    </div>
                    <div class="float-end">
                        <a href="{{ route('departments.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('departments.store') }}" method="post">
                        @csrf
                        <div class="mb-3 row">
                            <label for="name" class="col-md-4 col-form-label text-md-end text-start">Name</label>
                            <div class="col-md-6">
                                <input type="text" name="name" class="form-control" placeholder="Department Name">
                                </div>
                        </div>



                        <div class="mb-3 row">
                            <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Add Department">
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
