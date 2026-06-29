<?php

namespace App\Http\Controllers\MainAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordChangeRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        return view('MainAdmin.Account.profile');
    }

    public function security()
    {
        return view('MainAdmin.Account.security');
    }

    public function update(ProfileUpdateRequest $request)
    {
        $data = $request->validated();
        $user = User::find(Auth::id());

        $updateData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? $user->phone,
            'address' => $data['address'] ?? $user->address,
            'updated_by' => Auth::id(),
        ];

        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('users', 'public');
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }
            $updateData['profile_image'] = $imagePath;
        }

        $user->update($updateData);

        return redirect()->route('main_admin.profile')->with('success', 'Your profile was updated.');
    }

    public function updatePassword(PasswordChangeRequest $request)
    {
        $user = User::find(Auth::id());

        if (! Hash::check($request->currentPassword, $user->password)) {
            return redirect()->back()->with('error', 'Current password is incorrect.');
        }

        $user->update([
            'password' => Hash::make($request->newPassword),
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('main_admin.security')->with('success', 'Password updated successfully.');
    }

    public function deactivate(Request $request)
    {
        $user = User::find(Auth::id());
        $user->update(['status' => 'inactive']);

        return redirect()->route('main_admin.login')->with('success', 'Your account has been deactivated.');
    }
}
