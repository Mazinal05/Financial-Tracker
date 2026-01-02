@extends('layouts.app')

@section('content')
<div style="max-width: 400px; margin: 0 auto; padding-top: 60px;">
    
    <div style="text-align: center; margin-bottom: 30px;">
        <h1 style="font-size: 1.8rem; font-weight: 700;">Reset Password</h1>
        <p style="color: var(--text-muted); margin-top: 8px;">Buat password baru untuk akun Anda.</p>
    </div>

    <div class="glass-card" style="padding: 40px;">
        <form action="{{ route('password.update') }}" method="POST">
            @csrf
            
            <input type="hidden" name="token" value="{{ $token }}">

            <div style="margin-bottom: 24px;">
                <label style="display: block; margin-bottom: 8px; color: var(--text-secondary);">Email</label>
                <input type="email" name="email" value="{{ $email ?? old('email') }}" required readonly
                    style="width: 100%; padding: 12px; background: rgba(255,255,255,0.03); border: 1px solid var(--glass-border); border-radius: 12px; color: var(--text-muted); outline: none; cursor: not-allowed;">
                @error('email')
                    <div style="color: var(--danger); font-size: 0.8rem; margin-top: 6px;">{{ $message }}</div>
                @enderror
            </div>

            <div style="margin-bottom: 24px;">
                <label style="display: block; margin-bottom: 8px; color: var(--text-secondary);">Password Baru</label>
                <input type="password" name="password" required autofocus placeholder="Minimal 8 karakter"
                    style="width: 100%; padding: 12px; background: rgba(255,255,255,0.05); border: 1px solid var(--glass-border); border-radius: 12px; color: white; outline: none;">
                @error('password')
                    <div style="color: var(--danger); font-size: 0.8rem; margin-top: 6px;">{{ $message }}</div>
                @enderror
            </div>

            <div style="margin-bottom: 30px;">
                <label style="display: block; margin-bottom: 8px; color: var(--text-secondary);">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required placeholder="Ulangi password baru"
                    style="width: 100%; padding: 12px; background: rgba(255,255,255,0.05); border: 1px solid var(--glass-border); border-radius: 12px; color: white; outline: none;">
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 14px; font-size: 1rem; justify-content: center;">
                Update Password
            </button>
        </form>
    </div>
</div>
@endsection
