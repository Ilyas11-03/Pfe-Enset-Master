<?php

namespace App\Http\Controllers\MainAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\Gym;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Define the current and previous time frames
        $currentStart = now()->startOfWeek();
        $currentEnd = now()->endOfWeek();
        $previousStart = now()->subWeek()->startOfWeek();
        $previousEnd = now()->subWeek()->endOfWeek();

        // Fetch current period data
        $totalUsers = User::where('id', '!=', auth()->id())->count();
        $activeUsers = User::where('id', '!=', auth()->id())->where('status', true)->count();
        $gymAdmins = User::where('id', '!=', auth()->id())->where('role', 'gym_admin')->count();
        $inactiveUsers = User::where('id', '!=', auth()->id())->where('status', false)->count();

        // Fetch previous period data
        $previousTotalUsers = User::where('created_at', '>=', $previousStart)
            ->where('created_at', '<=', $previousEnd)
            ->where('id', '!=', auth()->id())
            ->count();
        $previousActiveUsers = User::where('created_at', '>=', $previousStart)
            ->where('created_at', '<=', $previousEnd)
            ->where('id', '!=', auth()->id())
            ->where('status', true)
            ->count();
        $previousGymAdmins = User::where('created_at', '>=', $previousStart)
            ->where('created_at', '<=', $previousEnd)
            ->where('id', '!=', auth()->id())
            ->where('role', 'gym_admin')
            ->count();
        $previousInactiveUsers = User::where('created_at', '>=', $previousStart)
            ->where('created_at', '<=', $previousEnd)
            ->where('id', '!=', auth()->id())
            ->where('status', false)
            ->count();

        // Calculate percentage changes
        $totalUsersChange = $previousTotalUsers > 0 ? (($totalUsers - $previousTotalUsers) / $previousTotalUsers) * 100 : 0;
        $activeUsersChange = $previousActiveUsers > 0 ? (($activeUsers - $previousActiveUsers) / $previousActiveUsers) * 100 : 0;
        $gymAdminsChange = $previousGymAdmins > 0 ? (($gymAdmins - $previousGymAdmins) / $previousGymAdmins) * 100 : 0;
        $inactiveUsersChange = $previousInactiveUsers > 0 ? (($inactiveUsers - $previousInactiveUsers) / $previousInactiveUsers) * 100 : 0;

        // Fetch all users for the list
        $users = User::where('id', '!=', auth()->id())
            ->with('gym')
            ->orderBy('gym_id') // Order by gym_id
            ->orderBy('created_at', 'DESC') // Additional ordering by created_at
            ->get();

        return view('MainAdmin.users.index', compact(
            'users',
            'totalUsers',
            'activeUsers',
            'gymAdmins',
            'inactiveUsers',
            'totalUsersChange',
            'activeUsersChange',
            'gymAdminsChange',
            'inactiveUsersChange'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $gyms = Gym::all();

        return view('MainAdmin.users.create', compact('gyms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $data = $request->validated();
        $status = $request->has('status') ? 'active' : 'inactive';

        $gym = Gym::findOrFail($data['gym_id']);
        $currentPlan = $gym->currentPlan;

        if ($currentPlan && $currentPlan->plan && $currentPlan->plan->user_limit) {
            $memberLimit = $currentPlan->plan->user_limit;
            $currentMemberCount = $gym->users()->count();

            if ($currentMemberCount >= $memberLimit) {
                return back()->with('error', 'User limit exceeded for this gym plan.');
            }
        }

        $profileImagePath = null;

        if ($request->hasFile('profile_image')) {
            $profileImagePath = $request->file('profile_image')->store('users', 'public');
        }

        User::create([
            'gym_id' => $data['gym_id'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'],
            'address' => $data['address'],
            'profile_image' => $profileImagePath,
            'role' => $data['role'],
            'status' => $status,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('main_admin.users.index')->with('success', 'User added successfully');
    }

    public function show(string $id)
    {
        $user = User::findOrFail($id);

        return view('MainAdmin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $gyms = Gym::all();

        return view('MainAdmin.users.edit', compact('user', 'gyms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id)
    {
        $data = $request->validated();
        $status = ($request->has('status')) ? 'active' : 'inactive';
        $user = User::findOrFail($id);

        $updateData = [
            'gym_id' => $data['gym_id'],
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'role' => $data['role'],
            'status' => $status,
            'updated_by' => Auth::id(),
        ];

        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('users', 'public');
            $updateData['profile_image'] = $imagePath;
        }

        if (! empty($data['password'])) {
            $updateData['password'] = Hash::make($data['password']);
        }

        $user->update($updateData);

        return redirect()->route('main_admin.users.index')->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('main_admin.users.index')->with('success', 'User deleted successfully');
    }
}
