<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SplitBillController extends Controller
{
    public function index()
    {
        return view('split-bill.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.name' => 'required|string',
            'items.*.amount' => 'required|numeric|min:0',
            'items.*.description' => 'nullable|string', // Validating the per-person item list
            'description' => 'required|string',
        ]);

        foreach ($request->items as $item) {
            if ($item['amount'] > 0) {
                // Format: "Makan Siang (Nasi Goreng, Es Teh)"
                $fullDescription = $request->description;
                if (!empty($item['description'])) {
                    $fullDescription .= ' ' . $item['description'];
                }

                auth()->user()->debts()->create([
                    'name' => $item['name'],
                    'amount' => $item['amount'],
                    'description' => $fullDescription,
                    'status' => 'unpaid',
                ]);
            }
        }

        return redirect()->route('debts.index')->with('success', 'Hasil split bill berhasil disimpan.');
    }
}
