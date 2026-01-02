@extends('layouts.app')

@section('content')
<div style="max-width: 1200px; margin: 0 auto;">
    
    <!-- Desktop Header (Hidden on Mobile) -->
    <div class="desktop-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px;">
        <div>
            <h1 style="font-size: 1.8rem; font-weight: 700;">Dashboard</h1>
            <p style="color: var(--text-muted);">Ringkasan keuangan Anda hari ini.</p>
        </div>
        <a href="{{ route('expenses.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Catat Pengeluaran
        </a>
    </div>

    <div class="stats-grid" style="display: grid; gap: 24px; margin-bottom: 40px;">
        <!-- Balance Card -->
        <div class="glass-card" style="position: relative; overflow: hidden;">
            <div style="position: relative; z-index: 2;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
                    <h3 style="color: var(--text-muted); font-size: 1rem; font-weight: 500;">Sisa Saldo</h3>
                    <i class="fas fa-wallet" style="color: var(--primary); font-size: 1.2rem; opacity: 0.8;"></i>
                </div>
                <div style="font-size: 2.2rem; font-weight: 700; color: {{ $todaysBalance >= 0 ? 'var(--text-main)' : 'var(--danger)' }}; letter-spacing: -1px;">
                    Rp {{ number_format($todaysBalance, 0, ',', '.') }}
                </div>
                <div style="font-size: 0.9rem; color: var(--text-muted); margin-top: 8px; display: flex; align-items: center; gap: 6px;">
                    <span style="display: inline-block; width: 6px; height: 6px; border-radius: 50%; background: {{ $todaysBalance >= 0 ? 'var(--success)' : 'var(--danger)' }};"></span>
                    Target: Rp {{ number_format($dailyBudget, 0, ',', '.') }}
                </div>
            </div>
            <!-- Decorative bg icon -->
            <i class="fas fa-wallet" style="position: absolute; right: -20px; bottom: -20px; font-size: 8rem; opacity: 0.03; color: white;"></i>
        </div>
    
        <!-- Income Card -->
        <div class="glass-card">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
                <h3 style="color: var(--text-muted); font-size: 1rem; font-weight: 500;">Pemasukan Hari Ini</h3>
                <i class="fas fa-arrow-down" style="color: var(--success); font-size: 1.2rem; opacity: 0.8;"></i>
            </div>
            <div style="font-size: 2.2rem; font-weight: 700; color: var(--success); letter-spacing: -1px;">
                Rp {{ number_format($todaysIncome, 0, ',', '.') }}
            </div>
        </div>

        <!-- Expense Card -->
        <div class="glass-card">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
                <h3 style="color: var(--text-muted); font-size: 1rem; font-weight: 500;">Pengeluaran Hari Ini</h3>
                <i class="fas fa-arrow-up" style="color: var(--danger); font-size: 1.2rem; opacity: 0.8;"></i>
            </div>
            <div style="font-size: 2.2rem; font-weight: 700; color: var(--text-main); letter-spacing: -1px;">
                Rp {{ number_format($todaysExpenses, 0, ',', '.') }}
            </div>
        </div>
    
        <!-- Weekly Card -->
        <div class="glass-card">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
                <h3 style="color: var(--text-muted); font-size: 1rem; font-weight: 500;">Rata-rata Mingguan</h3>
                <i class="fas fa-chart-line" style="color: var(--secondary); font-size: 1.2rem; opacity: 0.8;"></i>
            </div>
            <div style="font-size: 2.2rem; font-weight: 700; color: var(--text-main); letter-spacing: -1px;">
                Rp {{ number_format($weeklyAverage, 0, ',', '.') }}
            </div>
            <div style="margin-top: 8px; font-size: 0.9rem; color: var(--text-muted);">
                Per Hari
            </div>
        </div>
    </div>
    
    <div style="max-width: 800px; margin: 0 auto;">
        <!-- Recent History -->
        <div class="glass-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                <h2 style="font-size: 1.25rem; font-weight: 600;"><i class="fas fa-history" style="margin-right: 8px; color: var(--primary);"></i> Transaksi Terakhir</h2>
                <a href="{{ route('expenses.index') }}" style="color: var(--primary); text-decoration: none; font-size: 0.9rem; font-weight: 500;">Lihat Semua <i class="fas fa-arrow-right" style="font-size: 0.7rem;"></i></a>
            </div>
            
            @if($recentExpenses->count() > 0)
                <div style="display: flex; flex-direction: column; gap: 16px;">
                    @foreach($recentExpenses as $expense)
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px; border-radius: 16px; background: rgba(255,255,255,0.02); border: 1px solid transparent; transition: all 0.2s;">
                        <div style="display: flex; align-items: center; gap: 16px;">
                            <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(255,255,255,0.05); display: flex; align-items: center; justify-content: center; color: var(--text-muted);">
                                <i class="fas fa-shopping-bag"></i>
                            </div>
                            <div>
                                <div style="font-weight: 600;">{{ $expense->description }}</div>
                            <div style="font-size: 0.8rem; color: var(--text-muted);">
                                {{ $expense->created_at->timezone('Asia/Jakarta')->format('H:i') }} • 
                                <span style="font-weight: 500; color: {{ $expense->type == 'income' ? 'var(--success)' : 'var(--danger)' }};">
                                    {{ $expense->type == 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div style="font-weight: 600; color: {{ $expense->type == 'income' ? 'var(--success)' : 'var(--danger)' }};">
                        {{ $expense->type == 'income' ? '+' : '-' }} Rp {{ number_format($expense->amount, 0, ',', '.') }}
                    </div>
                </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 40px; color: var(--text-muted);">
                    <i class="fas fa-inbox" style="font-size: 2rem; margin-bottom: 16px; opacity: 0.5;"></i>
                    <p>Belum ada pengeluaran.</p>
                </div>
            @endif
        </div>
    
        <!-- Budget Settings (Minimalist Toggle) -->
        <div style="margin-top: 24px; text-align: center;">
            <details>
                <summary style="cursor: pointer; color: var(--text-muted); font-size: 0.9rem; list-style: none;">
                    <i class="fas fa-cog"></i> Atur Budget Harian
                </summary>
                <div class="glass-card" style="margin-top: 10px; max-width: 300px; margin-left: auto; margin-right: auto; padding: 16px;">
                    <form action="{{ route('settings.update') }}" method="POST" style="display: flex; gap: 12px;">
                        @csrf
                        <input type="number" name="daily_budget" value="{{ $dailyBudget }}" required style="padding: 10px; font-size: 0.9rem;">
                        <button type="submit" class="btn btn-primary" style="padding: 10px 16px; font-size: 0.9rem;">Simpan</button>
                    </form>
                </div>
            </details>
        </div>
    </div>
</div>

<!-- Floating Action Button -->
<a href="{{ route('expenses.create') }}" class="fab-btn">
    <i class="fas fa-plus"></i>
</a>

<style>
    /* Default (Desktop) */
    .fab-btn { display: none; } /* Hide FAB on Desktop */
    .desktop-header { display: flex; }
    
    .stats-grid {
        grid-template-columns: repeat(4, 1fr);
    }

    /* Mobile & Tablet */
    @media (max-width: 1024px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    /* Mobile */
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }
        .glass-card {
            padding: 16px !important;
        }
        /* Adjust font sizes for compact 2-column view */
        .glass-card h3 {
            font-size: 0.8rem !important;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .glass-card div[style*="font-size: 2.2rem"] {
            font-size: 1.4rem !important;
            letter-spacing: -0.5px !important;
        }
        .glass-card i {
            font-size: 1rem !important;
        }
        
        .desktop-header { display: none !important; } /* Hide Header on Mobile */
        
        .fab-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            box-shadow: 0 10px 30px rgba(139, 92, 246, 0.5);
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            z-index: 1000;
        }

        .fab-btn:hover {
            transform: scale(1.1) rotate(90deg);
            box-shadow: 0 15px 40px rgba(139, 92, 246, 0.6);
        }
    }
</style>
@endsection
