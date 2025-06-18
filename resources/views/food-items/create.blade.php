@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4><i class="bi bi-plus-circle"></i> Add New Food Item</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('food-items.store') }}" method="POST">
                    @csrf
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Food Item Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-control @error('category') is-invalid @enderror" 
                                    id="category" name="category" required>
                                <option value="">Select Category</option>
                                <option value="Fruits" {{ old('category') == 'Fruits' ? 'selected' : '' }}>Fruits</option>
                                <option value="Vegetables" {{ old('category') == 'Vegetables' ? 'selected' : '' }}>Vegetables</option>
                                <option value="Meat" {{ old('category') == 'Meat' ? 'selected' : '' }}>Meat</option>
                                <option value="Dairy" {{ old('category') == 'Dairy' ? 'selected' : '' }}>Dairy</option>
                                <option value="Grains" {{ old('category') == 'Grains' ? 'selected' : '' }}>Grains</option>
                                <option value="Beverages" {{ old('category') == 'Beverages' ? 'selected' : '' }}>Beverages</option>
                                <option value="Snacks" {{ old('category') == 'Snacks' ? 'selected' : '' }}>Snacks</option>
                                <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control @error('quantity') is-invalid @enderror" 
                                   id="quantity" name="quantity" value="{{ old('quantity') }}" min="0" required>
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="unit" class="form-label">Unit</label>
                            <select class="form-control @error('unit') is-invalid @enderror" 
                                    id="unit" name="unit" required>
                                <option value="">Select Unit</option>
                                <option value="pieces" {{ old('unit') == 'pieces' ? 'selected' : '' }}>Pieces</option>
                                <option value="kg" {{ old('unit') == 'kg' ? 'selected' : '' }}>Kilograms</option>
                                <option value="lbs" {{ old('unit') == 'lbs' ? 'selected' : '' }}>Pounds</option>
                                <option value="liters" {{ old('unit') == 'liters' ? 'selected' : '' }}>Liters</option>
                                <option value="bottles" {{ old('unit') == 'bottles' ? 'selected' : '' }}>Bottles</option>
                                <option value="cans" {{ old('unit') == 'cans' ? 'selected' : '' }}>Cans</option>
                                <option value="boxes" {{ old('unit') == 'boxes' ? 'selected' : '' }}>Boxes</option>
                            </select>
                            @error('unit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="expiry_date" class="form-label">Expiry Date (Optional)</label>
                        <input type="date" class="form-control @error('expiry_date') is-invalid @enderror" 
                               id="expiry_date" name="expiry_date" value="{{ old('expiry_date') }}">
                        @error('expiry_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes (Optional)</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" 
                                  id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('food-items.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Back to Pantry
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Add Item
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection