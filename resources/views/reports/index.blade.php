@extends('layouts.app')

@section('content')
<div style="max-width: 600px; margin: 0 auto; padding-bottom: 40px;">
    <!-- Filter Buttons -->
    <div class="glass-card mb-4" style="display: flex; justify-content: center; gap: 12px; padding: 16px;">
        <a href="{{ route('reports.index', ['type' => 'daily']) }}" class="btn {{ $type == 'daily' ? 'btn-primary' : '' }}" style="background: {{ $type == 'daily' ? 'var(--primary)' : 'rgba(255,255,255,0.05)' }}; border: 1px solid var(--glass-border); color: white; text-decoration: none; padding: 10px 20px;">Harian</a>
        <a href="{{ route('reports.index', ['type' => 'weekly']) }}" class="btn {{ $type == 'weekly' ? 'btn-primary' : '' }}" style="background: {{ $type == 'weekly' ? 'var(--primary)' : 'rgba(255,255,255,0.05)' }}; border: 1px solid var(--glass-border); color: white; text-decoration: none; padding: 10px 20px;">Mingguan</a>
        <a href="{{ route('reports.index', ['type' => 'monthly']) }}" class="btn {{ $type == 'monthly' ? 'btn-primary' : '' }}" style="background: {{ $type == 'monthly' ? 'var(--primary)' : 'rgba(255,255,255,0.05)' }}; border: 1px solid var(--glass-border); color: white; text-decoration: none; padding: 10px 20px;">Bulanan</a>
    </div>

    <!-- Receipt Preview -->
    <div id="receipt-container" style="background: white; color: #1F1D2B; padding: 40px 30px; border-radius: 0; position: relative; font-family: 'Courier New', ms-gothic, monospace; box-shadow: 0 10px 30px rgba(0,0,0,0.5); margin-bottom: 30px;">
        <!-- Texture/Pattern -->
        <div style="text-align: center; border-bottom: 2px dashed #000; padding-bottom: 20px; margin-bottom: 20px;">
            <h2 style="font-size: 1.5rem; font-weight: 900; letter-spacing: 2px; text-transform: uppercase;">Financial Tracker</h2>
            <p style="font-size: 0.8rem; margin-top: 5px;">LAPORAN PENGELUARAN</p>
        </div>

        <div style="margin-bottom: 20px;">
            <div style="display: flex; justify-content: space-between; font-size: 0.9rem; margin-bottom: 5px;">
                <span>PERIODE:</span>
                <span style="font-weight: bold;">{{ strtoupper($type) }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; font-size: 0.9rem; margin-bottom: 5px;">
                <span>TANGGAL:</span>
                <span style="text-align: right;">{{ $subTitle }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; font-size: 0.9rem; border-bottom: 1px dashed #ccc; padding-bottom: 10px; margin-bottom: 10px;">
                <span>CETAK:</span>
                <span style="text-align: right;">{{ now()->setTimezone('Asia/Jakarta')->translatedFormat('d/m/y H:i') }}</span>
            </div>
        </div>

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 0.9rem;">
            <thead>
                <tr style="border-bottom: 1px dashed #000;">
                    <th style="text-align: left; padding: 10px 0;">ITEM</th>
                    <th style="text-align: right; padding: 10px 0;">PRICE</th>
                </tr>
            </thead>
            <tbody>
                @foreach($expenses as $expense)
                <tr>
                    <td style="padding: 8px 0;">
                        <div style="font-weight: bold;">{{ $expense->description }}</div>
                        <div style="font-size: 0.75rem; color: #555;">
                            {{ $expense->date->format('d/m/y') }} <span style="margin-left: 5px; color: #888;">{{ $expense->created_at->format('H:i') }}</span>
                            <span style="font-size: 0.7rem; padding: 2px 4px; border-radius: 4px; background: {{ $expense->type == 'income' ? '#dcfce7' : '#fee2e2' }}; color: {{ $expense->type == 'income' ? '#166534' : '#991b1b' }}; margin-left: 4px;">
                                {{ $expense->type == 'income' ? 'IN' : 'OUT' }}
                            </span>
                        </div>
                    </td>
                    <td style="text-align: right; padding: 8px 0; color: {{ $expense->type == 'income' ? '#166534' : '#991b1b' }};">
                        {{ $expense->type == 'income' ? '+' : '-' }} {{ number_format($expense->amount, 0, ',', '.') }}
                    </td>
                </tr>
                @endforeach
                @if($expenses->isEmpty())
                <tr>
                    <td colspan="2" style="text-align: center; padding: 20px 0; color: #777;">Tidak ada transaksi.</td>
                </tr>
                @endif
            </tbody>
        </table>

        <!-- Totals -->
        <div style="border-top: 2px dashed #000; padding-top: 15px;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-weight: bold; color: #991b1b;">
                <span>TOTAL PENGELUARAN</span>
                <span>- Rp {{ number_format($totalExpense, 0, ',', '.') }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-weight: bold; color: #166534;">
                <span>TOTAL PEMASUKAN</span>
                <span>+ Rp {{ number_format($totalIncome, 0, ',', '.') }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 8px; color: #555; font-size: 0.9rem;">
                <span>Budget (Est)</span>
                <span>Rp {{ number_format($periodBudget, 0, ',', '.') }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; font-size: 1.2rem; font-weight: 900; margin-top: 15px; border-top: 1px dotted #000; padding-top: 15px;">
                <span>SISA SALDO</span>
                <span>Rp {{ number_format($balance, 0, ',', '.') }}</span>
            </div>
        </div>

        <div style="text-align: center; margin-top: 40px; font-size: 0.8rem; color: #555;">
            <p>Jangan Lupa Untuk Berhemat</p>
        </div>

        <!-- Jagged Edge Effect (CSS Trick) -->
        <div style="position: absolute; bottom: -10px; left: 0; width: 100%; height: 10px; background: 
            linear-gradient(45deg, transparent 33.333%, white 33.333%, white 66.667%, transparent 66.667%), 
            linear-gradient(-45deg, transparent 33.333%, white 33.333%, white 66.667%, transparent 66.667%);
            background-size: 20px 20px; background-position: 0 -10px;">
        </div>
    </div>

    <div style="text-align: center;">
        <button onclick="downloadReceipt()" class="btn btn-primary" style="font-size: 1.1rem; padding: 16px 32px;">
            <i class="fas fa-camera" style="margin-right: 10px;"></i> Download Foto Struk
        </button>
    </div>
</div>

<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
<script>
    function downloadReceipt() {
        const receipt = document.getElementById('receipt-container');
        
        html2canvas(receipt, {
            scale: 2, // Higher quality
            backgroundColor: null,
            logging: false
        }).then(canvas => {
            const link = document.createElement('a');
            link.download = 'struk-laporan-{{ $type }}-{{ now()->format("YmdHis") }}.png';
            link.href = canvas.toDataURL('image/png');
            link.click();
        });
    }
</script>
<style>
    @media (max-width: 640px) {
        /* Filter Buttons: Scrollable or Stacked */
        .glass-card[style*="display: flex"] {
            padding: 12px !important;
            gap: 8px !important;
            flex-wrap: wrap; 
        }
        
        .glass-card .btn {
            flex: 1;
            text-align: center;
            font-size: 0.9rem;
            padding: 10px;
        }

        /* Receipt Container */
        #receipt-container {
            padding: 30px 20px !important; /* Reduced padding */
        }

        #receipt-container h2 {
            font-size: 1.2rem !important;
        }
        
        /* Receipt Tables */
        #receipt-container table th, 
        #receipt-container table td {
            font-size: 0.85rem !important;
        }

        /* Totals section */
        #receipt-container div[style*="font-size: 1.2rem"] {
            font-size: 1rem !important;
        }
    }
</style>
@endsection
