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


