@extends('layouts.app')

@section('title', 'Show Payment')

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
                <h5 class="card-header">Show Payment</h5>
                <div class="card-body">
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="member_id" class="form-label">Member</label>
                            <input type="text" class="form-control" id="member_id" 
                                value="{{ $payment->member->name }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="membership_id" class="form-label">Membership</label>
                            <input type="text" class="form-control" id="membership_id" 
                                value="{{ $payment->membership->name }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="start_date" 
                                value="{{ $payment->start_date }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="end_date" 
                                value="{{ $payment->end_date }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="sport_id" class="form-label">Sport</label>
                            <input type="text" class="form-control" id="sport_id" 
                                value="{{ $payment->sport->name }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="total_amount" class="form-label">Total Amount</label>
                            <input type="number" class="form-control" id="total_amount" 
                                value="{{ $payment->total_amount }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="amount_paid" class="form-label">Amount Paid</label>
                            <input type="text" class="form-control" id="amount_paid" 
                                value="{{ $payment->amount_paid }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="due_amount" class="form-label">Due Amount</label>
                            <input type="text" class="form-control" id="due_amount" 
                                value="{{ $payment->due_amount }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="payment_status" class="form-label">Payment Status</label>
                            <input type="text" class="form-control" id="payment_status" 
                                value="{{ $payment->payment_status }}" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="auto_renew" class="form-label">Auto Renew</label>
                            <input type="text" class="form-control" id="auto_renew" 
                                value="{{ $payment->auto_renew ? 'Yes' : 'No' }}" readonly>
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control" id="notes" rows="3" readonly>{{ $payment->notes }}</textarea>
                        </div>
                    </div>
                    <a href="{{ route('staff.payments.index') }}" class="btn btn-secondary">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
