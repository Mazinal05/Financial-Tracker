<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'daily_budget' => 'required|numeric|min:0'
        ]);

        Setting::updateOrCreate(
            [
                'key' => 'daily_budget',
                'user_id' => auth()->id()
            ],
            ['value' => $request->daily_budget]
        );

        return redirect()->back()->with('success', 'Budget harian diperbarui!');
    }
}
