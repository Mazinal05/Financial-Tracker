<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DebtController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'unpaid');
        $debts = auth()->user()->debts()
            ->when($status != 'all', function ($q) use ($status) {
                return $q->where('status', $status);
            })
            ->latest()
            ->get();

        return view('debts.index', compact('debts', 'status'));
    }

    public function create()
    {
        return view('debts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'image' => 'nullable|image|max:2048', // Max 2MB
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('struk', 'public');
        }

        auth()->user()->debts()->create([
            'name' => $request->name,
            'amount' => $request->amount,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'image_path' => $imagePath,
            'status' => 'unpaid',
        ]);

        return redirect()->route('debts.index')->with('success', 'Catatan hutang berhasil ditambahkan.');
    }

    public function markAsPaid(\App\Models\Debt $debt)
    {
        if ($debt->user_id !== auth()->id()) {
            abort(403);
        }

        $debt->update(['status' => 'paid']);
        return back()->with('success', 'Hutang ditandai lunas.');
    }

    public function destroy(\App\Models\Debt $debt)
    {
        if ($debt->user_id !== auth()->id()) {
            abort(403);
        }

        $debt->delete();
        return back()->with('success', 'Catatan hutang dihapus.');
    }
}
