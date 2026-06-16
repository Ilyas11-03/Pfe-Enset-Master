@extends('layouts.app')

@section('title', 'Expense Details')

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Expenses /</span> Expense Details</h4>
            </div>
            <div class="card p-3">
                <div class="mb-3 row">
                    <label for="description" class="col-sm-2 col
                <label for="description"
                        class="col-sm-2 col-form-label">Description</label>
                    <div class="col-sm-10">
                        <p class="form-control-plaintext">{{ $expense->description }}</p>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="category" class="col-sm-2 col-form-label">Category</label>
                    <div class="col-sm-10">
                        <p class="form-control-plaintext">{{ $expense->category }}</p>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="amount" class="col-sm-2 col-form-label">Amount</label>
                    <div class="col-sm-10">
                        <p class="form-control-plaintext">${{ number_format($expense->amount, 2) }}</p>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="expense_date" class="col-sm-2 col-form-label">Expense Date</label>
                    <div class="col-sm-10">
                        <p class="form-control-plaintext">
                            {{ \Carbon\Carbon::parse($expense->expense_date)->format('Y-m-d') }}</p>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="receipt" class="col-sm-2 col-form-label">Receipt</label>
                    <div class="col-sm-10">
                        @if ($expense->receipt)
                            <a href="#" class="btn btn-sm btn-icon" data-bs-toggle="modal"
                                data-bs-target="#receiptModal"
                                onclick="showReceipt('{{ asset('storage/' . $expense->receipt) }}', '{{ $expense->name }}')">
                                <i class="bx bx-file"></i>
                            </a>
                        @else
                            <p class="form-control-plaintext">No receipt uploaded</p>
                        @endif
                    </div>
                </div>
                <div class="mb-3">
                    <a href="{{ route('gym_admin.expenses.index') }}" class="btn btn-secondary">Back to Expenses</a>
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
