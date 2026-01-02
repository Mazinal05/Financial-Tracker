@extends('layouts.app')

@section('content')
<div style="max-width: 500px; margin: 0 auto; padding-top: 40px;">
    
    <div style="margin-bottom: 20px;">
        <a href="{{ route('dashboard') }}" style="text-decoration: none; color: var(--text-muted); display: inline-flex; align-items: center; gap: 8px; transition: color 0.3s;">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>

    <div class="glass-card" style="padding: 40px; animation: slideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1);">
        <h1 style="font-size: 1.75rem; font-weight: 700; margin-bottom: 8px; text-align: center;">Catat Pengeluaran</h1>
        <p style="text-align: center; color: var(--text-muted); margin-bottom: 32px;">Apa yang Anda beli hari ini?</p>

        <form action="{{ route('expenses.store') }}" method="POST">
            @csrf
            
            <!-- Type Toggle -->
            <div style="margin-bottom: 24px; display: flex; background: rgba(255,255,255,0.05); border-radius: 12px; padding: 4px; border: 1px solid var(--glass-border);">
                <input type="radio" name="type" id="type_expense" value="expense" checked style="display: none;">
                <label for="type_expense" id="label_expense" style="flex: 1; text-align: center; padding: 10px; border-radius: 8px; cursor: pointer; transition: all 0.3s; color: white; margin: 0; background: var(--danger);">
                    Pengeluaran
                </label>
                
                <input type="radio" name="type" id="type_income" value="income" style="display: none;">
                <label for="type_income" id="label_income" style="flex: 1; text-align: center; padding: 10px; border-radius: 8px; cursor: pointer; transition: all 0.3s; color: var(--text-muted); margin: 0;">
                    Pemasukan
                </label>
            </div>

            <div style="margin-bottom: 24px;">
                <label style="display: block; margin-bottom: 8px; color: var(--text-secondary);">Nominal (Rp)</label>
                <div style="position: relative;">
                    <span style="position: absolute; left: 20px; top: 50%; transform: translateY(-50%); font-size: 1.2rem; color: var(--primary); font-weight: bold;">Rp</span>
                    <input type="number" name="amount" placeholder="0" min="0" required autofocus
                        style="padding-left: 55px; font-size: 1.5rem; font-weight: 700; color: var(--text-main); height: 60px;">
                </div>
            </div>

            <div style="margin-bottom: 24px;">
                <label>Deskripsi</label>
                <input type="text" name="description" placeholder="Contoh: Makan Siang, Bensin..." required
                    style="height: 50px;">
            </div>

            <div style="margin-bottom: 32px;">
                <label>Tanggal</label>
                <input type="date" name="date" value="{{ \Carbon\Carbon::now()->setTimezone('Asia/Jakarta')->format('Y-m-d') }}" required
                    style="height: 50px;">
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 16px; font-size: 1.1rem; justify-content: center;">
                <i class="fas fa-check"></i> Simpan Transaksi
            </button>
        </form>
    </div>
</div>

<style>
    @keyframes slideUp {
        from { transform: translateY(20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
</style>

<script>
    const typeExpense = document.getElementById('type_expense');
    const typeIncome = document.getElementById('type_income');
    const labelExpense = document.getElementById('label_expense');
    const labelIncome = document.getElementById('label_income');

    function updateToggle() {
        if(typeExpense.checked) {
            labelExpense.style.background = 'var(--danger)';
            labelExpense.style.color = 'white';
            labelIncome.style.background = 'transparent';
            labelIncome.style.color = 'var(--text-muted)';
        } else {
            labelIncome.style.background = 'var(--success)';
            labelIncome.style.color = 'white';
            labelExpense.style.background = 'transparent';
            labelExpense.style.color = 'var(--text-muted)';
        }
    }

    typeExpense.addEventListener('change', updateToggle);
    typeIncome.addEventListener('change', updateToggle);
</script>
@endsection
