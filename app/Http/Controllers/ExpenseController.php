<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function create()
    {
        return view('expenses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'type' => 'in:expense,income' // Optional validation
        ]);

        Expense::create([
            'description' => $request->description,
            'amount' => $request->amount,
            'date' => $request->date,
            'type' => $request->type ?? 'expense',
            'user_id' => auth()->id() // Assign to current user
        ]);

        return redirect()->route('dashboard')->with('success', 'Transaksi berhasil dicatat!');
    }

    public function destroy(Expense $expense)
    {
        // Ensure user owns the expense
        if ($expense->user_id !== auth()->id()) {
            abort(403);
        }

        $expense->delete();
        return redirect()->route('expenses.index')->with('success', 'Pengeluaran dihapus.');
    }
    
    public function index(Request $request)
    {
        $query = Expense::where('user_id', auth()->id());
        
        if ($request->has('filter')) {
            $filter = $request->filter;
            if ($filter == 'week') {
                $query->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()]);
            } elseif ($filter == 'month') {
                $query->whereMonth('date', now()->month);
            } elseif ($filter == 'year') {
                $query->whereYear('date', now()->year);
            }
        }

        $expenses = $query->orderBy('date', 'desc')->get();
        
        // Calculate totals for the view
        $totalExpense = $expenses->where('type', 'expense')->sum('amount');
        $totalIncome = $expenses->where('type', 'income')->sum('amount');
        $totalBalance = $totalIncome - $totalExpense;

        return view('expenses.index', compact('expenses', 'totalExpense', 'totalIncome', 'totalBalance'));
    }
}
