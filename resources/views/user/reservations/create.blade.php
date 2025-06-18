@extends('layouts.user')

@section('title', 'Reserve Pantry Items')

@section('content')
<div class="container mt-4">
    <h2>Reserve Pantry Items</h2>
    <form action="{{ route('reservations.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="item_id" class="form-label">Select Item</label>
            <select class="form-control" name="item_id" id="item_id" required>
                @foreach ($items as $item)
                    <option value="{{ $item->id }}">{{ $item->name }} (In stock: {{ $item->stock }})</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" class="form-control" name="quantity" min="1" max="10" required>
        </div>
        <button type="submit" class="btn btn-primary">Reserve</button>
    </form>
</div>
@endsection
