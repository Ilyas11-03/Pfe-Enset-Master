<?php

namespace App\Http\Controllers\Staff;

use Carbon\Carbon;
use App\Models\Sport;
use App\Models\Member;
use App\Models\Payment;
use App\Models\Membership;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PaymentRequest;
use Illuminate\Support\Facades\Crypt;

class PaymentController extends Controller
{
    public function index()
    {
        $gymId = Auth::user()->gym_id;

        $payments = Payment::whereHas('member', function ($query) use ($gymId) {
            $query->where('gym_id', $gymId);
        })
            ->with(['member', 'membership'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        $totalPayments = $payments->count();
        $expiredPayments = $payments->filter(function ($payment) {
            return $payment->end_date < now();
        })->count();
        $paidPayments = $payments->where('payment_status', 'Paid')->count();
        $partialPaidPayments = $payments->where('payment_status', 'Partial Paid')->count();
        $pendingPayments = $payments->where('payment_status', 'Pending')->count();

        return view('Staff.payments.index', compact('payments', 'totalPayments', 'expiredPayments', 'paidPayments', 'partialPaidPayments', 'pendingPayments'));
    }


    public function show($id)
    {
        $id = Crypt::decrypt($id);

        $payment = Payment::with(['member', 'membership', 'createdBy', 'updatedBy'])->findOrFail($id);
        $relatedPayments = Payment::where('member_id', $payment->member_id)
            ->where('id', '!=', $payment->id)
            ->get();

        return view('Staff.payments.show', compact('payment', 'relatedPayments'));
    }


    public function create()
    {
        $gymId = Auth::user()->gym_id;

        $members = Member::where('gym_id', $gymId)->get();
        $memberships = Membership::where('gym_id', $gymId)->get();
        $sports = Sport::where('gym_id', $gymId)->get(); // Get all sports for the dropdown
        
        return view('Staff.payments.create', compact('members', 'memberships', 'sports'));
    }

    public function store(PaymentRequest $request)
    {
        $data = $request->validated();
        $startDate = Carbon::parse($data['start_date']);
        $endDate = Carbon::parse($data['end_date']);
        $totalAmount = (int) $data['total_amount'];
        $amountPaid = (int) $data['amount_paid'];
        $dueAmount = $totalAmount - $amountPaid;

        Payment::create([
            'member_id' => $data['member_id'],
            'membership_id' => $data['membership_id'],
            'sport_id' => $data['sport_id'], // Include sport_id
            'start_date' => $startDate,
            'end_date' => $endDate,
            'total_amount' => $totalAmount,
            'amount_paid' => $amountPaid,
            'due_amount' => $dueAmount,
            'payment_status' => $data['payment_status'],
            'auto_renew' => $data['auto_renew'],
            'notes' => $data['notes'],
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id,
        ]);

        return redirect()->route('staff.payments.index')->with('success', 'Payment added successfully');
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);

        $payment = Payment::findOrFail($id);
        
        $gymId = Auth::user()->gym_id;

        $members = Member::where('gym_id', $gymId)->get();
        $memberships = Membership::where('gym_id', $gymId)->get();
        $sports = Sport::where('gym_id', $gymId)->get(); // Get all sports for the dropdown
        
        return view('Staff.payments.edit', compact('payment', 'members', 'memberships', 'sports'));
    }

    public function update(PaymentRequest $request, $id)
    {
        $id = Crypt::decrypt($id);

        $data = $request->validated();
        $payment = Payment::findOrFail($id);

        $startDate = Carbon::parse($data['start_date']);
        $endDate = Carbon::parse($data['end_date']);

        $totalAmount = (int) $data['total_amount'];
        $amountPaid = (int) $data['amount_paid'];
        $dueAmount = $totalAmount - $amountPaid;

        $payment->update([
            'membership_id' => $data['membership_id'],
            'sport_id' => $data['sport_id'], // Update sport_id
            'start_date' => $startDate,
            'end_date' => $endDate,
            'total_amount' => $totalAmount,
            'amount_paid' => $amountPaid,
            'due_amount' => $dueAmount,
            'payment_status' => $data['payment_status'],
            'auto_renew' => $data['auto_renew'],
            'notes' => $data['notes'],
            'updated_by' => Auth::user()->id,
        ]);

        return redirect()->route('staff.payments.index')->with('success', 'Payment updated successfully');
    }

    public function destroy($id)
    {
        $id = Crypt::decrypt($id);

        $payment = Payment::findOrFail($id);
        $payment->delete();

        
        return redirect()->route('staff.payments.index')->with('success', 'Payment deleted successfully.');
    }
}
