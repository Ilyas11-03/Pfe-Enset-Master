@extends('layouts.app')

@section('title', 'Gym Details')

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">

            <div class="row">
                <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
                    <!-- Gym Card -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="user-avatar-section">
                                <div class="d-flex align-items-center flex-column">
                                    <img class="img-fluid rounded my-4"
                                        src="{{ $gym->image && Storage::exists('public/' . $gym->image) ? Storage::url($gym->image) : asset('/assets/img/default.png') }}"
                                        height="110" width="110" alt="Gym image">
                                    <div class="user-info text-center">
                                        <h4 class="mb-2">{{ $gym->name }}</h4>
                                        <span
                                            class="badge bg-label-secondary">{{ $gym->status == 'active' ? 'Active' : 'Inactive' }}</span>
                                    </div>
                                </div>
                            </div>
                            <h5 class="pb-2 border-bottom mb-4">Details</h5>
                            <div class="info-container">
                                <ul class="list-unstyled">
                                    <li class="mb-3">
                                        <span class="fw-medium me-2">Name:</span>
                                        <span>{{ $gym->name }}</span>
                                    </li>
                                    <li class="mb-3">
                                        <span class="fw-medium me-2">Address:</span>
                                        <span>{{ $gym->address ?: 'Not provided' }}</span>
                                    </li>
                                    <li class="mb-3">
                                        <span class="fw-medium me-2">Phone:</span>
                                        <span>{{ $gym->phone ?: 'Not provided' }}</span>
                                    </li>
                                    <li class="mb-3">
                                        <span class="fw-medium me-2">Operating Hours:</span>
                                        <span>{{ $gym->operating_hours ?: 'Not provided' }}</span>
                                    </li>
                                    <li class="mb-3">
                                        <span class="fw-medium me-2">City:</span>
                                        <span>{{ $gym->city ?: 'Not provided' }}</span>
                                    </li>
                                    <li class="mb-3">
                                        <span class="fw-medium me-2">Region:</span>
                                        <span>{{ $gym->region ?: 'Not provided' }}</span>
                                    </li>
                                    <li class="mb-3">
                                        <span class="fw-medium me-2">Plan:</span>
                                        @if ($gym->currentPlan && $gym->currentPlan->plan)
                                            <span>{{ $gym->currentPlan->plan->name }}</span>
                                        @else
                                            <span>No current plan</span>
                                        @endif
                                    </li>

                                    <li class="mb-3">
                                        <span class="fw-medium me-2">Status:</span>
                                        <span
                                            class="badge bg-label-success">{{ $gym->status == 'active' ? 'Active' : 'Inactive' }}</span>
                                    </li>
                                </ul>
                                <div class="d-flex justify-content-center pt-3">
                                    <a href="{{ route('main_admin.gyms.edit', $gym->id) }}" class="btn btn-primary me-3">Edit</a>
                                    <a href="{{ route('main_admin.gyms.index') }}" class="btn btn-secondary">Back</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Gym Card -->

                    <!-- Plan Card -->
                    @if ($gym->currentPlan)
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <span class="badge bg-label-primary">{{ $gym->currentPlan->plan->name }}</span>
                                    <div class="d-flex justify-content-center">
                                        <sup class="h5 pricing-currency mt-3 mb-0 me-1 text-primary">$</sup>
                                        <h1 class="display-5 mb-0 text-primary">
                                            {{ $gym->currentPlan->total_amount }}</h1>
                                        <sub class="fs-6 pricing-duration mt-auto mb-3">
                                            /{{ $gym->currentPlan->duration }}
                                            month{{ $gym->currentPlan->duration > 1 ? 's' : '' }}
                                        </sub>
                                    </div>
                                </div>
                                <ul class="ps-3 g-2 my-4">
                                    <li class="mb-2">{{ $gym->currentPlan->plan->name }}</li>
                                </ul>
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span>Days</span>
                                    <span>{{ round($percentageCompleted, 2) }}% Completed</span>
                                </div>
                                <div class="progress mb-1" style="height: 8px;">
                                    <div class="progress-bar" role="progressbar"
                                        style="width: {{ round($percentageCompleted, 2) }}%;"
                                        aria-valuenow="{{ round($percentageCompleted, 2) }}" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                                <span>{{ $daysRemaining > 0 ? $daysRemaining . ' days remaining' : 'Expired' }}</span>
                                <div class="d-grid w-100 mt-4 pt-2">
                                    <button class="btn btn-primary" data-bs-target="#upgradePlanModal"
                                        data-bs-toggle="modal">Upgrade Plan</button>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <span class="badge bg-label-danger">Plan Expired</span>
                                </div>
                                <ul class="ps-3 g-2 my-4">
                                    <li class="mb-2">Your current plan has expired.</li>
                                    @if ($gym->latestPlan)
                                        <li class="mb-2">{{ $expiredDays }} days ago</li>
                                        <li class="mb-2">Due Date: {{ $dueDate }}</li>
                                    @endif
                                </ul>
                                <div class="d-grid w-100 mt-4 pt-2">
                                    <a class="btn btn-primary" href="{{ route('main_admin.gym-plans.create') }}">Renew Plan</a>
                                </div>
                            </div>
                        </div>
                    @endif
                    <!-- /Plan Card -->

                </div>

                {{-- Gym Users --}}
                <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
                    {{-- Gym Analytics --}}
                    <div class="row mb-4">
                        <div class="col-lg-3 col-sm-6">
                            <div class="card card-border-shadow-primary h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="avatar me-4">
                                            <span class="avatar-initial rounded bg-label-primary"><i
                                                    class="bx bx-user bx-lg"></i></span>
                                        </div>
                                        <h4 class="mb-0">{{ $totalMembers }}</h4>
                                    </div>
                                    <p class="mb-2">Total Members</p>
                                    <p class="mb-0">
                                        <span class="text-muted">Active members in the gym</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="card card-border-shadow-primary h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="avatar me-4">
                                            <span class="avatar-initial rounded bg-label-primary"><i
                                                    class="bx bx-id-card bx-lg"></i></span>
                                        </div>
                                        <h4 class="mb-0">{{ $totalStaff }}</h4>
                                    </div>
                                    <p class="mb-2">Total Staff</p>
                                    <p class="mb-0">
                                        <span class="text-muted">Staff members managing the gym</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="card card-border-shadow-primary h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="avatar me-4">
                                            <span class="avatar-initial rounded bg-label-primary"><i
                                                    class="bx bx-dumbbell bx-lg"></i></span>
                                        </div>
                                        <h4 class="mb-0">{{ $totalCoaches }}</h4>
                                    </div>
                                    <p class="mb-2">Total Coaches</p>
                                    <p class="mb-0">
                                        <span class="text-muted">Coaches available for members</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="card card-border-shadow-primary h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="avatar me-4">
                                            <span class="avatar-initial rounded bg-label-primary"><i
                                                    class="bx bx-package bx-lg"></i></span>
                                        </div>
                                        <h4 class="mb-0">{{ $totalPlans }}</h4>
                                    </div>
                                    <p class="mb-2">Total Plans</p>
                                    <p class="mb-0">
                                        <span class="text-muted">Active plans offered by the gym</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- End Gym Analytics --}}


                    <div class="card mb-4">
                        <h5 class="card-header">Gym Users</h5>
                        <div class="card-body">
                            @if ($gym->users->count())
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Role</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($gym->users as $user)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="rounded-circle overflow-hidden"
                                                                style="width: 60px; height: 60px; flex-shrink: 0;">
                                                                @if ($user->profile_image && Storage::exists('public/' . $user->profile_image))
                                                                    <img src="{{ asset(Storage::url($user->profile_image)) }}"
                                                                        alt="Profile Image" width="60"
                                                                        class="rounded-circle">
                                                                @else
                                                                    <span
                                                                        class="d-flex justify-content-center align-items-center fw-bold text-uppercase bg-secondary text-white rounded-circle"
                                                                        style="width: 60px; height: 60px;">{{ substr($user->name, 0, 2) }}</span>
                                                                @endif
                                                            </div>
                                                            <div class="ms-2">
                                                                <a href="{{ route('main_admin.users.show', $user->id) }}"
                                                                    class="text-body text-truncate"><strong>{{ $user->name }}</strong></a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ $user->role }}</td>
                                                    <td>{{ $user->status == 'active' ? 'Active' : 'Inactive' }}</td>
                                                    <td>
                                                        <a href="{{ route('main_admin.users.show', $user->id) }}"
                                                            class="btn btn-info btn-sm">View</a>
                                                        <a href="{{ route('main_admin.users.edit', $user->id) }}"
                                                            class="btn btn-primary btn-sm">Edit</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p>No users found for this gym.</p>
                            @endif
                        </div>
                    </div>


                    <!-- Gym Plans Card -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-header">Gym Plans</h5>
                                <a href="{{ route('main_admin.gym-plans.create') }}" class="btn btn-primary">Add Gym Plan</a>
                            </div>
                            @if ($gym->gymPlans && $gym->gymPlans->count())
                                <div class="table-responsive mt-3">
                                    <table id="dataTable" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Plan Name</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($gym->gymPlans as $gymPlan)
                                                <tr>
                                                    <td>
                                                        <span
                                                            class="badge bg-{{ strtolower($gymPlan->plan->name) === 'basic' ? 'info' : (strtolower($gymPlan->plan->name) === 'standard' ? 'primary' : (strtolower($gymPlan->plan->name) === 'premium' ? 'success' : 'warning')) }} me-1">
                                                            {{ $gymPlan->plan->name }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-label-primary me-1">
                                                            {{ $gymPlan->start_date }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-label-primary me-1">
                                                            {{ $gymPlan->end_date }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge bg-label-{{ $gymPlan->status === 'Expired' ? 'danger' : 'success' }}">
                                                            {{ $gymPlan->status }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="d-inline-block text-nowrap">
                                                            <!-- View Details Dropdown -->
                                                            <div class="dropdown d-inline">
                                                                <button type="button"
                                                                    class="btn btn-sm btn-icon dropdown-toggle hide-arrow"
                                                                    data-bs-toggle="dropdown">
                                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                                </button>
                                                                <div class="dropdown-menu">
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('main_admin.gym-plans.show', $gymPlan->id) }}">
                                                                        <i class="bx bx-show me-1"></i> View Details
                                                                    </a>
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('main_admin.gym-plans.edit', $gymPlan->id) }}">
                                                                        <i class="bx bx-edit-alt me-1"></i> Edit
                                                                    </a>
                                                                    <form
                                                                        action="{{ route('main_admin.gym-plans.destroy', $gymPlan->id) }}"
                                                                        method="POST" class="d-inline">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="button" class="dropdown-item"
                                                                            onclick="if (confirm('Delete?')) { this.closest('form').submit(); }">
                                                                            <i class="bx bx-trash me-1"></i> Delete
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="mt-3">No plans found for this gym.</p>
                            @endif
                        </div>
                    </div>
                    <!-- /Gym Plans Card -->

                </div>
            </div>
        </div>
    </div>
    @if ($gym->gymPlans->isNotEmpty())
        @include('layouts.table')
    @endif
@endsection
