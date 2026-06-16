@extends('layouts.app')

@section('title', 'View Membership')

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
            <h5 class="card-header">Membership Details</h5>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Name</label>
                        <p class="form-control">{{ $membership->name }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Price</label>
                        <p class="form-control">{{ $membership->price }}</p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Duration</label>
                        <p class="form-control">{{ $membership->duration }} months</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Description</label>
                        <p class="form-control">{{ $membership->description }}</p>
                    </div>
                </div>
                <a href="{{ route('gym_admin.memberships.edit', encrypt($membership->id)) }}" class="btn btn-primary">Edit</a>
                <form action="{{ route('gym_admin.memberships.destroy', encrypt($membership->id)) }}" method="POST" class="d-inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this membership?')">Delete</button>
                </form>
                <a href="{{ route('gym_admin.memberships.index') }}" class="btn btn-secondary">Back to Memberships</a>
            </div>
        </div>
    </div>
</div>
@endsection
