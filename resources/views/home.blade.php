@extends('layouts.app')

@section('content')
    <div class="container">
        <div id="taskContainer" class="text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            fetch("{{ route('tasks.get') }}")
                .then(response => response.json())
                .then(data => {
                    const taskContainer = document.getElementById("taskContainer");
                    taskContainer.innerHTML = '';

                    const sections = [
                        { title: 'CREATED', tasks: data.created, btn: 'Start', btnClass: 'success', icon: 'bi-play', borderColor: '#0dcaf0', routePrefix: 'start' },
                        { title: 'IN PROGRESS', tasks: data.inProgress, btn: 'End', btnClass: 'dark', icon: 'bi-stop', borderColor: '#0dcaf0', routePrefix: 'end' },
                        { title: 'DONE', tasks: data.done, btn: 'Delete', btnClass: 'danger', icon: 'bi-trash', borderColor: 'green', routePrefix: 'delete' },
                    ];

                    let row = document.createElement('div');
                    row.className = 'row justify-content-center';

                    sections.forEach(section => {
                        let col = document.createElement('div');
                        col.className = 'col-md-4';

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
                            let description = section.title === 'CREATED'
                                ? 'Tasks that are just added to the system and not yet started.'
                                : section.title === 'IN PROGRESS'
                                    ? 'Tasks currently being worked on.'
                                    : 'Tasks that are completed.';

                            let taskCard = document.createElement('div');
                            taskCard.className = 'card mb-3';
                            taskCard.style.width = '18rem';
                            taskCard.style.borderColor = section.borderColor;

                            taskCard.innerHTML = `
                            <div class="card-body">
                                <h5 class="card-title"><b>${task.name}</b></h5>
                                <p class="card-text">${description}</p>
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
        });
    </script>
@endpush
