@extends('layouts.app')

@section('title', 'Gym Plans')

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            {{-- Summary Cards --}}
            <div class="row g-4 mb-4">
                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="content-left">
                                    <span>Total Gym Plans</span>
                                    <div class="d-flex align-items-end mt-2">
                                        <h4 class="mb-0 me-2">{{ $totalGymPlans }}</h4>
                                    </div>
                                </div>
                                <div class="avatar">
                                    <span class="avatar-initial rounded bg-label-primary">
                                        <i class="bx bx-briefcase bx-sm"></i>
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
                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="content-left">
                                    <span>Active Gyms</span>
                                    <div class="d-flex align-items-end mt-2">
                                        <h4 class="mb-0 me-2">{{ $activeGyms }}</h4>
                                    </div>
                                </div>
                                <div class="avatar">
                                    <span class="avatar-initial rounded bg-label-success">
                                        <i class="bx bx-check-circle bx-sm"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Add more cards if needed -->
            </div>

            <div class="col-12 d-flex justify-content-between align-items-center">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Gym Plans</span></h4>
                <a href="{{ route('main_admin.gym-plans.create') }}" class="btn btn-primary">Add Gym Plan</a>
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
                                                            alt="Gym Image" width="60" class="rounded-circle">
                                                    @else
                                                        <span
                                                            class="d-flex justify-content-center align-items-center fw-bold text-uppercase bg-secondary text-white rounded-circle"
                                                            style="width: 60px; height: 60px;">{{ substr($gymPlan->gym->name, 0, 2) }}</span>
                                                    @endif
                                                </div>
                                                <div class="ms-2">
                                                    <a href="{{ route('main_admin.gyms.show', $gymPlan->gym->id) }}"
                                                        class="text-body text-truncate"><strong>{{ $gymPlan->gym->name }}</strong></a>
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
                                                <!-- Edit Button -->
                                                <a href="{{ route('main_admin.gym-plans.edit', $gymPlan->id) }}"
                                                    class="btn btn-sm btn-icon"><i class="bx bx-edit-alt me-1"></i></a>

                                                <!-- Delete Button -->
                                                <form action="{{ route('main_admin.gym-plans.destroy', $gymPlan->id) }}"
                                                    method="POST" class="d-inline" id="deleteform_{{ $gymPlan->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-icon"
                                                        onclick="if (confirm('Delete?')) { document.getElementById('deleteform_{{ $gymPlan->id }}').submit(); }">
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
                                                            href="{{ route('main_admin.gym-plans.show', $gymPlan->id) }}">
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
                                    <td colspan="8" class="text-center text-muted">No plans found for gyms.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @if ($gymPlans->isNotEmpty())
        @include('layouts.table')
    @endif
@endsection
