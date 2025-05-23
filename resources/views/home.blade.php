@extends('layouts.app')

@section('content')

        <div class="row">
            <!-- Filter Sidebar -->
            <div class="col-md-2">
                <h5 class="mb-3">Filter Tasks</h5>

                <div class="mb-3">
                    <label for="departmentFilter" class="form-label">Department</label>
                    <select id="departmentFilter" class="form-select">
                        <option value="">All Departments</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="userFilter" class="form-label">User</label>
                    <select id="userFilter" class="form-select">
                        <option value="">All Users</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Tasks Area -->
            <div class="col-md-10">
                <div id="taskContainer" class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const userFilter = document.getElementById("userFilter");
            const departmentFilter = document.getElementById("departmentFilter");

            function loadTasks() {
                const userId = userFilter.value;
                const departmentId = departmentFilter.value;

                let url = new URL("/getTasks", window.location.origin);
                if (userId) {
                    url.searchParams.append("user_id", userId);
                } else if (departmentId) {
                    url.searchParams.append("department_id", departmentId);
                }

                document.getElementById("taskContainer").innerHTML = `
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        `;

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        const taskContainer = document.getElementById("taskContainer");
                        taskContainer.innerHTML = "";

                        const sections = [
                            { title: 'CREATED', tasks: data.created, btn: 'Start', btnClass: 'success', icon: 'bi-play', borderColor: '#0dcaf0', routePrefix: 'start' },
                            { title: 'IN PROGRESS', tasks: data.inProgress, btn: 'End', btnClass: 'dark', icon: 'bi-stop', borderColor: '#0dcaf0', routePrefix: 'end' },
                            { title: 'DONE', tasks: data.done, btn: 'Delete', btnClass: 'danger', icon: 'bi-trash', borderColor: 'green', routePrefix: 'delete' },
                        ];

                        let row = document.createElement('div');
                        row.className = 'row justify-content-center';

                        sections.forEach(section => {
                            let col = document.createElement('div');
                            col.className = 'col-md-4 d-flex flex-column align-items-center';

                            let header = `
                        <div class="text-center mb-3">
                            <h3 class="card-title">${section.title}
                                ${section.title === 'IN PROGRESS' ? '<i class="bi bi-arrow-repeat"></i>' : ''}
                                ${section.title === 'DONE' ? '<i class="bi bi-check-all" style="color: green"></i>' : ''}
                            </h3>
                        </div>
                    `;
                            col.innerHTML = header;

                            section.tasks.forEach(task => {
                                let taskCard = document.createElement('div');
                                taskCard.className = 'card mb-3 mx-auto';
                                taskCard.style.width = '18rem';
                                taskCard.style.borderColor = section.borderColor;

                                taskCard.innerHTML = `
                            <div class="card-body">
                                <h5 class="card-title"><b>${task.name}</b></h5>
                                <p class="card-text">${task.description}</p>
                                <p class="card-text">
                                    <i class="bi bi-person-fill"></i> ${task.user?.name ?? 'Unknown'}
                                </p>
                                <a href="/tasks/${task.id}" class="btn btn-primary mb-1">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <a href="/tasks/${section.routePrefix}/${task.id}" class="btn btn-${section.btnClass} mb-1">
                                    <i class="bi ${section.icon}"></i> ${section.btn}
                                </a>
                            </div>
                        `;
                                col.appendChild(taskCard);
                            });

                            row.appendChild(col);
                        });

                        taskContainer.appendChild(row);
                    })
                    .catch(error => {
                        document.getElementById("taskContainer").innerHTML = "<p class='text-danger'>Failed to load tasks.</p>";
                        console.error(error);
                    });
            }

            userFilter.addEventListener("change", loadTasks);
            departmentFilter.addEventListener("change", function () {
                userFilter.value = ''; // Reset user filter if department is changed
                loadTasks();
            });

            loadTasks(); // Initial load
        });
    </script>
@endpush
