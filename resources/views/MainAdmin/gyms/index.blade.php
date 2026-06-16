@extends('layouts.app')

@section('title', 'Gyms')

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">

            <!-- Analytics Section -->
            <div class="row g-4 mb-4">
                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="content-left">
                                    <span>Total Gyms</span>
                                    <div class="d-flex align-items-end mt-2">
                                        <h4 class="mb-0 me-2">{{ $totalGyms }}</h4>
                                    </div>
                                    <p class="mb-0">Total number of gyms</p>
                                </div>
                                <div class="avatar">
                                    <span class="avatar-initial rounded bg-label-primary">
                                        <i class="bx bx-buildings bx-sm"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="content-left">
                                    <span>Active Gyms</span>
                                    <div class="d-flex align-items-end mt-2">
                                        <h4 class="mb-0 me-2">{{ $activeGyms }}</h4>
                                    </div>
                                    <p class="mb-0">Number of active gyms</p>
                                </div>
                                <div class="avatar">
                                    <span class="avatar-initial rounded bg-label-success">
                                        <i class="bx bx-check-shield bx-sm"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="content-left">
                                    <span>Pending Gyms</span>
                                    <div class="d-flex align-items-end mt-2">
                                        <h4 class="mb-0 me-2">{{ $pendingGyms }}</h4>
                                    </div>
                                    <p class="mb-0">Number of pending gyms</p>
                                </div>
                                <div class="avatar">
                                    <span class="avatar-initial rounded bg-label-warning">
                                        <i class="bx bx-time-five bx-sm"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="content-left">
                                    <span>Expired Gyms</span>
                                    <div class="d-flex align-items-end mt-2">
                                        <h4 class="mb-0 me-2">{{ $expiredGyms }}</h4>
                                    </div>
                                    <p class="mb-0">Number of expired gyms</p>
                                </div>
                                <div class="avatar">
                                    <span class="avatar-initial rounded bg-label-danger">
                                        <i class="bx bx-x-circle bx-sm"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                {{-- <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="content-left">
                                    <span>Basic Plan Gyms</span>
                                    <div class="d-flex align-items-end mt-2">
                                        <h4 class="mb-0 me-2">{{ $basicGyms }}</h4>
                                    </div>
                                    <p class="mb-0">Number of gyms with Basic plan</p>
                                </div>
                                <div class="avatar">
                                    <span class="avatar-initial rounded bg-label-info">
                                        <i class="bx bx-bulb bx-sm"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="content-left">
                                    <span>Standard Plan Gyms</span>
                                    <div class="d-flex align-items-end mt-2">
                                        <h4 class="mb-0 me-2">{{ $standardGyms }}</h4>
                                    </div>
                                    <p class="mb-0">Number of gyms with Standard plan</p>
                                </div>
                                <div class="avatar">
                                    <span class="avatar-initial rounded bg-label-primary">
                                        <i class="bx bx-star bx-sm"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="content-left">
                                    <span>Premium Plan Gyms</span>
                                    <div class="d-flex align-items-end mt-2">
                                        <h4 class="mb-0 me-2">{{ $premiumGyms }}</h4>
                                    </div>
                                    <p class="mb-0">Number of gyms with Premium plan</p>
                                </div>
                                <div class="avatar">
                                    <span class="avatar-initial rounded bg-label-success">
                                        <i class="bx bx-diamond bx-sm"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>

            <div class="col-12 d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold py-3 mb-0"><span class="text-muted fw-light">Gyms</span></h4>
                <a href="{{ route('main_admin.gyms.create') }}" class="btn btn-primary">Add Gym</a>
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
            </div>

            <div class="card p-3">
                <div class="table-responsive-sm table-responsive-md table-responsive-lg" id="tablediv">
                    <table id="dataTable" class="table p-3 table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Gym</th>
                                <th>Users</th>
                                <th>Expires At</th>
                                <th>Status</th>
                                <th>Plan</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @forelse ($gyms as $gym)
                                <tr>
                                    {{-- <tr class="{{ $gym->name === 'hhh' ? 'table-success' : '' }}"> --}}
                                    <td class="align-middle">{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle overflow-hidden"
                                                style="width: 60px; height: 60px; flex-shrink: 0;">
                                                @if ($gym->image && Storage::exists('public/' . $gym->image))
                                                    <img src="{{ asset(Storage::url($gym->image)) }}" alt="Gym Image"
                                                        width="60" class="rounded-circle">
                                                @else
                                                    <span
                                                        class="d-flex justify-content-center align-items-center fw-bold text-uppercase bg-secondary text-white rounded-circle"
                                                        style="width: 60px; height: 60px;">{{ substr($gym->name, 0, 2) }}</span>
                                                @endif
                                            </div>
                                            <div class="ms-2">
                                                <a href="{{ route('main_admin.gyms.show', $gym->id) }}"
                                                    class="text-body text-truncate"><strong>{{ $gym->name }}</strong></a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                                            @if ($gym->users->count() > 0)
                                                @foreach ($gym->users as $user)
                                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                        data-bs-placement="top" class="avatar avatar-xs pull-up"
                                                        aria-label="{{ $user->name }}"
                                                        data-bs-original-title="{{ $user->name }}">
                                                        <a href="{{ route('main_admin.users.show', $user->id) }}"
                                                            class="text-decoration-none">
                                                            <img src="{{ $user->profile_image && Storage::exists('public/' . $user->profile_image) ? Storage::url($user->profile_image) : asset('/assets/img/avatars/profile.png') }}"
                                                                alt="Avatar" class="rounded-circle">
                                                        </a>
                                                    </li>
                                                @endforeach
                                            @else
                                                <li class="avatar avatar-xs pull-up">
                                                    <span class="avatar-title rounded-circle bg-soft-primary text-primary">
                                                        <i class="bx bx-user"></i>
                                                    </span>
                                                </li>
                                            @endif
                                        </ul>
                                    </td>
                                    <td>
                                        @php
                                            $endDate = optional($gym->currentPlan)->end_date;
                                            $isExpired = $endDate && \Carbon\Carbon::parse($endDate)->isPast();
                                        @endphp
                                        <span class="badge bg-label-{{ $isExpired ? 'danger' : 'primary' }} me-1">
                                            {{ $endDate ?: 'N/A' }}
                                        </span>
                                    </td>
                                    <td>
                                        {{-- @if ($gym->currentPlan) --}}
                                            <span
                                                class="badge bg-label-{{ $gym->status === 'inactive' ? 'danger' : 'success' }} me-1">
                                                {{ ucfirst($gym->status) }}
                                            </span>
                                        {{-- @else
                                            <span class="badge bg-label-warning me-1">Pending</span>
                                        @endif --}}
                                    </td>
                                    <td>
                                        @if ($gym->currentPlan && $gym->currentPlan->plan)
                                            <span
                                                class="badge bg-{{ strtolower($gym->currentPlan->plan->name) === 'basic' ? 'info' : (strtolower($gym->currentPlan->plan->name) === 'standard' ? 'primary' : (strtolower($gym->currentPlan->plan->name) === 'premium' ? 'success' : 'warning')) }} me-1">
                                                {{ $gym->currentPlan->plan->name }}
                                            </span>
                                        @else
                                            <span class="badge bg-label-warning me-1">No Plan</span>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="d-inline-block text-nowrap">
                                            <!-- Edit Button -->
                                            <a href="{{ route('main_admin.gyms.edit', $gym->id) }}" class="btn btn-sm btn-icon"><i
                                                    class="bx bx-edit-alt me-1"></i></a>

                                            <!-- Delete Button -->
                                            <form action="{{ route('main_admin.gyms.destroy', $gym->id) }}" method="POST"
                                                class="d-inline" id="deleteform_{{ $gym->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-icon"
                                                    onclick="if (confirm('Are you sure you want to delete this gym?')) { document.getElementById('deleteform_{{ $gym->id }}').submit(); }">
                                                    <i class="bx bx-trash me-1"></i>
                                                </button>
                                            </form>

                                            <!-- View Details Dropdown -->
                                            <div class="dropdown d-inline">
                                                <button type="button"
                                                    class="btn btn-sm btn-icon dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{ route('main_admin.gyms.show', $gym->id) }}">
                                                        <i class="bx bx-show me-1"></i> View Details
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No gyms found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @if ($gyms->isNotEmpty())
        @include('layouts.table')
    @endif
@endsection
