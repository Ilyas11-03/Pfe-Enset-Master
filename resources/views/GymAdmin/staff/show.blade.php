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
                                        src="{{ $staffMember->profile_image && Storage::exists('public/' . $staffMember->profile_image) ? Storage::url($staffMember->profile_image) : asset('/assets/img/avatars/profile.png') }}"
                                        height="110" width="110" alt="User avatar">
                                    <div class="user-info text-center">
                                        <h4 class="mb-2">{{ $staffMember->name }}</h4>
                                        <span class="badge bg-label-secondary">{{ $staffMember->role }}</span>
                                    </div>
                                </div>
                            </div>
                            <h5 class="pb-2 border-bottom mb-4">Details</h5>
                            <div class="info-container">
                                <ul class="list-unstyled">
                                    <li class="mb-3">
                                        <span class="fw-medium me-2">Gym:</span>
                                        <span>{{ $staffMember->gym->name }}</span>
                                    </li>
                                    <li class="mb-3">
                                        <span class="fw-medium me-2">Name:</span>
                                        <span>{{ $staffMember->name }}</span>
                                    </li>
                                    <li class="mb-3">
                                        <span class="fw-medium me-2">Email:</span>
                                        <span>{{ $staffMember->email }}</span>
                                    </li>
                                    <li class="mb-3">
                                        <span class="fw-medium me-2">Phone:</span>
                                        <span>{{ $staffMember->phone }}</span>
                                    </li>
                                    <li class="mb-3">
                                        <span class="fw-medium me-2">Address:</span>
                                        <span>{{ $staffMember->address }}</span>
                                    </li>
                                    <li class="mb-3">
                                        <span class="fw-medium me-2">Status:</span>
                                        <span
                                            class="badge bg-label-{{ $staffMember->status === 'active' ? 'success' : 'danger' }}">{{ $staffMember->status }}</span>
                                    </li>
                                </ul>
                                <div class="d-flex justify-content-center pt-3">
                                    <a href="{{ route('gym_admin.staff.edit', Crypt::encrypt($staffMember->id)) }}"
                                        class="btn btn-primary me-3">Edit</a>
                                    <a href="{{ route('gym_admin.staff.index') }}" class="btn btn-secondary">Back</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /User Card -->
                </div>
                <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
                    {{-- Staff Analytics --}}
                    <div class="row mb-4">
                        <div class="col-lg-3 col-sm-6">
                            <div class="card card-border-shadow-primary h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="avatar me-4">
                                            <span class="avatar-initial rounded bg-label-primary"><i class="bx bxs-user bx-lg"></i></span>
                                        </div>
                                        <h4 class="mb-0">{{ $membersManaged }}</h4>
                                    </div>
                                    <p class="mb-2">Members Managed</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="card card-border-shadow-primary h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="avatar me-4">
                                            <span class="avatar-initial rounded bg-label-primary"><i class="bx bxs-user-check bx-lg"></i></span>
                                        </div>
                                        <h4 class="mb-0">{{ $activeMembersManaged }}</h4>
                                    </div>
                                    <p class="mb-2">Active Members Managed</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="card card-border-shadow-primary h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="avatar me-4">
                                            <span class="avatar-initial rounded bg-label-primary"><i class="bx bxs-user-x bx-lg"></i></span>
                                        </div>
                                        <h4 class="mb-0">{{ $inactiveMembersManaged }}</h4>
                                    </div>
                                    <p class="mb-2">Inactive Members Managed</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="card card-border-shadow-primary h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="avatar me-4">
                                            <span class="avatar-initial rounded bg-label-primary"><i class="bx bxs-calendar-x bx-lg"></i></span>
                                        </div>
                                        <h4 class="mb-0">{{ $expiredMembershipsManaged }}</h4>
                                    </div>
                                    <p class="mb-2">Expired Memberships Managed</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- End Staff Analytics --}}
                </div>

            </div>
        </div>
    </div>
@endsection
