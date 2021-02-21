<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @livewireStyles
</head>
<body>
    <div id="app">
        <x-layouts.navbar/>

        <main class="py-4 container">
            <div class="row">
                @auth

                <nav class="nav col-md-2 flex-column">
                    <div class="h4 fw-bolder">
                        @lang("application.menu")
                    </div>

                    <a class="text-dark nav-link {{ \Illuminate\Support\Facades\Route::is("kata.*") ? "active fw-bold" : "" }}" aria-current="page" href="{{ route("kata.index") }}">
                        @lang("application.word")
                    </a>

                    <a class="text-dark nav-link {{ \Illuminate\Support\Facades\Route::is("dokumen.*") ? "active fw-bold" : "" }}" aria-current="page" href="{{ route("dokumen.index") }}">
                        @lang("application.document")
                    </a>
                </nav>

                @endauth

                <article class="@auth col-md-10 @else col-md-12 @endauth">
                    {{ $slot }}
                </article>
            </div>
        </main>
    </div>
</body>

@livewireScripts
<script src="{{ asset('js/app.js') }}"></script>



<!-- Scripts -->
</html>
