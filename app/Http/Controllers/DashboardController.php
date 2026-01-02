<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        
        // Settings (Daily Budget) for current user
        $dailyBudget = \App\Models\Setting::where('user_id', $userId)
                        ->where('key', 'daily_budget')
                        ->value('value') ?? 100000;

        $today = now()->timezone('Asia/Jakarta');

        // Today's Data
        $todaysTransactions = Expense::where('user_id', $userId)
            ->whereDate('date', $today->toDateString())
            ->get();
            
        $todaysExpenses = $todaysTransactions->where('type', 'expense')->sum('amount');
        $todaysIncome = $todaysTransactions->where('type', 'income')->sum('amount');

        // Balance Logic: Budget - Expense + Income OR Total Income - Expense?
        // User likely wants "Remaining Budget" but with income added.
        // Let's assume Daily Budget is an initial limit, and Income adds to available funds.
        $todaysBalance = ($dailyBudget + $todaysIncome) - $todaysExpenses;

        $lastWeek = $today->copy()->subDays(7);
        $weeklyExpenses = Expense::where('user_id', $userId)
            ->whereDate('date', '>=', $lastWeek)
            ->where('type', 'expense')
            ->sum('amount');
        
        $weeklyAverage = $weeklyExpenses / 7;

        $recentExpenses = Expense::where('user_id', $userId)
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact('dailyBudget', 'todaysExpenses', 'todaysIncome', 'todaysBalance', 'weeklyAverage', 'recentExpenses'));
    }
}
