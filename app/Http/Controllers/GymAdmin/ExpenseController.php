<?php

namespace App\Http\Controllers\GymAdmin;

use App\Models\Gym;
use App\Models\Expense;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ExpenseRequest;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // Retrieve the expenses for the authenticated user's gym
    public function index(Request $request)
    {
        $gymId = Auth::user()->gym_id;

        // Search, filter, and pagination
        $query = Expense::where('gym_id', $gymId);

        // Filter by category
        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        // Search by name
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Paginate the results
        $expenses = $query->orderBy('created_at', 'DESC')->paginate(10);

        // Calculate total expenses and amount
        $totalExpenses = $query->count();
        $totalAmount = $query->sum('amount');


        return view('GymAdmin.expenses.index', compact('expenses', 'totalExpenses', 'totalAmount'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $gymId = Auth::user()->gym_id;
        $gyms = Gym::where('id', $gymId)->get();
        return view('GymAdmin.expenses.create', compact('gyms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExpenseRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('receipt')) {
            $receiptPath = $request->file('receipt')->store('receipts', 'public');
            $data['receipt'] = $receiptPath;
        }

        Expense::create([
            'gym_id' => Auth::user()->gym_id,
            'name' => $data['name'],
            'description' => $data['description'],
            'amount' => $data['amount'],
            'expense_date' => $data['expense_date'],
            'category' => $data['category'],
            'receipt' => $data['receipt'] ?? null,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('gym_admin.expenses.index')->with('success', 'Expense added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $id = Crypt::decrypt($id);

        $gymId = Auth::user()->gym_id;
        $expense = Expense::where('id', $id)->where('gym_id', $gymId)->firstOrFail();
        return view('GymAdmin.expenses.show', compact('expense'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $id = Crypt::decrypt($id);

        $gymId = Auth::user()->gym_id;
        $expense = Expense::where('id', $id)->where('gym_id', $gymId)->firstOrFail();
        $gyms = Gym::where('id', $gymId)->get();
        return view('GymAdmin.expenses.edit', compact('expense', 'gyms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExpenseRequest $request, $id)
    {
        $id = Crypt::decrypt($id);

        $data = $request->validated();

        $gymId = Auth::user()->gym_id;
        $expense = Expense::where('id', $id)->where('gym_id', $gymId)->firstOrFail();

        $updateData = [
            'name' => $data['name'],
            'description' => $data['description'],
            'amount' => $data['amount'],
            'expense_date' => $data['expense_date'],
            'category' => $data['category'],
            'updated_by' => Auth::id(),
        ];

        if ($request->hasFile('receipt')) {
            if ($expense->receipt) {
                Storage::disk('public')->delete($expense->receipt);
            }
            $receiptPath = $request->file('receipt')->store('receipts', 'public');
            $updateData['receipt'] = $receiptPath;
        }

        $expense->update($updateData);

        return redirect()->route('gym_admin.expenses.index')->with('success', 'Expense updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $id = Crypt::decrypt($id);

        $gymId = Auth::user()->gym_id;
        $expense = Expense::where('id', $id)->where('gym_id', $gymId)->firstOrFail();
        if ($expense->receipt) {
            Storage::disk('public')->delete($expense->receipt);
        }
        $expense->delete();
        return redirect()->route('gym_admin.expenses.index')->with('success', 'Expense deleted successfully');
    }
}
