<nav class="premium-nav">
        <div class="nav-links" id="navLinks">
            <div class="nav-container">
                <a href="{{ url('/') }}" class="nav-logo">
                    <span class="logo-text">Mes tâches</span>
                    <span class="logo-shine"></span>
                </a>
            <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                <i class="ri-home-5-line"></i>
                <span>Home</span>
            </a>
            <a href="{{ route('tasks.index') }}" class="nav-link {{ request()->routeIs('tasks.index') ? 'active' : '' }}">
                <i class="ri-task-line"></i>
                <span>Tâches</span>
            </a>
            <a href="{{ route('departments.index') }}" class="nav-link {{ request()->routeIs('departments.index') ? 'active' : '' }}">
                <i class="ri-building-line"></i>
                <span>Departments</span>
            </a>
            <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}">
                <i class="ri-user-line"></i>
                <span>Users</span>
            </a>
            <a href="{{ route('calendar.index') }}" class="nav-link {{ request()->routeIs('calendar.index') ? 'active' : '' }}">
                <i class="bi bi-calendar"></i>
                <span>Calendrier</span>
            </a>
            <a href="{{ route('admin.roles_permissions.index') }}" class="nav-link {{ request()->routeIs('admin.roles_permissions.index') ? 'active' : '' }}">
                <i class="ri-shield-user-line"></i>
                <span>Roles & Permission</span>
            </a>
        </div>
        <div class="nav-actions">
            <button class="theme-toggle" aria-label="Toggle theme">
                <i class="ri-sun-line sun-icon"></i>
                <i class="ri-moon-line moon-icon"></i>
            </button>
            <button class="mobile-menu" aria-label="Menu">
                <i class="ri-menu-line"></i>
            </button>
        </div>
    </div>

</nav>
<style>
    .nav-container {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .nav-logo {
        display: flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        color: black;
        font-weight: bold;
        font-size: 1.3rem;
    }

    .logo-shine {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: linear-gradient(45deg, #ff4081, #40c4ff);
        box-shadow: 0 0 6px #40c4ff;
        flex-shrink: 0;
    }

</style>

