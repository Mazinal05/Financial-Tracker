<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Financial Tracker') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #8B5CF6;
            --secondary: #10B981;
            --bg-dark: #0F172A;
            --text-main: #F8FAFC;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }

        body {
            background: var(--bg-dark);
            color: var(--text-main);
            height: 100vh;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        /* Animated Background */
        .bg-glow {
            position: absolute;
            width: 60vw;
            height: 60vw;
            background: radial-gradient(circle, rgba(139, 92, 246, 0.2) 0%, transparent 70%);
            border-radius: 50%;
            top: -20%;
            left: -20%;
            animation: pulse 10s infinite alternate;
            z-index: -1;
        }

        .bg-glow-2 {
            position: absolute;
            width: 50vw;
            height: 50vw;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.15) 0%, transparent 70%);
            border-radius: 50%;
            bottom: -10%;
            right: -10%;
            animation: pulse 12s infinite alternate-reverse;
            z-index: -1;
        }

        @keyframes pulse {
            0% { transform: scale(1); opacity: 0.5; }
            100% { transform: scale(1.2); opacity: 0.8; }
        }

        /* Content */
        .container {
            text-align: center;
            padding: 24px;
            max-width: 600px;
            z-index: 10;
        }

        .icon-wrapper {
            font-size: 4rem;
            margin-bottom: 24px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            opacity: 0;
            transform: translateY(30px) scale(0.8);
            animation: fadeInUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards 0.2s;
        }

        h1 {
            font-size: 3.5rem;
            font-weight: 800;
            letter-spacing: -2px;
            line-height: 1.1;
            margin-bottom: 16px;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards 0.4s;
        }

        p {
            font-size: 1.1rem;
            color: #94A3B8;
            margin-bottom: 40px;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards 0.6s;
        }

        .btn-start {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            background: white;
            color: var(--bg-dark);
            padding: 16px 40px;
            border-radius: 100px;
            font-weight: 700;
            font-size: 1.1rem;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.1);
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards 0.8s;
        }

        .btn-start:hover {
            transform: translateY(-5px) scale(1.05); /* Combined hover effect */
            box-shadow: 0 10px 30px rgba(255, 255, 255, 0.3);
        }

        .btn-start i {
            transition: transform 0.3s ease;
        }

        .btn-start:hover i {
            transform: translateX(5px);
        }

        /* Animations */
        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            h1 { font-size: 2.5rem; }
            p { font-size: 1rem; }
            .btn-start { padding: 14px 32px; font-size: 1rem; }
        }
    </style>
</head>
<body>
    <!-- Background Elements -->
    <div class="bg-glow"></div>
    <div class="bg-glow-2"></div>

    <div class="container">
        <div class="icon-wrapper">
            <i class="fas fa-wallet"></i>
        </div>
        
        <h1>Financial<br>Tracker</h1>
        <p>Kelola keuangan Anda dengan elegan.<br>Hemat pangkal kaya.</p>
        
        <a href="{{ route('dashboard') }}" class="btn-start">
            Mulai Sekarang <i class="fas fa-arrow-right"></i>
        </a>
    </div>
</body>
</html>
