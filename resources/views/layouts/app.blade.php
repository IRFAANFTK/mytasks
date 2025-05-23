<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts & Icons -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include this in your <head> section -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <link rel="stylesheet" href="{{ asset('css/table-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/premium-navbar.css') }}">
</head>

<body>
<div id="app">
    {{-- Premium Navbar --}}
    @include('partials.premium-navbar')

    <main class="pt-5" style="margin-top: 70px">
        <div class="container" style="max-width: 1800px;">
            @yield('content')
        </div>
    </main>
</div>

@yield('script')

<script>

    const themeToggle = document.querySelector('.theme-toggle');
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)');
    document.documentElement.setAttribute('data-theme',
        localStorage.getItem('theme') || (prefersDark.matches ? 'dark' : 'light')
    );

    themeToggle.addEventListener('click', () => {
        themeToggle.style.transform = 'scale(0.95)';
        setTimeout(() => themeToggle.style.transform = '', 150);

        const currentTheme = document.documentElement.getAttribute('data-theme');
        const newTheme = currentTheme === 'light' ? 'dark' : 'light';
        document.documentElement.setAttribute('data-theme', newTheme);
        localStorage.setItem('theme', newTheme);
    });

    // Mobile menu
    const mobileMenuBtn = document.querySelector('.mobile-menu');
    const navLinks = document.querySelector('.nav-links');

    mobileMenuBtn.addEventListener('click', () => {
        const isOpen = navLinks.classList.contains('active');
        const icon = mobileMenuBtn.querySelector('i');
        navLinks.classList.toggle('active');
        icon.className = isOpen ? 'ri-menu-line' : 'ri-close-line';
        mobileMenuBtn.setAttribute('aria-expanded', !isOpen);
    });

    document.addEventListener('click', (e) => {
        if (!e.target.closest('.nav-links') &&
            !e.target.closest('.mobile-menu') &&
            navLinks.classList.contains('active')) {
            navLinks.classList.remove('active');
            mobileMenuBtn.querySelector('i').className = 'ri-menu-line';
            mobileMenuBtn.setAttribute('aria-expanded', 'false');
        }
    });

    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', (e) => {
            document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
            e.target.closest('.nav-link').classList.add('active');
            if (window.innerWidth <= 768) {
                navLinks.classList.remove('active');
                mobileMenuBtn.querySelector('i').className = 'ri-menu-line';
                mobileMenuBtn.setAttribute('aria-expanded', 'false');
            }
        });
    });

    const navLinkItems = document.querySelectorAll('.nav-link');
    navLinkItems.forEach((link, index) => {
        link.style.animation = `navItemFade 0.5s ease forwards ${index / 7 + 0.3}s`;
    });

    const logo = document.querySelector('.nav-logo');
    logo.addEventListener('mousemove', (e) => {
        const bound = logo.getBoundingClientRect();
        const x = e.clientX - bound.left;
        const y = e.clientY - bound.top;
        logo.style.setProperty('--x', `${x}px`);
        logo.style.setProperty('--y', `${y}px`);
    });
</script>
@stack('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
