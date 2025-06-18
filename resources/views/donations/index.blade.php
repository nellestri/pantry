@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Donations</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('donations.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Record New Donation
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Donor</th>
                        <th>Date</th>
                        <th>Items</th>
                        <th>Total Value</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($donations as $donation)
                        <tr>
                            <td>
                                <strong>{{ $donation->donor_name }}</strong>
                                @if($donation->donor_email)
                                    <br><small class="text-muted">{{ $donation->donor_email }}</small>
                                @endif
                                @if($donation->donor_phone)
                                    <br><small class="text-muted">{{ $donation->donor_phone }}</small>
                                @endif
                            </td>
                            <td>{{ $donation->donation_date->format('M d, Y') }}</td>
                            <td>
                                <span class="badge bg-primary">{{ $donation->total_items }} items</span>
                                @if($donation->notes)
                                    <br><small class="text-muted">{{ Str::limit($donation->notes, 30) }}</small>
                                @endif
                            </td>
                            <td>
                                @if($donation->total_value > 0)
                                    ${{ number_format($donation->total_value, 2) }}
                                @else
                                    <span class="text-muted">Not specified</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('donations.show', $donation) }}"
                                       class="btn btn-sm btn-outline-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('donations.edit', $donation) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST" action="{{ route('donations.destroy', $donation) }}"
                                          class="d-inline" onsubmit="return confirm('Are you sure? This will reverse inventory changes.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="bi bi-heart fs-1 d-block mb-2"></i>
                                No donations recorded yet
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $donations->links() }}
        </div>
    </div>
</div>
@endsection
