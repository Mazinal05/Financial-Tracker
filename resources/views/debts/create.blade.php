@extends('layouts.app')

@section('content')
<div style="max-width: 600px; margin: 0 auto;">
    
    <div style="margin-bottom: 20px;">
        <a href="{{ route('debts.index') }}" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem; display: inline-flex; align-items: center;">
            <i class="fas fa-arrow-left" style="margin-right: 8px;"></i> Kembali
        </a>
        <h1 style="font-size: 1.8rem; font-weight: 700; margin-top: 10px;">Catat Hutang Baru</h1>
    </div>

    <div class="glass-card" style="padding: 24px;">
        <form action="{{ route('debts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group mb-4">
                <label style="display: block; margin-bottom: 8px; color: var(--text-secondary); font-weight: 500;">Nama Peminjam</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="text" name="name" class="form-control" placeholder="Siapa yang berhutang?" required>
                </div>
            </div>

            <div class="form-group mb-4">
                <label style="display: block; margin-bottom: 8px; color: var(--text-secondary); font-weight: 500;">Nominal (Rp)</label>
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="number" name="amount" class="form-control" placeholder="0" min="0" required>
                </div>
            </div>

            <div class="form-group mb-4">
                <label style="display: block; margin-bottom: 8px; color: var(--text-secondary); font-weight: 500;">Deskripsi / Catatan</label>
                <textarea name="description" class="form-control" rows="3" placeholder="Contoh: Utang beli makan siang"></textarea>
            </div>

            <div class="form-group mb-4">
                <label style="display: block; margin-bottom: 8px; color: var(--text-secondary); font-weight: 500;">Jatuh Tempo (Opsional)</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                    <input type="date" name="due_date" class="form-control">
                </div>
            </div>

            <div class="form-group mb-4">
                <label style="display: block; margin-bottom: 8px; color: var(--text-secondary); font-weight: 500;">Bukti / Struk (Opsional)</label>
                <div style="position: relative; overflow: hidden; display: inline-block; width: 100%;">
                    <input type="file" name="image" id="fileInput" class="form-control" accept="image/*" style="opacity: 0; position: absolute; z-index: -1;">
                    <label for="fileInput" style="display: flex; align-items: center; justify-content: center; width: 100%; padding: 12px; border: 1px dashed var(--glass-border); border-radius: 12px; cursor: pointer; color: var(--text-muted); background: rgba(255,255,255,0.02); transition: all 0.2s;">
                        <i class="fas fa-cloud-upload-alt" style="margin-right: 8px;"></i> <span id="fileName">Upload Foto Struk</span>
                    </label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 14px; font-size: 1rem;">
                Simpan Catatan
            </button>
        </form>
    </div>
</div>

<style>
    .form-group label {
        color: var(--text-muted);
    }
    .input-group {
        display: flex;
        align-items: center;
        background: rgba(255,255,255,0.05);
        border: 1px solid var(--glass-border);
        border-radius: 12px;
        overflow: hidden;
        transition: border-color 0.2s;
    }
    .input-group:focus-within {
        border-color: var(--primary);
        box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.2);
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
    .form-control::placeholder {
        color: rgba(255,255,255,0.3);
    }
</style>

<script>
    document.getElementById('fileInput').addEventListener('change', function(e) {
        var fileName = e.target.files[0].name;
        document.getElementById('fileName').innerText = fileName;
    });
</script>
@endsection
