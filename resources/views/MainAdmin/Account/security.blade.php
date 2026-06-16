@extends('layouts.app')

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Account Settings /</span> Security</h4>

        <!-- Message Toast -->
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

        <!-- Error Toast -->
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
                <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('main_admin.profile') }}"><i class="bx bx-user me-1"></i> Account</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('main_admin.security') }}"><i class="bx bx-lock-alt me-1"></i> Security</a>
                    </li>
                </ul>
                <div class="card mb-6">
                    <h5 class="card-header">Change Password</h5>
                    <div class="card-body pt-1">
                        <form method="POST" action="{{ route('main_admin.security.updatePassword') }}" class="fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate">
                            @csrf
                            <div class="row">
                                <div class="mb-3 col-md-6 form-password-toggle fv-plugins-icon-container">
                                    <label class="form-label" for="currentPassword">Current Password</label>
                                    <div class="input-group input-group-merge has-validation">
                                        <input class="form-control @error('currentPassword') is-invalid @enderror" type="password" name="currentPassword" id="currentPassword" placeholder="············">
                                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                        @error('currentPassword')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-6 form-password-toggle fv-plugins-icon-container">
                                    <label class="form-label" for="newPassword">New Password</label>
                                    <div class="input-group input-group-merge has-validation">
                                        <input class="form-control @error('newPassword') is-invalid @enderror" type="password" id="newPassword" name="newPassword" placeholder="············">
                                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                        @error('newPassword')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 col-md-6 form-password-toggle fv-plugins-icon-container">
                                    <label class="form-label" for="confirmPassword">Confirm New Password</label>
                                    <div class="input-group input-group-merge has-validation">
                                        <input class="form-control @error('newPassword_confirmation') is-invalid @enderror" type="password" name="newPassword_confirmation" id="confirmPassword" placeholder="············">
                                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                        @error('newPassword_confirmation')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <h6 class="text-body">Password Requirements:</h6>
                            <ul class="ps-4 mb-0">
                                <li class="mb-1">Minimum 8 characters long - the more, the better</li>
                                <li class="mb-1">At least one lowercase character</li>
                                <li>At least one number, symbol, or whitespace character</li>
                            </ul>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary me-3">Save changes</button>
                                <button type="reset" class="btn btn-label-secondary">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
