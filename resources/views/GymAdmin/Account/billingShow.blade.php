@extends('layouts.app')

@section('title', 'View Gym Plan')

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
                <h5 class="card-header">View Gym Plan</h5>
                <div class="card-body">
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="gym_id" class="form-label">Gym</label>
                            <p class="form-control">{{ $gymPlan->gym->name }}</p>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="plan_id" class="form-label">Plan</label>
                            <p class="form-control">{{ $gymPlan->plan->name }}</p>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="start_date" class="form-label">Start Date</label>
                            <p class="form-control">{{ $gymPlan->start_date }}</p>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="end_date" class="form-label">End Date</label>
                            <p class="form-control">{{ $gymPlan->end_date }}</p>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="duration" class="form-label">Duration</label>
                            <p class="form-control">{{ $gymPlan->duration }} months</p>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="total_amount" class="form-label">Total Amount</label>
                            <p class="form-control">{{ $gymPlan->total_amount }}</p>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="amount_paid" class="form-label">Amount Paid</label>
                            <p class="form-control">{{ $gymPlan->amount_paid }}</p>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="due_amount" class="form-label">Due Amount</label>
                            <p class="form-control">{{ $gymPlan->due_amount }}</p>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="payment_method" class="form-label">Payment Method</label>
                            <p class="form-control">{{ $gymPlan->payment_method }}</p>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="payment_status" class="form-label">Payment Status</label>
                            <p class="form-control">{{ $gymPlan->payment_status }}</p>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="status" class="form-label">Status</label>
                            <p class="form-control">{{ $gymPlan->status }}</p>
                        </div>
                    </div>
                    {{-- <a href="{{ route('billing', $gymPlan->id) }}" class="btn btn-primary">Edit</a> --}}
                </div>
            </div>
        </div>
    </div>
@endsection
