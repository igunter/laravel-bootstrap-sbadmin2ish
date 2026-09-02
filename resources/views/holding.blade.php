<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Welcome - {{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Bootstrap Icons -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

        <!-- SB Admin 2 (ish) theme -->
        <link href="{{ asset('css/sb-admin-2.css') }}" rel="stylesheet">
    </head>
    <body class="d-flex flex-column min-vh-100">
        <header class="sb-topbar navbar navbar-expand navbar-light bg-white sticky-top">
            <div class="container-fluid">
                <span class="navbar-brand mb-0 h1 d-flex align-items-center">
                    <i class="bi bi-boxes text-primary me-2"></i>
                    {{ config('app.name', 'Laravel') }}
                </span>

                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-box-arrow-right me-1"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </header>

        <main class="flex-grow-1 d-flex align-items-center justify-content-center">
            <div class="text-center px-3">
                <i class="bi bi-hourglass-split text-primary" style="font-size: 3.5rem;"></i>
                <h1 class="h3 mt-3 text-gray-800">You're all signed in</h1>
                <p class="text-gray-600 mb-0">Your account doesn't have access to the dashboard yet.</p>
                <p class="text-gray-600">Please contact an administrator if you believe this is a mistake.</p>
            </div>
        </main>

        <footer class="sb-footer sticky-bottom">
            <div class="container-fluid text-center small text-gray-600">
                Copyright &copy; {{ config('app.name', 'Laravel') }} {{ date('Y') }}
            </div>
        </footer>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
