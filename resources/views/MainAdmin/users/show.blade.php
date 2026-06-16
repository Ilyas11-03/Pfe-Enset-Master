@extends('layouts.app')

@section('title', 'User Details')

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
                    <!-- User Card -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="user-avatar-section">
                                <div class="d-flex align-items-center flex-column">
                                    <img class="img-fluid rounded my-4"
                                        src="{{ $user->profile_image && Storage::exists('public/' . $user->profile_image) ? Storage::url($user->profile_image) : asset('/assets/img/avatars/profile.png') }}"
                                        height="110" width="110" alt="User profile">
                                    <div class="user-info text-center">
                                        <h4 class="mb-2">{{ $user->name }}</h4>
                                        <span class="badge bg-label-secondary">{{ $user->role }}</span>
                                    </div>
                                </div>
                            </div>
                            <h5 class="pb-2 border-bottom mb-4">Details</h5>
                            <div class="info-container">
                                <ul class="list-unstyled">
                                    <li class="mb-3">
                                        <span class="fw-medium me-2">Gym:</span>
                                        <span>{{ $user->gym->name }}</span>
                                    </li>
                                    <li class="mb-3">
                                        <span class="fw-medium me-2">Name:</span>
                                        <span>{{ $user->name }}</span>
                                    </li>
                                    <li class="mb-3">
                                        <span class="fw-medium me-2">Email:</span>
                                        <span>{{ $user->email }}</span>
                                    </li>
                                    <li class="mb-3">
                                        <span class="fw-medium me-2">Phone:</span>
                                        <span>{{ $user->phone }}</span>
                                    </li>
                                    <li class="mb-3">
                                        <span class="fw-medium me-2">Address:</span>
                                        <span>{{ $user->address }}</span>
                                    </li>
                                    <li class="mb-3">
                                        <span class="fw-medium me-2">Status:</span>
                                        <span class="badge bg-label-success">{{ $user->status == 'active' ? 'Active' : 'Inactive' }}</span>
                                    </li>
                                </ul>
                                <div class="d-flex justify-content-center pt-3">
                                    <a href="{{ route('main_admin.users.edit', $user->id) }}" class="btn btn-primary me-3">Edit</a>
                                    <a href="{{ route('main_admin.users.index') }}" class="btn btn-secondary">Back</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /User Card -->
                </div>

                {{-- User Details --}}
                <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
                    <div class="card mb-4">
                        <h5 class="card-header">User Details</h5>
                        <div class="card-body">
                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                <img src="{{ asset($user->profile_image ? 'storage/' . $user->profile_image : '/storage/users/profile.png') }}"
                                    alt="profile" class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
                            </div>
                        </div>
                        <hr class="my-0" />
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Gym</label>
                                    <input type="text" class="form-control" value="{{ $user->gym->name }}" readonly>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" value="{{ $user->name }}" readonly>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" value="{{ $user->email }}" readonly>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Phone</label>
                                    <input type="text" class="form-control" value="{{ $user->phone }}" readonly>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Address</label>
                                    <input type="text" class="form-control" value="{{ $user->address }}" readonly>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Role</label>
                                    <input type="text" class="form-control" value="{{ $user->role }}" readonly>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Status</label>
                                    <input type="text" class="form-control"
                                        value="{{ $user->status == 'active' ? 'Active' : 'Inactive' }}" readonly>
                                </div>
                            </div>
                            <a href="{{ route('main_admin.users.edit', $user->id) }}" class="btn btn-primary">Edit</a>
                            <a href="{{ route('main_admin.users.index') }}" class="btn btn-secondary">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
