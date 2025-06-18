@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Food Item</h1>
    <form action="{{ route('food-items.update', $foodItem) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Name</label>
            <input name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $foodItem->name) }}" required>
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label>Category</label>
            <input name="category" class="form-control @error('category') is-invalid @enderror" value="{{ old('category', $foodItem->category) }}" required>
            @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label>Quantity</label>
            <input type="number" step="0.01" name="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity', $foodItem->quantity) }}" required>
            @error('quantity') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label>Unit</label>
            <input name="unit" class="form-control @error('unit') is-invalid @enderror" value="{{ old('unit', $foodItem->unit) }}" required>
            @error('unit') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label>Expiry Date (optional)</label>
            <input type="date" name="expiry_date" class="form-control @error('expiry_date') is-invalid @enderror"
                   value="{{ old('expiry_date', $foodItem->expiry_date ? $foodItem->expiry_date->format('Y-m-d') : '') }}">
            @error('expiry_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label>Notes (optional)</label>
            <textarea name="notes" class="form-control @error('notes') is-invalid @enderror">{{ old('notes', $foodItem->notes) }}</textarea>
            @error('notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="d-flex justify-content-between">
            <a href="{{ route('food-items.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to Pantry
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle"></i> Update Item
            </button>
        </div>
    </form>
</div>
@endsection
