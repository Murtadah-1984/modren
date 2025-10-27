<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head', ['title' => $title ?? 'Dashbrd'])
    </head>

    <body>
        <!-- Modals -->
        @include('partials.modals')


        <!-- Main -->
        <main class="main px-lg-6">
            @yield('content')
        </main>

        <!-- JAVASCRIPT -->
        @include('partials.scripts')
    </body>
</html>


