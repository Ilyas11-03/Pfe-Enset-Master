@extends('layouts.app')

@section('title', 'Edit Plan')

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

            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <h5 class="card-header">Edit Plan</h5>
                        <form action="{{ route('main_admin.plans.update', $plan->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ $plan->name }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" required>{{ $plan->description }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="price" class="form-label">Price</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" step="1"
                                                class="form-control @error('price') is-invalid @enderror" id="price"
                                                name="price" value="{{ $plan->price }}" required>
                                        </div>
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="discount_percentage" class="form-label">Discount Percentage</label>
                                        <div class="input-group">
                                            <span class="input-group-text">%</span>
                                            <input type="number" step="1"
                                                class="form-control @error('discount_percentage') is-invalid @enderror"
                                                id="discount_percentage" name="discount_percentage"
                                                value="{{ $plan->discount_percentage }}" required>
                                        </div>
                                        @error('discount_percentage')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="user_limit" class="form-label">User Limit</label>
                                        <input type="number" class="form-control @error('user_limit') is-invalid @enderror"
                                            id="user_limit" name="user_limit" value="{{ $plan->user_limit }}" required>
                                        @error('user_limit')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="member_limit" class="form-label">Member Limit</label>
                                        <input type="number" class="form-control @error('member_limit') is-invalid @enderror"
                                            id="member_limit" name="member_limit" value="{{ $plan->member_limit }}" required>
                                        @error('member_limit')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <input type="hidden" name="updated_by" value="{{ auth()->user()->id }}">
                                    <button type="submit" class="btn btn-primary me-2">Save changes</button>
                                    <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
