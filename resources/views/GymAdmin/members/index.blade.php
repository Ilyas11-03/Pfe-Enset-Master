@extends('layouts.app')

@section('title', 'Members')

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row g-4 mb-4">
                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="content-left">
                                    <span>Total Members</span>
                                    <div class="d-flex align-items-end mt-2">
                                        <h4 class="mb-0 me-2">{{ $totalMembers }}</h4>
                                        {{-- <small class="{{ $totalMembersChange >= 0 ? 'text-success' : 'text-danger' }}">
                                            ({{ $totalMembersChange >= 0 ? '+' : '' }}{{ number_format($totalMembersChange, 2) }}%)
                                        </small> --}}
                                    </div>
                                    {{-- <p class="mb-0">Compared to last week</p> --}}
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
                                    <span>Active Members</span>
                                    <div class="d-flex align-items-end mt-2">
                                        <h4 class="mb-0 me-2">{{ $activeMembers }}</h4>
                                        {{-- <small class="{{ $activeMembersChange >= 0 ? 'text-success' : 'text-danger' }}">
                                            ({{ $activeMembersChange >= 0 ? '+' : '' }}{{ number_format($activeMembersChange, 2) }}%)
                                        </small> --}}
                                    </div>
                                    {{-- <p class="mb-0">Compared to last week</p> --}}
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
                                    <span>Inactive Members</span>
                                    <div class="d-flex align-items-end mt-2">
                                        <h4 class="mb-0 me-2">{{ $inactiveMembers }}</h4>
                                        {{-- <small class="{{ $inactiveMembersChange >= 0 ? 'text-success' : 'text-danger' }}">
                                            ({{ $inactiveMembersChange >= 0 ? '+' : '' }}{{ number_format($inactiveMembersChange, 2) }}%)
                                        </small> --}}
                                    </div>
                                    {{-- <p class="mb-0">Compared to last week</p> --}}
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
                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="content-left">
                                    <span>Expired Members</span>
                                    <div class="d-flex align-items-end mt-2">
                                        <h4 class="mb-0 me-2">{{ $expiredMembers }}</h4>
                                    </div>
                                    {{-- <p class="mb-0">Number of expired Members</p> --}}
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
            </div>

            <div class="col-12 d-flex justify-content-between align-items-center">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Members</span></h4>
                <a href="{{ route('gym_admin.members.create') }}" class="btn btn-primary">Add Member</a>
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
                    <div class="table-responsive" >
                        <table id="dataTable" class="table p-3 table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Plan</th>
                                <th>Expires At</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @if ($members->count() > 0)
                                @foreach ($members as $member)
                                    <tr>
                                        <td class="align-middle">{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle overflow-hidden"
                                                    style="width: 60px; height: 60px; flex-shrink: 0;">
                                                    @if ($member->profile_image && Storage::exists('public/' . $member->profile_image))
                                                        <img src="{{ $member->profile_image && Storage::exists('public/' . $member->profile_image) ? Storage::url($member->profile_image) : asset('/assets/img/avatars/profile.png') }}"
                                                            alt="Profile Image" width="60" class="rounded-circle">
                                                    @else
                                                        <span
                                                            class="d-flex justify-content-center align-items-center fw-bold text-uppercase bg-secondary text-white rounded-circle"
                                                            style="width: 60px; height: 60px;">{{ substr($member->name, 0, 2) }}</span>
                                                    @endif
                                                </div>
                                                <div class="ms-2">
                                                    <a href="{{ route('gym_admin.members.show', Crypt::encrypt($member->id)) }}"
                                                        class="text-body text-truncate"><strong>{{ $member->name }}</strong></a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="https://wa.me/{{ $member->phone }}?text=Hello%20{{ urlencode($member->name) }}%2C%20I%20would%20like%20to%20contact%20you."
                                                target="_blank">
                                                {{ $member->phone }}
                                            </a>
                                        </td>
                                        <td>
                                            @if ($member->currentPlan && $member->currentPlan->membership)
                                                <span class="badge bg-primary me-1">
                                                    {{ $member->currentPlan->membership->name }}
                                                </span>
                                            @else
                                                <span class="badge bg-label-warning me-1">No Plan</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($member->isExpired() && $member->latestPlan)
                                                <span class="badge bg-label-danger me-1">Expired</span>
                                            @elseif($member->currentPlan)
                                                <span class="badge bg-primary me-1">
                                                    {{ $member->currentPlan->end_date }}
                                                </span>
                                            @else
                                                <span class="badge bg-label-warning me-1">No Plan</span>
                                            @endif
                                        </td>
                                        <td><span
                                                class="badge bg-label-{{ $member->status === 'active' ? 'success' : 'danger' }} me-1">{{ ucfirst($member->status) }}</span>
                                        </td>
                                        <td>
                                            <div class="d-inline-block text-nowrap">
                                                <!-- Edit Button -->
                                                <a href="{{ route('gym_admin.members.edit', Crypt::encrypt($member->id)) }}"
                                                    class="btn btn-sm btn-icon"><i class="bx bx-edit-alt me-1"></i></a>

                                                <!-- Delete Button -->
                                                <form action="{{ route('gym_admin.members.destroy', Crypt::encrypt($member->id)) }}"
                                                    method="POST" class="d-inline" id="deleteform_{{ $member->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-icon"
                                                        onclick="if (confirm('Delete?')) { document.getElementById('deleteform_{{ $member->id }}').submit(); }">
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
                                                            href="{{ route('gym_admin.members.show', Crypt::encrypt($member->id)) }}">
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
                                    <td colspan="10" class="text-center">No members found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @if ($members->isNotEmpty())
        @include('layouts.table')
    @endif
@endsection
