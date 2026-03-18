<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | ATHLETIQ</title>
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 280px;
            --accent: #32FF7E;
            --accent-glow: rgba(50, 255, 126, 0.3);
            --bg-color: #ffffff;
            --bg-secondary: #f9f9f9;
            --card-bg: #ffffff;
            --text-primary: #111111;
            --text-secondary: #444444;
            --text-muted: #888888;
        }
        body.dark-mode {
            --bg-color: #0c0c0c;
            --bg-secondary: #141414;
            --card-bg: #1a1a1a;
            --text-primary: #f0f0f0;
            --text-secondary: #bbbbbb;
            --text-muted: #666666;
        }
        body {
            background: var(--bg-color);
            color: var(--text-primary);
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            display: flex;
            min-height: 100vh;
        }
        /* ── Sidebar ────────────────────────────────────────────── */
        .admin-sidebar {
            width: var(--sidebar-width);
            background: var(--bg-secondary);
            border-right: 1px solid rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            z-index: 100;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        body.dark-mode .admin-sidebar {
            border-right-color: rgba(255, 255, 255, 0.05);
        }
        .sidebar-header {
            padding: 40px 30px;
            text-align: center;
        }
        .admin-logo {
            height: 32px;
            margin-bottom: 20px;
            filter: brightness(0);
            transition: filter 0.3s ease;
        }
        body.dark-mode .admin-logo {
            filter: brightness(0) invert(1);
        }
        .sidebar-nav {
            flex: 1;
            padding: 10px 20px;
        }
        .nav-group {
            margin-bottom: 35px;
        }
        .nav-label {
            font-size: 0.65rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 3px;
            color: var(--text-muted);
            padding: 0 15px 12px;
            display: block;
        }
        .admin-nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            border-radius: 10px;
            color: var(--text-secondary);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            margin-bottom: 2px;
        }
        .admin-nav-link i {
            font-size: 1.25rem;
            opacity: 0.7;
        }
        .admin-nav-link:hover {
            color: var(--accent);
            background: rgba(50, 255, 126, 0.05);
        }
        .admin-nav-link.active {
            background: var(--accent);
            color: #000;
            box-shadow: 0 4px 15px var(--accent-glow);
        }
        .admin-nav-link.active i {
            opacity: 1;
        }
        .sidebar-footer {
            padding: 25px 20px;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }
        /* ── Main Content ──────────────────────────────────────────── */
        .admin-main {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding: 50px 60px;
            max-width: calc(100% - var(--sidebar-width));
            background: var(--bg-color);
        }
        .admin-top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 60px;
        }
        .admin-user-info {
            display: flex;
            align-items: center;
            gap: 15px;
            background: var(--bg-secondary);
            padding: 8px 8px 8px 20px;
            border-radius: 50px;
            border: 1px solid rgba(0,0,0,0.03);
        }
        .admin-avatar {
            width: 36px;
            height: 36px;
            background: var(--accent);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            color: #000;
            font-size: 0.9rem;
        }
        /* ── UI Components ─────────────────────────────────────────── */
        .premium-card {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 40px;
            border: 1px solid rgba(0,0,0,0.05);
            box-shadow: 0 10px 40px rgba(0,0,0,0.03);
        }
        body.dark-mode .premium-card {
            border-color: rgba(255,255,255,0.05);
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        .premium-title {
            font-family: 'Sakana', 'Montserrat', sans-serif;
            font-size: 2.5rem;
            margin-bottom: 30px;
            letter-spacing: -1px;
        }
        .premium-label {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
            margin-bottom: 10px;
            display: block;
        }
        .premium-input {
            width: 100%;
            padding: 15px 20px;
            background: var(--bg-secondary);
            border: 1.5px solid transparent;
            border-radius: 12px;
            color: var(--text-primary);
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }
        .premium-input:focus {
            border-color: var(--accent);
            background: var(--bg-color);
            box-shadow: 0 0 0 4px var(--accent-glow);
            outline: none;
        }
        .premium-btn {
            background: var(--accent);
            color: #000;
            border: none;
            padding: 15px 30px;
            border-radius: 12px;
            font-weight: 800;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .premium-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px var(--accent-glow);
            background: var(--accent-dark);
        }
        .premium-btn-outline {
            background: transparent;
            border: 1.5px solid var(--accent);
            color: var(--text-primary);
        }
        .premium-btn-outline:hover {
            background: var(--accent);
            color: #000;
        }
        @media (max-width: 900px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }
            .admin-sidebar.open {
                transform: translateX(0);
            }
            .admin-main {
                margin-left: 0;
                max-width: 100%;
                padding: 30px 20px;
            }
        /* ── Theme Toggle (Synced with Home) ─────────────────────── */
        .theme-toggle {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            border: none;
            background: var(--accent);
            color: #111;
            font-size: 1.3rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            transition: all 0.4s ease;
            box-shadow: 0 0 20px rgba(50, 255, 126, 0.6);
            margin-right: 20px;
        }
        .theme-toggle i {
            transition: transform 0.4s ease;
        }
        body.dark-mode .theme-toggle i {
            transform: rotate(180deg);
        }
        .theme-toggle:hover {
            transform: scale(1.1);
            box-shadow: 0 0 30px rgba(50, 255, 126, 0.8);
        }
        @media (max-width: 900px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }
            .admin-sidebar.open {
                transform: translateX(0);
            }
            .admin-main {
                margin-left: 0;
                max-width: 100%;
                padding: 30px 20px;
            }
        }
    </style>
    @yield('admin_styles')
