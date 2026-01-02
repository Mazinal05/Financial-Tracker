<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(10);
        
        // Stats
        $totalUsers = User::count();
        $bannedUsers = User::where('is_banned', true)->count();
        $suspendedUsers = User::whereNotNull('suspended_until')->where('suspended_until', '>', now())->count();
        $activeUsers = $totalUsers - $bannedUsers - $suspendedUsers;

        return view('admin.users.index', compact('users', 'totalUsers', 'bannedUsers', 'suspendedUsers', 'activeUsers'));
    }

    public function suspend(Request $request, User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat mengubah status akun Anda sendiri.');
        }

        $request->validate([
            'action' => 'required|in:ban,suspend_days,activate',
            'days' => 'required_if:action,suspend_days|integer|min:1',
        ]);

        if ($request->action === 'ban') {
            $user->update(['is_banned' => true, 'suspended_until' => null]);
            $msg = 'Akun berhasil diblokir permanen.';
        } elseif ($request->action === 'suspend_days') {
            $user->update([
                'is_banned' => false,
                'suspended_until' => now()->addDays((int) $request->days)
            ]);
            $msg = "Akun berhasil disuspend selama {$request->days} hari.";
        } else {
            // Activate
            $user->update(['is_banned' => false, 'suspended_until' => null]);
            $msg = 'Akun berhasil diaktifkan kembali.';
        }

        return back()->with('success', $msg);
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();
        return back()->with('success', 'Akun user berhasil dihapus.');
    }
}
