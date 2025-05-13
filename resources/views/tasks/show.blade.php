@extends('layouts.app')

@section('content')

    <div class="row justify-content-center mt-3">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">
                    <div class="float-start">
                        Tasks Information
                    </div>
                    <div class="float-end">
                        <a href="{{ route('tasks.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                    </div>
                </div>
                <div class="card-body">

                    <div class="row">
                        <label for="name" class="col-md-4 col-form-label text-md-end text-start"><strong>Name:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $task->name }}
                        </div>
                    </div>

                    <div class="row">
                        <label for="description"
                               class="col-md-4 col-form-label text-md-end text-start"><strong>Description:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $task->description }}
                        </div>
                    </div>

                    <div class="row">
                        <label for="assignee"
                               class="col-md-4 col-form-label text-md-end text-start"><strong>Assignee:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $task->assignee->name ?? 'N/A' }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
