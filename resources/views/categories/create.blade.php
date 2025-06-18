@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Create New Category</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Categories
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('categories.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Category Name *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="description" name="description" rows="3">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="color" class="form-label">Category Color *</label>
                        <div class="input-group">
                            <input type="color" class="form-control form-control-color @error('color') is-invalid @enderror"
                                   id="color" name="color" value="{{ old('color', '#6366f1') }}" required>
                            <input type="text" class="form-control @error('color') is-invalid @enderror"
                                   id="color_text" value="{{ old('color', '#6366f1') }}" readonly>
                        </div>
                        @error('color')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Choose a color to help identify this category</div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('categories.index') }}" class="btn btn-secondary me-md-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Create Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Category Preview</h6>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-3" id="category-preview">
                    <div class="rounded-circle me-3"
                         style="width: 40px; height: 40px; background-color: #6366f1" id="preview-color"></div>
                    <div>
                        <h6 class="mb-0" id="preview-name">Category Name</h6>
                        <small class="text-muted">0 items</small>
                    </div>
                </div>
                <p class="text-muted" id="preview-description">Category description will appear here</p>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">Suggested Categories</h6>
            </div>
            <div class="card-body">
                <div class="d-flex flex-wrap gap-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="fillCategory('Fruits', '#22c55e', 'Fresh fruits and produce')">Fruits</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="fillCategory('Vegetables', '#16a34a', 'Fresh vegetables and greens')">Vegetables</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="fillCategory('Dairy', '#3b82f6', 'Milk, cheese, and dairy products')">Dairy</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="fillCategory('Meat', '#dc2626', 'Fresh and frozen meat products')">Meat</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="fillCategory('Canned Goods', '#f59e0b', 'Canned and preserved foods')">Canned</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="fillCategory('Beverages', '#06b6d4', 'Drinks and beverages')">Beverages</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('name').addEventListener('input', function() {
    document.getElementById('preview-name').textContent = this.value || 'Category Name';
});

document.getElementById('description').addEventListener('input', function() {
    document.getElementById('preview-description').textContent = this.value || 'Category description will appear here';
});

document.getElementById('color').addEventListener('input', function() {
    document.getElementById('color_text').value = this.value;
    document.getElementById('preview-color').style.backgroundColor = this.value;
});

function fillCategory(name, color, description) {
    document.getElementById('name').value = name;
    document.getElementById('description').value = description;
    document.getElementById('color').value = color;
    document.getElementById('color_text').value = color;

    // Update preview
    document.getElementById('preview-name').textContent = name;
    document.getElementById('preview-description').textContent = description;
    document.getElementById('preview-color').style.backgroundColor = color;
}
</script>
@endsection
