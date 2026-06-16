@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <!-- Total Earnings from GymPlans -->
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-primary h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class="bx bx-dollar bx-lg"></i>
                                </span>
                            </div>
                            <h4 class="mb-0">{{ number_format($totalEarnings, 2) }} DH</h4>
                        </div>
                        <p class="mb-2">Total Earnings (This Month)</p>
                    </div>
                </div>
            </div>

            <!-- Total Gyms -->
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-info h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-info">
                                    <i class="bx bx-buildings bx-lg"></i>
                                </span>
                            </div>
                            <h4 class="mb-0">{{ $totalGyms }}</h4>
                        </div>
                        <p class="mb-2">Total Gyms</p>
                    </div>
                </div>
            </div>

            <!-- Active Gyms -->
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-success h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-success">
                                    <i class="bx bx-check-circle bx-lg"></i>
                                </span>
                            </div>
                            <h4 class="mb-0">{{ $activeGyms }}</h4>
                        </div>
                        <p class="mb-2">Active Gyms</p>
                    </div>
                </div>
            </div>

            <!-- Inactive Gyms -->
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-secondary h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-secondary">
                                    <i class="bx bx-x-circle bx-lg"></i>
                                </span>
                            </div>
                            <h4 class="mb-0">{{ $inactiveGyms }}</h4>
                        </div>
                        <p class="mb-2">Inactive Gyms</p>
                    </div>
                </div>
            </div>

            <!-- Expired Gyms -->
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-danger h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-danger">
                                    <i class="bx bx-calendar-exclamation bx-lg"></i>
                                </span>
                            </div>
                            <h4 class="mb-0">{{ $expiredGyms }}</h4>
                        </div>
                        <p class="mb-2">Expired Gyms</p>
                    </div>
                </div>
            </div>

            <!-- Total Users -->
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-warning h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-warning">
                                    <i class="bx bx-user bx-lg"></i>
                                </span>
                            </div>
                            <h4 class="mb-0">{{ $totalUsers }}</h4>
                        </div>
                        <p class="mb-2">Total Users</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings Chart -->
        <div id="earningsChart" style="min-height: 300px; background-color:white;"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const monthlyData = @json($monthlyData);
            const months = monthlyData.map(item => item.month);
            const earnings = monthlyData.map(item => item.earnings);

            const options = {
                series: [{
                    name: 'Earnings',
                    data: earnings
                }],
                chart: {
                    type: 'line',
                    height: 350
                },
                xaxis: {
                    categories: months
                },
                yaxis: {
                    title: {
                        text: 'Earnings (DH)'
                    }
                },
                title: {
                    text: 'Monthly Earnings',
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
                colors: ['#00bcd4'],
                grid: {
                    borderColor: '#e0e0e0'
                }
            };

            const chart = new ApexCharts(document.querySelector("#earningsChart"), options);
            chart.render();
        });
    </script>
@endsection
