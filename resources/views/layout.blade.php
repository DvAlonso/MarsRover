<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>

        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,600;0,700;1,400&display=swap" rel="stylesheet"> 

        <style>
            body {
                font-family: 'Open Sans', sans-serif;
                background: #1E1E24;
                height: 100vh;
            }
            .main-title-link {
                color: #11AEFA !important;
            }
            .main-title-link:hover {
                color: #11AEFA !important;
                text-decoration: none;
            }
        </style>

        @stack('styles')

        <!-- Livewire core files -->
        <livewire:styles />
    </head>
    <body>
        <main class="container d-flex h-100">
            <div class="card mx-auto my-auto " style="width: 80%;">
                <div class="card-header text-center bg-transparent border-bottom-0">
                    <h1 class="my-2">
                        <a class="main-title-link" href='{{ route('home') }}'>
                            Mars Rover Mission
                        </a>
                    </h1>
                </div>
                @yield('content')
                <div class="card-footer text-center bg-transparent border-top-0">
                    <span style="color: #1E1E24; font-size: 12px">Made with <span style="color: #CC1100">♥</span> by <a href="https://github.com/DvAlonso">DvAlonso</a></span>
                </div>
            </div>
        </main>

        <!-- Livewire core files -->
        <livewire:scripts />

        <!-- jQuery & Bootstrap -->
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

        <script>
            const _token = '{{ csrf_token() }}'
        </script>
        @stack('scripts')
    </body>
</html>
