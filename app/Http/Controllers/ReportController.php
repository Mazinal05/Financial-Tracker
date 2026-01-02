<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();
        $type = $request->query('type', 'daily'); // daily, weekly, monthly
        $date = Carbon::now()->timezone('Asia/Jakarta');
        
        $query = Expense::where('user_id', $userId);
        $title = '';
        $subTitle = '';

        if ($type == 'daily') {
            $query->whereDate('date', $date);
            $title = 'Laporan Harian';
            $subTitle = $date->translatedFormat('l, d F Y');
        } elseif ($type == 'weekly') {
            $query->whereBetween('date', [$date->copy()->startOfWeek(), $date->copy()->endOfWeek()]);
            $title = 'Laporan Mingguan';
            $subTitle = $date->copy()->startOfWeek()->translatedFormat('d M') . ' - ' . $date->copy()->endOfWeek()->translatedFormat('d M Y');
        } elseif ($type == 'monthly') {
            $query->whereMonth('date', $date->month)->whereYear('date', $date->year);
            $title = 'Laporan Bulanan';
            $subTitle = $date->translatedFormat('F Y');
        }

        $expenses = $query->orderBy('date')->get();
        
        $totalExpense = $expenses->where('type', 'expense')->sum('amount');
        $totalIncome = $expenses->where('type', 'income')->sum('amount');
        
        // Calculate Budget Context
        $dailyBudget = Setting::where('user_id', $userId)
                        ->where('key', 'daily_budget')
                        ->value('value') ?? 100000;
        
        if ($type == 'daily') {
            $periodBudget = $dailyBudget;
        } elseif ($type == 'weekly') {
            $periodBudget = $dailyBudget * 7;
        } else {
            $periodBudget = $dailyBudget * $date->daysInMonth;
        }

        $balance = ($periodBudget + $totalIncome) - $totalExpense;

        return view('reports.index', compact('expenses', 'totalExpense', 'totalIncome', 'balance', 'periodBudget', 'title', 'subTitle', 'type'));
    }
}
