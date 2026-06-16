@extends('layouts.app')

@section('title', 'Edit Expense')

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Expenses /</span> Edit Expense</h4>
            </div>
            <div class="card p-3">
                <form action="{{ route('gym_admin.expenses.update', encrypt($expense->id)) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3 row">
                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name', $expense->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="description" class="col-sm-2 col-form-label">Description</label>
                        <div class="col-sm-10">
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                rows="3" required>{{ old('description', $expense->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="category" class="col-sm-2 col-form-label">Category</label>
                        <div class="col-sm-10">
                            <select class="form-control @error('category') is-invalid @enderror" id="category"
                                name="category" required>
                                <option value="">Select Category</option>
                                <option value="Rent"
                                    {{ old('category', $expense->category) == 'Rent' ? 'selected' : '' }}>Rent</option>
                                <option value="Utilities"
                                    {{ old('category', $expense->category) == 'Utilities' ? 'selected' : '' }}>Utilities
                                </option>
                                <option value="Salaries"
                                    {{ old('category', $expense->category) == 'Salaries' ? 'selected' : '' }}>Salaries
                                </option>
                                <option value="Maintenance"
                                    {{ old('category', $expense->category) == 'Maintenance' ? 'selected' : '' }}>Maintenance
                                </option>
                                <option value="Insurance"
                                    {{ old('category', $expense->category) == 'Insurance' ? 'selected' : '' }}>Insurance
                                </option>
                                <option value="Marketing and Advertising"
                                    {{ old('category', $expense->category) == 'Marketing and Advertising' ? 'selected' : '' }}>
                                    Marketing and Advertising</option>
                                <option value="Cleaning"
                                    {{ old('category', $expense->category) == 'Cleaning' ? 'selected' : '' }}>Cleaning
                                </option>
                                <option value="Security"
                                    {{ old('category', $expense->category) == 'Security' ? 'selected' : '' }}>Security
                                </option>
                                <option value="Other"
                                    {{ old('category', $expense->category) == 'Other' ? 'selected' : '' }}>Other</option>
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
                                id="amount" name="amount" value="{{ old('amount', $expense->amount) }}" required>
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="expense_date" class="col-sm-2 col-form-label">Expense Date</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control @error('expense_date') is-invalid @enderror"
                                id="expense_date" name="expense_date"
                                value="{{ old('expense_date', $expense->expense_date) }}" required>
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
                            @if ($expense->receipt)
                                <a href="#" class="btn btn-sm btn-icon" data-bs-toggle="modal"
                                    data-bs-target="#receiptModal"
                                    onclick="showReceipt('{{ asset('storage/' . $expense->receipt) }}', '{{ $expense->name }}')">
                                    <i class="bx bx-file"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Update Expense</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="receiptModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="receiptModalLabel">Receipt Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="receiptImage" src="" class="img-fluid d-none" alt="Receipt Preview">
                    <p id="nonImageFile" class="d-none">This file cannot be previewed. Click "Download" to
                        save it.</p>
                </div>
                <div class="modal-footer">
                    <a id="downloadReceipt" href="#" download class="btn btn-primary">Download</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        function showReceipt(url, filename) {
            const imageExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            const fileExtension = url.split('.').pop().toLowerCase();

            const receiptImage = document.getElementById('receiptImage');
            const nonImageFile = document.getElementById('nonImageFile');
            const downloadLink = document.getElementById('downloadReceipt');

            if (imageExtensions.includes(fileExtension)) {
                receiptImage.src = url;
                receiptImage.classList.remove('d-none');
                nonImageFile.classList.add('d-none');
            } else {
                receiptImage.classList.add('d-none');
                nonImageFile.classList.remove('d-none');
            }

            // Set download link and custom filename
            downloadLink.href = url;
            downloadLink.setAttribute('download', filename);
        }
    </script>
@endsection
