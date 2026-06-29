<?php

namespace App\Http\Controllers\GymAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\Gym;
use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get the current authenticated gym ID
        $gymId = Auth::user()->gym_id;

        // Fetch current period data for the specific gym
        $totalStaff = User::where('role', 'staff')->where('gym_id', $gymId)->count();
        $activeStaff = User::where('role', 'staff')->where('gym_id', $gymId)->where('status', 'Active')->count();
        $inactiveStaff = User::where('role', 'staff')->where('gym_id', $gymId)->where('status', 'Inactive')->count();

        // Fetch all staff members for the specific gym
        $staffMembers = User::where('role', 'staff')
            ->where('gym_id', $gymId)
            ->with('gym')
            ->orderBy('gym_id') // Order by gym_id
            ->orderBy('created_at', 'DESC') // Additional ordering by created_at
            ->get();

        return view('GymAdmin.staff.index', compact(
            'staffMembers',
            'totalStaff',
            'activeStaff',
            'inactiveStaff',
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $gymId = Auth::user()->gym_id;
        $gyms = Gym::where('id', $gymId)->get();

        return view('GymAdmin.staff.create', compact('gyms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $data = $request->validated();
        $status = $request->has('status') ? 'active' : 'inactive';

        $gymId = Auth::user()->gym_id;
        $gym = Gym::findOrFail($gymId);
        $currentPlan = $gym->currentPlan;

        // Check if the current plan exists and has a member limit
        if ($currentPlan && $currentPlan->plan && $currentPlan->plan->user_limit) {
            $memberLimit = $currentPlan->plan->user_limit;
            $currentMemberCount = $gym->users()->count();

            if ($currentMemberCount >= $memberLimit) {
                return redirect()->route('gym_admin.staff.index')->with('error', 'User limit exceeded for your current plan.');
            }
        }

        if ($request->hasFile('profile_image')) {
            $profileImagePath = $request->file('profile_image')->store('staff', 'public');
        }

        User::create([
            'gym_id' => Auth::user()->gym_id, // Set gym_id to authenticated user's gym
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'],
            'address' => $data['address'],
            'profile_image' => $profileImagePath ?? null,
            'role' => 'staff',
            'status' => $status,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('gym_admin.staff.index')->with('success', 'Staff member added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $id = Crypt::decrypt($id);

        $gymId = Auth::user()->gym_id;
        $staffMember = User::where('id', $id)->where('gym_id', $gymId)->firstOrFail();

        // Fetch the analytics data
        $membersManaged = Member::where('created_by', $id)->count();
        $activeMembersManaged = Member::where('created_by', $id)->where('status', 'active')->count();
        $inactiveMembersManaged = Member::where('created_by', $id)->where('status', 'inactive')->count();
        $expiredMembershipsManaged = Member::where('created_by', $id)->whereHas('currentPlan', function ($query) {
            $query->where('end_date', '<', now());
        })->count();

        return view('GymAdmin.staff.show', compact('staffMember', 'membersManaged', 'activeMembersManaged', 'inactiveMembersManaged', 'expiredMembershipsManaged'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $id = Crypt::decrypt($id);

        $gymId = Auth::user()->gym_id;
        $staffMember = User::where('id', $id)->where('gym_id', $gymId)->firstOrFail();
        $gyms = Gym::where('id', $gymId)->get();

        return view('GymAdmin.staff.edit', compact('staffMember', 'gyms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, $id)
    {
        $id = Crypt::decrypt($id);

        $data = $request->validated();
        $status = $request->has('status') ? 'active' : 'inactive';
        $gymId = Auth::user()->gym_id;
        $staffMember = User::where('id', $id)->where('gym_id', $gymId)->firstOrFail();

        $updateData = [
            'gym_id' => $gymId,
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'role' => 'staff',
            'status' => $status,
            'updated_by' => Auth::id(),
        ];

        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('staff', 'public');
            $updateData['profile_image'] = $imagePath;
        }

        if (! empty($data['password'])) {
            $updateData['password'] = Hash::make($data['password']);
        }

        $staffMember->update($updateData);

        return redirect()->route('gym_admin.staff.index')->with('success', 'Staff member updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $id = decrypt($id);

        $gymId = Auth::user()->gym_id;
        $staffMember = User::where('id', $id)->where('gym_id', $gymId)->firstOrFail();

        // Clear foreign key references before deleting
        $tables = ['members', 'memberships', 'user_memberships', 'payments', 'attendance', 'equipment', 'sports', 'expenses'];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                DB::table($table)->where('created_by', $id)->update(['created_by' => null]);
                DB::table($table)->where('updated_by', $id)->update(['updated_by' => null]);
            }
        }

        $staffMember->delete();

        return redirect()->route('gym_admin.staff.index')->with('success', 'Staff member deleted successfully');
    }
}
