@extends('layouts.app')

@section('title', 'Staff Members')

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row g-4 mb-4">
                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="content-left">
                                    <span>Total Staff</span>
                                    <div class="d-flex align-items-end mt-2">
                                        <h4 class="mb-0 me-2">{{ $totalStaff }}</h4>
                                    </div>
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
                                    <span>Active Staff</span>
                                    <div class="d-flex align-items-end mt-2">
                                        <h4 class="mb-0 me-2">{{ $activeStaff }}</h4>
                                    </div>
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
                                    <span>Inactive Staff</span>
                                    <div class="d-flex align-items-end mt-2">
                                        <h4 class="mb-0 me-2">{{ $inactiveStaff }}</h4>
                                    </div>
                                </div>
                                <div class="avatar">
                                    <span class="avatar-initial rounded bg-label-warning">
                                        <i class="bx bx-user-x bx-sm"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 d-flex justify-content-between align-items-center">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Staff Members</span></h4>
                <a href="{{ route('gym_admin.staff.create') }}" class="btn btn-primary">Add Staff</a>
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
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Last Login</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @if ($staffMembers->count() > 0)
                                @foreach ($staffMembers as $staff)
                                    <tr>
                                        <td class="align-middle">{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle overflow-hidden"
                                                    style="width: 60px; height: 60px; flex-shrink: 0;">
                                                    @if ($staff->profile_image && Storage::exists('public/' . $staff->profile_image))
                                                        <img src="{{ asset(Storage::url($staff->profile_image)) }}"
                                                            alt="Profile Image" width="60" class="rounded-circle">
                                                    @else
                                                        <span
                                                            class="d-flex justify-content-center align-items-center fw-bold text-uppercase bg-secondary text-white rounded-circle"
                                                            style="width: 60px; height: 60px;">{{ substr($staff->name, 0, 2) }}</span>
                                                    @endif
                                                </div>
                                                <div class="ms-2">
                                                    <a href="{{ route('gym_admin.staff.show', encrypt($staff->id)) }}"
                                                        class="text-body text-truncate"><strong>{{ $staff->name }}</strong></a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $staff->email }}</td>
                                        <td><span
                                            class="badge bg-label-{{ $staff->status === 'active' ? 'success' : 'danger' }} me-1">{{ $staff->status }}</span>
                                        </td>
                                        <td>
                                            <span class="bg-label-primary">
                                                {{ $staff->last_login ? $staff->last_login : 'Never' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-inline-block text-nowrap">
                                                <!-- Edit Button -->
                                                <a href="{{ route('gym_admin.staff.edit', encrypt($staff->id)) }}"
                                                    class="btn btn-sm btn-icon"><i class="bx bx-edit-alt me-1"></i></a>

                                                <!-- Delete Button -->
                                                <form action="{{ route('gym_admin.staff.destroy', encrypt($staff->id)) }}" method="POST"
                                                    class="d-inline" id="deleteform_{{ $staff->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-icon"
                                                        onclick="if (confirm('Delete?')) { document.getElementById('deleteform_{{ $staff->id }}').submit(); }">
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
                                                            href="{{ route('gym_admin.staff.show', encrypt($staff->id)) }}">
                                                            <i class='bx bx-detail'></i> Details
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="text-center">No staff members found.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @if ($staffMembers->isNotEmpty())
        @include('layouts.table')
    @endif

    <script>
        setTimeout(function() {
            var messageToast = document.getElementById('messageToast');
            if (messageToast) {
                var toast = new bootstrap.Toast(messageToast);
                toast.hide();
            }
        }, 3000);
        setTimeout(function() {
            var errorToast = document.getElementById('errorToast');
            if (errorToast) {
                var toast = new bootstrap.Toast(errorToast);
                toast.hide();
            }
        }, 3000);
    </script>
@endsection
