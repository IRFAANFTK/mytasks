@extends('layouts.app')

@section('content')
    <div class="row">
        <!-- Filter Sidebar -->
        <div class="col-md-2">
            <h5 class="mb-3">Filtrer les tâches</h5>
            <div id="react-root"></div>

            <div class="mb-3">
                <label for="departmentFilter" class="form-label">Département</label>
                <select id="departmentFilter" class="form-select">
                    <option value="">Tous les départements</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="userFilter" class="form-label">Utilisateur</label>
                <select id="userFilter" class="form-select">
                    <option value="">Tous les utilisateurs</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Weather Card -->
            <div class="mb-4 mt-4">
                <div class="card shadow-sm {{ session('dark_mode') ? 'bg-dark text-white border-light' : '' }}">
                    <div class="card-header {{ session('dark_mode') ? 'bg-secondary text-white' : 'bg-primary text-white' }}">
                        <h5 class="mb-0"><i class="bi bi-cloud-sun me-2"></i> Météo actuelle</h5>
                    </div>
                    <div id="weatherCardBody" class="card-body p-3">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Chargement météo...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tasks Area -->
        <div class="col-md-10 position-relative">
            <div id="taskContainer" class="overflow-auto" style="max-height: 80vh;"></div>
            <button onclick="scrollToTop()" class="btn btn-light position-fixed bottom-0 end-0 m-3 shadow-sm animate__animated animate__bounce" title="Remonter">
                <i class="bi bi-arrow-up"></i>
            </button>
        </div>
    </div>
