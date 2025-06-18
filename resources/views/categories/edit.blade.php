@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Category</h1>
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
                <form method="POST" action="{{ route('categories.update', $category) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Category Name *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               id="name" name="name" value="{{ old('name', $category->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="description" name="description" rows="3">{{ old('description', $category->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="color" class="form-label">Category Color *</label>
                        <div class="input-group">
                            <input type="color" class="form-control form-control-color @error('color') is-invalid @enderror"
                                   id="color" name="color" value="{{ old('color', $category->color) }}" required>
                            <input type="text" class="form-control @error('color') is-invalid @enderror"
                                   id="color_text" value="{{ old('color', $category->color) }}" readonly>
                        </div>
                        @error('color')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('categories.index') }}" class="btn btn-secondary me-md-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Update Category
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
                         style="width: 40px; height: 40px; background-color: {{ $category->color }}" id="preview-color"></div>
                    <div>
                        <h6 class="mb-0" id="preview-name">{{ $category->name }}</h6>
                        <small class="text-muted">{{ $category->total_items }} items</small>
                    </div>
                </div>
                <p class="text-muted" id="preview-description">{{ $category->description ?: 'No description' }}</p>
            </div>
        </div>

        @if($category->foodItems->count() > 0)
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0">Items in this Category</h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i>
                        This category contains {{ $category->foodItems->count() }} items.
                        You cannot delete it until all items are moved to other categories.
                    </div>
                    <a href="{{ route('food-items.index', ['category' => $category->id]) }}"
                       class="btn btn-sm btn-outline-primary">
                        View All Items
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('name').addEventListener('input', function() {
    document.getElementById('preview-name').textContent = this.value || '{{ $category->name }}';
});

document.getElementById('description').addEventListener('input', function() {
    document.getElementById('preview-description').textContent = this.value || 'No description';
});

document.getElementById('color').addEventListener('input', function() {
    document.getElementById('color_text').value = this.value;
    document.getElementById('preview-color').style.backgroundColor = this.value;
});
</script>
@endsection
