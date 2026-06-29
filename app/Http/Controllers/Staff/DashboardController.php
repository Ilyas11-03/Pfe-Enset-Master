<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $gym = Auth::user()->gym;
        $currentYear = now()->year;
        $cuurentMonth = now()->month;

        // Fetch earnings, expenses, and calculate profit for each month of the current year
        $monthlyData = [];
        for ($month = 1; $month <= 12; $month++) {
            $totalEarnings = $gym->members()
                ->whereHas('payments', function ($query) use ($currentYear, $month) {
                    $query->whereYear('created_at', $currentYear)
                        ->whereMonth('created_at', $month);
                })
                ->withSum('payments as total_amount_sum', 'total_amount')
                ->pluck('total_amount_sum')
                ->sum();

            $totalExpenses = $gym->expenses()
                ->whereYear('expense_date', $currentYear)
                ->whereMonth('expense_date', $month)
                ->sum('amount');

            $profit = $totalEarnings - $totalExpenses;

            $monthlyData[] = [
                'month' => date('M', mktime(0, 0, 0, $month, 1)),
                'earnings' => $totalEarnings,
                'expenses' => $totalExpenses,
                'profit' => $profit,
            ];
        }

        // Other data fetching...
        $totalEarningsThisMonth = $gym->members()
            ->whereHas('payments', function ($query) use ($currentYear, $cuurentMonth) {
                $query->whereYear('created_at', $currentYear)
                    ->whereMonth('created_at', $cuurentMonth);
            })
            ->withSum('payments as total_amount_sum', 'total_amount')
            ->pluck('total_amount_sum')
            ->sum();
        $totalMembers = $gym->members()->count();
        $joinedThisMonth = $gym->members()
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $cuurentMonth)
            ->count();
        $totalExpensesThisMonth = $gym->expenses()
            ->whereYear('expense_date', $currentYear)
            ->whereMonth('expense_date', $cuurentMonth)
            ->sum('amount');
        $activeMembers = $gym->members()
            ->where('status', 'active')
            ->count();
        $inactiveMembers = $gym->members()
            ->where('status', 'inactive')
            ->count();
        $expiringSoon = $gym->members()
            ->whereHas('payments', function ($query) {
                $query->whereBetween('end_date', [now(), now()->addDays(3)]);
            })
            ->count();

        // Fetch the last 7 payments filtered by gym
        $payments = Payment::whereHas('member', function ($query) use ($gym) {
            $query->where('gym_id', $gym->id); // Assuming `gym_id` is in the `members` table
        })
            ->orderBy('created_at', 'desc')
            ->take(7)
            ->get();

        // Pass data to view
        return view('Staff.dashboard', compact(
            'totalEarningsThisMonth',
            'joinedThisMonth',
            'totalExpensesThisMonth',
            'totalMembers',
            'activeMembers',
            'inactiveMembers',
            'expiringSoon',
            'monthlyData',
            'payments'
        ));
    }
}
