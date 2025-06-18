@extends('layouts.app')

@section('content')
<h2 class="mb-4">📋 Transaction History</h2>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Date</th>
            <th>Item</th>
            <th>Type</th>
            <th>Quantity</th>
            <th>Unit</th>
            <th>Notes</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transactions as $tx)
        <tr>
            <td>{{ $tx->created_at->format('Y-m-d H:i') }}</td>
            <td>{{ $tx->foodItem->name }}</td>
            <td>
                <span class="{{ $tx->getTypeDisplay()['class'] }}">
                    <i class="bi {{ $tx->getTypeDisplay()['icon'] }}"></i>
                    {{ $tx->getTypeDisplay()['text'] }}
                </span>
            </td>
            <td>{{ $tx->quantity }}</td>
            <td>{{ $tx->unit }}</td>
            <td>{{ $tx->notes }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $transactions->links() }}
@endsection
