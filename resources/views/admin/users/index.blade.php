@extends('layouts.app')

@section('content')
<div style="max-width: 1000px; margin: 0 auto;">
    
    <!-- Header & Stats -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
        <div class="glass-card" style="padding: 20px; text-align: center;">
            <div style="font-size: 2rem; font-weight: 700; color: white;">{{ $totalUsers }}</div>
            <div style="color: var(--text-muted); font-size: 0.9rem;">Total User</div>
        </div>
        <div class="glass-card" style="padding: 20px; text-align: center;">
            <div style="font-size: 2rem; font-weight: 700; color: #6ee7b7;">{{ $activeUsers }}</div>
            <div style="color: var(--text-muted); font-size: 0.9rem;">Aktif</div>
        </div>
        <div class="glass-card" style="padding: 20px; text-align: center;">
            <div style="font-size: 2rem; font-weight: 700; color: #fbbf24;">{{ $suspendedUsers }}</div>
            <div style="color: var(--text-muted); font-size: 0.9rem;">Suspended</div>
        </div>
        <div class="glass-card" style="padding: 20px; text-align: center;">
            <div style="font-size: 2rem; font-weight: 700; color: #fca5a5;">{{ $bannedUsers }}</div>
            <div style="color: var(--text-muted); font-size: 0.9rem;">Banned</div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert" style="background: rgba(16, 185, 129, 0.2); color: #6ee7b7; padding: 12px 20px; border-radius: 12px; margin-bottom: 24px; border: 1px solid rgba(16, 185, 129, 0.3);">
            <i class="fas fa-check-circle" style="margin-right: 8px;"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert" style="background: rgba(239, 68, 68, 0.2); color: #fca5a5; padding: 12px 20px; border-radius: 12px; margin-bottom: 24px; border: 1px solid rgba(239, 68, 68, 0.3);">
            <i class="fas fa-exclamation-circle" style="margin-right: 8px;"></i> {{ session('error') }}
        </div>
    @endif

    <!-- Search & Filters -->
    <div class="glass-card" style="padding: 20px; margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
        <div>
            <h2 style="font-size: 1.2rem; margin: 0;">Daftar Pengguna</h2>
        </div>
        <form action="{{ route('admin.users.index') }}" method="GET" style="display: flex; gap: 10px; width: 100%; max-width: 400px;">
            <div style="position: relative; flex: 1;">
                <i class="fas fa-search" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..." 
                    style="width: 100%; padding: 10px 10px 10px 40px; background: rgba(255,255,255,0.05); border: 1px solid var(--glass-border); border-radius: 10px; color: white; outline: none;">
            </div>
            <button type="submit" class="btn btn-primary" style="padding: 0 20px;">Cari</button>
        </form>
    </div>

    <!-- User Table -->
    <div class="glass-card" style="border-radius: 20px; overflow: hidden; margin-bottom: 20px;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; min-width: 600px;">
                <thead>
                    <tr style="border-bottom: 1px solid var(--glass-border);">
                        <th style="text-align: left; padding: 16px 20px; color: var(--text-muted); font-weight: 600; font-size: 0.9rem;">User</th>
                        <th style="text-align: left; padding: 16px 20px; color: var(--text-muted); font-weight: 600; font-size: 0.9rem;">Email</th>
                        <th style="text-align: left; padding: 16px 20px; color: var(--text-muted); font-weight: 600; font-size: 0.9rem;">Role</th>
                        <th style="text-align: left; padding: 16px 20px; color: var(--text-muted); font-weight: 600; font-size: 0.9rem;">Status</th>
                        <th style="text-align: right; padding: 16px 20px; color: var(--text-muted); font-weight: 600; font-size: 0.9rem;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.03); transition: background 0.2s;">
                        <td style="padding: 16px 20px;">
                            <div style="font-weight: 600;">{{ $user->name }}</div>
                            <div style="font-size: 0.8rem; color: var(--text-muted);">ID: #{{ $user->id }}</div>
                        </td>
                        <td style="padding: 16px 20px; color: var(--text-secondary);">{{ $user->email }}</td>
                        <td style="padding: 16px 20px;">
                            <span style="padding: 4px 10px; border-radius: 100px; font-size: 0.75rem; font-weight: 600; background: {{ $user->role == 'admin' ? 'rgba(139, 92, 246, 0.2)' : 'rgba(255,255,255,0.05)' }}; color: {{ $user->role == 'admin' ? '#c4b5fd' : 'var(--text-muted)' }}; border: 1px solid {{ $user->role == 'admin' ? 'rgba(139, 92, 246, 0.3)' : 'var(--glass-border)' }};">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td style="padding: 16px 20px;">
                            @if($user->is_banned)
                                <span style="padding: 4px 10px; border-radius: 100px; font-size: 0.75rem; font-weight: 600; background: rgba(239, 68, 68, 0.2); color: #fca5a5; border: 1px solid rgba(239, 68, 68, 0.3);">
                                    Banned
                                </span>
                            @elseif($user->suspended_until && $user->suspended_until->isFuture())
                                <span style="padding: 4px 10px; border-radius: 100px; font-size: 0.75rem; font-weight: 600; background: rgba(245, 158, 11, 0.2); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.3);">
                                    Suspended ({{ (int) ceil(now()->floatDiffInDays($user->suspended_until)) }} hari)
                                </span>
                            @else
                                <span style="padding: 4px 10px; border-radius: 100px; font-size: 0.75rem; font-weight: 600; background: rgba(16, 185, 129, 0.2); color: #6ee7b7; border: 1px solid rgba(16, 185, 129, 0.3);">
                                    Active
                                </span>
                            @endif
                        </td>
                        <td style="padding: 16px 20px; text-align: right;">
                            @if($user->id !== auth()->id())
                                <button onclick="openActionModal('{{ $user->id }}', '{{ $user->name }}')" class="btn-icon" style="background: none; border: none; cursor: pointer; color: var(--warning); margin-right: 8px;" title="Kelola Status">
                                    <i class="fas fa-gavel" style="font-size: 1.1rem;"></i>
                                </button>
                                
                                @if($user->is_banned || ($user->suspended_until && $user->suspended_until->isFuture()))
                                    <form action="{{ route('admin.users.suspend', $user) }}" method="POST" style="display: inline-block; margin-right: 8px;">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="action" value="activate">
                                        <button type="submit" class="btn-icon" style="background: none; border: none; cursor: pointer; color: var(--success);" title="Hapus Suspend / Aktifkan">
                                            <i class="fas fa-play" style="font-size: 1.1rem;"></i>
                                        </button>
                                    </form>
                                @endif
                                
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-icon" style="background: none; border: none; cursor: pointer; color: var(--danger);" title="Hapus User" onclick="return confirm('Yakin ingin menghapus user ini secara permanen?')">
                                        <i class="fas fa-trash-alt" style="font-size: 1.1rem;"></i>
                                    </button>
                                </form>
                            @else
                                <span style="font-size: 0.8rem; color: var(--text-muted); font-style: italic;">Anda</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding: 40px; text-align: center; color: var(--text-muted);">
                            <i class="fas fa-search" style="font-size: 2rem; margin-bottom: 10px; display: block; opacity: 0.5;"></i>
                            Tidak ada user ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Pagination -->
    <div style="display: flex; justify-content: flex-end;">
        {{ $users->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
</div>
    <!-- Action Modal -->
    <div id="actionModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); backdrop-filter: blur(5px); z-index: 1000; align-items: center; justify-content: center;">
        <div class="glass-card" style="width: 100%; max-width: 400px; padding: 30px; position: relative;">
            <button onclick="closeActionModal()" style="position: absolute; top: 20px; right: 20px; background: none; border: none; color: var(--text-muted); cursor: pointer; font-size: 1.2rem;">
                <i class="fas fa-times"></i>
            </button>
            
            <h3 style="margin-bottom: 20px; font-size: 1.2rem;">Kelola Status User: <span id="modalUserName" style="color: var(--primary);"></span></h3>
            
            <form id="actionForm" method="POST">
                @csrf
                @method('PATCH')
                
                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: var(--text-secondary);">Tindakan</label>
                    <select name="action" id="actionSelect" onchange="toggleDaysInput()" style="width: 100%; padding: 12px; background: rgba(255,255,255,0.05); border: 1px solid var(--glass-border); border-radius: 12px; color: white; outline: none;">
                        <option value="activate" style="background: #1e1e2d; color: white;">Aktifkan Kembali</option>
                        <option value="suspend_days" style="background: #1e1e2d; color: white;">Suspend Sementara</option>
                        <option value="ban" style="background: #1e1e2d; color: white;">Blokir Permanen</option>
                    </select>
                </div>

                <div id="daysInputGroup" style="margin-bottom: 24px; display: none;">
                    <label style="display: block; margin-bottom: 8px; color: var(--text-secondary);">Durasi Suspend (Hari)</label>
                    <input type="number" name="days" min="1" placeholder="Contoh: 7" style="width: 100%; padding: 12px; background: rgba(255,255,255,0.05); border: 1px solid var(--glass-border); border-radius: 12px; color: white; outline: none;">
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</div>

<script>
    function openActionModal(userId, userName) {
        document.getElementById('actionModal').style.display = 'flex';
        document.getElementById('modalUserName').innerText = userName;
        document.getElementById('actionForm').action = "/admin/users/" + userId + "/suspend";
        document.getElementById('actionSelect').value = 'suspend_days'; // Default
        toggleDaysInput();
    }

    function closeActionModal() {
        document.getElementById('actionModal').style.display = 'none';
    }

    function toggleDaysInput() {
        const action = document.getElementById('actionSelect').value;
        const daysGroup = document.getElementById('daysInputGroup');
        if (action === 'suspend_days') {
            daysGroup.style.display = 'block';
        } else {
            daysGroup.style.display = 'none';
        }
    }

    // Close on click outside
    document.getElementById('actionModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeActionModal();
        }
    });
</script>
@endsection
