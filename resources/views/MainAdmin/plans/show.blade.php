@extends('layouts.app')

@section('title', 'View Plan')

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        @if (session('success'))
            <div class="bs-toast toast toast-placement-ex m-2 fade bg-success bottom-0 end-0 show" role="alert" aria-live="assertive" aria-atomic="true" id="messageToast">
                <div class="toast-header">
                    <i class="bx bx-bell me-2"></i>
                    <div class="me-auto fw-semibold">Status</div>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">{{ session('success') }}</div>
            </div>
        @endif
        @if (session('error'))
            <div class="bs-toast toast toast-placement-ex m-2 fade bg-danger bottom-0 end-0 show" role="alert" aria-live="assertive" aria-atomic="true" id="errorToast">
                <div class="toast-header">
                    <i class="bx bx-bell me-2"></i>
                    <div class="me-auto fw-semibold">Error</div>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">{{ session('error') }}</div>
            </div>
        @endif

        <div class="card">
            <h5 class="card-header">Plan Details</h5>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Name</label>
                        <p class="form-control">{{ $plan->name }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Description</label>
                        <p class="form-control">{{ $plan->description }}</p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Price</label>
                        <p class="form-control">{{ $plan->price }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Discount Percentage</label>
                        <p class="form-control">{{ $plan->discount_percentage }}</p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">User Limit</label>
                        <p class="form-control">{{ $plan->user_limit }}</p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Memeber Limit</label>
                        <p class="form-control">{{ $plan->member_limit }}</p>
                    </div>
                </div>
                <a href="{{ route('main_admin.plans.edit', $plan->id) }}" class="btn btn-primary">Edit</a>
                <form action="{{ route('main_admin.plans.destroy', $plan->id) }}" method="POST" class="d-inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this plan?')">Delete</button>
                </form>
                <a href="{{ route('main_admin.plans.index') }}" class="btn btn-secondary">Back to Plans</a>
            </div>
        </div>
    </div>
</div>
@endsection
