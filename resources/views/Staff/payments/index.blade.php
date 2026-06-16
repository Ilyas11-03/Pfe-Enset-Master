@extends('layouts.app')

@section('title', 'Payments')

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            {{--  --}}
            <div class="row g-4 mb-4">
                <!-- Total Payments Card -->
                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="content-left">
                                    <span>Total Payments</span>
                                    <div class="d-flex align-items-end mt-2">
                                        <h4 class="mb-0 me-2">{{ $totalPayments }}</h4>
                                    </div>
                                </div>
                                <div class="avatar">
                                    <span class="avatar-initial rounded bg-label-primary">
                                        <i class="bx bx-money bx-sm"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Expired Payments Card -->
                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="content-left">
                                    <span>Expired Payments</span>
                                    <div class="d-flex align-items-end mt-2">
                                        <h4 class="mb-0 me-2">{{ $expiredPayments }}</h4>
                                    </div>
                                </div>
                                <div class="avatar">
                                    <span class="avatar-initial rounded bg-label-danger">
                                        <i class="bx bx-calendar-x bx-sm"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Paid Payments Card -->
                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="content-left">
                                    <span>Paid Payments</span>
                                    <div class="d-flex align-items-end mt-2">
                                        <h4 class="mb-0 me-2">{{ $paidPayments }}</h4>
                                    </div>
                                </div>
                                <div class="avatar">
                                    <span class="avatar-initial rounded bg-label-success">
                                        <i class="bx bx-check bx-sm"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Partial Paid Payments Card -->
                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="content-left">
                                    <span>Partial Paid </span>
                                    <div class="d-flex align-items-end mt-2">
                                        <h4 class="mb-0 me-2">{{ $partialPaidPayments }}</h4>
                                    </div>
                                </div>
                                <div class="avatar">
                                    <span class="avatar-initial rounded bg-label-warning">
                                        <i class="bx bx-credit-card bx-sm"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Payments Card -->
                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="content-left">
                                    <span>Pending Payments</span>
                                    <div class="d-flex align-items-end mt-2">
                                        <h4 class="mb-0 me-2">{{ $pendingPayments }}</h4>
                                    </div>
                                </div>
                                <div class="avatar">
                                    <span class="avatar-initial rounded bg-label-secondary">
                                        <i class="bx bx-hourglass bx-sm"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-12 d-flex justify-content-between align-items-center">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Payments</span></h4>
                <a href="{{ route('staff.payments.create') }}" class="btn btn-primary">Add Payment</a>
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
                                <th>Member</th>
                                <th>Plan Name</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Auto Renew</th>
                                <th>Status/Payment Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @if ($payments->count() > 0)
                                @foreach ($payments as $payment)
                                    <tr>
                                        <td class="align-middle">{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle overflow-hidden"
                                                    style="width: 60px; height: 60px; flex-shrink: 0;">
                                                    @if ($payment->member->profile_image)
                                                        <img src="{{ asset(Storage::url($payment->member->profile_image)) }}"
                                                            alt="Gym Image" width="60" class="rounded-circle">
                                                    @else
                                                        <span
                                                            class="d-flex justify-content-center align-items-center fw-bold text-uppercase bg-secondary text-white rounded-circle"
                                                            style="width: 60px; height: 60px;">{{ substr($payment->member->name, 0, 2) }}</span>
                                                    @endif
                                                </div>
                                                <div class="ms-2">
                                                    <a href="{{ route('staff.members.show', encrypt($payment->member->id)) }}"
                                                        class="text-body text-truncate"><strong>{{ $payment->member->name }}</strong></a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $payment->membership->name }}</td>
                                        <td>
                                            <span class="badge bg-label-primary me-1">
                                                {{ $payment->start_date }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-label-primary me-1">
                                                {{ $payment->end_date }}
                                            </span>
                                        </td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $payment->auto_renew === 'No' ? 'danger' : 'success' }} me-1">{{ $payment->auto_renew }}</span>
                                        </td>
                                        <td>
                                            <span
                                                class="badge bg-label-{{ $payment->status === 'Expired' ? 'danger' : 'success' }}">
                                                {{ $payment->status }}
                                            </span>
                                            <br>
                                            <span
                                                class="badge bg-{{ $payment->payment_status === 'Paid' ? 'success' : ($payment->payment_status === 'Pending' ? 'warning' : 'info') }} me-1">
                                                {{ $payment->payment_status }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-inline-block text-nowrap">
                                                <!-- Edit Button -->
                                                <a href="{{ route('staff.payments.edit', encrypt($payment->id)) }}"
                                                    class="btn btn-sm btn-icon"><i class="bx bx-edit-alt me-1"></i></a>

                                                <!-- Delete Button -->
                                                <form
                                                    action="{{ route('staff.payments.destroy', encrypt($payment->id)) }}"
                                                    method="POST" class="d-inline" id="deleteform_{{ $payment->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-icon"
                                                        onclick="if (confirm('Delete?')) { document.getElementById('deleteform_{{ $payment->id }}').submit(); }">
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
                                                            href="{{ route('staff.payments.show', encrypt($payment->id)) }}">
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
                                    <td colspan="8" class="text-center">No payments found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @if ($payments->isNotEmpty())
        @include('layouts.table')
    @endif
@endsection
