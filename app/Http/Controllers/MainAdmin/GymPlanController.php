<?php

namespace App\Http\Controllers\MainAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\GymPlanRequest;
use App\Models\Gym;
use App\Models\GymPlan;
use App\Models\Plan;
use Carbon\Carbon;

class GymPlanController extends Controller
{
    public function index()
    {
        $gymPlans = GymPlan::with(['gym', 'plan'])->orderBy('created_at', 'desc')->get();
        $totalGymPlans = $gymPlans->count();
        $expiredGyms = GymPlan::where('end_date', '<', now())->count();
        $activeGyms = GymPlan::where('end_date', '>=', now())->count();

        return view('MainAdmin.gym-plans.index', compact('gymPlans', 'totalGymPlans', 'expiredGyms', 'activeGyms'));
    }

    public function show($id)
    {
        $gymPlan = GymPlan::with(['gym', 'plan'])->findOrFail($id);

        return view('MainAdmin.gym-plans.show', compact('gymPlan'));
    }

    public function create()
    {
        $gyms = Gym::all();
        $plans = Plan::all();

        return view('MainAdmin.gym-plans.create', compact('gyms', 'plans'));
    }

    public function store(GymPlanRequest $request)
    {
        $data = $request->validated();

        $startDate = Carbon::parse($data['start_date']);
        $duration = (int) $data['duration']; // Ensure duration is an integer
        $endDate = $startDate->clone()->addMonths($duration);

        $plan = Plan::find($data['plan_id']);

        // Apply discount if duration is more than or equal to 3 months
        $discountAmount = 0;
        if ($duration >= 3) {
            $discountAmount = ($plan->price * $plan->discount_percentage / 100) * $duration;
        }

        // Calculate total amount based on plan price and duration, minus discount
        $totalAmount = ($plan->price * $duration) - $discountAmount;
        $amountPaid = (int) $data['amount_paid'];
        $dueAmount = $totalAmount - $amountPaid; // Calculate due amount

        GymPlan::create([
            'gym_id' => $data['gym_id'],
            'plan_id' => $data['plan_id'],
            'start_date' => $data['start_date'],
            'end_date' => $endDate,
            'duration' => $duration,
            'total_amount' => (int) $totalAmount, // Ensure integer
            'amount_paid' => $amountPaid, // Ensure integer
            'due_amount' => (int) $dueAmount, // Ensure integer
            'discount_amount' => (int) $discountAmount, // Ensure integer
            'payment_status' => $data['payment_status'],
            'payment_method' => $data['payment_method'],
            'due_date' => $startDate->clone()->addDays(7), // Set due date to 7 days after start date
            'auto_renew' => $data['auto_renew'],
            'notes' => $data['notes'],
            'status' => 'active',
        ]);

        return redirect()->route('main_admin.gym-plans.index')->with('success', 'Gym plan added successfully');
    }

    public function edit($id)
    {
        $gymPlan = GymPlan::findOrFail($id);
        $gyms = Gym::all();
        $plans = Plan::all();

        return view('MainAdmin.gym-plans.edit', compact('gymPlan', 'gyms', 'plans'));
    }

    public function update(GymPlanRequest $request, $id)
    {
        $data = $request->validated();
        $gymPlan = GymPlan::findOrFail($id);

        $startDate = Carbon::parse($data['start_date']);
        $duration = (int) $data['duration']; // Ensure duration is an integer
        $endDate = $startDate->clone()->addMonths($duration);

        $plan = Plan::find($data['plan_id']);

        $discountAmount = 0;
        if ($duration >= 3) {
            $discountAmount = ($plan->price * $plan->discount_percentage / 100) * $duration;
        }

        $totalAmount = ($plan->price * $duration) - $discountAmount;
        $amountPaid = (int) $data['amount_paid'];
        $dueAmount = $totalAmount - $amountPaid;

        $gymPlan->update([
            'gym_id' => $data['gym_id'],
            'plan_id' => $data['plan_id'],
            'start_date' => $data['start_date'],
            'end_date' => $endDate,
            'duration' => $duration,
            'total_amount' => (int) $totalAmount,
            'amount_paid' => $amountPaid,
            'due_amount' => (int) $dueAmount,
            'discount_amount' => (int) $discountAmount,
            'payment_status' => $data['payment_status'],
            'payment_method' => $data['payment_method'],
            'due_date' => $startDate->clone()->addDays(7),
            'auto_renew' => $data['auto_renew'],
            'notes' => $data['notes'],
            'status' => $gymPlan->getStatusAttribute(), // Get status from model
        ]);

        return redirect()->route('main_admin.gym-plans.index')->with('success', 'Gym plan updated successfully');
    }

    public function destroy($id)
    {
        $gymPlan = GymPlan::findOrFail($id);
        $gymPlan->delete();

        return redirect()->route('main_admin.gym-plans.index')->with('success', 'Gym plan deleted successfully.');
    }
}
