@extends('layouts.app')

@section('content')
<div style="max-width: 900px; margin: 0 auto;">
    
    <div style="margin-bottom: 24px;">
        <h1 style="font-size: 1.5rem; font-weight: 700;">Split Bill Calculator</h1>
        <p style="color: var(--text-muted);">Hitung pembagian tagihan dengan mudah termasuk pajak & layanan.</p>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; align-items: start;">
        
        <!-- Input Form -->
        <div class="glass-card" style="padding: 24px;">
            <h3 style="margin-bottom: 20px; font-size: 1.1rem; border-bottom: 1px solid var(--glass-border); padding-bottom: 10px;">
                <i class="fas fa-calculator" style="margin-right: 8px; color: var(--primary);"></i> Masukan Data
            </h3>

            <!-- Bill Details -->
            <div class="form-group mb-4">
                <label>Total Tagihan (Subtotal)</label>
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="number" id="subtotal" class="form-control" placeholder="0" oninput="calculate()">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 24px;">
                <div class="form-group">
                    <label>Pajak / Tax (Rp)</label>
                    <div class="input-group">
                        <span class="input-group-text" style="border-right: none; border-left: 1px solid var(--glass-border); border-radius: 12px 0 0 12px;">Rp</span>
                        <input type="number" id="tax" class="form-control" placeholder="0" value="0" oninput="calculate()">
                    </div>
                </div>
                <div class="form-group">
                    <label>Layanan / Service (Rp)</label>
                    <div class="input-group">
                        <span class="input-group-text" style="border-right: none; border-left: 1px solid var(--glass-border); border-radius: 12px 0 0 12px;">Rp</span>
                        <input type="number" id="service" class="form-control" placeholder="0" value="0" oninput="calculate()">
                    </div>
                </div>
            </div>

            <!-- People -->
            <div class="form-group mb-4">
                <label style="display: flex; justify-content: space-between; align-items: center;">
                    Daftar Teman
                    <button type="button" onclick="addPerson()" class="btn btn-sm btn-outline" style="padding: 4px 10px; font-size: 0.8rem;">
                        <i class="fas fa-plus"></i> Tambah
                    </button>
                </label>
                <div id="people-container" style="display: flex; flex-direction: column; gap: 10px; margin-top: 10px;">
                    <!-- JS will populate this -->
                </div>
                <div style="margin-top: 10px; font-size: 0.8rem; color: var(--text-muted);">
                    * Masukkan nominal (harga menu) untuk setiap orang. Pajak akan dibagi proporsional.
                </div>
            </div>

        </div>

        <!-- Result / Preview -->
        <div class="glass-card" style="padding: 24px; position: sticky; top: 100px;">
            <h3 style="margin-bottom: 20px; font-size: 1.1rem; border-bottom: 1px solid var(--glass-border); padding-bottom: 10px;">
                <i class="fas fa-receipt" style="margin-right: 8px; color: var(--success);"></i> Hasil Perhitungan
            </h3>

            <div style="margin-bottom: 20px;">
                <div class="summary-row">
                    <span>Subtotal</span>
                    <span id="display-subtotal">Rp 0</span>
                </div>
                <div class="summary-row text-muted" style="font-size: 0.9rem;">
                    <span>Tax + Service</span>
                    <span id="display-fees">Rp 0</span>
                </div>
                <div class="summary-row total">
                    <span>Grand Total</span>
                    <span id="display-total" style="color: var(--primary);">Rp 0</span>
                </div>
            </div>

            <form action="{{ route('split-bill.store') }}" method="POST" id="saveForm">
                @csrf
                <input type="hidden" name="description" id="bill-desc" value="Split Bill">
                
                <div id="results-list" style="margin-bottom: 24px; max-height: 300px; overflow-y: auto;">
                    <!-- Results go here -->
                </div>

                <div class="form-group mb-3">
                    <label>Judul Catatan (Opsional)</label>
                    <input type="text" name="description" class="form-control" value="Makan Bersama" placeholder="cth: Makan Siang di Kokas">
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">
                    <i class="fas fa-save" style="margin-right: 8px;"></i> Simpan ke Hutang
                </button>
            </form>
        </div>

    </div>
</div>

<template id="person-template">
    <div class="person-row input-group">
        <input type="text" class="form-control person-name" placeholder="Nama" required>
        <span class="input-group-text" style="background: transparent; border: none; font-size: 0.9rem; color: var(--text-muted);">Rp</span>
        <input type="number" class="form-control person-amount" placeholder="Menu" oninput="calculate()">
        <button type="button" class="btn-remove" onclick="removePerson(this)">
            <i class="fas fa-times"></i>
        </button>
    </div>
</template>

