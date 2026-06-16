@extends('layouts.app')

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Account Settings /</span> Billing & Plans</h4>

        <!-- Message Toast -->
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

        <!-- Error Toast -->
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

        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('gym_admin.profile') }}"><i class="bx bx-user me-1"></i> Account</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('gym_admin.security') }}"><i class="bx bx-lock-alt me-1"></i> Security</a>
                    </li>
                    @if (Auth::user()->role == 'gym_admin')
                        <li class="nav-item "><a class="nav-link " href="{{ route('gym_admin.settings') }}"><i
                                    class="bx bx-dumbbell me-1"></i> Gym Settings</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('gym_admin.billing') }}"><i
                                    class="bx bx-wallet me-1"></i> Billing &
                                Plans</a>
                        </li>
                    @endif
                </ul>

                <!-- Plan Card -->
                @if ($currentPlan)
                    <div class="card mb-6">
                        <!-- Current Plan -->
                        <h5 class="card-header">Current Plan</h5>
                        <div class="card-body">
                            <div class="row">
                                <!-- Plan Details -->
                                <div class="col-md-6 mb-4">
                                    <div class="mb-4">
                                        <h6 class="fw-bold">Your Current Plan: <span
                                                class="badge bg-{{ strtolower($currentPlan->plan->name) === 'basic' ? 'info' : (strtolower($currentPlan->plan->name) === 'standard' ? 'primary' : (strtolower($currentPlan->plan->name) === 'premium' ? 'success' : 'warning')) }} me-1">
                                                {{ $currentPlan->plan->name }} - {{ $gym->currentPlan->duration }}
                                                month{{ $gym->currentPlan->duration > 1 ? 's' : '' }}
                                            </span></h6>
                                        <p class="text-muted">{{ $currentPlan->plan->description }}</p>
                                    </div>
                                    <div class="mb-4">
                                        <h6 class="fw-bold">Active Until:</h6>
                                        <p>{{ $subscriptionEndDate ? $subscriptionEndDate->format('M d, Y') : 'N/A' }}</p>
                                    </div>
                                </div>

                                <!-- Plan Statistics -->
                                <div class="col-md-6">
                                    <div class="alert alert-warning d-flex align-items-center mb-4">
                                        <i class="bx bx-error bx-md me-2"></i>
                                        <div>
                                            <h6 class="alert-heading mb-0">Attention Required!</h6>
                                            <p>Your plan requires an update.</p>
                                        </div>
                                    </div>
                                    <div class="plan-statistics mb-4">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="mb-0">Days Remaining</h6>
                                            <h6 class="mb-0">{{ $remainingDays }} of {{ $currentPlan->duration * 30 }}
                                                Days
                                            </h6>
                                        </div>
                                        <div class="progress rounded">
                                            <div class="progress-bar" role="progressbar"
                                                style="width: {{ $percentageCompleted }}%;"
                                                aria-valuenow="{{ $percentageCompleted }}" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>
                                        <small class="d-block mt-2">{{ $remainingDays }} days remaining until your plan
                                            requires an update.</small>
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
                                                    class="badge bg-secondary">{{ ucfirst($currentPlan->payment_status) }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="card border-light p-3">
                                            <h6 class="fw-bold mb-2">Payment Method</h6>
                                            <p class="mb-0">{{ ucfirst($currentPlan->payment_method) }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="card border-light p-3">
                                            <h6 class="fw-bold mb-2">Due Date</h6>
                                            <p class="mb-0">
                                                {{ $currentPlan->due_date ? \Carbon\Carbon::parse($currentPlan->due_date)->format('M d, Y') : 'N/A' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /Financial Summary -->

                            <!-- Action Buttons -->
                            {{-- <div class="d-flex gap-3 mt-4">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#pricingModal">
                                    Upgrade Plan
                                </button>
                                <button class="btn btn-danger cancel-subscription">
                                    Cancel Subscription
                                </button>
                            </div> --}}
                        </div>
                        <!-- /Current Plan -->
                    </div>
                    <div class="card mt-4">
                        <div class="table-responsive-sm table-responsive-md table-responsive-lg" id="tablediv">
                            <table id="dataTable" class="table p-3 table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Gym</th>
                                        <th>Plan</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Status<br>/Payment Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @if ($gymPlans->count() > 0)
                                        @foreach ($gymPlans as $gymPlan)
                                            <tr>
                                                <td class="align-middle">{{ $loop->iteration }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="rounded-circle overflow-hidden"
                                                            style="width: 60px; height: 60px; flex-shrink: 0;">
                                                            @if ($gymPlan->gym->image && Storage::exists('public/' . $gymPlan->gym->image))
                                                                <img src="{{ asset(Storage::url($gymPlan->gym->image)) }}"
                                                                    alt="Gym Image" width="60"
                                                                    class="rounded-circle">
                                                            @else
                                                                <span
                                                                    class="d-flex justify-content-center align-items-center fw-bold text-uppercase bg-secondary text-white rounded-circle"
                                                                    style="width: 60px; height: 60px;">{{ substr($gymPlan->gym->name, 0, 2) }}</span>
                                                            @endif
                                                        </div>
                                                        <div class="ms-2">
                                                            <strong>{{ $gymPlan->gym->name }}</strong>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge bg-{{ strtolower($gymPlan->plan->name) === 'basic' ? 'info' : (strtolower($gymPlan->plan->name) === 'standard' ? 'primary' : (strtolower($gymPlan->plan->name) === 'premium' ? 'success' : 'warning')) }} me-1">
                                                        {{ $gymPlan->plan->name . ' / ' . $gymPlan->duration }}
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
                                                        class="badge bg-{{ $gymPlan->status === 'Expired' ? 'danger' : 'success' }} me-1">{{ $gymPlan->status }}</span>
                                                    <br>
                                                    <span
                                                        class="badge bg-{{ $gymPlan->payment_status === 'Paid' ? 'success' : ($gymPlan->payment_status === 'Pending' ? 'warning' : 'info') }} me-1">
                                                        {{ $gymPlan->payment_status }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="d-inline-block text-nowrap">
                                                        <!-- View Button -->
                                                        <a href="{{ route('gym_admin.billing.show', $gymPlan->id) }}"
                                                            class="bx bx-show me-1"></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="8" class="text-center text-muted">No plans found for gyms.
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <!-- Expired Plan Card -->
                    <div class="card mb-6">
                        <h5 class="card-header">Expired Plan</h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-danger d-flex align-items-center mb-4">
                                        <i class="bx bx-error bx-md me-2"></i>
                                        <div>
                                            <h6 class="alert-heading mb-0">Your Plan Has Expired</h6>
                                            <p>Please renew your plan to continue using our services.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            {{-- <div class="d-flex gap-3 mt-4">
                                <a href="{{ route('gym_admin.plans.renew', $currentPlan->id) }}" class="btn btn-primary">
                                    Renew Plan
                                </a>
                                <a href="{{ route('gym_admin.plans.upgrade', $currentPlan->id) }}" class="btn btn-secondary">
                                    Upgrade Plan
                                </a>
                            </div> --}}
                        </div>
                    </div>
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5>Available Plans</h5>
                        </div>
                        <div class="card-body">
                            <!-- Available Plans Listing -->
                            <div class="row">
                                @foreach ($plans as $plan)
                                    <div class="col-md-4 mb-4">
                                        <div class="card p-4">
                                            <h6 class="card-title">{{ $plan->name }}</h6>
                                            <p class="card-text">{{ $plan->description }}</p>
                                            <p class="card-text fw-bold">{{ $plan->price }} dh</p>
                                            {{-- <a href="{{ route('gym_admin.plans.details', $plan->id) }}" class="btn btn-primary">View Details</a> --}}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif


            </div>
        </div>
        <!-- /Content -->
    </div>
@endsection
