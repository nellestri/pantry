@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h1 class="page-title">
            <i class="bi bi-basket2-fill me-3"></i>My Food Pantry
        </h1>
        <a href="{{ route('food-items.create') }}" class="btn btn-primary btn-lg">
            <i class="bi bi-plus-circle me-2"></i>Add New Item
        </a>
    </div>

    @if($foodItems->count() > 0)
        <!-- Stats Row -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card glass-effect">
                    <div class="card-body text-center">
                        <i class="bi bi-box-seam display-4 text-primary mb-2"></i>
                        <h4 class="fw-bold">{{ $foodItems->count() }}</h4>
                        <p class="text-muted mb-0">Total Items</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card glass-effect">
                    <div class="card-body text-center">
                        <i class="bi bi-clock-history display-4 text-warning mb-2"></i>
                        <h4 class="fw-bold">{{ $foodItems->filter(fn($item) => $item->expiresSoon())->count() }}</h4>
                        <p class="text-muted mb-0">Expiring Soon</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card glass-effect">
                    <div class="card-body text-center">
                        <i class="bi bi-exclamation-triangle display-4 text-danger mb-2"></i>
                        <h4 class="fw-bold">{{ $foodItems->filter(fn($item) => $item->isExpired())->count() }}</h4>
                        <p class="text-muted mb-0">Expired</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Food Items Grid -->
        <div class="row">
            @foreach($foodItems as $item)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card food-item-card h-100
                            @if($item->isExpired()) danger
                            @elseif($item->expiresSoon()) warning
                            @endif">
                        <div class="card-body p-4">
                            <!-- Category Badge -->
                            <div class="category-badge category-{{ strtolower($item->category) }}">
                                {{ $item->category }}
                            </div>

                            <!-- Item Name -->
                            <h5 class="card-title fw-bold mb-3">{{ $item->name }}</h5>

                            <!-- Quantity -->
                            <div class="quantity-display mb-3">
                                <i class="bi bi-box me-2"></i>{{ $item->quantity }} {{ $item->unit }}
                            </div>

                            <!-- Expiry Date -->
                            @if($item->expiry_date)
                                <div class="expiry-badge mb-3
                                            @if($item->isExpired()) expiry-danger
                                            @elseif($item->expiresSoon()) expiry-warning
                                                @else expiry-good
                                            @endif">
                                    @if($item->isExpired())
                                        <i class="bi bi-exclamation-triangle"></i>
                                        Expired {{ $item->expiry_date->diffForHumans() }}
                                    @elseif($item->expiresSoon())
                                        <i class="bi bi-clock"></i>
                                        Expires {{ $item->expiry_date->diffForHumans() }}
                                    @else
                                        <i class="bi bi-calendar-check"></i>
                                        Expires {{ $item->expiry_date->format('M d, Y') }}
                                    @endif
                                </div>
                            @else
                                <div class="expiry-badge expiry-good mb-3">
                                    <i class="bi bi-infinity"></i>
                                    No expiry date
                                </div>
                            @endif


                            <button class="btn btn-outline-success flex-fill" data-bs-toggle="modal"
                                data-bs-target="#consumeModal{{ $item->id }}">
                                <i class="bi bi-check-circle me-1"></i> Consume
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="consumeModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form method="POST" action="{{ route('food-items.consume', $item) }}">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Consume {{ $item->name }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <label>Quantity</label>
                                                <input type="number" name="quantity" step="0.01" class="form-control"
                                                    max="{{ $item->quantity }}" required>
                                                <label class="mt-2">Notes (optional)</label>
                                                <textarea name="notes" class="form-control" rows="2"></textarea>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success">Record</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>


                            <!-- Notes -->
                            @if($item->notes)
                                <div class="mb-3">
                                    <small class="text-muted">
                                        <i class="bi bi-sticky me-1"></i>{{ $item->notes }}
                                    </small>
                                </div>
                            @endif
                        </div>

                        <!-- Card Actions -->
                        <div class="card-footer bg-transparent border-0 p-4 pt-0">
                            <div class="d-flex gap-2">
                                <a href="{{ route('food-items.edit', $item) }}" class="btn btn-outline-primary flex-fill">
                                    <i class="bi bi-pencil me-1"></i>Edit
                                </a>
                                <form action="{{ route('food-items.destroy', $item) }}" method="POST" class="flex-fill">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger w-100"
                                        onclick="return confirm('Are you sure you want to delete {{ $item->name }}?')">
                                        <i class="bi bi-trash me-1"></i>Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <i class="bi bi-basket2"></i>
            <h2 class="mt-4 mb-3">Your pantry is empty!</h2>
            <p class="text-muted mb-4 fs-5">Start tracking your food items and never let anything go to waste again.</p>
            <a href="{{ route('food-items.create') }}" class="btn btn-primary btn-lg">
                <i class="bi bi-plus-circle me-2"></i>Add Your First Item
            </a>
        </div>
    @endif
@endsection
