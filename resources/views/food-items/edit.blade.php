@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Food Item</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('food-items.show', $foodItem) }}" class="btn btn-outline-info me-2">
            <i class="bi bi-eye"></i> View Item
        </a>
        <a href="{{ route('food-items.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Items
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('food-items.update', $foodItem) }}">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <div class="col-md-8">
                            <label for="name" class="form-label">Item Name *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name', $foodItem->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="category_id" class="form-label">Category *</label>
                            <select class="form-select @error('category_id') is-invalid @enderror"
                                    id="category_id" name="category_id" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                            {{ old('category_id', $foodItem->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="description" name="description" rows="3">{{ old('description', $foodItem->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="quantity" class="form-label">Quantity *</label>
                            <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                                   id="quantity" name="quantity" value="{{ old('quantity', $foodItem->quantity) }}" min="0" required>
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="unit" class="form-label">Unit *</label>
                            <select class="form-select @error('unit') is-invalid @enderror" id="unit" name="unit" required>
                                <option value="pieces" {{ old('unit', $foodItem->unit) == 'pieces' ? 'selected' : '' }}>Pieces</option>
                                <option value="kg" {{ old('unit', $foodItem->unit) == 'kg' ? 'selected' : '' }}>Kilograms</option>
                                <option value="lbs" {{ old('unit', $foodItem->unit) == 'lbs' ? 'selected' : '' }}>Pounds</option>
                                <option value="cans" {{ old('unit', $foodItem->unit) == 'cans' ? 'selected' : '' }}>Cans</option>
                                <option value="boxes" {{ old('unit', $foodItem->unit) == 'boxes' ? 'selected' : '' }}>Boxes</option>
                                <option value="bottles" {{ old('unit', $foodItem->unit) == 'bottles' ? 'selected' : '' }}>Bottles</option>
                                <option value="bags" {{ old('unit', $foodItem->unit) == 'bags' ? 'selected' : '' }}>Bags</option>
                            </select>
                            @error('unit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="cost" class="form-label">Cost ($)</label>
                            <input type="number" class="form-control @error('cost') is-invalid @enderror"
                                   id="cost" name="cost" value="{{ old('cost', $foodItem->cost) }}" step="0.01" min="0">
                            @error('cost')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="expiration_date" class="form-label">Expiration Date</label>
                            <input type="date" class="form-control @error('expiration_date') is-invalid @enderror"
                                   id="expiration_date" name="expiration_date"
                                   value="{{ old('expiration_date', $foodItem->expiration_date?->format('Y-m-d')) }}">
                            @error('expiration_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="location" class="form-label">Storage Location</label>
                            <input type="text" class="form-control @error('location') is-invalid @enderror"
                                   id="location" name="location" value="{{ old('location', $foodItem->location) }}"
                                   placeholder="e.g., Shelf A, Freezer, Pantry">
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('food-items.show', $foodItem) }}" class="btn btn-secondary me-md-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Update Item
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Item Status</h6>
            </div>
            <div class="card-body">
                @if($foodItem->is_expired)
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle"></i>
                        This item has expired!
                    </div>
                @elseif($foodItem->is_expiring_soon)
                    <div class="alert alert-warning">
                        <i class="bi bi-clock"></i>
                        This item is expiring soon.
                    </div>
                @endif

                @if($foodItem->quantity <= 5)
                    <div class="alert alert-info">
                        <i class="bi bi-box"></i>
                        Low stock alert!
                    </div>
                @endif

                <p><strong>Added:</strong> {{ $foodItem->date_added->format('M d, Y') }}</p>
                <p><strong>Last Updated:</strong> {{ $foodItem->updated_at->format('M d, Y g:i A') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
