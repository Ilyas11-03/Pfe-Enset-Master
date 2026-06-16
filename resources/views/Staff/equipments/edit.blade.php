@extends('layouts.app')

@section('title', 'Edit Equipment')

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Equipment /</span> Edit Equipment</h4>
            </div>
            <div class="card p-3">
                <form action="{{ route('staff.equipment.update', encrypt($equipment->id)) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            <img src="{{ $equipment->image && Storage::exists('public/' . $equipment->image) ? Storage::url($equipment->image) : asset('/assets/img/default.png') }}"
                                alt="Equipment Image" class="img-fluid rounded my-4" height="110" width="110"
                                id="uploadedAvatar" />
                            <div class="button-wrapper">
                                <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                    <span class="d-none d-sm-block">Upload new photo</span>
                                    <i class="bx bx-upload d-block d-sm-none"></i>
                                    <input type="file" id="upload" class="account-file-input" name="image" hidden />
                                </label>
                                <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name', $equipment->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="description" class="col-sm-2 col-form-label">Description</label>
                        <div class="col-sm-10">
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                rows="3">{{ old('description', $equipment->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="quantity" class="col-sm-2 col-form-label">Quantity</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                                id="quantity" name="quantity" value="{{ old('quantity', $equipment->quantity) }}" required>
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="amount" class="col-sm-2 col-form-label">Amount</label>
                        <div class="col-sm-10">
                            <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror"
                                id="amount" name="amount" value="{{ old('amount', $equipment->amount) }}" required>
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="purchase_date" class="col-sm-2 col-form-label">Purchase Date</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control @error('purchase_date') is-invalid @enderror"
                                id="purchase_date" name="purchase_date"
                                value="{{ old('purchase_date', $equipment->purchase_date) }}" required>
                            @error('purchase_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="maintenance_date" class="col-sm-2 col-form-label">Maintenance Date</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control @error('maintenance_date') is-invalid @enderror"
                                id="maintenance_date" name="maintenance_date"
                                value="{{ old('maintenance_date', $equipment->maintenance_date) }}">
                            @error('maintenance_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="serial_number" class="col-sm-2 col-form-label">Serial Number</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('serial_number') is-invalid @enderror"
                                id="serial_number" name="serial_number"
                                value="{{ old('serial_number', $equipment->serial_number) }}">
                            @error('serial_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="condition" class="col-sm-2 col-form-label">Condition</label>
                        <div class="col-sm-10">
                            <select class="form-control @error('condition') is-invalid @enderror" id="condition"
                                name="condition" required>
                                <option value="">Select Condition</option>
                                <option value="New"
                                    {{ old('condition', $equipment->condition) == 'New' ? 'selected' : '' }}>New</option>
                                <option value="Good"
                                    {{ old('condition', $equipment->condition) == 'Good' ? 'selected' : '' }}>Good</option>
                                <option value="Poor"
                                    {{ old('condition', $equipment->condition) == 'Poor' ? 'selected' : '' }}>Poor</option>
                            </select>
                            @error('condition')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Update Equipment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Show Pic Instantly --}}
    <script>
        document.getElementById('upload').addEventListener('change', function(event) {
            var input = event.target;
            var reader = new FileReader();
            reader.onload = function() {
                var dataURL = reader.result;
                var output = document.getElementById('uploadedAvatar');
                output.src = dataURL;
            };
            reader.readAsDataURL(input.files[0]);
        });
    </script>
@endsection
