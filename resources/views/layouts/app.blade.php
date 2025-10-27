<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head', ['title' => $title ?? 'Dashbrd'])
    </head>

    <body>
        <!-- Modals -->
        @include('partials.modals')
        <!-- Sidenav tool bar -->
        @include('partials.side-toolbar')

        <!-- Sidenav -->
        @include('partials.sidenav', ['category' => $category ?? 'dashboards', 'page' => $page ?? 'crypto'])

        <!-- Topnav -->
        @include('partials.topnav', ['category' => $category ?? 'dashboards', 'page' => $page ?? 'crypto'])
        <!-- Main -->
        <main class="main px-lg-6">
            @yield('content')
        </main>

        <!-- JAVASCRIPT -->
        @include('partials.scripts')
    </body>
</html>


