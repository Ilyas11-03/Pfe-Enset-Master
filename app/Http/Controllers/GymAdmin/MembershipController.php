<?php

namespace App\Http\Controllers\GymAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MembershipRequest;
use App\Models\Membership;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class MembershipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gymId = Auth::user()->gym_id;

        // Count total memberships
        $totalMemberships = Membership::count();

        // Fetch recent memberships
        $memberships = Membership::where('gym_id', $gymId)->orderBy('created_at', 'DESC')->get();

        return view('GymAdmin.memberships.index', compact('memberships', 'totalMemberships'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('GymAdmin.memberships.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MembershipRequest $request)
    {
        $data = $request->validated();

        Membership::create([
            'gym_id' => auth()->user()->gym_id,
            'name' => $data['name'],
            'description' => $data['description'],
            'duration' => $data['duration'],
            'price' => $data['price'],
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ]);

        return redirect()->route('gym_admin.memberships.index')->with('success', 'Membership added successfully');
    }

    /**
     * Show the specified resource.
     */
    public function show(string $id)
    {
        $id = Crypt::decrypt($id);

        $membership = Membership::findOrFail($id);

        return view('GymAdmin.memberships.show', compact('membership'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $id = Crypt::decrypt($id);

        $membership = Membership::findOrFail($id);

        return view('GymAdmin.memberships.edit', compact('membership'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MembershipRequest $request, string $id)
    {

        $id = Crypt::decrypt($id);

        $data = $request->validated();
        $membership = Membership::findOrFail($id);

        $membership->update([
            'name' => $data['name'],
            'description' => $data['description'],
            'duration' => $data['duration'],
            'price' => $data['price'],
            'updated_by' => auth()->user()->id,
        ]);

        return redirect()->route('gym_admin.memberships.index')->with('success', 'Membership updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $id = Crypt::decrypt($id);

        $membership = Membership::findOrFail($id);
        $membership->delete();

        return redirect()->route('gym_admin.memberships.index')->with('success', 'Membership deleted successfully');
    }
}