<style>
    .input-group {
        display: flex;
        align-items: center;
        background: rgba(255,255,255,0.05);
        border: 1px solid var(--glass-border);
        border-radius: 12px;
        overflow: hidden;
    }
    .input-group-text {
        padding: 12px 16px;
        color: var(--text-muted);
        background: rgba(0,0,0,0.1);
        border-right: 1px solid var(--glass-border);
    }
    .form-control {
        width: 100%;
        background: transparent;
        border: none;
        color: white;
        padding: 12px 16px;
        outline: none;
        font-size: 1rem;
    }
    .btn-remove {
        background: none;
        border: none;
        color: var(--danger);
        padding: 0 16px;
        cursor: pointer;
        opacity: 0.6;
    }
    .btn-remove:hover { opacity: 1; }
    
    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
        color: var(--text-secondary);
    }
    .summary-row.total {
        font-weight: 700;
        font-size: 1.2rem;
        color: white;
        margin-top: 12px;
        padding-top: 12px;
        border-top: 1px dashed var(--glass-border);
    }

    .result-item {
        display: flex;
        justify-content: space-between;
        padding: 10px;
        background: rgba(255,255,255,0.03);
        border-radius: 8px;
        margin-bottom: 8px;
        font-size: 0.95rem;
    }

    @media (max-width: 768px) {
        div[style*="grid-template-columns: 1fr 1fr"] {
            grid-template-columns: 1fr !important;
        }
        .glass-card[style*="position: sticky"] {
            position: static !important;
        }
    }
</style>

<script>
    let peopleCount = 0;

    function formatRupiah(amount) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(amount);
    }

    function addPerson() {
        peopleCount++;
        const container = document.getElementById('people-container');
        const template = document.getElementById('person-template');
        const clone = template.content.cloneNode(true);
        
        container.appendChild(clone);
        calculate();
    }

    function removePerson(btn) {
        btn.closest('.person-row').remove();
        calculate();
    }

    function calculate() {
        const subtotal = parseFloat(document.getElementById('subtotal').value) || 0;
        const taxNominal = parseFloat(document.getElementById('tax').value) || 0;
        const serviceNominal = parseFloat(document.getElementById('service').value) || 0;

        // Total Fees (Nominal)
        const totalFees = taxNominal + serviceNominal;
        const grandTotal = subtotal + totalFees;
        
        // Fee Ratio for proportional distribution
        // If subtotal is 0, avoid division by zero
        const feeRatio = subtotal > 0 ? (totalFees / subtotal) : 0;

        // Display Totals
        document.getElementById('display-subtotal').innerText = formatRupiah(subtotal);
        document.getElementById('display-fees').innerText = formatRupiah(totalFees);
        document.getElementById('display-total').innerText = formatRupiah(grandTotal);

        // Distribute
        const personRows = document.querySelectorAll('.person-row');
        const resultsList = document.getElementById('results-list');
        resultsList.innerHTML = ''; // Clear results

        let manualTotal = 0;
        let manualCount = 0;
        let autoCount = 0;

        // First pass: check manual inputs
        personRows.forEach(row => {
            const amountInput = row.querySelector('.person-amount').value;
            if (amountInput) {
                manualTotal += parseFloat(amountInput);
                manualCount++;
            } else {
                autoCount++;
            }
        });

        // Remaining subtotal to be split evenly among those with empty inputs
        const remainingSubtotal = Math.max(0, subtotal - manualTotal);
        const autoShare = autoCount > 0 ? remainingSubtotal / autoCount : 0;

        // Generate Results & Inputs for Form
        personRows.forEach((row, index) => {
            const name = row.querySelector('.person-name').value || `Teman ${index + 1}`;
            const amountInput = row.querySelector('.person-amount').value;
            
            // Base Amount (Menu Price)
            let userBaseAmount = amountInput ? parseFloat(amountInput) : autoShare;
            
            // Apply proportional fees
            let userTotal = userBaseAmount + (userBaseAmount * feeRatio);

            // Create UI Result Element
            const div = document.createElement('div');
            div.className = 'result-item';
            div.innerHTML = `
                <span>${name}</span>
                <span class="text-success" style="font-weight: 600;">${formatRupiah(userTotal)}</span>
            `;
            resultsList.appendChild(div);

            // Create Hidden Input for Form Submission
            const inputName = document.createElement('input');
            inputName.type = 'hidden';
            inputName.name = `items[${index}][name]`;
            inputName.value = name;
            resultsList.appendChild(inputName);

            const inputAmount = document.createElement('input');
            inputAmount.type = 'hidden';
            inputAmount.name = `items[${index}][amount]`;
            inputAmount.value = userTotal; 
            resultsList.appendChild(inputAmount);
        });
    }

    // Initialize with 2 people
    window.onload = function() {
        addPerson();
        addPerson();
    };
</script>
@endsection
