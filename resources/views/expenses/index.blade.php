@extends('layouts.app')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    
    <!-- Stats Overview (Responsive Grid) -->
    <div class="glass-card mb-4" style="padding: 20px; border-radius: 20px;">
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; text-align: center;">
            <div style="position: relative;">
                <div style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 4px;">Pemasukan</div>
                <div style="font-size: 0.95rem; font-weight: 700; color: var(--success); overflow: hidden; text-overflow: ellipsis;">
                    +{{ number_format($totalIncome, 0, ',', '.') }}
                </div>
                <div style="position: absolute; right: 0; top: 10%; height: 80%; width: 1px; background: var(--glass-border);"></div>
            </div>
            <div style="position: relative;">
                <div style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 4px;">Pengeluaran</div>
                <div style="font-size: 0.95rem; font-weight: 700; color: var(--danger); overflow: hidden; text-overflow: ellipsis;">
                    -{{ number_format($totalExpense, 0, ',', '.') }}
                </div>
                <div style="position: absolute; right: 0; top: 10%; height: 80%; width: 1px; background: var(--glass-border);"></div>
            </div>
            <div>
                <div style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 4px;">Netto</div>
                <div style="font-size: 0.95rem; font-weight: 700; color: {{ $totalBalance >= 0 ? 'var(--text-main)' : 'var(--danger)' }}; overflow: hidden; text-overflow: ellipsis;">
                    {{ number_format($totalBalance, 0, ',', '.') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Sticky Filters -->
    <div style="position: sticky; top: 0; z-index: 50; background: rgba(13, 13, 17, 0.95); backdrop-filter: blur(10px); margin: 0 -20px 20px -20px; padding: 15px 20px; border-bottom: 1px solid var(--glass-border);">
        <div class="filter-scroll" style="display: flex; gap: 10px; overflow-x: auto; -webkit-overflow-scrolling: touch; padding-bottom: 2px;">
            <a href="{{ route('expenses.index') }}" class="filter-pill {{ !request('filter') ? 'active' : '' }}">
                Semua
            </a>
            <a href="{{ route('expenses.index', ['filter' => 'week']) }}" class="filter-pill {{ request('filter') == 'week' ? 'active' : '' }}">
                Minggu Ini
            </a>
            <a href="{{ route('expenses.index', ['filter' => 'month']) }}" class="filter-pill {{ request('filter') == 'month' ? 'active' : '' }}">
                Bulan Ini
            </a>
            <a href="{{ route('expenses.index', ['filter' => 'year']) }}" class="filter-pill {{ request('filter') == 'year' ? 'active' : '' }}">
                Tahun Ini
            </a>
        </div>
    </div>

    @if($expenses->count() > 0)
        <div style="display: flex; flex-direction: column; gap: 16px; padding-bottom: 40px;">
            @php
                $currentDate = null;
            @endphp

            @foreach($expenses as $expense)
                @php
                    $expenseDate = $expense->date->format('Y-m-d');
                    $isNewDate = $currentDate !== $expenseDate;
                    
                    if ($isNewDate) {
                        $currentDate = $expenseDate;
                        $displayDate = $expense->date->isToday() ? 'Hari Ini' : 
                                      ($expense->date->isYesterday() ? 'Kemarin' : $expense->date->translatedFormat('l, d F Y'));
                    }
                @endphp

                @if($isNewDate)
                    <!-- Date Header -->
                    <div style="font-size: 0.85rem; font-weight: 600; color: var(--text-muted); margin-top: 8px; margin-bottom: 4px; padding-left: 4px;">
                        {{ $displayDate }}
                    </div>
                @endif

                <!-- Expense Item -->
                <div class="glass-card expense-item" style="padding: 16px; border-radius: 16px; display: flex; justify-content: space-between; align-items: center; transition: all 0.2s;">
                    <div style="display: flex; align-items: center; gap: 14px;">
                        <!-- Icon -->
                        <div style="width: 42px; height: 42px; min-width: 42px; border-radius: 12px; background: rgba(255,255,255,0.03); display: flex; align-items: center; justify-content: center; font-size: 1.1rem; color: {{ $expense->type == 'income' ? 'var(--success)' : 'var(--text-muted)' }}; border: 1px solid rgba(255,255,255,0.03);">
                            <i class="fas {{ $expense->type == 'income' ? 'fa-arrow-down' : 'fa-shopping-bag' }}"></i>
                        </div>
                        
                        <div style="overflow: hidden;">
                            <h4 style="font-weight: 500; font-size: 0.95rem; margin-bottom: 3px; color: var(--text-main); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 15rem;">{{ $expense->description }}</h4>
                            <div style="font-size: 0.75rem; color: var(--text-muted);">
                                {{ optional($expense->created_at)->timezone('Asia/Jakarta')?->format('H:i') ?? '00:00' }} • {{ $expense->type == 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                            </div>
                        </div>
                    </div>

                    <div style="text-align: right; margin-left: 10px;">
                        <div style="font-weight: 600; color: {{ $expense->type == 'income' ? 'var(--success)' : 'var(--text-main)' }}; font-size: 0.95rem;">
                            {{ $expense->type == 'income' ? '+' : '-' }} {{ number_format($expense->amount, 0, ',', '.') }}
                        </div>
                        
                        <form action="{{ route('expenses.destroy', $expense) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Hapus?')" style="background: none; border: none; font-size: 0.7rem; color: var(--danger); cursor: pointer; opacity: 0.7; padding: 4px; margin-top: 2px;" class="delete-btn">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div style="text-align: center; padding: 60px 20px;">
            <div style="width: 60px; height: 60px; background: rgba(255,255,255,0.05); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                <i class="fas fa-search" style="font-size: 1.5rem; color: var(--text-muted); opacity: 0.5;"></i>
            </div>
            <p style="color: var(--text-muted);">Tidak ada transaksi ditemukan.</p>
        </div>
    @endif
</div>

<style>
    /* Filter Pills */
    .filter-pill {
        padding: 6px 16px;
        background: rgba(255,255,255,0.03);
        border: 1px solid var(--glass-border);
        border-radius: 100px;
        color: var(--text-muted);
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 500;
        white-space: nowrap;
        transition: all 0.3s;
    }

    .filter-pill:hover, .filter-pill.active {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }

    /* Interaction */
    .expense-item:hover {
        transform: scale(1.01);
        background: rgba(255,255,255,0.05);
    }
    
    /* .expense-item:hover .delete-btn { opacity: 0.7 !important; }  Removed per request */

    /* Mobile Improvements */
    @media (max-width: 640px) {
        .expense-item h4 {
            max-width: 140px;
        }
    }

    .filter-scroll::-webkit-scrollbar {
        display: none;
    }
</style>
@endsection
