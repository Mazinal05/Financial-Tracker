@extends('layouts.app')

@section('content')
<div style="min-height: 80vh; display: flex; align-items: center; justify-content: center;">
    <div class="glass-card" style="width: 100%; max-width: 400px; padding: 40px;">
        <div style="text-align: center; margin-bottom: 32px;">
            <i class="fas fa-wallet" style="font-size: 3rem; color: var(--primary); margin-bottom: 16px;"></i>
            <h2 style="font-size: 1.8rem; font-weight: 700; margin-bottom: 8px;">Selamat Datang Kembali</h2>
            <p style="color: var(--text-muted);">Masuk untuk mengelola keuangan Anda.</p>
        </div>

        <form action="{{ route('login') }}" method="POST">
            @csrf
            
            <div style="margin-bottom: 24px;">
                <label for="email" style="display: block; margin-bottom: 8px; font-weight: 500; font-size: 0.9rem;">Email</label>
                <div style="position: relative;">
                    <i class="fas fa-envelope" style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                    <input type="email" id="email" name="email" required autofocus
                        style="width: 100%; padding: 12px 12px 12px 48px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; color: white; font-size: 1rem; outline: none; transition: border-color 0.2s;">
                </div>
                @error('email')
                    <p style="color: var(--danger); font-size: 0.85rem; margin-top: 6px;">{{ $message }}</p>
                @enderror
            </div>

            <div style="margin-bottom: 32px;">
                <div style="margin-bottom: 30px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                    <label style="color: var(--text-secondary);">Password</label>
                    <a href="{{ route('password.request') }}" style="font-size: 0.85rem; color: var(--primary); text-decoration: none;">Lupa Password?</a>
                </div>
                <input type="password" name="password" required placeholder="••••••••"
                    style="width: 100%; padding: 12px; background: rgba(255,255,255,0.05); border: 1px solid var(--glass-border); border-radius: 12px; color: white; outline: none;">
                @error('password')
                    <div style="color: var(--danger); font-size: 0.8rem; margin-top: 6px;">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 14px; font-size: 1rem;">
                Masuk
            </button>
        </form>

        <div style="text-align: center; margin-top: 24px; color: var(--text-muted); font-size: 0.9rem;">
            Belum punya akun? 
            <a href="{{ route('register') }}" style="color: var(--primary); text-decoration: none; font-weight: 600;">Daftar Sekarang</a>
        </div>
    </div>
</div>

<style>
    input:focus {
        border-color: var(--primary) !important;
        background: rgba(255,255,255,0.08) !important;
    }
</style>
@endsection
