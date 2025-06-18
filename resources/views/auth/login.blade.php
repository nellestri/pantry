<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Food Pantry Tracker</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        .login-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .login-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <section class="login-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5">
                    <div class="card login-card">
                        <div class="card-body p-5">
                            <div class="text-center mb-4">
                                <i class="bi bi-basket3 text-primary" style="font-size: 3rem;"></i>
                                <h2 class="fw-bold mt-3">Welcome Back</h2>
                                <p class="text-muted">Sign in to your account</p>
                            </div>

                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-envelope"></i>
                                        </span>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                               id="email" name="email" value="{{ old('email') }}" required autofocus>
                                    </div>
                                    @error('email')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-lock"></i>
                                        </span>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                               id="password" name="password" required>
                                    </div>
                                    @error('password')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                    <label class="form-check-label" for="remember">
                                        Remember me
                                    </label>
                                </div>

                                <div class="d-grid mb-3">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="bi bi-box-arrow-in-right me-2"></i>
                                        Sign In
                                    </button>
                                </div>

                                <div class="text-center">
                                    <p class="mb-0">
                                        Don't have an account?
                                        <a href="{{ route('register') }}" class="text-decoration-none">Register here</a>
                                    </p>
                                    <a href="{{ route('welcome') }}" class="text-muted text-decoration-none">
                                        <i class="bi bi-arrow-left me-1"></i>
                                        Back to Home
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
