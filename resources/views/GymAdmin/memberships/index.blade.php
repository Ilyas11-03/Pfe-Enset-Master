@extends('layouts.app')

@section('title', 'Memberships')

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
                                    <span>Total Memberships</span>
                                    <div class="d-flex align-items-end mt-2">
                                        <h4 class="mb-0 me-2">{{ $totalMemberships }}</h4>
                                    </div>
                                </div>
                                <div class="avatar">
                                    <span class="avatar-initial rounded bg-label-primary">
                                        <i class="bx bx-package bx-sm"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Add more cards if needed -->
            </div>

            <div class="col-12 d-flex justify-content-between align-items-center">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Memberships</span></h4>
                <a href="{{ route('gym_admin.memberships.create') }}" class="btn btn-primary">Add Membership</a>
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

            <div class="card p-3 ">
                <div class="table-responsive-sm table-responsive-md table-responsive-lg" style="" id="tablediv">
                    <table id="dataTable" class="table p-3 table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Duration</th>
                                <th>Price</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @if ($memberships->count() > 0)
                                @foreach ($memberships as $membership)
                                    <tr>
                                        <td class="align-middle">{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="ms-2">
                                                    <a href="{{ route('gym_admin.memberships.show', encrypt($membership->id)) }}"
                                                        class="text-body text-truncate"><strong>{{ $membership->name }}</strong></a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{$membership->duration}} Month{{ $membership->duration > 1 ? 's' : '' }} </td>
                                        <td>{{ $membership->price }} DH</td>
                                        <td>
                                            <div class="d-inline-block text-nowrap">
                                                <!-- Edit Button -->
                                                <a href="{{ route('gym_admin.memberships.edit', encrypt($membership->id)) }}"
                                                    class="btn btn-sm btn-icon"><i class="bx bx-edit-alt me-1"></i></a>

                                                <!-- Delete Button -->
                                                <form action="{{ route('gym_admin.memberships.destroy', encrypt($membership->id)) }}" method="POST"
                                                    class="d-inline" id="deleteform_{{ $membership->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-icon"
                                                        onclick="if (confirm('Delete?')) { document.getElementById('deleteform_{{ $membership->id }}').submit(); }">
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
                                                            href="{{ route('gym_admin.memberships.show', encrypt($membership->id)) }}">
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
                                    <td colspan="6" class="text-center">No memberships found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @if ($memberships->isNotEmpty())
        @include('layouts.table')
    @endif
@endsection
