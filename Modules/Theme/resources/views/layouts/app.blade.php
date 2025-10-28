<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('theme::partials.head', ['title' => $title ?? 'Dashbrd'])
    </head>

    <body>
        <!-- Modals -->
        @include('theme::partials.modals')
        <!-- Sidenav tool bar -->
        @include('theme::partials.side-toolbar')

        <!-- Sidenav -->
        @include('theme::partials.sidenav', ['category' => $category ?? 'dashboards', 'page' => $page ?? 'crypto'])

        <!-- Topnav -->
        @include('theme::partials.topnav', ['category' => $category ?? 'dashboards', 'page' => $page ?? 'crypto'])
        <!-- Main -->
        <main class="main px-lg-6">
            @yield('content')
        </main>

        <!-- JAVASCRIPT -->
        @include('theme::partials.scripts')
    </body>
</html>


