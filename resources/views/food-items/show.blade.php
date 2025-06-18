@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">{{ $foodItem->name }}</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('food-items.edit', $foodItem) }}" class="btn btn-primary">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <form method="POST" action="{{ route('food-items.destroy', $foodItem) }}"
                  class="d-inline" onsubmit="return confirm('Are you sure you want to delete this item?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-trash"></i> Delete
                </button>
            </form>
        </div>
        <a href="{{ route('food-items.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Items
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5>Item Details</h5>
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Name:</strong></td>
                                <td>{{ $foodItem->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Category:</strong></td>
                                <td>
                                    <span class="badge" style="background-color: {{ $foodItem->category->color }}">
                                        {{ $foodItem->category->name }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Quantity:</strong></td>
                                <td>
                                    <strong>{{ $foodItem->quantity }}</strong> {{ $foodItem->unit }}
                                    @if($foodItem->quantity <= 5)
                                        <span class="badge bg-warning ms-2">Low Stock</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Location:</strong></td>
                                <td>{{ $foodItem->location ?? 'Not specified' }}</td>
                            </tr>
                            @if($foodItem->cost)
                                <tr>
                                    <td><strong>Cost:</strong></td>
                                    <td>${{ number_format($foodItem->cost, 2) }}</td>
                                </tr>
                            @endif
                        </table>
                    </div>

                    <div class="col-md-6">
                        <h5>Dates & Status</h5>
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Date Added:</strong></td>
                                <td>{{ $foodItem->date_added->format('M d, Y') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Expiration Date:</strong></td>
                                <td>
                                    @if($foodItem->expiration_date)
                                        {{ $foodItem->expiration_date->format('M d, Y') }}
                                        @if($foodItem->days_until_expiration !== null)
                                            <br>
                                            <small class="text-muted">
                                                @if($foodItem->days_until_expiration > 0)
                                                    {{ $foodItem->days_until_expiration }} days remaining
                                                @elseif($foodItem->days_until_expiration == 0)
                                                    Expires today
                                                @else
                                                    Expired {{ abs($foodItem->days_until_expiration) }} days ago
                                                @endif
                                            </small>
                                        @endif
                                    @else
                                        <span class="text-muted">No expiration date</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Status:</strong></td>
                                <td>
                                    @if($foodItem->is_expired)
                                        <span class="badge bg-danger">Expired</span>
                                    @elseif($foodItem->is_expiring_soon)
                                        <span class="badge bg-warning">Expiring Soon</span>
                                    @elseif($foodItem->quantity <= 5)
                                        <span class="badge bg-warning">Low Stock</span>
                                    @else
                                        <span class="badge bg-success">Good</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Last Updated:</strong></td>
                                <td>{{ $foodItem->updated_at->format('M d, Y g:i A') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                @if($foodItem->description)
                    <div class="mb-4">
                        <h5>Description</h5>
                        <p class="text-muted">{{ $foodItem->description }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Status Alerts -->
        @if($foodItem->is_expired)
            <div class="alert alert-danger">
                <h6><i class="bi bi-exclamation-triangle"></i> Item Expired</h6>
                <p class="mb-0">This item expired {{ abs($foodItem->days_until_expiration) }} days ago. Consider removing it from inventory.</p>
            </div>
        @elseif($foodItem->is_expiring_soon)
            <div class="alert alert-warning">
                <h6><i class="bi bi-clock"></i> Expiring Soon</h6>
                <p class="mb-0">This item will expire in {{ $foodItem->days_until_expiration }} days. Use it soon!</p>
            </div>
        @endif

        @if($foodItem->quantity <= 5)
            <div class="alert alert-info">
                <h6><i class="bi bi-box"></i> Low Stock</h6>
                <p class="mb-0">Only {{ $foodItem->quantity }} {{ $foodItem->unit }} remaining. Consider restocking.</p>
            </div>
        @endif

        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Quick Actions</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('food-items.edit', $foodItem) }}" class="btn btn-outline-primary">
                        <i class="bi bi-pencil"></i> Edit Item
                    </a>
                    <button class="btn btn-outline-success" onclick="updateQuantity('increase')">
                        <i class="bi bi-plus-circle"></i> Increase Quantity
                    </button>
                    <button class="btn btn-outline-warning" onclick="updateQuantity('decrease')">
                        <i class="bi bi-dash-circle"></i> Decrease Quantity
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Update Modal -->
<div class="modal fade" id="quantityModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Quantity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('food-items.update', $foodItem) }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="new_quantity" class="form-label">New Quantity</label>
                        <input type="number" class="form-control" id="new_quantity" name="quantity"
                               value="{{ $foodItem->quantity }}" min="0" required>
                    </div>
                    <!-- Hidden fields to maintain other data -->
                    <input type="hidden" name="name" value="{{ $foodItem->name }}">
                    <input type="hidden" name="category_id" value="{{ $foodItem->category_id }}">
                    <input type="hidden" name="unit" value="{{ $foodItem->unit }}">
                    <input type="hidden" name="description" value="{{ $foodItem->description }}">
                    <input type="hidden" name="expiration_date" value="{{ $foodItem->expiration_date?->format('Y-m-d') }}">
                    <input type="hidden" name="cost" value="{{ $foodItem->cost }}">
                    <input type="hidden" name="location" value="{{ $foodItem->location }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Quantity</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function updateQuantity(action) {
    const currentQuantity = {{ $foodItem->quantity }};
    const modal = new bootstrap.Modal(document.getElementById('quantityModal'));
    const input = document.getElementById('new_quantity');

    if (action === 'increase') {
        input.value = currentQuantity + 1;
    } else if (action === 'decrease' && currentQuantity > 0) {
        input.value = currentQuantity - 1;
    }

    modal.show();
}
</script>
@endsection
