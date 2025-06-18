<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Welcome - {{ config('app.name', 'Food Pantry Tracker') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .hero-section {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            border: none;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            margin: 0 auto 20px;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-outline-custom {
            border: 2px solid rgba(255, 255, 255, 0.8);
            color: white;
            border-radius: 10px;
            padding: 12px 30px;
            font-weight: 600;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .btn-outline-custom:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: white;
            color: white;
            transform: translateY(-2px);
        }

        .stats-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
        }

        .logo-text {
            background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row min-vh-100">
            <div class="col-12">
                <!-- Navigation -->
                <nav class="navbar navbar-expand-lg navbar-dark py-3">
                    <div class="container">
                        <a class="navbar-brand d-flex align-items-center" href="#">
                            <i class="bi bi-basket3 me-2 fs-3"></i>
                            <span class="logo-text fs-4">Food Pantry Tracker</span>
                        </a>

                        <div class="navbar-nav ms-auto">
                            <a class="nav-link text-white me-3" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right me-1"></i>
                                Login
                            </a>
                            <a class="btn btn-outline-custom" href="{{ route('register') }}">
                                <i class="bi bi-person-plus me-1"></i>
                                Register
                            </a>
                        </div>
                    </div>
                </nav>

                <!-- Hero Section -->
                <div class="container my-5">
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div class="hero-section p-5 text-center text-white">
                                <div class="mb-4">
                                    <i class="bi bi-basket3 display-1 mb-3"></i>
                                    <h1 class="display-4 fw-bold mb-3">Welcome to Food Pantry Tracker</h1>
                                    <p class="lead mb-4">
                                        Efficiently manage your food pantry inventory, track donations,
                                        and help serve your community better with our comprehensive management system.
                                    </p>
                                </div>

                                <div class="d-flex flex-column flex-md-row gap-3 justify-content-center">
                                    <a href="{{ route('register') }}" class="btn btn-primary-custom btn-lg">
                                        <i class="bi bi-rocket-takeoff me-2"></i>
                                        Get Started Today
                                    </a>
                                    <a href="{{ route('login') }}" class="btn btn-outline-custom btn-lg">
                                        <i class="bi bi-box-arrow-in-right me-2"></i>
                                        Sign In
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stats Section -->
                <div class="container mb-5">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="stats-card p-4 text-center">
                                <i class="bi bi-box-seam display-4 mb-3"></i>
                                <h3 class="fw-bold">Inventory Management</h3>
                                <p class="mb-0">Track all your food items with expiration dates and stock levels</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stats-card p-4 text-center">
                                <i class="bi bi-heart display-4 mb-3"></i>
                                <h3 class="fw-bold">Donation Tracking</h3>
                                <p class="mb-0">Record and manage donations from various sources</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stats-card p-4 text-center">
                                <i class="bi bi-graph-up display-4 mb-3"></i>
                                <h3 class="fw-bold">Analytics & Reports</h3>
                                <p class="mb-0">Generate insights and reports for better decision making</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Features Section -->
                <div class="container mb-5">
                    <div class="row justify-content-center mb-5">
                        <div class="col-lg-8 text-center">
                            <h2 class="display-5 fw-bold text-white mb-3">Powerful Features</h2>
                            <p class="lead text-white-50">Everything you need to manage your food pantry efficiently</p>
                        </div>
                    </div>

                    <div class="row g-4">
                        <div class="col-lg-4 col-md-6">
                            <div class="feature-card p-4 text-center h-100">
                                <div class="feature-icon">
                                    <i class="bi bi-speedometer2"></i>
                                </div>
                                <h5 class="fw-bold mb-3">Real-time Dashboard</h5>
                                <p class="text-muted">Monitor your inventory levels, low stock alerts, and key metrics at a glance.</p>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="feature-card p-4 text-center h-100">
                                <div class="feature-icon">
                                    <i class="bi bi-tags"></i>
                                </div>
                                <h5 class="fw-bold mb-3">Category Management</h5>
                                <p class="text-muted">Organize your food items by categories for better inventory organization.</p>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="feature-card p-4 text-center h-100">
                                <div class="feature-icon">
                                    <i class="bi bi-calendar-check"></i>
                                </div>
                                <h5 class="fw-bold mb-3">Expiration Tracking</h5>
                                <p class="text-muted">Never let food go to waste with automated expiration date monitoring.</p>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="feature-card p-4 text-center h-100">
                                <div class="feature-icon">
                                    <i class="bi bi-people"></i>
                                </div>
                                <h5 class="fw-bold mb-3">User Management</h5>
                                <p class="text-muted">Manage staff access with role-based permissions and user accounts.</p>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="feature-card p-4 text-center h-100">
                                <div class="feature-icon">
                                    <i class="bi bi-shield-check"></i>
                                </div>
                                <h5 class="fw-bold mb-3">Secure & Reliable</h5>
                                <p class="text-muted">Built with security in mind, ensuring your data is safe and protected.</p>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="feature-card p-4 text-center h-100">
                                <div class="feature-icon">
                                    <i class="bi bi-download"></i>
                                </div>
                                <h5 class="fw-bold mb-3">Export & Backup</h5>
                                <p class="text-muted">Export your data and create backups to ensure business continuity.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Call to Action -->
                <div class="container mb-5">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="hero-section p-5 text-center text-white">
                                <h3 class="fw-bold mb-3">Ready to Get Started?</h3>
                                <p class="mb-4">Join thousands of food pantries already using our system to serve their communities better.</p>
                                <a href="{{ route('register') }}" class="btn btn-primary-custom btn-lg">
                                    <i class="bi bi-arrow-right me-2"></i>
                                    Start Your Free Account
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <footer class="text-center text-white-50 py-4">
                    <div class="container">
                        <p class="mb-0">
                            &copy; {{ date('Y') }} Food Pantry Tracker.
                            Built with <i class="bi bi-heart-fill text-danger"></i> for community service.
                        </p>
                    </div>
                </footer>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
