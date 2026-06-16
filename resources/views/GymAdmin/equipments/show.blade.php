@extends('layouts.app')

@section('title', 'Equipment Details')

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Equipment /</span> Show Equipment</h4>
        </div>
        <div class="card p-3">
            <div class="card-body">
                <div class="d-flex align-items-start align-items-sm-center gap-4">
                    <img src="{{ $equipment->image && Storage::exists('public/' . $equipment->image) ? Storage::url($equipment->image) : asset('/assets/img/default.png') }}" alt="Equipment Image" class="img-fluid rounded my-4" height="110" width="110" />

                    <div class="button-wrapper">
                        <!-- Displaying current image with no option to upload a new one -->
                        <p class="text-muted mb-0">Currently uploaded photo. Max size of 800K.</p>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="name" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control-plaintext" id="name" value="{{ $equipment->name }}" readonly>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="description" class="col-sm-2 col-form-label">Description</label>
                    <div class="col-sm-10">
                        <textarea class="form-control-plaintext" id="description" rows="3" readonly>{{ $equipment->description }}</textarea>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="quantity" class="col-sm-2 col-form-label">Quantity</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control-plaintext" id="quantity" value="{{ $equipment->quantity }}" readonly>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="amount" class="col-sm-2 col-form-label">Amount</label>
                    <div class="col-sm-10">
                        <input type="number" step="0.01" class="form-control-plaintext" id="amount" value="{{ $equipment->amount }}" readonly>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="purchase_date" class="col-sm-2 col-form-label">Purchase Date</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control-plaintext" id="purchase_date" value="{{ $equipment->purchase_date }}" readonly>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="maintenance_date" class="col-sm-2 col-form-label">Maintenance Date</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control-plaintext" id="maintenance_date" value="{{ $equipment->maintenance_date ? $equipment->maintenance_date : 'N/A' }}" readonly>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="serial_number" class="col-sm-2 col-form-label">Serial Number</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control-plaintext" id="serial_number" value="{{ $equipment->serial_number }}" readonly>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="condition" class="col-sm-2 col-form-label">Condition</label>
                    <div class="col-sm-10">
                        <select class="form-control-plaintext" id="condition" disabled>
                            <option value="New" {{ $equipment->condition == 'New' ? 'selected' : '' }}>New</option>
                            <option value="Good" {{ $equipment->condition == 'Good' ? 'selected' : '' }}>Good</option>
                            <option value="Poor" {{ $equipment->condition == 'Poor' ? 'selected' : '' }}>Poor</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <!-- No update button, just a back button or other actions -->
                    <a href="{{ route('gym_admin.equipment.index') }}" class="btn btn-secondary">Back to List</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
