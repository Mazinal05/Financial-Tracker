@extends('layouts.app')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <h1 style="font-size: 1.5rem; font-weight: 700;">Catatan Hutang</h1>
        <a href="{{ route('debts.create') }}" class="btn btn-primary">
            <i class="fas fa-plus" style="margin-right: 8px;"></i> Catat Baru
        </a>
    </div>

    <!-- Stats Summary -->
    <div class="glass-card mb-4" style="padding: 20px; border-radius: 20px;">
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; text-align: center;">
            <div style="position: relative;">
                <div style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 4px;">Total Belum Dibayar</div>
                <div style="font-size: 1.2rem; font-weight: 700; color: var(--warning);">
                    Rp {{ number_format($debts->where('status', 'unpaid')->sum('amount'), 0, ',', '.') }}
                </div>
                <div style="position: absolute; right: 0; top: 10%; height: 80%; width: 1px; background: var(--glass-border);"></div>
            </div>
            <div>
                <div style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 4px;">Total Sudah Dibayar</div>
                <div style="font-size: 1.2rem; font-weight: 700; color: var(--success);">
                    Rp {{ number_format($debts->where('status', 'paid')->sum('amount'), 0, ',', '.') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div style="margin-bottom: 20px; display: flex; gap: 10px; overflow-x: auto; padding-bottom: 5px;">
        <a href="{{ route('debts.index', ['status' => 'unpaid']) }}" class="filter-pill {{ $status == 'unpaid' ? 'active' : '' }}">Belum Lunas</a>
        <a href="{{ route('debts.index', ['status' => 'paid']) }}" class="filter-pill {{ $status == 'paid' ? 'active' : '' }}">Lunas</a>
        <a href="{{ route('debts.index', ['status' => 'all']) }}" class="filter-pill {{ $status == 'all' ? 'active' : '' }}">Semua</a>
    </div>

    @if($debts->count() > 0)
        <div style="display: grid; gap: 16px;">
            @foreach($debts as $debt)
                <div class="glass-card" style="padding: 20px; border-radius: 16px; position: relative; overflow: hidden;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                        <div>
                            <h3 style="margin: 0 0 4px 0; font-size: 1.1rem; font-weight: 600;">{{ $debt->name }}</h3>
                            <div style="font-size: 0.85rem; color: var(--text-muted);">
                                <i class="far fa-clock"></i> {{ $debt->created_at->format('d M Y') }}
                                @if($debt->due_date)
                                    <span style="margin-left: 8px; color: var(--warning);">
                                        <i class="fas fa-calendar-alt"></i> Jatuh Tempo: {{ $debt->due_date->format('d M Y') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div style="text-align: right;">
                            <div style="font-size: 1.1rem; font-weight: 700; color: {{ $debt->status == 'paid' ? 'var(--success)' : 'var(--warning)' }};">
                                Rp {{ number_format($debt->amount, 0, ',', '.') }}
                            </div>
                            <span style="font-size: 0.75rem; padding: 2px 8px; border-radius: 100px; background: {{ $debt->status == 'paid' ? 'rgba(16, 185, 129, 0.2)' : 'rgba(251, 191, 36, 0.2)' }}; color: {{ $debt->status == 'paid' ? '#6ee7b7' : '#fbbf24' }}; border: 1px solid {{ $debt->status == 'paid' ? 'rgba(16, 185, 129, 0.3)' : 'rgba(251, 191, 36, 0.3)' }};">
                                {{ $debt->status == 'paid' ? 'Lunas' : 'Belum Lunas' }}
                            </span>
                        </div>
                    </div>

                    @if($debt->description)
                        <div style="background: rgba(255,255,255,0.03); padding: 10px; border-radius: 8px; font-size: 0.9rem; color: var(--text-secondary); margin-bottom: 15px; border: 1px solid var(--glass-border);">
                            {{ $debt->description }}
                        </div>
                    @endif

                    <div style="display: flex; gap: 10px; margin-top: 15px; border-top: 1px solid var(--glass-border); padding-top: 15px;">
                        @if($debt->image_path)
                            <a href="{{ asset('storage/' . $debt->image_path) }}" target="_blank" class="btn btn-outline" style="flex: 1; justify-content: center; font-size: 0.9rem;">
                                <i class="fas fa-image" style="margin-right: 6px;"></i> Lihat Struk
                            </a>
                        @endif
                        
                        @if($debt->status == 'unpaid')
                            <form action="{{ route('debts.pay', $debt) }}" method="POST" style="flex: 1;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; background: var(--success); border: none;" onclick="return confirm('Tandai sudah lunas?')">
                                    <i class="fas fa-check" style="margin-right: 6px;"></i> Tandai Lunas
                                </button>
                            </form>
                        @endif

                        <form action="{{ route('debts.destroy', $debt) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-icon" style="background: rgba(239, 68, 68, 0.1); color: var(--danger); width: 40px; height: 40px; border-radius: 10px;" onclick="return confirm('Hapus catatan ini?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div style="text-align: center; padding: 60px 20px;">
            <div style="width: 60px; height: 60px; background: rgba(255,255,255,0.05); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                <i class="fas fa-book" style="font-size: 1.5rem; color: var(--text-muted); opacity: 0.5;"></i>
            </div>
            <p style="color: var(--text-muted);">Belum ada catatan hutang.</p>
        </div>
    @endif
</div>

<style>
    .filter-pill {
        padding: 8px 20px;
        background: rgba(255,255,255,0.03);
        border: 1px solid var(--glass-border);
        border-radius: 100px;
        color: var(--text-muted);
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
        white-space: nowrap;
        transition: all 0.3s;
    }

    .filter-pill:hover, .filter-pill.active {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }
    
    .btn-outline {
        background: transparent;
        border: 1px solid var(--glass-border);
        color: var(--text-main);
    }
    .btn-outline:hover {
        background: rgba(255,255,255,0.05);
    }

    @media (max-width: 640px) {
        .glass-card {
            padding: 16px !important;
        }
        h3 {
            font-size: 1rem !important;
        }
        .btn {
            font-size: 0.9rem !important;
            padding: 10px 16px !important;
        }
        /* Stack buttons on mobile */
        div[style*="display: flex; gap: 10px; margin-top: 15px"] {
            flex-direction: column;
        }
        .btn-icon {
            width: 100% !important;
            border-radius: 12px !important;
            margin-top: 8px;
        }
        .btn-icon i {
            margin-right: 8px;
        }
        .btn-icon::after {
            content: "Hapus";
            font-size: 0.9rem;
            font-weight: 600;
        }
    }
</style>
@endsection
