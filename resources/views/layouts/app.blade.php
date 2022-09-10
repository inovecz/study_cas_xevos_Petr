<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @hasSection('title')
            <title>@yield('title', config('app.name'))</title>
        @else
            <title>{{ config('app.name') }}</title>
        @endif

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="shortcut icon" href="{{ url(asset('favicon.ico')) }}">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>

    <body class="bg-gray-200">
        @yield('content')
        <footer class="w-full flex justify-center pb-8">
            <div>Made with <i class="fa-solid fa-heart text-rose-500"></i> by
                <a href="https://github.com/inDeev" target="_blank" class="text-blue-500 hover:text-blue-700">Petr Katerinak</a></div>
        </footer>
        @livewireScripts

        <script>
            window.addEventListener('alert', event => {
                console.log('toastr called', event.detail);
                toastr[event.detail.type](event.detail.message, event.detail.title ?? '',
                    toastr.options = {
                        "closeButton": true,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": true,
                        "positionClass": "toast-bottom-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": 300,
                        "hideDuration": 1000,
                        "timeOut": 5000,
                        "extendedTimeOut": 1000,
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    }
                );
            });
        </script>

        @livewire('livewire-ui-modal')
        @stack('scripts')
    </body>
</html>
