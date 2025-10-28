<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Favicon -->
<link rel="shortcut icon" href="{{ asset('assets/favicon.ico') }}" type="image/x-icon">

<!-- title -->
<title>{{ config('app.name', 'Laravel') }}</title>

<!-- theme style -->
<link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/libs.bundle.css') }}">
<link rel="stylesheet" href="{{ asset('css/theme.bundle.css') }}">

<style>
    .avatar-initials {
        width: 32px;         /* Match .avatar-sm size */
        height: 32px;
        font-weight: 600;
        font-size: 0.875rem; /* Slightly smaller than body text */
        text-transform: uppercase;
    }
</style>

<!-- Fonts and icons -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&amp;display=swap">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,1,0">

<!-- Scripts -->
@vite(['resources/sass/app.scss', 'resources/js/app.js'])

<script>
    (() => {
        'use strict';

        const getStoredTheme = () => localStorage.getItem('theme');
        const setStoredTheme = (theme) => localStorage.setItem('theme', theme);

        const getStoredNavigationPosition = () => localStorage.getItem('navigationPosition');
        const setStoredNavigationPosition = (navigationPosition) => localStorage.setItem('navigationPosition', navigationPosition);

        const getStoredSidenavSizing = () => localStorage.getItem('sidenavSizing');
        const setStoredSidenavSizing = (sidenavSizing) => localStorage.setItem('sidenavSizing', sidenavSizing);

        const getPreferredTheme = () => {
            const storedTheme = getStoredTheme();
            if (storedTheme) return storedTheme;
            return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        };

        const getPreferredNavigationPosition = () => {
            const storedNavigationPosition = getStoredNavigationPosition();
            // Only allow "sidenav" or "topnav" — fallback to sidenav
            if (storedNavigationPosition === 'sidenav' || storedNavigationPosition === 'topnav') {
                return storedNavigationPosition;
            }
            return 'sidenav';
        };


        const getPreferredSidenavSizing = () => {
            const stored = getStoredSidenavSizing();
            return stored || 'base';
        };

        const setTheme = (theme) => {
            const resolved = theme === 'auto'
                ? (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light')
                : theme;
            document.documentElement.setAttribute('data-bs-theme', resolved);
        };

        const setNavigationPosition = (pos) => {
            document.documentElement.setAttribute('data-bs-navigation-position', pos);
            // ✅ Ensure nav is shown if position is sidenav/topnav
            document.querySelector('nav')?.classList.remove('d-none', 'invisible');
        };

        const setSidenavSizing = (size) => {
            document.documentElement.setAttribute('data-bs-sidenav-sizing', size);
        };

        window.addEventListener('DOMContentLoaded', () => {
            setTheme(getPreferredTheme());
            setNavigationPosition(getPreferredNavigationPosition());
            setSidenavSizing(getPreferredSidenavSizing());
        ...
        });


        window.addEventListener('DOMContentLoaded', () => {
            const navPos = getPreferredNavigationPosition();
            setNavigationPosition(navPos);

            const showActive = (selector, value) => {
                document.querySelectorAll(selector).forEach((el) => {
                    el.classList.toggle('active', el.getAttribute(selector.replace('[', '').replace(']', '').split('=')[0]) === value);
                });
            };

            showActive('[data-bs-theme-value]', getPreferredTheme());
            showActive('[data-bs-navigation-position-value]', navPos);
            showActive('[data-bs-sidenav-sizing-value]', getPreferredSidenavSizing());

            // Theme toggle
            document.querySelectorAll('[data-bs-theme-value]').forEach((toggle) => {
                toggle.addEventListener('click', (e) => {
                    e.preventDefault();
                    const val = toggle.getAttribute('data-bs-theme-value');
                    setStoredTheme(val);
                    setTheme(val);
                });
            });

            // Navigation toggle
            document.querySelectorAll('[data-bs-navigation-position-value]').forEach((toggle) => {
                toggle.addEventListener('click', (e) => {
                    e.preventDefault();
                    const val = toggle.getAttribute('data-bs-navigation-position-value');
                    setStoredNavigationPosition(val);
                    setNavigationPosition(val);
                });
            });

            // Sidenav sizing toggle
            document.querySelectorAll('[data-bs-sidenav-sizing-value]').forEach((toggle) => {
                toggle.addEventListener('click', (e) => {
                    e.preventDefault();
                    const val = toggle.getAttribute('data-bs-sidenav-sizing-value');
                    setStoredSidenavSizing(val);
                    setSidenavSizing(val);
                });
            });
        });
    })();
</script>
