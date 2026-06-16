<?php

namespace App\Http\Controllers\GymAdmin;

use Carbon\Carbon;
use App\Models\Plan;
use App\Models\GymPlan;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BillingController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $gym = $user->gym;
        $currentPlan = $gym->currentPlan;
        $latestPlan = $gym->latestPlan;
        $now = Carbon::now();

        $subscriptionEndDate = null;
        $remainingDays = null;
        $totalDays = null;
        $daysRemaining = null;
        $percentageCompleted = null;
        $expiredDays = null;

        if ($currentPlan) {
            $subscriptionEndDate = Carbon::parse($currentPlan->end_date);
            $remainingDays = intval($now->diffInDays($subscriptionEndDate, false));
            $totalDays = $currentPlan->duration * 30; // Assuming duration is in months

            $daysRemaining = max($remainingDays, 0); // Ensure non-negative remaining days
            $percentageCompleted = $totalDays > 0 ? (($totalDays - $daysRemaining) / $totalDays) * 100 : 0;
        } elseif ($latestPlan) {
            $subscriptionEndDate = Carbon::parse($latestPlan->end_date);
            $expiredDays = intval($now->diffInDays($subscriptionEndDate, false));
        }

        $gymPlans = GymPlan::with(['gym', 'plan'])
            ->where('gym_id', $gym->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $totalGymPlans = $gymPlans->count();
        $expiredGyms = $gymPlans->where('end_date', '<', now())->count();
        $activeGyms = $gymPlans->where('end_date', '>=', now())->count();

        $plans = Plan::all();

        return view('GymAdmin.Account.billing', compact(
            'gym',
            'plans',
            'currentPlan',
            'latestPlan',
            'subscriptionEndDate',
            'remainingDays',
            'percentageCompleted',
            'daysRemaining',
            'expiredDays',
            'gymPlans',
            'totalGymPlans',
            'expiredGyms',
            'activeGyms'
        ));
    }



    public function show($id)
    {
        $gymPlan = GymPlan::with('gym', 'plan')->findOrFail($id);

        // Check if the authenticated user belongs to the same gym as the gym plan
        // Method 2: Authorization Middleware
        if (Auth::user()->gym_id !== $gymPlan->gym_id) {
            abort(403, 'Unauthorized action.');
        }

        // Calculate remaining days and percentage completed if needed
        $startDate = Carbon::parse($gymPlan->start_date);
        $endDate = Carbon::parse($gymPlan->end_date);
        $today = Carbon::now();
        $totalDays = $startDate->diffInDays($endDate);
        $remainingDays = $today->diffInDays($endDate, false);
        $percentageCompleted = ($totalDays - $remainingDays) / $totalDays * 100;

        return view('GymAdmin.Account.billingShow', compact('gymPlan', 'remainingDays', 'percentageCompleted'));
    }
}
