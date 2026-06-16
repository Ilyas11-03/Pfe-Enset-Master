<?php

namespace App\Http\Controllers\MainAdmin;

use Carbon\Carbon;
use App\Models\Gym;
use App\Http\Requests\GymRequest;
use App\Http\Controllers\Controller;

class GymController extends Controller
{
    public function index()
    {
        $totalGyms = Gym::count();
        $activeGyms = Gym::where('status', 'active')->count();
        $pendingGyms = Gym::where('status', 'inactive')->count();

        // Calculate expired gyms
        $expiredGyms = Gym::whereHas('latestPlan', function ($query) {
            $query->where('end_date', '<', Carbon::now());
        })->count();

        $gyms = Gym::with(['users', 'currentPlan.plan'])
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('MainAdmin.gyms.index', compact('gyms', 'totalGyms', 'activeGyms', 'pendingGyms', 'expiredGyms'));
    }


    public function create()
    {
        return view('MainAdmin.gyms.create');
    }

    public function store(GymRequest $request)
    {
        $data = $request->validated();
        $status = $request->has('status') ? 'active' : 'inactive';

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('gym_images', 'public');
        }

        $gym = Gym::create([
            'name' => $data['name'],
            'domain' => $data['domain'],
            'address' => $data['address'],
            'phone' => $data['phone'],
            'operating_hours' => $data['operating_hours'],
            'city' => $data['city'],
            'region' => $data['region'],
            'status' => $status,
            'image' => $imagePath ?? null,
        ]);

        return redirect()->route('main_admin.gyms.index')->with('success', 'Gym added successfully');
    }

    public function show($id)
    {
        $gym = Gym::with(['latestPlan.plan', 'currentPlan.plan', 'gymPlans.plan', 'users'])->findOrFail($id);

        $now = Carbon::now();

        // Initialize default values
        $daysRemaining = null;
        $percentageCompleted = null;
        $expiredDays = null;
        $dueDate = null;

        // Check if the gym has a current plan
        if ($gym->currentPlan) {
            $startsAt = Carbon::parse($gym->currentPlan->start_date);
            $expiresAt = Carbon::parse($gym->currentPlan->end_date);

            $totalDurationDays = $startsAt->diffInDays($expiresAt);
            $daysRemaining = intval($now->diffInDays($expiresAt, false));
            $daysCompleted = $totalDurationDays - $daysRemaining;

            $percentageCompleted = intval(($daysCompleted / $totalDurationDays) * 100);
        } elseif ($gym->latestPlan) {
            $endDate = Carbon::parse($gym->latestPlan->end_date);

            if ($now->greaterThan($endDate)) {
                $expiredDays = abs((int)$now->diffInDays($endDate, false)); // This will be positive
            }

            $dueDate = Carbon::parse($gym->latestPlan->due_date)->format('F j, Y');
        }

        // Gym Analytics
        $totalMembers = $gym->members->count();
        $totalStaff = $gym->users->where('role', 'staff')->count();
        $totalCoaches = $gym->users->where('role', 'coach')->count();
        $totalPlans = $gym->gymPlans->count();
        
        return view('MainAdmin.gyms.show', compact(
            'gym',
            'daysRemaining',
            'percentageCompleted',
            'totalMembers',
            'totalStaff',
            'totalCoaches',
            'totalPlans',
            'expiredDays',
            'dueDate'
        ));
    }





    public function edit(string $id)
    {
        $gym = Gym::findOrFail($id);
        return view('MainAdmin.gyms.edit', compact('gym'));
    }

    public function update(GymRequest $request, string $id)
    {
        $data = $request->validated();
        $status = $request->has('status') ? 'active' : 'inactive';
        $gym = Gym::findOrFail($id);

        $updateData = [
            'name' => $data['name'],
            'domain' => $data['domain'],
            'address' => $data['address'],
            'phone' => $data['phone'],
            'operating_hours' => $data['operating_hours'],
            'city' => $data['city'],
            'region' => $data['region'],
            'status' => $status,
        ];

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('gym_images', 'public');
            $updateData['image'] = $imagePath;
        }

        $gym->update($updateData);

        // Update the status of all users related to the gym
        $gym->users()->update(['status' => $status]);

        return redirect()->route('main_admin.gyms.index')->with('success', 'Gym updated successfully');
    }

    public function destroy(string $id)
    {
        $gym = Gym::findOrFail($id);
        $gym->delete();
        return redirect()->route('main_admin.gyms.index')->with('success', 'Gym deleted successfully');
    }
}
