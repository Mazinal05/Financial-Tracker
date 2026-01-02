<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user();

            // Check if Banned
            if ($user->is_banned) {
                auth()->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('login')->withErrors(['email' => 'Akun Anda telah diblokir. Hubungi admin.']);
            }

            // Check if Suspended
            if ($user->suspended_until && $user->suspended_until->isFuture()) {
                $days = (int) ceil(now()->floatDiffInDays($user->suspended_until));
                $message = "Akun Anda disuspend selama {$days} hari lagi hingga " . $user->suspended_until->format('d M Y, H:i');
                
                auth()->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('login')->withErrors(['email' => $message]);
            }
            
            // Clear expired suspension
            if ($user->suspended_until && $user->suspended_until->isPast()) {
                $user->update(['suspended_until' => null]);
            }
        }

        return $next($request);
    }
}
