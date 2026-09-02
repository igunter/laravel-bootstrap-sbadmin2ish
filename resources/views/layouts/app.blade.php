<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title', config('app.name', 'Laravel')) - @lang('SB Admin 2')</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Bootstrap Icons -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

        <!-- DataTables (Bootstrap 5 styling) -->
        <link href="https://cdn.datatables.net/v/bs5/dt-2.1.8/datatables.min.css" rel="stylesheet">

        <!-- SB Admin 2 (ish) theme -->
        <link href="{{ asset('css/sb-admin-2.css') }}" rel="stylesheet">

        @stack('styles')
    </head>
    <body>
        <div id="wrapper">
            @include('partials.sidebar')

            <div id="content-wrapper">
                @include('partials.topbar')

                <div id="content" class="container-fluid py-4">
                    @yield('content')
                </div>

                <footer class="sb-footer">
                    <div class="container-fluid text-center small text-gray-600">
                        Copyright &copy; {{ config('app.name', 'Laravel') }} {{ date('Y') }}
                    </div>
                </footer>
            </div>
        </div>

        <a class="scroll-to-top" href="#" data-sb-toggle="scroll-top"><i class="bi bi-arrow-up"></i></a>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

        <!-- jQuery + DataTables (Bootstrap 5 styling) -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdn.datatables.net/v/bs5/dt-2.1.8/datatables.min.js"></script>

        <!-- SB Admin 2 (ish) theme -->
        <script src="{{ asset('js/sb-admin-2.js') }}"></script>

        @stack('scripts')
    </body>
</html>