@endsection
@push('styles')
    <style>

        #taskContainer {
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        #taskContainer::-webkit-scrollbar {
            display: none;
        }


        .show-more-btn {
            background: linear-gradient(to right, #0dcaf0, #0a58ca);
            color: white;
            border: none;
            border-radius: 20px;
            padding: 6px 16px;
            transition: all 0.3s ease;
            font-weight: 500;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .show-more-btn:hover {
            background: linear-gradient(to right, #0a58ca, #6610f2);
            transform: scale(1.05);
        }

        .task-wrapper .extra-task {
            opacity: 0;
            transform: translateY(10px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        .task-wrapper .extra-task.reveal {
            opacity: 1;
            transform: translateY(0);
        }
    </style>

@push('scripts')
    <script>
        function scrollToTop() {
            document.getElementById('taskContainer').scrollTo({ top: 0, behavior: 'smooth' });
        }

        document.addEventListener("DOMContentLoaded", function () {
            const userFilter = document.getElementById("userFilter");
            const departmentFilter = document.getElementById("departmentFilter");



            userFilter.addEventListener("change", loadTasks);
            departmentFilter.addEventListener("change", function () {
                userFilter.value = '';
                loadTasks();
            });

            loadTasks();
            loadWeather();
        });

        function loadTasks() {
            const userId = userFilter.value;
            const departmentId = departmentFilter.value;
            let url = new URL("/getTasks", window.location.origin);
            if (userId) {
                url.searchParams.append("user_id", userId);
            } else if (departmentId) {
                url.searchParams.append("department_id", departmentId);
            }

            document.getElementById("taskContainer").innerHTML = "";

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const taskContainer = document.getElementById("taskContainer");
                    taskContainer.innerHTML = "";

                    const sections = [
                        {
                            title: 'CRÉÉ',
                            tasks: data.created,
                            btn: 'Commencer',
                            btnClass: 'success',
                            icon: 'bi-play',
                            borderColor: '#0dcaf0',
                            routePrefix: 'start'
                        },
                        {
                            title: 'EN COURS',
                            tasks: data.inProgress,
                            btn: 'Terminer',
                            btnClass: 'dark',
                            icon: 'bi-stop',
                            borderColor: '#0dcaf0',
                            routePrefix: 'end'
                        },
                        {
                            title: 'TERMINER',
                            tasks: data.done,
                            btn: 'Supprimer',
                            btnClass: 'danger',
                            icon: 'bi-trash',
                            borderColor: 'green',
                            routePrefix: 'delete'
                        },
                    ];

                    let row = document.createElement('div');
                    row.className = 'row justify-content-center';

                    sections.forEach(section => {
                        let col = document.createElement('div');
                        col.className = 'col-md-4 d-flex flex-column align-items-center';

                        let header = `
<div class="text-center mb-3">
<h3 class="card-title">${section.title}</h3>
</div>
`;
                        col.innerHTML = header;

                        let taskWrapper = document.createElement('div');
                        taskWrapper.className = 'task-wrapper w-100 d-flex flex-column align-items-center';

                        section.tasks.forEach((task, index) => {
                            let taskCard = document.createElement('div');
                            taskCard.className = 'card mb-3 mx-auto';
                            taskCard.style.width = '18rem';
                            taskCard.style.borderColor = section.borderColor;

                            if (index >= 3) {
                                taskCard.classList.add('d-none', 'extra-task');
                            }

                            taskCard.innerHTML = `
<div class="card-body">
<h5 class="card-title"><b>${task.name}</b></h5>
<p class="card-text">${task.description}</p>
<p class="card-text">
<i class="bi bi-person-fill me-1 text-primary"></i><strong> ${task.user?.name ?? 'Inconnu'}</strong>
</p>
<a href="/tasks/${task.id}" class="btn btn-primary mb-1">
<i class="bi bi-eye"></i> Voir
</a>
<a href="/tasks/${section.routePrefix}/${task.id}" class="btn btn-${section.btnClass} mb-1">
<i class="bi ${section.icon}"></i> ${section.btn}
</a>
</div>
`;
                            taskWrapper.appendChild(taskCard);
                        });

                        col.appendChild(taskWrapper);

                        if (section.tasks.length > 3) {
                            let showMoreBtn = document.createElement('button');
                            showMoreBtn.className = 'show-more-btn mt-2';
                            showMoreBtn.textContent = 'Afficher plus';
                            showMoreBtn.onclick = function () {
                                const hiddenTasks = taskWrapper.querySelectorAll('.extra-task');
                                hiddenTasks.forEach((t, i) => {
                                    setTimeout(() => {
                                        t.classList.remove('d-none');
                                        t.classList.add('reveal');
                                    }, i * 100);
                                });
                                showMoreBtn.style.display = 'none';
                            };
                            col.appendChild(showMoreBtn);
                        }

                        row.appendChild(col);
                    });

                    taskContainer.appendChild(row);
                })
                .catch(error => {
                    document.getElementById("taskContainer").innerHTML = "<p class='text-danger'>Échec du chargement des tâches</p>";
                    console.error(error);
                });
        }

        function loadWeather() {

            const weatherCard = document.getElementById("weatherCardBody");

            weatherCard.innerHTML = '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Chargement météo...</span></div>';

            if (navigator.geolocation) {

                navigator.geolocation.getCurrentPosition(

                    function (position) {

                        const lat = position.coords.latitude;

                        const lon = position.coords.longitude;

                        fetch(`/weather?lat=${lat}&lon=${lon}`)

                            .then(res => res.json())

                            .then(data => {

                                const interval = data?.weather?.data?.timelines?.[0]?.intervals?.[0];

                                const locationName = data?.location || 'Votre position';

                                if (interval) {

                                    const temp = interval.values.temperature ?? 'N/A';

                                    const humidity = interval.values.humidity ?? 'N/A';

                                    const startTime = new Date(interval.startTime).toLocaleString('fr-FR', {

                                        day: '2-digit',

                                        month: '2-digit',

                                        year: 'numeric',

                                        hour: '2-digit',

                                        minute: '2-digit',

                                        timeZone: 'Indian/Mauritius'

                                    });

                                    weatherCard.innerHTML = `
<div class="mb-2 fw-bold">${locationName}</div>
<ul class="list-group list-group-flush">
<li class="list-group-item"><strong>Heure:</strong> ${startTime}</li>
<li class="list-group-item"><strong>Température:</strong> ${temp} °C</li>
<li class="list-group-item"><strong>Humidité:</strong> ${humidity}%</li>
</ul>

                            `;

                                } else {

                                    weatherCard.innerHTML = `<div class="alert alert-warning mb-0">Données météo non disponibles.</div>`;

                                }

                            })

                            .catch(error => {

                                weatherCard.innerHTML = `<div class="alert alert-danger mb-0">Erreur météo</div>`;

                                console.error("Weather API error:", error);

                            });

                    },

                    function () {

                        weatherCard.innerHTML = `<div class="alert alert-warning mb-0">Autorisation de localisation refusée.</div>`;

                    }

                );

            } else {

                weatherCard.innerHTML = `<div class="alert alert-warning mb-0">Géolocalisation non supportée.</div>`;

            }

        }
    </script>
    @endpush
