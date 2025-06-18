@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Admin Dashboard</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                <i class="bi bi-calendar3"></i>
                This Month
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">This Week</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
            </ul>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2" style="border-left: 4px solid #4e73df;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Users</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($stats['total_users']) }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-people fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2" style="border-left: 4px solid #1cc88a;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Items</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($stats['total_items']) }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-box-seam fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2" style="border-left: 4px solid #36b9cc;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Monthly Donations</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['monthly_donations'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-heart fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2" style="border-left: 4px solid #f6c23e;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Value</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">${{ number_format($stats['total_value'], 2) }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-currency-dollar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Users -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Recent Users</h6>
                <a href="{{ route('admin.users') }}" class="btn btn-sm btn-primary">View All</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Role</th>
                                <th>Joined</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recent_users as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2"
                                                 style="width: 32px; height: 32px; font-size: 14px;">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold">{{ $user->name }}</div>
                                                <small class="text-muted">{{ $user->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge {{ $user->role_badge }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td>{{ $user->created_at->format('M d, Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">No users found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Donations -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Recent Donations</h6>
                <a href="{{ route('donations.index') }}" class="btn btn-sm btn-primary">View All</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Donor</th>
                                <th>Items</th>
                                <th>Value</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recent_donations as $donation)
                                <tr>
                                    <td>
                                        <div class="fw-bold">{{ $donation->donor_name }}</div>
                                        @if($donation->donor_email)
                                            <small class="text-muted">{{ $donation->donor_email }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $donation->total_items }} items</span>
                                    </td>
                                    <td>
                                        @if($donation->total_value > 0)
                                            ${{ number_format($donation->total_value, 2) }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $donation->donation_date->format('M d') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No donations found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Alerts -->
@if($stats['expired_items'] > 0 || $stats['low_stock_items'] > 0)
<div class="row">
    <div class="col-12">
        <div class="card border-warning shadow">
            <div class="card-header bg-warning text-dark">
                <h6 class="m-0 font-weight-bold">
                    <i class="bi bi-exclamation-triangle"></i>
                    System Alerts
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    @if($stats['expired_items'] > 0)
                        <div class="col-md-6">
                            <div class="alert alert-danger">
                                <strong>{{ $stats['expired_items'] }} Expired Items</strong>
                                <p class="mb-0">Some items in your inventory have expired and need attention.</p>
                                <a href="{{ route('food-items.index', ['status' => 'expired']) }}" class="btn btn-sm btn-danger mt-2">
                                    View Expired Items
                                </a>
                            </div>
                        </div>
                    @endif

                    @if($stats['low_stock_items'] > 0)
                        <div class="col-md-6">
                            <div class="alert alert-warning">
                                <strong>{{ $stats['low_stock_items'] }} Low Stock Items</strong>
                                <p class="mb-0">Some items are running low and may need restocking.</p>
                                <a href="{{ route('food-items.index', ['status' => 'low_stock']) }}" class="btn btn-sm btn-warning mt-2">
                                    View Low Stock Items
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
