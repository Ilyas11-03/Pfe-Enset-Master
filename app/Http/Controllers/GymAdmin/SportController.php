<?php

namespace App\Http\Controllers\GymAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SportRequest;
use App\Models\Sport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class SportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gymId = Auth::user()->gym_id;

        // Fetch recent sports
        $sports = Sport::where('gym_id', $gymId)->orderBy('created_at', 'DESC')->get();

        // Count total sports
        $totalSports = $sports->count();

        return view('GymAdmin.sports.index', compact('sports', 'totalSports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('GymAdmin.sports.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SportRequest $request)
    {
        $data = $request->validated();
        $status = ($request->has('status')) ? 'active' : 'inactive';

        Sport::create([
            'gym_id' => auth()->user()->gym_id,
            'name' => $data['name'],
            'description' => $data['description'],
            'status' => $status,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ]);

        return redirect()->route('gym_admin.sports.index')->with('success', 'Sport added successfully');
    }

    /**
     * Show the specified resource.
     */
    public function show(string $id)
    {
        $id = Crypt::decrypt($id);

        $sport = Sport::findOrFail($id);

        return view('GymAdmin.sports.show', compact('sport'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $id = Crypt::decrypt($id);

        $sport = Sport::findOrFail($id);

        return view('GymAdmin.sports.edit', compact('sport'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SportRequest $request, string $id)
    {
        $id = Crypt::decrypt($id);

        $data = $request->validated();
        $status = ($request->has('status')) ? 'active' : 'inactive';

        $sport = Sport::findOrFail($id);
        $sport->update([
            'name' => $data['name'],
            'description' => $data['description'],
            'status' => $status,
            'updated_by' => auth()->user()->id,
        ]);

        return redirect()->route('gym_admin.sports.index')->with('success', 'Sport updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $id = Crypt::decrypt($id);

        $sport = Sport::findOrFail($id);
        $sport->delete();

        return redirect()->route('gym_admin.sports.index')->with('success', 'Sport deleted successfully');
    }
}
