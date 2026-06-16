@extends('layouts.app')

@section('title', 'Attendance')

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
                                    <span>Total Attendances</span>
                                    <div class="d-flex align-items-end mt-2">
                                        <h4 class="mb-0 me-2">{{ $totalAttendances }}</h4>
                                    </div>
                                    <p class="mb-0">Total number of attendances</p>
                                </div>
                                <div class="avatar">
                                    <span class="avatar-initial rounded bg-label-primary">
                                        <i class="bx bx-calendar-check bx-sm"></i>
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
                                    <span>Unique Members</span>
                                    <div class="d-flex align-items-end mt-2">
                                        <h4 class="mb-0 me-2">{{ $uniqueMembers }}</h4>
                                    </div>
                                    <p class="mb-0">Number of unique members</p>
                                </div>
                                <div class="avatar">
                                    <span class="avatar-initial rounded bg-label-success">
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
                                    <span>Average Duration</span>
                                    <div class="d-flex align-items-end mt-2">
                                        <h4 class="mb-0 me-2">{{ number_format($averageDuration, 2) }} minutes</h4>
                                    </div>
                                    <p class="mb-0">Average check-in duration</p>
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
                                    <span>Today's Check-ins</span>
                                    <div class="d-flex align-items-end mt-2">
                                        <h4 class="mb-0 me-2">{{ $todayCheckIns }}</h4>
                                    </div>
                                    <p class="mb-0">Number of check-ins today</p>
                                </div>
                                <div class="avatar">
                                    <span class="avatar-initial rounded bg-label-info">
                                        <i class="bx bx-calendar-event bx-sm"></i>
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
                                    <span>Currently Checked In</span>
                                    <div class="d-flex align-items-end mt-2">
                                        <h4 class="mb-0 me-2">{{ $currentlyCheckedIn }}</h4>
                                    </div>
                                    <p class="mb-0">Number of members currently checked in</p>
                                </div>
                                <div class="avatar">
                                    <span class="avatar-initial rounded bg-label-secondary">
                                        <i class="bx bx-log-in bx-sm"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Attendance</span></h4>
            <div class="row mb-4">
                <div class="col-md-6">
                    <form action="{{ route('gym_admin.attendance.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="member_name" class="form-control"
                                placeholder="Search by Member Name">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <form action="{{ route('gym_admin.attendance.checkin') }}" method="POST">
                        @csrf
                        <div class="input-group">
                            <select name="member_id" class="form-control @error('member_id') is-invalid @enderror" required>
                                <option value="">Select Member</option>
                                @foreach ($members as $member)
                                    <option value="{{ encrypt($member->id) }}">{{ $member->name }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-primary">Check In</button>
                        </div>
                        @error('member_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="table-responsive-sm table-responsive-md table-responsive-lg" id="tablediv">
                    <table id="dataTable" class="table p-3 table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Member</th>
                                <th>Check In</th>
                                <th>Check Out</th>
                                <th>Duration (minutes)</th>
                                <th>Created By</th>
                                <th>Updated By</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($attendances->count() > 0)
                                @foreach ($attendances as $attendance)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle overflow-hidden"
                                                    style="width: 60px; height: 60px; flex-shrink: 0;">
                                                    @if ($attendance->member->profile_image && Storage::exists('public/' . $attendance->member->profile_image))
                                                        <img src="{{ asset(Storage::url($attendance->member->profile_image)) }}"
                                                            alt="Profile Image" width="60" class="rounded-circle">
                                                    @else
                                                        <span
                                                            class="d-flex justify-content-center align-items-center fw-bold text-uppercase bg-secondary text-white rounded-circle"
                                                            style="width: 60px; height: 60px;">{{ substr($attendance->member->name, 0, 2) }}</span>
                                                    @endif
                                                </div>
                                                <div class="ms-2">
                                                    <a href="{{ route('gym_admin.members.show', encrypt($attendance->member->id)) }}"
                                                        class="text-body text-truncate"><strong>{{ $attendance->member->name }}</strong></a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $attendance->check_in }}</td>
                                        <td>{{ $attendance->check_out }}</td>
                                        <td>{{ $attendance->duration }}</td>
                                        <td>{{ $attendance->createdBy->name }}</td>
                                        <td>{{ $attendance->updatedBy->name ?? 'N/A' }}</td>
                                        <td>
                                            @if ($attendance->is_checked_in)
                                                <form
                                                    action="{{ route('gym_admin.attendance.checkout', encrypt($attendance->id)) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-primary">Check
                                                        Out</button>
                                                </form>
                                            @else
                                                Checked Out
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8" class="text-center">No attendance found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @if ($attendances->isNotEmpty())
        @include('layouts.table')
    @endif


@endsection
