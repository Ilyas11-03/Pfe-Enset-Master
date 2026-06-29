<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\MemberRequest;
use App\Models\Gym;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class MemberController extends Controller
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

        $gymId = Auth::user()->gym_id;

        // Fetch current period data
        $totalMembers = Member::where('gym_id', $gymId)->count();
        $activeMembers = Member::where('gym_id', $gymId)->where('status', 'active')->count();
        $inactiveMembers = Member::where('gym_id', $gymId)->where('status', 'inactive')->count();
        $expiredMembers = Member::where('gym_id', $gymId)->get()->filter->isExpired->count();

        // Fetch previous period data
        $previousTotalMembers = Member::where('gym_id', $gymId)
            ->whereBetween('created_at', [$previousStart, $previousEnd])
            ->count();
        $previousActiveMembers = Member::where('gym_id', $gymId)
            ->whereBetween('created_at', [$previousStart, $previousEnd])
            ->where('status', 'active')
            ->count();
        $previousInactiveMembers = Member::where('gym_id', $gymId)
            ->whereBetween('created_at', [$previousStart, $previousEnd])
            ->where('status', 'inactive')
            ->count();

        // Calculate percentage changes
        $totalMembersChange = $previousTotalMembers > 0 ? (($totalMembers - $previousTotalMembers) / $previousTotalMembers) * 100 : 0;
        $activeMembersChange = $previousActiveMembers > 0 ? (($activeMembers - $previousActiveMembers) / $previousActiveMembers) * 100 : 0;
        $inactiveMembersChange = $previousInactiveMembers > 0 ? (($inactiveMembers - $previousInactiveMembers) / $previousInactiveMembers) * 100 : 0;

        // Fetch all members for the list
        $members = Member::where('gym_id', $gymId)
            ->get()
            ->sortByDesc(function ($member) {
                return $member->is_expired ? 1 : 0;
            })
            ->values();

        return view('Staff.members.index', compact(
            'members',
            'totalMembers',
            'activeMembers',
            'inactiveMembers',
            'expiredMembers',
            'totalMembersChange',
            'activeMembersChange',
            'inactiveMembersChange'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Staff.members.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MemberRequest $request)
    {
        $data = $request->validated();
        $status = ($request->has('status')) ? 'active' : 'inactive';

        $gymId = Auth::user()->gym_id;
        $gym = Gym::findOrFail($gymId);
        $currentPlan = $gym->currentPlan;

        // Check if the current plan exists and has a member limit
        if ($currentPlan && $currentPlan->plan && $currentPlan->plan->member_limit) {
            $memberLimit = $currentPlan->plan->member_limit;
            $currentMemberCount = $gym->members()->count();

            if ($currentMemberCount >= $memberLimit) {
                return redirect()->route('staff.members.index')->with('error', 'Member limit exceeded for your current plan.');
            }
        }

        $profileImagePath = null;
        if ($request->hasFile('profile_image')) {
            $profileImagePath = $request->file('profile_image')->store('members', 'public');
        }

        Member::create([
            'gym_id' => Auth::user()->gym_id,
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'gender' => $data['gender'],
            'join_date' => $data['join_date'],
            'status' => $status,
            'profile_image' => $profileImagePath,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('staff.members.index')->with('success', 'Member added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $id = Crypt::decrypt($id);

        $member = Member::findOrFail($id);
        $currentPlan = $member->currentPlan;
        $latestPlan = $member->latestPlan;
        $now = Carbon::now();

        $subscriptionEndDate = null;
        $remainingDays = null;
        $totalDays = null;
        $daysRemaining = null;
        $percentageCompleted = null;

        if ($currentPlan) {
            $subscriptionEndDate = Carbon::parse($currentPlan->end_date);
            $remainingDays = intval($now->diffInDays($subscriptionEndDate, false));
            $totalDays = $currentPlan->membership->duration * 30; // Assuming duration is in months

            $daysRemaining = max($remainingDays, 0); // Ensure non-negative remaining days
            $percentageCompleted = $totalDays > 0 ? (($totalDays - $daysRemaining) / $totalDays) * 100 : 0;
        }

        $payments = $member->payments()->orderBy('created_at', 'desc')->get();

        return view('Staff.members.show', compact('member', 'currentPlan', 'latestPlan', 'subscriptionEndDate', 'remainingDays', 'percentageCompleted', 'daysRemaining', 'payments', 'totalDays'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $id = Crypt::decrypt($id);

        $member = Member::findOrFail($id);

        return view('Staff.members.edit', compact('member'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MemberRequest $request, string $id)
    {
        $id = Crypt::decrypt($id);

        $data = $request->validated();
        $member = Member::findOrFail($id);
        $status = ($request->has('status')) ? 'active' : 'inactive';
        $updateData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'gender' => $data['gender'],
            'join_date' => $data['join_date'],
            'status' => $status,
            'updated_by' => Auth::id(),
        ];

        if ($request->hasFile('profile_image')) {
            $updateData['profile_image'] = $request->file('profile_image')->store('members', 'public');
        }

        $member->update($updateData);

        return redirect()->route('staff.members.index')->with('success', 'Member updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $id = Crypt::decrypt($id);

        $member = Member::findOrFail($id);
        $member->delete();

        return redirect()->route('staff.members.index')->with('success', 'Member deleted successfully');
    }
}
