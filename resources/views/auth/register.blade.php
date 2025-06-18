<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - Food Pantry Tracker</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        .register-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 2rem 0;
        }
        .register-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <section class="register-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="card register-card">
                        <div class="card-body p-5">
                            <div class="text-center mb-4">
                                <i class="bi bi-person-plus text-primary" style="font-size: 3rem;"></i>
                                <h2 class="fw-bold mt-3">Create Account</h2>
                                <p class="text-muted">Join our food pantry management system</p>
                            </div>

                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Full Name</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-person"></i>
                                            </span>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                   id="name" name="name" value="{{ old('name') }}" required autofocus>
                                        </div>
                                        @error('name')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email Address</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-envelope"></i>
                                            </span>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                   id="email" name="email" value="{{ old('email') }}" required>
                                        </div>
                                        @error('email')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-telephone"></i>
                                            </span>
                                            <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                                   id="phone" name="phone" value="{{ old('phone') }}">
                                        </div>
                                        @error('phone')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="role" class="form-label">Role</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-person-badge"></i>
                                            </span>
                                            <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                                                <option value="">Select Role</option>
                                                <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff Member</option>
                                                <option value="volunteer" {{ old('role') == 'volunteer' ? 'selected' : '' }}>Volunteer</option>
                                            </select>
                                        </div>
                                        @error('role')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
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

                                    <div class="col-md-6 mb-3">
                                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-lock-fill"></i>
                                            </span>
                                            <input type="password" class="form-control"
                                                   id="password_confirmation" name="password_confirmation" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-grid mb-3">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="bi bi-person-plus me-2"></i>
                                        Create Account
                                    </button>
                                </div>

                                <div class="text-center">
                                    <p class="mb-0">
                                        Already have an account?
                                        <a href="{{ route('login') }}" class="text-decoration-none">Sign in here</a>
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
