
<nav class="premium-nav">
    <div class="nav-container">
        <!-- Left: Logo & Nav links -->
        <div class="nav-left d-flex align-items-center gap-3">
            <a href="{{ url('/') }}" class="nav-logo">
                <span class="logo-text">Mes Taches</span>
                <span class="logo-shine"></span>
            </a>
            <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                <i class="ri-home-5-line"></i> <span>Accueil</span>
            </a>
            <a href="{{ route('tasks.index') }}" class="nav-link {{ request()->routeIs('tasks.index') ? 'active' : '' }}">
                <i class="ri-task-line"></i> <span>Tâches</span>
            </a>
            <a href="{{ route('departments.index') }}" class="nav-link {{ request()->routeIs('departments.index') ? 'active' : '' }}">
                <i class="ri-building-line"></i> <span>Départements</span>
            </a>
            <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}">
                <i class="ri-user-line"></i> <span>Utilisateurs</span>
            </a>
            <a href="{{ route('calendar.index') }}" class="nav-link {{ request()->routeIs('calendar.index') ? 'active' : '' }}">
                <i class="bi bi-calendar"></i> <span>Calendrier</span>
            </a>
            <a href="{{ route('admin.roles_permissions.index') }}" class="nav-link {{ request()->routeIs('admin.roles_permissions.index') ? 'active' : '' }}">
                <i class="ri-shield-user-line"></i> <span style="white-space: nowrap;">Rôles et Autorisations</span>
            </a>
        </div>

        <!-- Right: Actions -->
        <div class="nav-actions d-flex align-items-center gap-2">
            <button class="theme-toggle" aria-label="Toggle theme">
                <i class="ri-sun-line sun-icon"></i>
                <i class="ri-moon-line moon-icon"></i>
            </button>

            @auth
                <!-- Notifications -->
                <div class="dropdown">
                    <button
                        class="btn btn-outline-secondary dropdown-toggle"
                        type="button"
                        id="notifDropdown"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                    >
                        Notifications
                        <span id="notifBadge" class="badge bg-danger">{{ auth()->user()->unreadNotifications->count() }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notifDropdown" id="notifMenu">
                        @php
                            $notifications = auth()->user()->notifications()->latest()->get();
                        @endphp

                        @forelse($notifications as $notification)
                            <li>
        <span class="dropdown-item {{ $notification->read_at ? 'notification-read' : 'notification-unread' }}">
            {{ $notification->data['message'] }}
        </span>
                            </li>
                        @empty
                            <li><span class="dropdown-item text-muted">Aucune notification</span></li>
                        @endforelse

                    </ul>
                </div>
            @endauth

            <!-- User menu -->
            <!-- User menu -->
            <div class="dropdown">
                <a href="#" id="userMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false" class="d-block">
                    @if(auth()->check())
                        <img
                            src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('default-avatar.png') }}"
                            alt="{{ auth()->user()->name }}"
                            class="rounded-circle avatar-hover"
                            style="width: 35px; height: 35px; object-fit: cover; cursor: pointer;">
                    @endif
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                    @auth
                        <li><a class="dropdown-item" href="{{ route('users.show', auth()->user()->id) }}">Voir le profil</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item" type="submit">Déconnexion</button>
                            </form>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.settings') }}">Paramètres du profil</a>
                        </li>
                    @endauth
                </ul>
            </div>

        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const notifDropdown = document.getElementById('notifDropdown');
        const notifBadge = document.getElementById('notifBadge');
        const notifMenu = document.getElementById('notifMenu');

        if (notifDropdown) {
            notifDropdown.addEventListener('show.bs.dropdown', function () {
                // Only mark as read if there are unread notifications
                if (notifBadge && parseInt(notifBadge.textContent) > 0) {
                    fetch("{{ route('notifications.markAllReadAjax') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({})
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                // Hide badge since all are marked read
                                notifBadge.style.display = 'none';

                                // Update dropdown menu items to have read style
                                // Here you can reload or update the list dynamically, or simply reload the page
                                // For simplicity, reload the page to refresh notifications
                                location.reload();
                            }
                        })
                        .catch(err => console.error('Error marking notifications read:', err));
                }
            });
        }
    });
</script>
