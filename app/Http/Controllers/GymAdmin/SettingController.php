<?php

namespace App\Http\Controllers\GymAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    // Display the settings form
    public function index()
    {
        $gym = Auth::user()->gym;
        return view('GymAdmin.settings', compact('gym'));
    }

    // Handle the update request
    public function update(Request $request)
    {
        $gym = Auth::user()->gym;

        // Validate the incoming request data
        $request->validate([
            'domain' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => [
                'required',
                'regex:/^(\+\d{1,3}[- ]?)?\d{10}$/', 
                'max:15'
            ],            
            'operating_hours' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'region' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:800',
        ]);

        // Handle file upload for image if provided
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('gym_images', 'public');
            $gym->image = $imagePath;
        }

        // Update gym information
        $gym->update($request->only([
            'domain',
            'address',
            'phone',
            'operating_hours',
            'city',
            'region',
        ]));

        return redirect()->route('gym_admin.settings')->with('success', 'Gym information updated successfully.');
    }
}
