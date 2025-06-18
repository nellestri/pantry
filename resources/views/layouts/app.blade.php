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
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --warning-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            --danger-gradient: linear-gradient(135deg, #ff6b6b 0%, #ffa500 100%);
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            --card-hover-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        .navbar {
            background: var(--primary-gradient) !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
        }

        .navbar-brand {
            font-weight: 600;
            font-size: 1.4rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .card {
            border: none;
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: var(--card-hover-shadow);
        }

        .card-header {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 1.5rem;
            font-weight: 600;
        }

        .food-item-card {
            position: relative;
            overflow: hidden;
        }

        .food-item-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--success-gradient);
            z-index: 1;
        }

        .food-item-card.warning::before {
            background: var(--warning-gradient);
        }

        .food-item-card.danger::before {
            background: var(--danger-gradient);
        }

        .btn {
            border-radius: 12px;
            padding: 0.6rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.85rem;
        }

        .btn-primary {
            background: var(--primary-gradient);
            border: none;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-success {
            background: var(--success-gradient);
            border: none;
            box-shadow: 0 4px 15px rgba(79, 172, 254, 0.3);
        }

        .btn-warning {
            background: var(--warning-gradient);
            border: none;
            color: white;
            box-shadow: 0 4px 15px rgba(250, 112, 154, 0.3);
        }

        .btn-danger {
            background: var(--danger-gradient);
            border: none;
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
        }

        .form-control, .form-select {
            border-radius: 12px;
            border: 2px solid #e3ebf0;
            padding: 0.8rem 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.8);
        }

        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            background: white;
        }

        .alert {
            border-radius: 15px;
            border: none;
            padding: 1rem 1.5rem;
            backdrop-filter: blur(10px);
        }

        .alert-success {
            background: linear-gradient(135deg, rgba(79, 172, 254, 0.1) 0%, rgba(0, 242, 254, 0.1) 100%);
            color: #0c63e4;
            border-left: 4px solid #4facfe;
        }

        .category-badge {
            display: inline-block;
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }

        .category-fruits { background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%); color: #d63384; }
        .category-vegetables { background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%); color: #198754; }
        .category-meat { background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%); color: #fd7e14; }
        .category-dairy { background: linear-gradient(135deg, #e0c3fc 0%, #9bb5ff 100%); color: #6f42c1; }
        .category-grains { background: linear-gradient(135deg, #ffd89b 0%, #19547b 100%); color: #0f5132; }
        .category-beverages { background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%); color: #0dcaf0; }
        .category-snacks { background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%); color: #e83e8c; }
        .category-other { background: linear-gradient(135deg, #d299c2 0%, #fef9d7 100%); color: #6c757d; }

        .quantity-display {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 15px;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 0.5rem;
        }

        .expiry-badge {
            padding: 0.3rem 0.8rem;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
        }

        .expiry-good {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }

        .expiry-warning {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            color: white;
        }

        .expiry-danger {
            background: linear-gradient(135deg, #ff6b6b 0%, #ffa500 100%);
            color: white;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 20px;
            box-shadow: var(--card-shadow);
        }

        .empty-state i {
            font-size: 4rem;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .page-title {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
            margin-bottom: 2rem;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeInUp 0.6s ease-out;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('food-items.index') }}">
                <i class="bi bi-basket2-fill me-2"></i>Food Pantry Tracker
            </a>
        </div>
    </nav>
    <div class="collapse navbar-collapse">
    <ul class="navbar-nav ms-auto">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('food-items.index') }}">🏠 Pantry</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('food-items.transactions') }}">📋 Transactions</a>
        </li>
    </ul>
</div>


    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show animate-fade-in" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Add animation class to cards on load
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.card');
            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.classList.add('animate-fade-in');
                }, index * 100);
            });
        });
    </script>
</body>
</html>
