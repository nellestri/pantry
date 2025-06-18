@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Food Items</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('food-items.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add New Item
        </a>
    </div>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('food-items.index') }}" class="row g-3">
            <div class="col-md-4">
                <label for="search" class="form-label">Search</label>
                <input type="text" class="form-control" id="search" name="search"
                       value="{{ request('search') }}" placeholder="Search by name...">
            </div>
            <div class="col-md-3">
                <label for="category" class="form-label">Category</label>
                <select class="form-select" id="category" name="category">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                                {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="">All Status</option>
                    <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                    <option value="expiring_soon" {{ request('status') == 'expiring_soon' ? 'selected' : '' }}>Expiring Soon</option>
                    <option value="low_stock" {{ request('status') == 'low_stock' ? 'selected' : '' }}>Low Stock</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">&nbsp;</label>
                <div class="d-grid">
                    <button type="submit" class="btn btn-outline-primary">Filter</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Items Table -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Quantity</th>
                        <th>Location</th>
                        <th>Expiration Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                        <tr>
                            <td>
                                <strong>{{ $item->name }}</strong>
                                @if($item->description)
                                    <br><small class="text-muted">{{ Str::limit($item->description, 50) }}</small>
                                @endif
                            </td>
                            <td>
                                <span class="badge" style="background-color: {{ $item->category->color }}">
                                    {{ $item->category->name }}
                                </span>
                            </td>
                            <td>
                                <strong>{{ $item->quantity }}</strong> {{ $item->unit }}
                                @if($item->quantity <= 5)
                                    <br><small class="text-warning">Low Stock</small>
                                @endif
                            </td>
                            <td>{{ $item->location ?? 'Not specified' }}</td>
                            <td>
                                @if($item->expiration_date)
                                    {{ $item->expiration_date->format('M d, Y') }}
                                    @if($item->days_until_expiration !== null)
                                        <br>
                                        <small class="text-muted">
                                            @if($item->days_until_expiration > 0)
                                                {{ $item->days_until_expiration }} days left
                                            @elseif($item->days_until_expiration == 0)
                                                Expires today
                                            @else
                                                {{ abs($item->days_until_expiration) }} days ago
                                            @endif
                                        </small>
                                    @endif
                                @else
                                    <span class="text-muted">No expiration</span>
                                @endif
                            </td>
                            <td>
                                @if($item->is_expired)
                                    <span class="badge bg-danger">Expired</span>
                                @elseif($item->is_expiring_soon)
                                    <span class="badge bg-warning">Expiring Soon</span>
                                @elseif($item->quantity <= 5)
                                    <span class="badge bg-warning">Low Stock</span>
                                @else
                                    <span class="badge bg-success">Good</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('food-items.show', $item) }}"
                                       class="btn btn-sm btn-outline-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('food-items.edit', $item) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST" action="{{ route('food-items.destroy', $item) }}"
                                          class="d-inline" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="bi bi-box-seam fs-1 d-block mb-2"></i>
                                No food items found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $items->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection
