<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Pantry Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f7f7fb; }
        .page-title { font-weight: 700; }
        .glass-effect { background: rgba(255,255,255,0.8); border-radius: 1rem; box-shadow: 0 2px 16px rgba(0,0,0,0.07); }
        .category-badge { font-size: 0.9em; background: #e7e7f7; border-radius: 8px; padding: 3px 10px; display: inline-block; margin-bottom: 10px; }
        .expiry-badge { font-size: 0.9em; border-radius: 8px; padding: 3px 10px; display: inline-block; }
        .expiry-danger { background: #ffe9e9; color: #e00; }
        .expiry-warning { background: #fff7e0; color: #b8860b; }
        .expiry-good { background: #e7ffe9; color: #218838; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white mb-4 shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('food-items.index') }}">
                <i class="bi bi-basket2-fill"></i> Pantry
            </a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item">
                            <span class="nav-link">👤 {{ Auth::user()->name }} ({{ Auth::user()->role }})</span>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-link nav-link" type="submit">Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mb-5">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
