@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Categories</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('categories.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add New Category
        </a>
    </div>
</div>

<div class="row">
    @forelse($categories as $category)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle me-3"
                             style="width: 40px; height: 40px; background-color: {{ $category->color }}"></div>
                        <div>
                            <h5 class="card-title mb-0">{{ $category->name }}</h5>
                            <small class="text-muted">{{ $category->food_items_count }} items</small>
                        </div>
                    </div>

                    @if($category->description)
                        <p class="card-text text-muted">{{ $category->description }}</p>
                    @endif

                    <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group" role="group">
                            <a href="{{ route('categories.edit', $category) }}"
                               class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            @if($category->food_items_count == 0)
                                <form method="POST" action="{{ route('categories.destroy', $category) }}"
                                      class="d-inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            @endif
                        </div>
                        <a href="{{ route('food-items.index', ['category' => $category->id]) }}"
                           class="btn btn-sm btn-outline-info">
                            View Items
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="text-center py-5">
                <i class="bi bi-tags fs-1 text-muted d-block mb-3"></i>
                <h4 class="text-muted">No Categories Found</h4>
                <p class="text-muted">Create your first category to organize your food items.</p>
                <a href="{{ route('categories.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Add First Category
                </a>
            </div>
        </div>
    @endforelse
</div>
@endsection
