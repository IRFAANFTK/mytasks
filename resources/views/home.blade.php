@php use Carbon\Carbon; @endphp
@extends('layouts.app')

@section('content')
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-2">
            <h5 class="mb-3">Filtrer les tâches</h5>

            <!-- Department Filter -->
            <div class="mb-3">
                <label for="departmentFilter" class="form-label">Département</label>
                <select id="departmentFilter" class="form-select">
                    <option value="">Tous les départements</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- User Filter -->
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



        <!-- Tasks Column Area -->
        <div class="col-md-10">
            <div class="container-fluid">
                <div id="taskContainer" class="row justify-content-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Chargement des tâches...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const userFilter = document.getElementById("userFilter");
            const departmentFilter = document.getElementById("departmentFilter");

            if (userFilter && departmentFilter) {
                userFilter.addEventListener("change", loadTasks);
                departmentFilter.addEventListener("change", function () {
                    userFilter.value = '';
                    loadTasks();
                });
            }

            loadTasks();
            loadWeather();
        });

        function loadTasks() {
            const userId = document.getElementById("userFilter")?.value;
            const departmentId = document.getElementById("departmentFilter")?.value;
            const taskContainer = document.getElementById("taskContainer");

            let url = new URL("/getTasks", window.location.origin);
            if (userId) {
                url.searchParams.append("user_id", userId);
            } else if (departmentId) {
                url.searchParams.append("department_id", departmentId);
            }

            taskContainer.innerHTML = '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>';

            fetch(url)
                .then(res => res.json())
                .then(data => {
                    taskContainer.innerHTML = "";
                    const sections = [
                        { title: 'CRÉÉ', key: 'created', btn: 'Commencer', btnClass: 'success', icon: 'bi-play', borderColor: '#0dcaf0', routePrefix: 'start' },
                        { title: 'EN COURS', key: 'inProgress', btn: 'Terminer', btnClass: 'dark', icon: 'bi-stop', borderColor: '#0dcaf0', routePrefix: 'end' },
                        { title: 'TERMINER', key: 'done', btn: 'Supprimer', btnClass: 'danger', icon: 'bi-trash', borderColor: 'green', routePrefix: 'delete' }
                    ];

                    sections.forEach(section => {
                        const col = document.createElement('div');
                        col.className = 'col-md-4 d-flex flex-column align-items-center';
                        col.id = section.key + '_column';

                        col.innerHTML = `
<div class="text-center mb-3">
<h3 class="card-title">${section.title}</h3>
</div>
`;

                        const tasks = data[section.key] || [];
                        tasks.forEach(task => {
                            const card = document.createElement('div');
                            card.className = 'card mb-3 mx-auto';
                            card.style.width = '18rem';
                            card.style.borderColor = section.borderColor;
                            card.dataset.id = task.id;

                            card.innerHTML = `
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
                            col.appendChild(card);
                        });

                        taskContainer.appendChild(col);
                    });
                })
                .catch(error => {
                    taskContainer.innerHTML = "<p class='text-danger'>Échec du chargement des tâches</p>";
                    console.error("Task error:", error);
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
