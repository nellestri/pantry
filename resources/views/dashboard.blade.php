@extends('layouts.app')

@section('title', 'Dashboard - Food Pantry Tracker')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="bi bi-speedometer2 me-2"></i>
        Dashboard
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-download"></i>
                Export
            </button>
        </div>
        <button type="button" class="btn btn-sm btn-primary">
            <i class="bi bi-plus-lg"></i>
            Quick Add Item
        </button>
    </div>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card success">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Total Items</div>
                        <div class="h5 mb-0 font-weight-bold">{{ $totalItems ?? '1,234' }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-box-seam fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card warning">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Low Stock Items</div>
                        <div class="h5 mb-0 font-weight-bold">{{ $lowStockItems ?? '23' }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-exclamation-triangle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">This Month's Donations</div>
                        <div class="h5 mb-0 font-weight-bold">{{ $monthlyDonations ?? '156' }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-heart fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card danger">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Expired Items</div>
                        <div class="h5 mb-0 font-weight-bold">{{ $expiredItems ?? '7' }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-calendar-x fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity and Quick Actions -->
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-clock-history me-2"></i>
                    Recent Activity
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>Item</th>
                                <th>User</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="badge bg-success">Added</span></td>
                                <td>Canned Tomatoes</td>
                                <td>John Doe</td>
                                <td>2 hours ago</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-info">Updated</span></td>
                                <td>Rice Bags</td>
                                <td>Jane Smith</td>
                                <td>4 hours ago</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-warning">Low Stock</span></td>
                                <td>Pasta</td>
                                <td>System</td>
                                <td>6 hours ago</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-lightning me-2"></i>
                    Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('food-items.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg me-2"></i>
                        Add New Item
                    </a>
                    <a href="{{ route('donations.create') }}" class="btn btn-success">
                        <i class="bi bi-heart me-2"></i>
                        Record Donation
                    </a>
                    <a href="{{ route('categories.create') }}" class="btn btn-info">
                        <i class="bi bi-tags me-2"></i>
                        Add Category
                    </a>
                    <button class="btn btn-warning" onclick="checkLowStock()">
                        <i class="bi bi-search me-2"></i>
                        Check Low Stock
                    </button>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-calendar-event me-2"></i>
                    Upcoming Expiries
                </h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <div>
                            <strong>Milk</strong>
                            <br>
                            <small class="text-muted">Expires in 2 days</small>
                        </div>
                        <span class="badge bg-warning rounded-pill">5 units</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <div>
                            <strong>Bread</strong>
                            <br>
                            <small class="text-muted">Expires in 3 days</small>
                        </div>
                        <span class="badge bg-warning rounded-pill">12 units</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function checkLowStock() {
    // Implement low stock check functionality
    alert('Checking low stock items...');
}
</script>
@endsection
