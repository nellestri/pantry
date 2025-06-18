@extends('layouts.user')

@section('title', 'My Reservations')

@section('content')
<div class="container mt-4">
    <h2>My Reservations</h2>
    <a href="{{ route('reservations.create') }}" class="btn btn-primary mb-3">Reserve Pantry Items</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Item</th>
                <th>Quantity</th>
                <th>Status</th>
                <th>Pickup Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($reservations as $reservation)
            <tr>
                <td>{{ $reservation->item->name }}</td>
                <td>{{ $reservation->quantity }}</td>
                <td>
                    @if ($reservation->status == 'approved')
                        <span class="badge bg-success">Approved</span>
                    @elseif ($reservation->status == 'pending')
                        <span class="badge bg-warning">Pending</span>
                    @else
                        <span class="badge bg-danger">{{ ucfirst($reservation->status) }}</span>
                    @endif
                </td>
                <td>{{ $reservation->pickup_date ? $reservation->pickup_date->format('Y-m-d') : '-' }}</td>
                <td>
                    @if ($reservation->status == 'pending')
                        <form action="{{ route('reservations.destroy', $reservation) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Cancel this reservation?')">Cancel</button>
                        </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">No reservations found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
