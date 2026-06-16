@extends('layouts.app')

@section('title', 'Add Expense')

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Expenses /</span> Add Expense</h4>
            </div>
            <div class="card p-3">
                <form action="{{ route('gym_admin.expenses.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3 row">
                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="description" class="col-sm-2 col-form-label">Description</label>
                        <div class="col-sm-10">
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="category" class="col-sm-2 col-form-label">Category</label>
                        <div class="col-sm-10">
                            <select class="form-control @error('category') is-invalid @enderror" id="category" name="category" required>
                                <option value="">Select Category</option>
                                <option value="Rent" {{ old('category') == 'Rent' ? 'selected' : '' }}>Rent</option>
                                <option value="Utilities" {{ old('category') == 'Utilities' ? 'selected' : '' }}>Utilities</option>
                                <option value="Salaries" {{ old('category') == 'Salaries' ? 'selected' : '' }}>Salaries</option>
                                <option value="Maintenance" {{ old('category') == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                                <option value="Insurance" {{ old('category') == 'Insurance' ? 'selected' : '' }}>Insurance</option>
                                <option value="Marketing and Advertising" {{ old('category') == 'Marketing and Advertising' ? 'selected' : '' }}>Marketing and Advertising</option>
                                <option value="Cleaning" {{ old('category') == 'Cleaning' ? 'selected' : '' }}>Cleaning</option>
                                <option value="Security" {{ old('category') == 'Security' ? 'selected' : '' }}>Security</option>
                                <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="amount" class="col-sm-2 col-form-label">Amount</label>
                        <div class="col-sm-10">
                            <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror"
                                id="amount" name="amount" value="{{ old('amount') }}" required>
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="expense_date" class="col-sm-2 col-form-label">Expense Date</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control @error('expense_date') is-invalid @enderror"
                                id="expense_date" name="expense_date" value="{{ old('expense_date') }}" required>
                            @error('expense_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="receipt" class="col-sm-2 col-form-label">Receipt</label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control @error('receipt') is-invalid @enderror" id="receipt"
                                name="receipt">
                            @error('receipt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Add Expense</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
