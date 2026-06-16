<?php

namespace App\Http\Controllers\Staff;

use Carbon\Carbon;
use App\Models\Member;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $gym_id = Auth::user()->gym_id;
        $query = Attendance::with(['member', 'gym'])->where('gym_id', $gym_id)->orderBy('created_at', 'desc');

        if ($request->has('member_name')) {
            $query->whereHas('member', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->member_name . '%');
            });
        }

        $attendances = $query->get();

        // Analytics
        $totalAttendances = $attendances->count();
        $uniqueMembers = $attendances->pluck('member_id')->unique()->count();
        $averageDuration = $attendances->whereNotNull('duration')->avg('duration');
        $todayCheckIns = $attendances->where('check_in', '>=', Carbon::today())->count();
        $currentlyCheckedIn = $attendances->where('is_checked_in', true)->count();

        // Pass the list of members to the view
        $members = Member::where('gym_id', $gym_id)->get();

        return view('Staff.attendance.index', compact(
            'attendances',
            'members',
            'totalAttendances',
            'uniqueMembers',
            'averageDuration',
            'todayCheckIns',
            'currentlyCheckedIn'
        ));
    }


    public function checkin(Request $request)
    {
        // Decrypt the member_id before validation
        $id = decrypt($request->input('member_id'));

        // Perform validation
        $request->merge(['member_id' => $id]);

        $request->validate([
            'member_id' => 'required|exists:members,id',
        ]);

        $member = Member::findOrFail($request->member_id);

        // Check if the member is already checked in
        $alreadyCheckedIn = Attendance::where('member_id', $member->id)
            ->whereNull('check_out')
            ->exists();

        if ($alreadyCheckedIn) {
            return redirect()->back()->with('error', 'Member is already checked in and must check out first.');
        }
        $gym_id = Auth::user()->gym_id;


        Attendance::create([
            'member_id' => $member->id,
            'gym_id' => $gym_id,
            'check_in' => Carbon::now(),
            'is_checked_in' => true,
            'created_by' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Member checked in successfully.');
    }


    public function checkOut(Request $request, $id)
    {
        $id = Crypt::decrypt($id);

        $attendance = Attendance::findOrFail($id);

        if ($attendance->is_checked_in) {
            $checkOutTime = Carbon::now();
            $duration = intval($checkOutTime->diffInMinutes($attendance->check_in, true));

            $attendance->update([
                'check_out' => $checkOutTime,
                'duration' => $duration,
                'updated_by' => Auth::id(),
            ]);

            return redirect()->back()->with('success', 'Member checked out successfully.');
        }

        return redirect()->back()->with('error', 'Member is not currently checked in.');
    }


    public function autocomplete(Request $request)
    {
        $search = $request->get('term');

        $members = Member::where('name', 'like', '%' . $search . '%')->get();

        $results = [];

        foreach ($members as $member) {
            $results[] = [
                'id' => $member->id,
                'label' => $member->name,
                'value' => $member->name,
                'image' => $member->profile_image // Assuming you have a profile_image field
            ];
        }

        return response()->json($results);
    }
}
