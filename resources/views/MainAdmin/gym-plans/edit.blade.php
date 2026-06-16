@extends('layouts.app')

@section('title', 'Edit Gym Plan')

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
                <h5 class="card-header">Edit Gym Plan</h5>
                <div class="card-body">
                    <form action="{{ route('main_admin.gym-plans.update', $gymPlan->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="gym_id" class="form-label">Gym</label>
                                <select class="form-control @error('gym_id') is-invalid @enderror" id="gym_id"
                                    name="gym_id" required>
                                    @foreach ($gyms as $gym)
                                        <option value="{{ $gym->id }}" {{ $gym->id == $gymPlan->gym_id ? 'selected' : '' }}>
                                            {{ $gym->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('gym_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="plan_id" class="form-label">Plan</label>
                                <select class="form-control @error('plan_id') is-invalid @enderror" id="plan_id"
                                    name="plan_id" required>
                                    @foreach ($plans as $plan)
                                        <option value="{{ $plan->id }}" {{ $plan->id == $gymPlan->plan_id ? 'selected' : '' }}>
                                            {{ $plan->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('plan_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                                    id="start_date" name="start_date" value="{{ old('start_date', $gymPlan->start_date) }}" required>
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="duration" class="form-label">Duration</label>
                                <select class="form-control @error('duration') is-invalid @enderror" id="duration"
                                    name="duration" required>
                                    <option value="">Select Duration</option>
                                    <option value="1" {{ $gymPlan->duration == 1 ? 'selected' : '' }}>1 month</option>
                                    <option value="3" {{ $gymPlan->duration == 3 ? 'selected' : '' }}>3 months</option>
                                    <option value="6" {{ $gymPlan->duration == 6 ? 'selected' : '' }}>6 months</option>
                                    <option value="12" {{ $gymPlan->duration == 12 ? 'selected' : '' }}>12 months</option>
                                    <option value="24" {{ $gymPlan->duration == 24 ? 'selected' : '' }}>24 months</option>
                                </select>
                                @error('duration')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                                    id="end_date" name="end_date" value="{{ old('end_date', $gymPlan->end_date) }}" readonly>
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="payment_method" class="form-label">Payment Method</label>
                                <select class="form-control @error('payment_method') is-invalid @enderror"
                                    id="payment_method" name="payment_method" required>
                                    <option value="Cash" {{ $gymPlan->payment_method == 'Cash' ? 'selected' : '' }}>Cash</option>
                                    <option value="Credit Card" {{ $gymPlan->payment_method == 'Credit Card' ? 'selected' : '' }}>Credit Card</option>
                                    <option value="Bank Transfer" {{ $gymPlan->payment_method == 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                </select>
                                @error('payment_method')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="payment_status" class="form-label">Payment Status</label>
                                <select class="form-control @error('payment_status') is-invalid @enderror"
                                    id="payment_status" name="payment_status" required>
                                    <option value="">Select Status</option>
                                    <option value="Paid" {{ $gymPlan->payment_status == 'Paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="Pending" {{ $gymPlan->payment_status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Partial Paid" {{ $gymPlan->payment_status == 'Partial Paid' ? 'selected' : '' }}>Partial Paid</option>
                                </select>
                                @error('payment_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="total_amount" class="form-label">Total Amount</label>
                                <input type="text" class="form-control @error('total_amount') is-invalid @enderror"
                                    id="total_amount" name="total_amount" value="{{ old('total_amount', $gymPlan->total_amount) }}" readonly>
                                @error('total_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="amount_paid" class="form-label">Amount Paid</label>
                                <input type="text" class="form-control @error('amount_paid') is-invalid @enderror"
                                    id="amount_paid" name="amount_paid" value="{{ old('amount_paid', $gymPlan->amount_paid) }}" required>
                                @error('amount_paid')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="due_amount" class="form-label">Due Amount</label>
                                <input type="text" class="form-control @error('due_amount') is-invalid @enderror"
                                    id="due_amount" name="due_amount" value="{{ old('due_amount', $gymPlan->due_amount) }}" readonly>
                                @error('due_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="auto_renew" class="form-label">Auto Renew</label>
                                <select class="form-control @error('auto_renew') is-invalid @enderror" id="auto_renew" name="auto_renew" required>
                                    <option value="1" {{ $gymPlan->auto_renew == 1 ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{ $gymPlan->auto_renew == 0 ? 'selected' : '' }}>No</option>
                                </select>
                                @error('auto_renew')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3 col-md-12">
                                <label for="notes" class="form-label">Notes</label>
                                <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes', $gymPlan->notes) }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                        </div>
                        <input type="hidden" name="updated_by" value="{{ auth()->user()->id }}">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
    const startDateInput = document.getElementById('start_date');
    const durationSelect = document.getElementById('duration');
    const endDateInput = document.getElementById('end_date');
    const totalAmountInput = document.getElementById('total_amount');
    const amountPaidInput = document.getElementById('amount_paid');
    const dueAmountInput = document.getElementById('due_amount');
    const planSelect = document.getElementById('plan_id');

    const plans = @json($plans); // Get plans data from server

    function calculateEndDate() {
        const startDate = new Date(startDateInput.value);
        const duration = parseInt(durationSelect.value, 10);
        if (startDate && !isNaN(duration)) {
            const endDate = new Date(startDate);
            endDate.setMonth(endDate.getMonth() + duration);
            endDateInput.value = endDate.toISOString().split('T')[0];
        }
    }

    function calculateTotalAmount() {
        const planId = parseInt(planSelect.value, 10);
        const duration = parseInt(durationSelect.value, 10);
        const plan = plans.find(p => p.id === planId);

        if (plan && !isNaN(duration)) {
            let totalAmount = plan.price * duration;
            if (duration >= 3) {
                const discount = plan.discount_percentage || 0;
                totalAmount -= totalAmount * (discount / 100);
            }
            totalAmount = Math.round(totalAmount); // Ensure integer value
            totalAmountInput.value = totalAmount;
            calculateDueAmount(totalAmount);
        }
    }

    function calculateDueAmount(totalAmount) {
        const amountPaid = parseFloat(amountPaidInput.value) || 0;
        const dueAmount = Math.round(totalAmount - amountPaid); // Ensure integer value
        dueAmountInput.value = dueAmount;
    }

    startDateInput.addEventListener('change', calculateEndDate);
    durationSelect.addEventListener('change', function() {
        calculateEndDate();
        calculateTotalAmount();
    });
    planSelect.addEventListener('change', calculateTotalAmount);
    amountPaidInput.addEventListener('input', function() {
        const totalAmount = parseFloat(totalAmountInput.value) || 0;
        calculateDueAmount(totalAmount);
    });

    // Initialize values if pre-filled
    calculateEndDate();
    calculateTotalAmount();
});

    </script>
@endsection
