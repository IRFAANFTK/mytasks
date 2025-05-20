@extends('layouts.app')

@section('content')
    @yield('scripts')

    <div class="row justify-content-center mt-3">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">
                    <div class="float-start">
                        Add New Task
                    </div>
                    <div class="float-end">
                        <a href="{{ route('tasks.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('tasks.store') }}" method="post">
                        @csrf

                        <div class="mb-3 row">
                            <label for="name" class="col-md-4 col-form-label text-md-end text-start">Name</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                       name="name" value="{{ old('name') }}">
                                @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="description" class="col-md-4 col-form-label text-md-end text-start">Description</label>
                            <div class="col-md-6">
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                          id="description" name="description">{{ old('description') }}</textarea>
                                @if ($errors->has('description'))
                                    <span class="text-danger">{{ $errors->first('description') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="due_at"
                                   class="col-md-4 col-form-label text-md-end text-start">Due At</label>
                            <div class="col-md-6">
                                <input type="date" class="form-control @error('due_at') is-invalid @enderror"
                                       id="due_at" name="due_at">{{ old('due_at') }}</textarea>
                                @if ($errors->has('due_at'))
                                    <span class="text-danger">{{ $errors->first('due_at') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="started_at"
                                   class="col-md-4 col-form-label text-md-end text-start">Started At</label>
                            <div class="col-md-6">
                                <input type="date" class="form-control @error('started_at') is-invalid @enderror"
                                          id="started_at" name="started_at">{{ old('started_at') }}</textarea>
                                @if ($errors->has('started_at'))
                                    <span class="text-danger">{{ $errors->first('started_at') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="ended_at"
                                   class="col-md-4 col-form-label text-md-end text-start">Ended At</label>
                            <div class="col-md-6">
                                <input type="date" class="form-control @error('ended_at') is-invalid @enderror"
                                       id="ended_at" name="ended_at">{{ old('ended_at') }}</textarea>
                                @if ($errors->has('ended_at'))
                                    <span class="text-danger">{{ $errors->first('ended_at') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="assignee"
                                   class="col-md-4 col-form-label text-md-end text-start">Assignee</label>
                            <div class="col-md-6">
                                <select id="user_id" name="user_id">
                                  @foreach($users as $user)
                                      <option value= "{{ $user->id }}">{{$user->name}}</option>
                                  @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="progress" class="form-label">Progress (%)</label>
                            <div class="d-flex align-items-center">
                                <input type="range" class="form-range me-3" name="progress" id="progress" min="0" max="100"
                                       value="{{ old('progress', $task->progress ?? 0) }}">
                                <span id="progressValue" class="fw-bold">{{ old('progress', $task->progress ?? 0) }}</span>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Add Tasks">
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const slider = document.getElementById('progress');
            const output = document.getElementById('progressValue');
            if (slider && output) {
                output.innerText = slider.value;
                slider.addEventListener('input', function () {
                    output.innerText = this.value;
                });
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggles = document.querySelectorAll('.toggle-switch');
            const input = document.getElementById('priorityInput');
            const label = document.getElementById('priorityLabel');
            toggles.forEach(toggle => {
                toggle.addEventListener('click', function () {

                    toggles.forEach(t => t.classList.remove('active'));

                    this.classList.add('active');

                    const priority = this.getAttribute('data-priority');
                    input.value = priority;
                    label.textContent = priority;
                });
            });

            const current = input.value;
            document.querySelector(`.toggle-switch[data-priority="${current}"]`)?.classList.add('active');
        });
    </script>
@endsection
