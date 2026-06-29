<?php

namespace App\Http\Controllers\MainAdmin;

use App\Models\Gym;
use App\Models\GymPlan;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        $currentYear = now()->year;
        $currentMonth = now()->month;

        // Initialize an array to hold the monthly data
        $monthlyData = [];

        // Loop through each month of the current year
        for ($month = 1; $month <= 12; $month++) {
            // Calculate total earnings from GymPlans for the current month
            $totalEarnings = GymPlan::whereYear('start_date', $currentYear)
                ->whereMonth('start_date', $month)
                ->sum('total_amount');

            // Store the data in the monthlyData array
            $monthlyData[] = [
                'month' => date('M', mktime(0, 0, 0, $month, 1)),
                'earnings' => $totalEarnings,
            ];
        }

        // Total earnings for the current month
        $totalEarnings = GymPlan::whereYear('start_date', $currentYear)
            ->whereMonth('start_date', $currentMonth)
            ->sum('total_amount');

        // Total gyms, active gyms, inactive gyms, expired gyms
        $totalGyms = Gym::count();
        $activeGyms = Gym::where('status', 'active')->count();
        $inactiveGyms = Gym::where('status', 'inactive')->count();
        $expiredGyms = GymPlan::where('end_date', '<', now())->count();

        // Total users
        $totalUsers = User::count();

        return view('MainAdmin.dashboard', compact(
            'totalEarnings',
            'totalGyms',
            'activeGyms',
            'inactiveGyms',
            'expiredGyms',
            'totalUsers',
            'monthlyData'
        ));
    }
}
