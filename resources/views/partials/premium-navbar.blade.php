<nav class="premium-nav">
    <div class="nav-container">
        <a href="{{ url('/') }}" class="nav-logo">
            <span class="logo-text">My Tasks</span>
            <div class="logo-shine"></div>
        </a>

        <div class="nav-links" id="navLinks">
            <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                <i class="ri-home-5-line"></i>
                <span>Home</span>
            </a>
            <a href="{{ route('tasks.index') }}" class="nav-link {{ request()->routeIs('tasks.index') ? 'active' : '' }}">
                <i class="ri-task-line"></i>
                <span>Tasks</span>
            </a>
            <a href="{{ route('departments.index') }}" class="nav-link {{ request()->routeIs('departments.index') ? 'active' : '' }}">
                <i class="ri-building-line"></i>
                <span>Departments</span>
            </a>
            <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}">
                <i class="ri-user-line"></i>
                <span>Users</span>
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
