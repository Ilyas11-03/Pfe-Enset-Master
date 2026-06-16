<?php

namespace App\Http\Controllers\GymAdmin;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
                'profit' => $profit
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

        // Calculate total expense for the current month
        $totalExpensesThisMonth = $gym->expenses()
            ->whereYear('expense_date', $currentYear)
            ->whereMonth('expense_date', $cuurentMonth)
            ->sum('amount');

        // Calculate profit for the current month
        $profitThisMonth = $totalEarningsThisMonth - $totalExpensesThisMonth;

        // Determine status based on profit
        $profitStatus = $profitThisMonth >= 0 ? 'success' : 'danger';

        $totalMembers = $gym->members()->count();
        $joinedThisMonth = $gym->members()
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $cuurentMonth)
            ->count();

        $totalStaff = $gym->users()
            ->where('role', 'staff')
            ->count();
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
        return view('GymAdmin.dashboard', compact(
            'totalEarningsThisMonth',
            'totalStaff',
            'joinedThisMonth',
            'totalExpensesThisMonth',
            'totalMembers',
            'activeMembers',
            'inactiveMembers',
            'expiringSoon',
            'monthlyData',
            'profitThisMonth',
            'profitStatus',
            'payments'
        ));
    }
}