</head>
<body>
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-header">
            <a href="/">
                <img src="{{ asset('images/logo.svg') }}" alt="Athletiq" class="admin-logo">
            </a>
            <div style="font-family: 'Sakana', sans-serif; font-size: 0.8rem; letter-spacing: 2px; color: var(--accent);">ADMIN CENTER</div>
        </div>
        <nav class="sidebar-nav">
            <div class="nav-group">
                <span class="nav-label">Overview</span>
                <a href="{{ route('admin.dashboard') }}" class="admin-nav-link {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class='bx bxs-dashboard'></i> Dashboard
                </a>
            </div>
            <div class="nav-group">
                <span class="nav-label">Management</span>
                <a href="{{ route('admin.categories.index') }}" class="admin-nav-link {{ Request::is('admin/categories*') ? 'active' : '' }}">
                    <i class='bx bxs-category'></i> Categories
                </a>
                <a href="{{ route('admin.products.index') }}" class="admin-nav-link {{ Request::is('admin/products*') ? 'active' : '' }}">
                    <i class='bx bxs-package'></i> Products
                </a>
                <a href="{{ route('admin.orders.index') }}" class="admin-nav-link {{ Request::is('admin/orders*') ? 'active' : '' }}">
                    <i class='bx bxs-receipt'></i> Orders
                </a>
            </div>
            <div class="nav-group">
                <span class="nav-label">Quick Actions</span>
                <a href="/" class="admin-nav-link">
                    <i class='bx bx-home-alt'></i> View Website
                </a>
            </div>
        </nav>
        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="admin-nav-link" style="width: 100%; border: none; background: transparent; cursor: pointer; text-align: left;">
                    <i class='bx bx-log-out'></i> Logout
                </button>
            </form>
        </div>
    </aside>
    <main class="admin-main">
        <header class="admin-top-bar">
            <div>
                <button class="theme-toggle" id="themeToggle" aria-label="Toggle Theme">
                    <i class='bx bx-moon'></i>
                </button>
            </div>
            <div class="admin-user-info">
                <div style="text-align: right;">
                    <div style="font-weight: 700; font-size: 0.9rem;">{{ Auth::user()->Email }}</div>
                    <div style="font-size: 0.75rem; color: var(--accent); font-weight: 800; text-transform: uppercase;">Administrator</div>
                </div>
                <div class="admin-avatar">
                    {{ strtoupper(substr(Auth::user()->Email, 0, 1)) }}
                </div>
            </div>
        </header>
        @yield('content')
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Theme Toggle Logic (Synced with Home)
            const toggleBtn = document.getElementById('themeToggle');
            const icon = toggleBtn.querySelector('i');
            if (localStorage.getItem("theme") === "dark") {
                document.body.classList.add("dark-mode");
                icon.classList.replace("bx-moon", "bx-sun");
            }
            toggleBtn.addEventListener("click", () => {
                document.body.classList.toggle("dark-mode");
                const isDark = document.body.classList.contains("dark-mode");
                localStorage.setItem("theme", isDark ? "dark" : "light");
                if (isDark) {
                    icon.classList.replace("bx-moon", "bx-sun");
                } else {
                    icon.classList.replace("bx-sun", "bx-moon");
                }
            });
        });
        // Toast success/error inherited from app.blade.php
    </script>
    <div id="toast-container"></div>
    <style>
        #toast-container {
            position: fixed;
            bottom: 28px;
            right: 28px;
            z-index: 10000;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .toast {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px 22px;
            border-radius: 12px;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.9rem;
            font-weight: 600;
            color: #fff;
            backdrop-filter: blur(12px);
            box-shadow: 0 8px 32px rgba(0,0,0,0.18);
            animation: toastIn 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
        }
        .toast.success { background: rgba(34, 204, 98, 0.95); color: #111; }
        .toast.error   { background: rgba(220, 38, 38, 0.95); }
        .toast i { font-size: 1.2rem; }
        @keyframes toastIn {
            from { transform: translateX(100%); opacity: 0; }
            to   { transform: translateX(0); opacity: 1; }
        }
    </style>
    <script>
        function showToast(message, type = 'info') {
            const container = document.getElementById('toast-container');
            if (!container) return;
            const icons = { success: 'bx-check-circle', error: 'bx-error', info: 'bx-info-circle' };
            const toast = document.createElement('div');
            toast.className = `toast ${type}`;
            toast.innerHTML = `<i class='bx ${icons[type] || icons.info}'></i><span>${message}</span>`;
            container.appendChild(toast);
            setTimeout(() => {
                toast.style.animation = 'toastIn 0.3s ease reverse forwards';
                setTimeout(() => toast.remove(), 300);
            }, 3500);
        }
        @if(session('success'))
            showToast("{{ session('success') }}", 'success');
        @endif
        @if(session('error'))
            showToast("{{ session('error') }}", 'error');
        @endif
    </script>
</body>
</html>
