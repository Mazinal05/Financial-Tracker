@extends('layouts.app')

@section('content')
<div style="min-height: 80vh; display: flex; align-items: center; justify-content: center;">
    <div class="glass-card" style="width: 100%; max-width: 400px; padding: 40px;">
        <div style="text-align: center; margin-bottom: 32px;">
            <i class="fas fa-user-plus" style="font-size: 3rem; color: var(--secondary); margin-bottom: 16px;"></i>
            <h2 style="font-size: 1.8rem; font-weight: 700; margin-bottom: 8px;">Buat Akun Baru</h2>
            <p style="color: var(--text-muted);">Mulai perjalanan finansial Anda hari ini.</p>
        </div>

        <form action="{{ route('register') }}" method="POST">
            @csrf
            
            <div style="margin-bottom: 24px;">
                <label for="name" style="display: block; margin-bottom: 8px; font-weight: 500; font-size: 0.9rem;">Nama Lengkap</label>
                <div style="position: relative;">
                    <i class="fas fa-user" style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                        style="width: 100%; padding: 12px 12px 12px 48px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; color: white; font-size: 1rem; outline: none; transition: border-color 0.2s;">
                </div>
                @error('name')
                    <p style="color: var(--danger); font-size: 0.85rem; margin-top: 6px;">{{ $message }}</p>
                @enderror
            </div>

            <div style="margin-bottom: 24px;">
                <label for="email" style="display: block; margin-bottom: 8px; font-weight: 500; font-size: 0.9rem;">Email</label>
                <div style="position: relative;">
                    <i class="fas fa-envelope" style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        style="width: 100%; padding: 12px 12px 12px 48px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; color: white; font-size: 1rem; outline: none; transition: border-color 0.2s;">
                </div>
                @error('email')
                    <p style="color: var(--danger); font-size: 0.85rem; margin-top: 6px;">{{ $message }}</p>
                @enderror
            </div>

            <div style="margin-bottom: 24px;">
                <label for="password" style="display: block; margin-bottom: 8px; font-weight: 500; font-size: 0.9rem;">Password</label>
                <div style="position: relative;">
                    <i class="fas fa-lock" style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                    <input type="password" id="password" name="password" required
                        style="width: 100%; padding: 12px 12px 12px 48px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; color: white; font-size: 1rem; outline: none; transition: border-color 0.2s;">
                </div>
                @error('password')
                    <p style="color: var(--danger); font-size: 0.85rem; margin-top: 6px;">{{ $message }}</p>
                @enderror
            </div>

            <div style="margin-bottom: 32px;">
                <label for="password_confirmation" style="display: block; margin-bottom: 8px; font-weight: 500; font-size: 0.9rem;">Konfirmasi Password</label>
                <div style="position: relative;">
                    <i class="fas fa-lock" style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                        style="width: 100%; padding: 12px 12px 12px 48px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; color: white; font-size: 1rem; outline: none; transition: border-color 0.2s;">
                </div>
            </div>

            <button type="submit" class="btn btn-secondary" style="width: 100%; justify-content: center; padding: 14px; font-size: 1rem;">
                Daftar
            </button>
        </form>

        <div style="text-align: center; margin-top: 24px; color: var(--text-muted); font-size: 0.9rem;">
            Sudah punya akun? 
            <a href="{{ route('login') }}" style="color: var(--primary); text-decoration: none; font-weight: 600;">Masuk</a>
        </div>
    </div>
</div>

<style>
    input:focus {
        border-color: var(--secondary) !important;
        background: rgba(255,255,255,0.08) !important;
    }
</style>
@endsection
