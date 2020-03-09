<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <script src="/js/jquery.js"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="bg-light">
    <div id="app">
        @include('shared/navbar')
        <div class="wrap">
            <main class="container">
                <div class="row">
                    <div class="col-md-12">
                        @if(session()->get('success'))
                            <div class="alert alert-success">
                                {{ session()->get('success') }}
                            </div>
                        @endif
                            @if(session()->get('error'))
                                <div class="alert alert-danger">
                                    {{ session()->get('error') }}
                                </div>
                            @endif
                        @yield('content')
                    </div>
                </div>
            </main>

            @include('shared/footer')
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"
            crossorigin="anonymous"
    ></script>
    @stack('inline-scripts')
</body>
</html>
