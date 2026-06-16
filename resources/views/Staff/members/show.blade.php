@extends('layouts.app')

@section('title', 'Member Details')

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">

                <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
                    <!-- Member Card -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="user-avatar-section">
                                <div class="d-flex align-items-center flex-column">
                                    <img class="img-fluid rounded my-4"
                                        src="{{ $member->profile_image && Storage::exists('public/' . $member->profile_image) ? Storage::url($member->profile_image) : asset('/assets/img/avatars/profile.png') }}"
                                        height="110" width="110" alt="Member avatar">
                                    <div class="user-info text-center">
                                        <h4 class="mb-2">{{ $member->name }}</h4>
                                        <span
                                            class="badge bg-label-{{ $member->status === 'active' ? 'success' : 'danger' }}">{{ $member->status }}</span>
                                    </div>
                                </div>
                            </div>
                            <h5 class="pb-2 border-bottom mb-4">Details</h5>
                            <div class="info-container">
                                <ul class="list-unstyled">
                                    <li class="mb-3">
                                        <span class="fw-medium me-2">Gym:</span>
                                        <span>{{ $member->gym->name }}</span>
                                    </li>
                                    <li class="mb-3">
                                        <span class="fw-medium me-2">Name:</span>
                                        <span>{{ $member->name }}</span>
                                    </li>
                                    <li class="mb-3">
                                        <span class="fw-medium me-2">Email:</span>
                                        <span>{{ $member->email }}</span>
                                    </li>
                                    <li class="mb-3">
                                        <span class="fw-medium me-2">Phone:</span>
                                        <span>{{ $member->phone }}</span>
                                    </li>
                                    <li class="mb-3">
                                        <span class="fw-medium me-2">Address:</span>
                                        <span>{{ $member->address }}</span>
                                    </li>
                                    <li class="mb-3">
                                        <span class="fw-medium me-2">Gender:</span>
                                        <span>{{ ucfirst($member->gender) }}</span>
                                    </li>
                                    <li class="mb-3">
                                        <span class="fw-medium me-2">Join Date:</span>
                                        <span>{{ ucfirst($member->join_date) }}</span>
                                    </li>
                                    <li class="mb-3">
                                        <span class="fw-medium me-2">Status:</span>
                                        <span
                                            class="badge bg-label-{{ $member->status === 'active' ? 'success' : 'danger' }}">{{ $member->status }}</span>
                                    </li>
                                </ul>
                                <div class="d-flex justify-content-center pt-3">
                                    <a href="{{ route('staff.members.edit', encrypt($member->id)) }}"
                                        class="btn btn-primary me-3">Edit</a>
                                    <a href="{{ route('staff.members.index') }}" class="btn btn-secondary">Back</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Member Card -->
                </div>


                <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
                    <!-- Plan Card -->
                    @if ($currentPlan)
                        <div class="card mb-4">
                            <!-- Current Plan -->
                            <h5 class="card-header">Current Plan</h5>
                            <div class="card-body">
                                <div class="row">
                                    <!-- Plan Details -->
                                    <div class="col-md-6 mb-4">
                                        <div class="mb-4">
                                            <h6 class="fw-bold">Your Current Plan:
                                                <span class="badge bg-success me-1">
                                                    {{ $currentPlan->membership->name }} -
                                                    {{ $currentPlan->membership->duration }}
                                                    month{{ $currentPlan->membership->duration > 1 ? 's' : '' }}
                                                </span>
                                            </h6>
                                            <p class="text-muted">{{ $currentPlan->membership->description }}</p>
                                        </div>
                                        <div class="mb-4">
                                            <h6 class="fw-bold">Active Until:</h6>
                                            <p>{{ $subscriptionEndDate ? $subscriptionEndDate->format('M d, Y') : 'N/A' }}
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Plan Statistics -->
                                    <div class="col-md-6">
                                        <div class="plan-statistics mb-4">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <h6 class="mb-0">Days Remaining</h6>
                                                <h6 class="mb-0">{{ $daysRemaining }} of {{ $totalDays }} Days</h6>
                                            </div>
                                            <div class="progress rounded">
                                                <div class="progress-bar" role="progressbar"
                                                    style="width: {{ $percentageCompleted }}%;"
                                                    aria-valuenow="{{ $percentageCompleted }}" aria-valuemin="0"
                                                    aria-valuemax="100"></div>
                                            </div>
                                            <small class="d-block mt-2">{{ $daysRemaining }} days remaining until your plan
                                                expires.</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Financial Summary -->
                                <div class="mt-4">
                                    <h6 class="fw-bold mb-3">Financial Summary</h6>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="card border-light p-3">
                                                <h6 class="fw-bold mb-2">Total Amount</h6>
                                                <p class="mb-0 text-success">{{ $currentPlan->total_amount }} dh</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="card border-light p-3">
                                                <h6 class="fw-bold mb-2">Amount Paid</h6>
                                                <p class="mb-0 text-info">{{ $currentPlan->amount_paid }} dh</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="card border-light p-3">
                                                <h6 class="fw-bold mb-2">Due Amount</h6>
                                                <p class="mb-0 text-danger">{{ $currentPlan->due_amount }} dh</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="card border-light p-3">
                                                <h6 class="fw-bold mb-2">Payment Status</h6>
                                                <p class="mb-0">
                                                    <span
                                                        class="badge bg-{{ $currentPlan->payment_status === 'Paid' ? 'success' : ($currentPlan->payment_status === 'Pending' ? 'warning' : 'info') }}">{{ ucfirst($currentPlan->payment_status) }}</span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="card border-light p-3">
                                                <h6 class="fw-bold mb-2">Auto Renew</h6>

                                                <p class="mb-0"><span
                                                        class="badge bg-{{ $currentPlan->auto_renew === 'No' ? 'danger' : 'success' }} me-1">{{ $currentPlan->auto_renew }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /Financial Summary -->
                            </div>
                            <!-- /Current Plan -->
                        </div>
                    @elseif($latestPlan)
                        <!-- Expired Plan Card -->
                        <div class="card mb-6">
                            <h5 class="card-header">Expired Plan</h5>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="alert alert-danger d-flex align-items-center mb-4">
                                            <i class="bx bx-error bx-md me-2"></i>
                                            <div>
                                                <h6 class="alert-heading mb-0">Member Plan Has Expired</h6>
                                                {{-- <p>Please renew the plan to continue using our services.</p> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="d-flex gap-3 mt-4">
                                    <a href="{{ route(request()->segment(1) . '.payments.create') }}"
                                        class="btn btn-primary">
                                        Renew Plan
                                    </a>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- No Plan Card -->
                        <div class="card mb-6">
                            <h5 class="card-header">No Plan</h5>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="alert alert-info d-flex align-items-center mb-4">
                                            <i class="bx bx-info-circle bx-md me-2"></i>

                                            <div>
                                                <h6 class="alert-heading mb-0">No Plan Selected</h6>
                                                <p>Please select a plan.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Action Buttons -->
                                <div class="d-flex gap-3 mt-4">
                                    <a href="{{ route(request()->segment(1) . '.payments.create') }}"
                                        class="
                                                    btn btn-primary">
                                        Select Plan
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Payments History -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-header">Payment History</h5>
                        <a href="{{ route(request()->segment(1) . '.payments.create') }}" class="btn btn-primary">Add
                            Payment</a>
                    </div>
                    @if ($member->payments && $member->payments->count())
                        <div class="table-responsive mt-3">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Plan Name</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Auto Renew</th>
                                        <th>Payment Status</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($member->payments as $payment)
                                        <tr>
                                            <td class="align-middle">{{ $loop->iteration }}</td>
                                            <td>
                                                {{ $payment->membership->name }}
                                            </td>
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
                                                    class="badge bg-{{ $payment->payment_status === 'Paid' ? 'success' : ($payment->payment_status === 'Pending' ? 'warning' : 'info') }} me-1">
                                                    {{ $payment->payment_status }}
                                                </span>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge bg-label-{{ $payment->status === 'Expired' ? 'danger' : 'success' }}">
                                                    {{ $payment->status }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route(request()->segment(1) . '.payments.show', encrypt($payment->id)) }}"
                                                    class="btn btn-info btn-sm">View</a>
                                                <a href="{{ route(request()->segment(1) . '.payments.edit', encrypt($payment->id)) }}"
                                                    class="btn btn-primary btn-sm">Edit</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="mt-3">No payments found.</p>
                    @endif
                </div>
            </div>
            <!-- /Payments History-->

        </div>
    </div>
@endsection
