<?php

namespace App\Http\Controllers\MainAdmin;

use App\Models\Plan;
use App\Http\Requests\PlanRequest;
use App\Http\Controllers\Controller;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Count total plans
        $totalPlans = Plan::count();

        // Fetch recent plans
        $plans = Plan::orderBy('created_at', 'DESC')->get();

        return view('MainAdmin.plans.index', compact('plans', 'totalPlans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('MainAdmin.plans.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PlanRequest $request)
    {
        $data = $request->validated();

        Plan::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'discount_percentage' => $data['discount_percentage'],
            'user_limit' => $data['user_limit'],
            'member_limit' => $data['member_limit'],
        ]);

        return redirect()->route('main_admin.plans.index')->with('success', 'Plan added successfully');
    }

    /**
     * Show the specified resource.
     */
    public function show(string $id)
    {
        $plan = Plan::findOrFail($id);
        return view('MainAdmin.plans.show', compact('plan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $plan = Plan::findOrFail($id);
        return view('MainAdmin.plans.edit', compact('plan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PlanRequest $request, string $id)
    {
        $data = $request->validated();
        $plan = Plan::findOrFail($id);

        $plan->update([
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'discount_percentage' => $data['discount_percentage'],
            'user_limit' => $data['user_limit'],
            'member_limit' => $data['member_limit'],
        ]);

        return redirect()->route('main_admin.plans.index')->with('success', 'Plan updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $plan = Plan::findOrFail($id);
        $plan->delete();
        return redirect()->route('main_admin.plans.index')->with('success', 'Plan deleted successfully');
    }
}
