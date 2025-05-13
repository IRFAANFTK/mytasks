@extends('layouts.app')

@section('content')



    <div class="position-relative">
        <a href="{{ route('departments.index') }}"
           class="btn btn-dark position-absolute top-0 end-0 m-3">Back</a>
    </div>

    <div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="card shadow-lg" style="width: 30rem;">
            <div class="card-body text-center">
                <h3 class="card-title mb-4">User Details</h3>
                <h5 class="card-subtitle mb-3 text-primary">{{ $department->name }}</h5>

            </div>
        </div>
    </div>
@endsection
