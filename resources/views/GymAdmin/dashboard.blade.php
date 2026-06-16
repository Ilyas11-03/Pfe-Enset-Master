@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <!-- Total Earnings (This Month) -->
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-primary h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class="bx bx-dollar bx-lg"></i>
                                </span>
                            </div>
                            <h4 class="mb-0">{{ number_format($totalEarningsThisMonth, 2) }} DH</h4>
                        </div>
                        <p class="mb-2">Total Earnings ({{ now()->format('F')}})</p>
                        <h6 class="mb-0 text-{{ $profitStatus }}">
                            Profit: {{ number_format($profitThisMonth, 2) }} DH
                        </h6>
                    </div>
                </div>
            </div>


            <!-- Total Members -->
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-success h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-success">
                                    <i class="bx bx-group bx-lg"></i>
                                    {{-- <a style="text:none" href="{{route('gym_admin.members.index')}}"><i class="bx bx-group bx-lg"></i></a> --}}
                                </span>
                            </div>
                            <h4 class="mb-0">{{ $totalMembers }}</h4>
                        </div>
                        <p class="mb-2">Total Members</p>
                    </div>
                </div>
            </div>

            <!-- Joined This Month -->
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-warning h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-warning">
                                    <i class="bx bx-user-plus bx-lg"></i>
                                </span>
                            </div>
                            <h4 class="mb-0">{{ $joinedThisMonth }}</h4>
                        </div>
                        <p class="mb-2">Joined This Month</p>
                    </div>
                </div>
            </div>

            <!-- Total Expenses (This Month) -->
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-danger h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-danger">
                                    <i class="bx bx-money bx-lg"></i>
                                </span>
                            </div>
                            <h4 class="mb-0">{{ $totalExpensesThisMonth }}</h4>
                        </div>
                        <p class="mb-2">Total Expenses ({{ now()->format('F')}})</p>
                    </div>
                </div>
            </div>

            <!-- Total Staff -->
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-info h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-info">
                                    <i class="bx bx-id-card bx-lg"></i>
                                </span>
                            </div>
                            <h4 class="mb-0">{{ $totalStaff }}</h4>
                        </div>
                        <p class="mb-2">Total Staff</p>
                    </div>
                </div>
            </div>

            <!-- Active Members -->
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-primary h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class="bx bx-user-check bx-lg"></i>
                                </span>
                            </div>
                            <h4 class="mb-0">{{ $activeMembers }}</h4>
                        </div>
                        <p class="mb-2">Active Members</p>
                    </div>
                </div>
            </div>
            <!-- Inactive Members -->
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-secondary h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-secondary">
                                    <i class="bx bx-user-x bx-lg"></i>
                                </span>
                            </div>
                            <h4 class="mb-0">{{ $inactiveMembers }}</h4>
                        </div>
                        <p class="mb-2">Inactive Members</p>
                    </div>
                </div>
            </div>

            <!-- Expiring Soon (3 days before) -->
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-warning h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-warning">
                                    <i class="bx bx-calendar-exclamation bx-lg"></i>
                                </span>
                            </div>
                            <h4 class="mb-0">{{ $expiringSoon }}</h4>
                        </div>
                        <p class="mb-2">Expiring Soon (3 days)</p>
                    </div>
                </div>
            </div>

        </div>

        <div id="financialChart" style="min-height: 300px;background-color:white"></div>

        <div class="card p-3 mt-4">
            <h5 class="card-title">Last 7 Payments</h5>
            <div class="table-responsive-sm table-responsive-md table-responsive-lg">
                <table class="table p-3 table-hover" style="width:100%">
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
                                            <div class="rounded-circle overflow-hidden" style="width: 60px; height: 60px; flex-shrink: 0;">
                                                @if ($payment->member->profile_image)
                                                    <img src="{{ asset(Storage::url($payment->member->profile_image)) }}"
                                                        alt="Gym Image" width="60" class="rounded-circle">
                                                @else
                                                    <span class="d-flex justify-content-center align-items-center fw-bold text-uppercase bg-secondary text-white rounded-circle"
                                                        style="width: 60px; height: 60px;">{{ substr($payment->member->name, 0, 2) }}</span>
                                                @endif
                                            </div>
                                            <div class="ms-2">
                                                <a href="{{ route('gym_admin.members.show', encrypt($payment->member->id)) }}"
                                                    class="text-body text-truncate"><strong>{{ $payment->member->name }}</strong></a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $payment->membership->name }}</td>
                                    <td>
                                        <span class="badge bg-label-primary me-1">{{ $payment->start_date }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-label-primary me-1">{{ $payment->end_date }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $payment->auto_renew === 'No' ? 'danger' : 'success' }} me-1">{{ $payment->auto_renew }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-label-{{ $payment->status === 'Expired' ? 'danger' : 'success' }}">
                                            {{ $payment->status }}
                                        </span>
                                        <br>
                                        <span class="badge bg-{{ $payment->payment_status === 'Paid' ? 'success' : ($payment->payment_status === 'Pending' ? 'warning' : 'info') }} me-1">
                                            {{ $payment->payment_status }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-inline-block text-nowrap">
                                            <!-- Edit Button -->
                                            <a href="{{ route('gym_admin.payments.edit', encrypt($payment->id)) }}"
                                                class="btn btn-sm btn-icon"><i class="bx bx-edit-alt me-1"></i></a>
        
                                            <!-- Delete Button -->
                                            <form action="{{ route('gym_admin.payments.destroy', encrypt($payment->id)) }}"
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
                                                <button type="button" class="btn btn-sm btn-icon dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item"
                                                        href="{{ route('gym_admin.payments.show', encrypt($payment->id)) }}">
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

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const monthlyData = @json($monthlyData);
            const months = monthlyData.map(item => item.month);
            const earnings = monthlyData.map(item => item.earnings);
            const expenses = monthlyData.map(item => item.expenses);
            const profit = monthlyData.map(item => item.profit);


            const options = {
                series: [{
                        name: 'Earnings',
                        data: earnings
                    },
                    {
                        name: 'Expenses',
                        data: expenses
                    },
                    {
                        name: 'Profit',
                        data: profit
                    }
                ],
                chart: {
                    type: 'line',
                    height: 350
                },
                xaxis: {
                    categories: months
                },
                yaxis: {
                    title: {
                        text: 'Amount (DH)'
                    }
                },
                title: {
                    text: 'Earnings and Expenses',
                    align: 'left'
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth'
                },
                markers: {
                    size: 5
                },
                colors: ['#71dd37', '#ff5733', '#00bcd4'],
                grid: {
                    borderColor: '#e0e0e0'
                }
            };

            const chart = new ApexCharts(document.querySelector("#financialChart"), options);
            chart.render();
        });
    </script>

@endsection
