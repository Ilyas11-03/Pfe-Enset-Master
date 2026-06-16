@extends('layouts.app')

@section('title', 'Edit Payment')

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            @if (session('success'))
                <div class="bs-toast toast toast-placement-ex m-2 fade bg-success bottom-0 end-0 show" role="alert"
                    aria-live="assertive" aria-atomic="true" id="messageToast">
                    <div class="toast-header">
                        <i class="bx bx-bell me-2"></i>
                        <div class="me-auto fw-semibold">Status</div>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">{{ session('success') }}</div>
                </div>
            @endif
            @if (session('error'))
                <div class="bs-toast toast toast-placement-ex m-2 fade bg-danger bottom-0 end-0 show" role="alert"
                    aria-live="assertive" aria-atomic="true" id="errorToast">
                    <div class="toast-header">
                        <i class="bx bx-bell me-2"></i>
                        <div class="me-auto fw-semibold">Error</div>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">{{ session('error') }}</div>
                </div>
            @endif

            <div class="card">
                <h5 class="card-header">Edit Payment</h5>
                <div class="card-body">
                    <form action="{{ route('staff.payments.update', encrypt($payment->id)) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="member_id" class="form-label">Member</label>
                                <select class="form-control @error('member_id') is-invalid @enderror" id="member_id"
                                    name="member_id" required>
                                    <option>Select Member</option>
                                    @foreach ($members as $member)
                                        <option value="{{ encrypt($member->id) }}" {{ $member->id == $payment->member_id ? 'selected' : '' }}>{{ $member->name }}</option>
                                    @endforeach
                                </select>
                                @error('member_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="membership_id" class="form-label">Membership</label>
                                <select class="form-control @error('membership_id') is-invalid @enderror" id="membership_id"
                                    name="membership_id" required>
                                    <option>Select Plan</option>
                                    @foreach ($memberships as $membership)
                                        <option value="{{ encrypt($membership->id) }}" 
                                            data-price="{{ $membership->price }}"
                                            data-duration="{{ $membership->duration }}"
                                            {{ $membership->id == $payment->membership_id ? 'selected' : '' }}>
                                            {{ $membership->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('membership_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                                    id="start_date" name="start_date" value="{{ old('start_date', $payment->start_date) }}" required>
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                                    id="end_date" name="end_date" value="{{ old('end_date', $payment->end_date) }}" readonly>
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="sport_id" class="form-label">Sports</label>
                                <select class="form-control @error('sport_id') is-invalid @enderror" id="sport_id"
                                    name="sport_id" required>
                                    <option>Select Sport</option>
                                    @foreach ($sports as $sport)
                                        <option value="{{ encrypt($sport->id) }}" {{ $sport->id == $payment->sport_id ? 'selected' : '' }}>{{ $sport->name }}</option>
                                    @endforeach
                                </select>
                                @error('sport_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="total_amount" class="form-label">Total Amount</label>
                                <input type="number" class="form-control @error('total_amount') is-invalid @enderror"
                                    id="total_amount" name="total_amount" value="{{ old('total_amount', $payment->total_amount) }}" readonly>
                                @error('total_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="amount_paid" class="form-label">Amount Paid</label>
                                <input type="text" class="form-control @error('amount_paid') is-invalid @enderror"
                                    id="amount_paid" name="amount_paid" value="{{ old('amount_paid', $payment->amount_paid) }}" required>
                                @error('amount_paid')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="due_amount" class="form-label">Due Amount</label>
                                <input type="text" class="form-control @error('due_amount') is-invalid @enderror"
                                    id="due_amount" name="due_amount" value="{{ old('due_amount', $payment->due_amount) }}" readonly>
                                @error('due_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="payment_status" class="form-label">Payment Status</label>
                                <select class="form-control @error('payment_status') is-invalid @enderror"
                                    id="payment_status" name="payment_status" required>
                                    <option value="Paid" {{ $payment->payment_status == 'Paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="Pending" {{ $payment->payment_status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Partial Paid" {{ $payment->payment_status == 'Partial Paid' ? 'selected' : '' }}>Partial Paid</option>
                                </select>
                                @error('payment_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="auto_renew" class="form-label">Auto Renew</label>
                                <select class="form-control @error('auto_renew') is-invalid @enderror" id="auto_renew"
                                    name="auto_renew" required>
                                    <option value="0" {{ $payment->auto_renew == 'No' ? 'selected' : '' }}>No</option>
                                    <option value="1" {{ $payment->auto_renew == 'Yes' ? 'selected' : '' }}>Yes</option>
                                </select>
                                @error('auto_renew')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="notes" class="form-label">Notes</label>
                                <textarea class="form-control @error('notes') is-invalid @enderror" id="notes"
                                    name="notes" rows="3">{{ old('notes', $payment->notes) }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const membershipSelect = document.getElementById('membership_id');
            const totalAmountInput = document.getElementById('total_amount');
            const amountPaidInput = document.getElementById('amount_paid');
            const dueAmountInput = document.getElementById('due_amount');
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');
            
            // Function to calculate total amount based on price, duration, and discount
            function calculateTotalAmount(price, duration) {
                return price * duration;
            }

            // Pre-fill total amount and due amount on page load
            const selectedOption = membershipSelect.options[membershipSelect.selectedIndex];
            const price = parseFloat(selectedOption.getAttribute('data-price')) || 0;
            const duration = parseInt(selectedOption.getAttribute('data-duration'), 10) || 0;
            totalAmountInput.value = calculateTotalAmount(price, duration);
            amountPaidInput.dispatchEvent(new Event('input')); // Trigger the calculation for due amount

            // Event listener for membership change
            membershipSelect.addEventListener('change', function() {
                const selectedOption = membershipSelect.options[membershipSelect.selectedIndex];
                const price = parseFloat(selectedOption.getAttribute('data-price')) || 0;
                const duration = parseInt(selectedOption.getAttribute('data-duration'), 10) || 0;
                totalAmountInput.value = calculateTotalAmount(price, duration);
                amountPaidInput.dispatchEvent(new Event('input')); // Trigger the calculation for due amount

                // Calculate and set end date
                const startDate = new Date(startDateInput.value);
                if (startDate && duration) {
                    const endDate = new Date(startDate);
                    endDate.setMonth(endDate.getMonth() + duration);
                    endDateInput.value = endDate.toISOString().slice(0, 10);
                }
            });

            // Event listener for amount paid input
            amountPaidInput.addEventListener('input', function() {
                const totalAmount = parseFloat(totalAmountInput.value) || 0;
                const amountPaid = parseFloat(amountPaidInput.value) || 0;
                dueAmountInput.value = totalAmount - amountPaid;
            });

            // Event listener for start date change
            startDateInput.addEventListener('change', function() {
                const selectedOption = membershipSelect.options[membershipSelect.selectedIndex];
                const duration = parseInt(selectedOption.getAttribute('data-duration'), 10) || 0;
                const startDate = new Date(startDateInput.value);
                if (startDate && duration) {
                    const endDate = new Date(startDate);
                    endDate.setMonth(endDate.getMonth() + duration);
                    endDateInput.value = endDate.toISOString().slice(0, 10);
                }
            });
        });
    </script>
@endsection
