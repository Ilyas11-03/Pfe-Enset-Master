@extends('layouts.app')

@section('title', 'Users')

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            {{--  --}}
            <div class="row g-4 mb-4">
                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="content-left">
                                    <span>Total Users</span>
                                    <div class="d-flex align-items-end mt-2">
                                        <h4 class="mb-0 me-2">{{ $totalUsers }}</h4>
                                        <small class="{{ $totalUsersChange >= 0 ? 'text-success' : 'text-danger' }}">
                                            ({{ $totalUsersChange >= 0 ? '+' : '' }}{{ number_format($totalUsersChange, 2) }}%)
                                        </small>
                                    </div>
                                    <p class="mb-0">Compared to last week</p>
                                </div>
                                <div class="avatar">
                                    <span class="avatar-initial rounded bg-label-primary">
                                        <i class="bx bx-user bx-sm"></i>
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
                                    <span>Gym Admins</span>
                                    <div class="d-flex align-items-end mt-2">
                                        <h4 class="mb-0 me-2">{{ $gymAdmins }}</h4>
                                        <small class="{{ $gymAdminsChange >= 0 ? 'text-success' : 'text-danger' }}">
                                            ({{ $gymAdminsChange >= 0 ? '+' : '' }}{{ number_format($gymAdminsChange, 2) }}%)
                                        </small>
                                    </div>
                                    <p class="mb-0">Compared to last week</p>
                                </div>
                                <div class="avatar">
                                    <span class="avatar-initial rounded bg-label-danger">
                                        <i class="bx bx-user-check bx-sm"></i>
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
                                    <span>Active Users</span>
                                    <div class="d-flex align-items-end mt-2">
                                        <h4 class="mb-0 me-2">{{ $activeUsers }}</h4>
                                        <small class="{{ $activeUsersChange >= 0 ? 'text-success' : 'text-danger' }}">
                                            ({{ $activeUsersChange >= 0 ? '+' : '' }}{{ number_format($activeUsersChange, 2) }}%)
                                        </small>
                                    </div>
                                    <p class="mb-0">Compared to last week</p>
                                </div>
                                <div class="avatar">
                                    <span class="avatar-initial rounded bg-label-success">
                                        <i class="bx bx-group bx-sm"></i>
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
                                    <span>Inactive Users</span>
                                    <div class="d-flex align-items-end mt-2">
                                        <h4 class="mb-0 me-2">{{ $inactiveUsers }}</h4>
                                        <small class="{{ $inactiveUsersChange >= 0 ? 'text-success' : 'text-danger' }}">
                                            ({{ $inactiveUsersChange >= 0 ? '+' : '' }}{{ number_format($inactiveUsersChange, 2) }}%)
                                        </small>
                                    </div>
                                    <p class="mb-0">Compared to last week</p>
                                </div>
                                <div class="avatar">
                                    <span class="avatar-initial rounded bg-label-warning">
                                        <i class="bx bx-user-voice bx-sm"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 d-flex justify-content-between align-items-center">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Users</h4>
                <a href="{{ route('main_admin.users.create') }}" class="btn btn-primary">Add User</a>
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
                <div class="table-responsive">
                    <table id="dataTable" class="table table-hover">
            {{-- <div class="card p-3 ">
                <div class="table-responsive-sm table-responsive-md table-responsive-lg" style="" id="tablediv">
                    <table id="dataTable" class="table p-3 table-hover" style="width:100%"> --}}
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Gym</th>
                                <th>Phone</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Last Login</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @if ($users->count() > 0)
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="align-middle">{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle overflow-hidden"
                                                    style="width: 60px; height: 60px; flex-shrink: 0;">
                                                    @if ($user->profile_image && Storage::exists('public/' . $user->profile_image))
                                                        <img src="{{ asset(Storage::url($user->profile_image)) }}"
                                                            alt="Profile Image" width="60" class="rounded-circle">
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
                                        <td>{{ $user->gym->name }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>{{ $user->role }}</td>
                                        <td><span
                                            class="badge bg-label-{{ $user->status === 'active' ? 'success' : 'danger' }} me-1">{{ $user->status }}</span>
                                        </td>
                                        <td>{{ $user->last_login ? $user->last_login : 'Never' }}</td>
                                        <td>
                                            <div class="d-inline-block text-nowrap">
                                                <!-- Edit Button -->
                                                <a href="{{ route('main_admin.users.edit', $user->id) }}"
                                                    class="btn btn-sm btn-icon"><i class="bx bx-edit-alt me-1"></i></a>

                                                <!-- Delete Button -->
                                                <form action="{{ route('main_admin.users.destroy', $user->id) }}" method="POST"
                                                    class="d-inline" id="deleteform_{{ $user->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-icon"
                                                        onclick="if (confirm('Delete?')) { document.getElementById('deleteform_{{ $user->id }}').submit(); }">
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
                                                        <a class="dropdown-item"
                                                            href="{{ route('main_admin.users.show', $user->id) }}">
                                                            <i class="bx bx-show me-1"></i> View Details
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8" class="text-center">No users found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @if ($users->isNotEmpty())
        @include('layouts.table')
    @endif
@endsection
