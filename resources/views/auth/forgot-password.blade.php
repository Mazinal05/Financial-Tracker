@extends('layouts.app')

@section('content')
<div style="max-width: 400px; margin: 0 auto; padding-top: 60px;">
    
    <div style="text-align: center; margin-bottom: 30px;">
        <div style="width: 70px; height: 70px; background: rgba(255,255,255,0.05); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; border: 1px solid var(--glass-border);">
            <i class="fas fa-lock-open" style="font-size: 1.8rem; color: var(--primary);"></i>
        </div>
        <h1 style="font-size: 1.8rem; font-weight: 700;">Lupa Password</h1>
        <p style="color: var(--text-muted); margin-top: 8px;">Masukkan email akun Anda untuk menerima link reset.</p>
    </div>

    <div class="glass-card" style="padding: 40px;">
        @if (session('status'))
            <div class="alert alert-success" style="background: rgba(16, 185, 129, 0.2); color: #6ee7b7; padding: 12px; border-radius: 8px; margin-bottom: 20px; text-align: center;">
                {{ session('status') }}
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST">
            @csrf

            <div style="margin-bottom: 24px;">
                <label style="display: block; margin-bottom: 8px; color: var(--text-secondary);"><i class="fas fa-envelope" style="margin-right: 8px;"></i> Email</label>
                <input type="email" name="email" placeholder="example@email.com" required value="{{ old('email') }}"
                    style="width: 100%; padding: 12px; background: rgba(255,255,255,0.05); border: 1px solid var(--glass-border); border-radius: 12px; color: white; outline: none;">
                @error('email')
                    <div style="color: var(--danger); font-size: 0.8rem; margin-top: 6px;">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 14px; font-size: 1rem; justify-content: center;">
                Kirim Link Reset
            </button> <!-- Fixing missing closing tag in logic -->

            <div style="text-align: center; margin-top: 20px;">
                <a href="{{ route('login') }}" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem;">
                    <i class="fas fa-arrow-left"></i> Kembali ke Login
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
