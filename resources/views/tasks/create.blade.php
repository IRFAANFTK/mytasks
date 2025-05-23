@extends('layouts.app')

@section('content')
    @yield('scripts')

    <div class="row justify-content-center mt-3">
        <div class="col-md-8">

            <div class="card {{ session('dark_mode') ? 'bg-dark text-white border-light' : '' }}">
                <div class="card-header {{ session('dark_mode') ? 'bg-dark text-white border-white' : '' }}">
                    <div class="float-start">
                        Ajouter une nouvelle tâche
                    </div>
                    <div class="float-end">
                        <a href="{{ route('tasks.index') }}" class="btn btn-primary btn-sm">&larr; Retour</a>
                    </div>
                </div>
                <div class="card-body {{ session('dark_mode') ? 'bg-dark text-white' : '' }}">
                    <form action="{{ route('tasks.store') }}" method="post">
                        @csrf

                        <!-- Task Name -->
                        <div class="mb-3 row">
                            <label for="name" class="col-md-4 col-form-label text-md-end text-start">Nom</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control @error('name') is-invalid @enderror {{ session('dark_mode') ? 'bg-dark text-white' : '' }}" id="name"
                                       name="name" value="{{ old('name') }}">
                                @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Task Description -->
                        <div class="mb-3 row">
                            <label for="description" class="col-md-4 col-form-label text-md-end text-start">Description</label>
                            <div class="col-md-6">
                                <textarea class="form-control @error('description') is-invalid @enderror {{ session('dark_mode') ? 'bg-dark text-white' : '' }}"
                                          id="description" name="description">{{ old('description') }}</textarea>
                                @if ($errors->has('description'))
                                    <span class="text-danger">{{ $errors->first('description') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Task Start Date -->
                        <div class="mb-3 row">
                            <label for="due_at"
                                   class="col-md-4 col-form-label text-md-end text-start">Due à</label>
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
                                   class="col-md-4 col-form-label text-md-end text-start">Commencé à</label>
                            <div class="col-md-6">
                                <input type="date" class="form-control @error('started_at') is-invalid @enderror {{ session('dark_mode') ? 'bg-dark text-white' : '' }} calendar-input"
                                       id="started_at" name="started_at" value="{{ old('started_at') }}">
                                @if ($errors->has('started_at'))
                                    <span class="text-danger">{{ $errors->first('started_at') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Task End Date -->
                        <div class="mb-3 row">
                            <label for="ended_at"
                                   class="col-md-4 col-form-label text-md-end text-start">Terminé à</label>
                            <div class="col-md-6">
                                <input type="date" class="form-control @error('ended_at') is-invalid @enderror {{ session('dark_mode') ? 'bg-dark text-white' : '' }} calendar-input"
                                       id="ended_at" name="ended_at" value="{{ old('ended_at') }}">
                                @if ($errors->has('ended_at'))
                                    <span class="text-danger">{{ $errors->first('ended_at') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Assignee -->
                        <div class="mb-3 row">
                            <label for="assignee"
                                   class="col-md-4 col-form-label text-md-end text-start">Cessionnaire</label>
                            <div class="col-md-6">
                                <select id="user_id" name="user_id" class="form-select {{ session('dark_mode') ? 'bg-dark text-white' : '' }}">
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Progress -->
                        <div class="mb-3">
                            <label for="progress" class="form-label">Progrès (%)</label>
                            <div class="d-flex align-items-center">
                                <input type="range" class="form-range me-3" name="progress" id="progress" min="0" max="100"
                                       value="{{ old('progress') }}">
                                <span id="progressValue" class="fw-bold">{{ old('progress') }}</span>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="mb-3 row">
                            <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Ajouter une nouvelle tâche">
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

@section('styles')
    <style>
        /* Dark Mode for Calendar Icon */
        .calendar-input::-webkit-calendar-picker-indicator {
            filter: invert(1);
        }

        /* Fallback for other browsers */
        .calendar-input {
            color: #fff;
        }

        .calendar-input:focus {
            background-color: #333;
        }
    </style>
@endsection
