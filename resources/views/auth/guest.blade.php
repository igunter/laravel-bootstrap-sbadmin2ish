<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Sign In - {{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Bootstrap Icons -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

        <!-- SB Admin 2 (ish) theme -->
        <link href="{{ asset('css/sb-admin-2.css') }}?v={{ filemtime(public_path('css/sb-admin-2.css')) }}" rel="stylesheet">
    </head>
    <body class="d-flex align-items-center justify-content-center min-vh-100 bg-light">
        <div class="text-center">
            <i class="bi bi-boxes text-primary" style="font-size: 3rem;"></i>
            <h1 class="h4 mt-3 text-gray-800">{{ config('app.name', 'Laravel') }}</h1>
            <p class="text-gray-600">Please sign in to continue.</p>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">
                <i class="bi bi-box-arrow-in-right me-1"></i> Sign In
            </button>
        </div>

        <!-- Login Modal -->
        <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="loginModalLabel"><i class="bi bi-box-arrow-in-right me-2"></i>Sign In</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="{{ route('login.attempt') }}">
                        @csrf
                        <div class="modal-body">
                            @if (session('status') && session('active_modal') !== 'reset')
                                <div class="alert alert-success py-2 small">{{ session('status') }}</div>
                            @endif

                            <div class="mb-3">
                                <label for="loginEmail" class="form-label">Email Address</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="loginEmail" name="email" value="{{ old('email', config('auth.default_username')) }}" required autofocus>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="loginPassword" class="form-label">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="loginPassword" name="password" value="{{ old('password', config('auth.default_password')) }}" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex align-items-center justify-content-between">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="rememberMe" checked>
                                    <label class="form-check-label small" for="rememberMe">Remember Me</label>
                                </div>

                                <button type="button" class="btn btn-link btn-sm p-0 text-decoration-none" data-bs-target="#forgotPasswordModal" data-bs-toggle="modal" data-bs-dismiss="modal">
                                    Forgot Password?
                                </button>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Sign In
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Forgot Password Modal -->
        <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="forgotPasswordModalLabel"><i class="bi bi-key me-2"></i>Reset Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="modal-body">
                            <p class="text-gray-600 small">Enter your email address and we'll send you a link to reset your password.</p>

                            @if (session('status') && session('active_modal') === 'reset')
                                <div class="alert alert-success py-2 small">{{ session('status') }}</div>
                            @endif

                            <div class="mb-3">
                                <label for="resetEmail" class="form-label">Email Address</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="resetEmail" name="email" value="{{ old('email', config('auth.default_username')) }}" required autofocus>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="button" class="btn btn-link btn-sm p-0 text-decoration-none" data-bs-target="#loginModal" data-bs-toggle="modal" data-bs-dismiss="modal">
                                Remembered your password? Sign In
                            </button>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-send me-1"></i> Send Reset Link
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var targetId = @json(session('active_modal') === 'reset' ? 'forgotPasswordModal' : 'loginModal');
                new bootstrap.Modal(document.getElementById(targetId)).show();
            });
        </script>
    </body>
</html>
