@extends('layouts.app')

@section('content')

    <div class="row justify-content-center mt-3">
        <div class="col-md-8">

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
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
                        <label for="due_at"
                               class="col-md-4 col-form-label text-md-end text-start"><strong>Due_at:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $task->due_at }}
                        </div>
                    </div>
                    <div class="row">
                        <label for="started_at"
                               class="col-md-4 col-form-label text-md-end text-start"><strong>Started_at:</strong></label>
                            {{ $task->started_at }}
                        </div>
                    </div>

                <div class="row">
                    <label for="ended_at"
                           class="col-md-4 col-form-label text-md-end text-start"><strong>Ended_at:</strong></label>
                    <div class="col-md-6" style="line-height: 35px;">
                        {{ $task->ended_at }}
                    </div>
                </div>

                    <div class="row">
                        <label for="assignee"
                               class="col-md-4 col-form-label text-md-end text-start"><strong>Assignee:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $task->assignee->name ?? 'N/A' }}
                        </div>
                    </div>



@endsection
