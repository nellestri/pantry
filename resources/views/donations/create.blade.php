@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Record New Donation</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('donations.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Donations
        </a>
    </div>
</div>

<form method="POST" action="{{ route('donations.store') }}" id="donation-form">
    @csrf

    <div class="row">
        <div class="col-md-8">
            <!-- Donor Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Donor Information</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="donor_name" class="form-label">Donor Name *</label>
                            <input type="text" class="form-control @error('donor_name') is-invalid @enderror"
                                   id="donor_name" name="donor_name" value="{{ old('donor_name') }}" required>
                            @error('donor_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="donation_date" class="form-label">Donation Date *</label>
                            <input type="date" class="form-control @error('donation_date') is-invalid @enderror"
                                   id="donation_date" name="donation_date" value="{{ old('donation_date', date('Y-m-d')) }}" required>
                            @error('donation_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="donor_email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('donor_email') is-invalid @enderror"
                                   id="donor_email" name="donor_email" value="{{ old('donor_email') }}">
                            @error('donor_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="donor_phone" class="form-label">Phone</label>
                            <input type="tel" class="form-control @error('donor_phone') is-invalid @enderror"
                                   id="donor_phone" name="donor_phone" value="{{ old('donor_phone') }}">
                            @error('donor_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror"
                                  id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Donated Items -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Donated Items</h5>
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="addItem()">
                        <i class="bi bi-plus"></i> Add Item
                    </button>
                </div>
                <div class="card-body">
                    <div id="items-container">
                        <!-- Items will be added here -->
                    </div>
                    @error('items')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Donation Summary</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Total Items:</strong> <span id="total-items">0</span>
                    </div>
                    <div class="mb-3">
                        <strong>Total Value:</strong> $<span id="total-value">0.00</span>
                    </div>
                    <hr>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Record Donation
                        </button>
                        <a href="{{ route('donations.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('scripts')
<script>
let itemIndex = 0;
const foodItems = @json($foodItems);

function addItem() {
    const container = document.getElementById('items-container');
    const itemHtml = `
        <div class="border rounded p-3 mb-3" id="item-${itemIndex}">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0">Item ${itemIndex + 1}</h6>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeItem(${itemIndex})">
                    <i class="bi bi-trash"></i>
                </button>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Food Item *</label>
                    <select class="form-select" name="items[${itemIndex}][food_item_id]" required onchange="updateItemInfo(${itemIndex})">
                        <option value="">Select Item</option>
                        ${foodItems.map(item => `<option value="${item.id}" data-unit="${item.unit}">${item.name} (${item.category.name})</option>`).join('')}
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Quantity *</label>
                    <input type="number" class="form-control" name="items[${itemIndex}][quantity]" min="1" required onchange="updateSummary()">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Value ($)</label>
                    <input type="number" class="form-control" name="items[${itemIndex}][value]" step="0.01" min="0" onchange="updateSummary()">
                </div>
            </div>
            <div class="text-muted" id="item-info-${itemIndex}"></div>
        </div>
    `;

    container.insertAdjacentHTML('beforeend', itemHtml);
    itemIndex++;
    updateSummary();
}

function removeItem(index) {
    document.getElementById(`item-${index}`).remove();
    updateSummary();
}

function updateItemInfo(index) {
    const select = document.querySelector(`select[name="items[${index}][food_item_id]"]`);
    const selectedOption = select.options[select.selectedIndex];
    const infoDiv = document.getElementById(`item-info-${index}`);

    if (selectedOption.value) {
        const unit = selectedOption.dataset.unit;
        infoDiv.innerHTML = `<small>Unit: ${unit}</small>`;
    } else {
        infoDiv.innerHTML = '';
    }

    updateSummary();
}

function updateSummary() {
    const quantities = document.querySelectorAll('input[name*="[quantity]"]');
    const values = document.querySelectorAll('input[name*="[value]"]');

    let totalItems = 0;
    let totalValue = 0;

    quantities.forEach(input => {
        if (input.value) {
            totalItems += parseInt(input.value);
        }
    });

    values.forEach(input => {
        if (input.value) {
            totalValue += parseFloat(input.value);
        }
    });

    document.getElementById('total-items').textContent = totalItems;
    document.getElementById('total-value').textContent = totalValue.toFixed(2);
}

// Add first item on page load
document.addEventListener('DOMContentLoaded', function() {
    addItem();
});
</script>
@endsection
