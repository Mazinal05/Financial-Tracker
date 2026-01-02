<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Financial Tracker') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            /* Palette: Modern Deep Violet & Vibrant Accents */
            --primary: #8B5CF6; /* Violet-500 */
            --primary-hover: #7C3AED;
            --secondary: #10B981; /* Emerald-500 */
            --accent: #F472B6; /* Pink-400 */
            
            --bg-dark: #0F172A; /* Slate-900 */
            --bg-gradient: radial-gradient(circle at top left, #1e1b4b, #0f172a);
            
            --glass-bg: rgba(255, 255, 255, 0.03);
            --glass-border: rgba(255, 255, 255, 0.08);
            --glass-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3);
            
            --text-main: #F8FAFC;
            --text-muted: #94A3B8;
            
            --success: #34D399;
            --danger: #F87171;
            --warning: #FBBF24;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        body {
            background: var(--bg-dark);
            background-image: var(--bg-gradient);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        /* Subtle animated background shapes */
        body::before {
            content: '';
            position: fixed;
            top: -10%;
            left: -10%;
            width: 50%;
            height: 50%;
            background: radial-gradient(circle, rgba(139, 92, 246, 0.15) 0%, transparent 70%);
            z-index: -1;
            animation: float 20s infinite ease-in-out;
        }
        
        body::after {
            content: '';
            position: fixed;
            bottom: -10%;
            right: -10%;
            width: 50%;
            height: 50%;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.1) 0%, transparent 70%);
            z-index: -1;
            animation: float 25s infinite ease-in-out reverse;
        }

        @keyframes float {
            0% { transform: translate(0, 0); }
            50% { transform: translate(20px, 40px); }
            100% { transform: translate(0, 0); }
        }

        /* Glassmorphism Classes */
        .glass-card {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            padding: 32px;
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            box-shadow: var(--glass-shadow);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .glass-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 40px 0 rgba(0, 0, 0, 0.4);
            border-color: rgba(255,255,255,0.15);
        }

        .glass-nav {
            background: rgba(15, 23, 42, 0.8);
            border-bottom: 1px solid var(--glass-border);
            backdrop-filter: blur(16px);
            position: sticky;
            top: 0;
            z-index: 100;
            padding: 16px 0;
        }

        /* Layout */
        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 24px;
        }

        /* Navbar */
        .nav-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            letter-spacing: -0.5px;
        }
        
        .logo i {
            color: var(--primary);
            font-size: 1.2rem;
        }

        .nav-links {
            display: flex;
            gap: 32px;
            background: rgba(255,255,255,0.03);
            padding: 8px 24px;
            border-radius: 100px;
            border: 1px solid var(--glass-border);
        }

        .nav-link {
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-link:hover, .nav-link.active {
            color: white;
        }
        
        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 50%;
            transform: translateX(-50%);
            width: 4px;
            height: 4px;
            background: var(--primary);
            border-radius: 50%;
        }

        /* Buttons & Forms */
        .btn {
            padding: 14px 28px;
            border-radius: 16px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            font-size: 0.95rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-hover));
            color: white;
            box-shadow: 0 4px 20px rgba(139, 92, 246, 0.4);
        }

        .btn-primary:active {
            transform: scale(0.98);
        }

        .btn-danger {
            background: rgba(248, 113, 113, 0.15);
            color: var(--danger);
            padding: 8px 16px;
            font-size: 0.85rem;
            border-radius: 12px;
        }
        
        .btn-danger:hover {
            background: rgba(248, 113, 113, 0.25);
            color: #fff;
        }

        input, select {
            width: 100%;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--glass-border);
            color: white;
            padding: 16px 20px;
            border-radius: 16px;
            outline: none;
            font-size: 1rem;
            transition: all 0.3s;
        }

        input:focus {
            border-color: var(--primary);
            background: rgba(255, 255, 255, 0.05);
            box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.1);
        }
        
        label {
            display: block;
            color: var(--text-muted);
            margin-bottom: 10px;
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* Utilities */
        .text-success { color: var(--success); }
        .text-danger { color: var(--danger); }
        .text-warning { color: var(--warning); }
        .mt-4 { margin-top: 2rem; }
        .mb-4 { margin-bottom: 2rem; }
        
        /* Mobile Menu */
        .mobile-toggle {
            display: none;
            font-size: 1.5rem;
            color: white;
            cursor: pointer;
        }

        /* Mobile */
        @media (max-width: 768px) {
            .container { padding: 0 16px; } /* Maximize width */
            
            .mobile-toggle { display: block; }
            
            .nav-links {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                width: 100%;
                background: rgba(15, 23, 42, 0.95);
                backdrop-filter: blur(20px);
                flex-direction: column;
                padding: 20px;
                gap: 15px;
                border-bottom: 1px solid var(--glass-border);
                align-items: center;
                border-radius: 0 0 20px 20px;
            }

            .nav-links.active {
                display: flex;
            }

            .nav-link {
                width: 100%;
                text-align: center;
                padding: 14px;
                font-size: 1rem;
                background: rgba(255,255,255,0.05);
                border-radius: 16px;
                margin-bottom: 4px;
            }

            .nav-link.active::after {
                display: none;
            }

            .nav-link.active {
                background: var(--primary);
                color: white;
            }
        }
    </style>
</head>
<body>
    <header class="glass-nav">
        <div class="container">
            <div class="nav-content">
                <a href="{{ route('dashboard') }}" class="logo">
                    <i class="fas fa-wallet"></i> FinancialTracker
                </a>
                
                <div class="mobile-toggle" onclick="toggleMenu()">
                    <i class="fas fa-bars"></i>
                </div>

                <div class="nav-links" id="navLinks">
                    @auth
                        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
                        <a href="{{ route('expenses.create') }}" class="nav-link {{ request()->routeIs('expenses.create') ? 'active' : '' }}" title="Catat Pengeluaran">
                            <i class="fas fa-plus-circle"></i> Catat
                        </a>
                        <a href="{{ route('debts.index') }}" class="nav-link {{ request()->routeIs('debts.*') ? 'active' : '' }}">
                    <i class="fas fa-book" style="margin-right: 8px;"></i> Catatan Hutang
                </a>

                <a href="{{ route('split-bill.index') }}" class="nav-link {{ request()->routeIs('split-bill.*') ? 'active' : '' }}">
                    <i class="fas fa-calculator" style="margin-right: 8px;"></i> Split Bill
                </a>
                
                <a href="{{ route('reports.index') }}" class="nav-link {{ request()->routeIs('reports.index') ? 'active' : '' }}" title="Laporan">
                            <i class="fas fa-file-invoice"></i> Laporan
                        </a>
                        
                        @if(auth()->check() && auth()->user()->role === 'admin')
                        <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}" style="color: #c4b5fd;">
                            <i class="fas fa-user-shield"></i> Admin
                        </a>
                        @endif
                
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="nav-link" style="background: none; border: none; font-size: 1rem; cursor: pointer; color: var(--danger);">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}">Masuk</a>
                        <a href="{{ route('register') }}" class="nav-link {{ request()->routeIs('register') ? 'active' : '' }}">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <main class="container mt-4">
        @if(session('success'))
            <div class="glass-card mb-4" style="border-left: 4px solid var(--success);">
                <p class="text-success">{{ session('success') }}</p>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="container" style="margin-top: auto; padding: 40px 0; text-align: center; color: var(--text-secondary);">
        <p>&copy; 2026 Financial Tracker.</p>
    </footer>

    <script>
        function toggleMenu() {
            const nav = document.getElementById('navLinks');
            nav.classList.toggle('active');
        }
    </script>
</body>
</html>
