<?php

namespace App\Http\Controllers\GymAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EquipmentRequest;
use App\Models\Equipment;
use App\Models\Gym;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class EquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gymId = Auth::user()->gym_id;

        // Retrieve the equipment for the authenticated user's gym
        $equipment = Equipment::where('gym_id', $gymId)->orderBy('created_at', 'DESC')->get();

        // Calculate analytics
        $totalEquipment = $equipment->count(); // Total number of equipment
        $goodCondition = $equipment->where('condition', 'Good')->count(); // Equipment in good condition
        $maintenanceNeeded = $equipment->where('condition', 'Needs Maintenance')->count(); // Equipment needing maintenance

        // Total quantity and value
        $totalQuantity = $equipment->sum('quantity'); // Total quantity of equipment
        $totalValue = $equipment->sum('amount'); // Total value of equipment

        return view('GymAdmin.equipments.index', compact('equipment', 'totalEquipment', 'goodCondition', 'maintenanceNeeded', 'totalQuantity', 'totalValue'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $gymId = Auth::user()->gym_id;
        $gyms = Gym::where('id', $gymId)->get();

        return view('GymAdmin.equipments.create', compact('gyms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EquipmentRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('equipment', 'public');
            $data['image'] = $imagePath;
        }

        Equipment::create([
            'gym_id' => Auth::user()->gym_id,
            'name' => $data['name'],
            'description' => $data['description'],
            'image' => $data['image'] ?? null,
            'quantity' => $data['quantity'],
            'amount' => $data['amount'],
            'purchase_date' => $data['purchase_date'],
            'condition' => $data['condition'],
            'maintenance_date' => $data['maintenance_date'],
            'serial_number' => $data['serial_number'] ?? null,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('gym_admin.equipment.index')->with('success', 'Equipment added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $id = Crypt::decrypt($id);

        $gymId = Auth::user()->gym_id;
        $equipment = Equipment::where('id', $id)->where('gym_id', $gymId)->firstOrFail();

        return view('GymAdmin.equipments.show', compact('equipment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $id = Crypt::decrypt($id);

        $gymId = Auth::user()->gym_id;
        $equipment = Equipment::where('id', $id)->where('gym_id', $gymId)->firstOrFail();
        $gyms = Gym::where('id', $gymId)->get();

        return view('GymAdmin.equipments.edit', compact('equipment', 'gyms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EquipmentRequest $request, $id)
    {
        $id = Crypt::decrypt($id);

        $data = $request->validated();

        $gymId = Auth::user()->gym_id;
        $equipment = Equipment::where('id', $id)->where('gym_id', $gymId)->firstOrFail();

        $updateData = [
            'name' => $data['name'],
            'description' => $data['description'],
            'quantity' => $data['quantity'],
            'amount' => $data['amount'],
            'purchase_date' => $data['purchase_date'],
            'condition' => $data['condition'],
            'maintenance_date' => $data['maintenance_date'],
            'serial_number' => $data['serial_number'] ?? null,
            'updated_by' => Auth::id(),
        ];

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('equipment', 'public');
            $updateData['image'] = $imagePath;
        }

        $equipment->update($updateData);

        return redirect()->route('gym_admin.equipment.index')->with('success', 'Equipment updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $id = Crypt::decrypt($id);

        $gymId = Auth::user()->gym_id;
        $equipment = Equipment::where('id', $id)->where('gym_id', $gymId)->firstOrFail();
        $equipment->delete();

        return redirect()->route('gym_admin.equipment.index')->with('success', 'Equipment deleted successfully');
    }
}
