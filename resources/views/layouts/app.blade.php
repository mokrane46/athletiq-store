<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ATHLETIQ')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/chatbot.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('styles') 
</head>   
<body>
    <button class="theme-toggle">
        <i class='bx bx-moon'></i>
    </button>
    @unless(Request::is('login') || Request::is('register'))
    <nav class="navbar {{ Request::is('/') ? '' : 'sub-page-nav' }}">
        <div class="overlay"></div>
        <div class="nav-links">
            <div class="mobile-menu-header">
                <span><img class="mobile-logo-dark" src="{{ asset('images/logo-dark.svg') }}" alt=""></span>
            </div>
            <div class="mobile-menu-header-dark">
                <span><img class="mobile-logo" src="{{ asset('images/logo.svg') }}" alt=""></span>
            </div>
            <ul>
                @foreach ($categories ?? [] as $category)
                    @if($category->Category_name === 'Clothes')
                        <li class="nav-dropdown">
                            <a href="{{ route('category.subcategories', $category->Category_ID) }}">
                                {{ $category->Category_name }} <i class='bx bx-chevron-down' style="font-size: 0.8em; margin-left: 2px;"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ url('/gender/men') }}">Men</a></li>
                                <li><a href="{{ url('/gender/women') }}">Women</a></li>
                            </ul>
                        </li>
                    @else
                        <li>
                            <a href="{{ route('category.subcategories', $category->Category_ID) }}">
                                {{ $category->Category_name }}
                            </a>
                        </li>
                    @endif
                @endforeach
                <li><a href="{{ url('/contact') }}">Contact</a></li>
            </ul>
            <li class="mobile-actions">
                <div class="menu-buttons">
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="menu-btn admin-link" style="color: var(--accent);">
                                <span class="bx bx-shield-quarter btn-text"></span>Admin
                            </a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                            @csrf
                            <button type="submit" class="menu-btn">
                                <span class="bx bx-log-out btn-text"></span>Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="menu-btn">
                            <span class="bx bx-user btn-text"></span>Login
                        </a>
                    @endauth
                    <a href="/cart" class="menu-btn" style="position:relative;">
                        <span class="bx bx-cart btn-text"></span>Cart
                        @php
                            $globalCartCount = Auth::check() ? Auth::user()->cartItemCount() : array_sum(session()->get('cart', []));
                        @endphp
                        @if($globalCartCount > 0)
                            <span class="cart-count-badge" style="top: -5px; right: -5px;">{{ $globalCartCount }}</span>
                        @endif
                    </a>
                </div>
            </li>
        </div>
        <div class="nav-center">
            <a href="/" class="logo"><img src="{{ asset('images/logo.svg') }}" alt=""></a>
            <a href="/" class="logo-dark"><img src="{{ asset('images/logo-dark.svg') }}" alt=""></a>
        </div>
        <div class="nav-icons">
            <i class='bx bx-menu menu-icon'></i>
            <form action="{{ route('products.search') }}" method="GET" class="search-wrapper" id="navbar-search-form">
                <input type="text" name="query" class="search-input" placeholder="Search gear..." required>
                <i class='bx bx-search search-icon' id="navbar-search-icon"></i>
            </form>
            <a href="{{ route('wishlist.index') }}" class="nav-icon-link" aria-label="Wishlist" style="position:relative;">
                <i class='bx bx-heart'></i>
                @auth
                    @php
                        $wishlistCount = count(session()->get('wishlist_' . Auth::id(), []));
                    @endphp
                    @if($wishlistCount > 0)
                        <span class="cart-count-badge">{{ $wishlistCount }}</span>
                    @endif
                @endauth
            </a>
            <a href="/cart" class="nav-icon-link cart-a" style="position:relative;">
                <i class='bx bx-cart'></i>
                @php
                    $globalCartCount = Auth::check() ? Auth::user()->cartItemCount() : array_sum(session()->get('cart', []));
                @endphp
                @if($globalCartCount > 0)
                    <span class="cart-count-badge">{{ $globalCartCount }}</span>
                @endif
            </a>
            @auth
                <div class="profile-dropdown">
                    <div class="profile-trigger nav-icon-link">
                        <i class='bx bx-user'></i>
                    </div>
                    <div class="profile-menu">
                        <div class="profile-header">
                            <span class="profile-name">{{ Auth::user()->name ?: 'Elite Member' }}</span>
                            <span class="profile-email">{{ Auth::user()->Email }}</span>
                            <span class="profile-role-badge" style="font-size: 0.75rem; background: var(--accent); color: #111; padding: 2px 8px; border-radius: 4px; font-weight: bold; text-transform: uppercase;">{{ Auth::user()->role }}</span>
                        </div>
                        <div class="profile-links">
                            @if(Auth::user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="profile-link admin-link" style="color: var(--accent); font-weight: bold;">
                                    <i class='bx bx-shield-quarter'></i> Admin Dashboard
                                </a>
                            @endif
                            <a href="{{ route('wishlist.index') }}" class="profile-link">
                                <i class='bx bx-heart'></i> My Wishlist
                            </a>
                            <a href="{{ route('cart.show') }}" class="profile-link">
                                <i class='bx bx-cart'></i> My Cart
                            </a>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="profile-logout-btn">
                                <i class='bx bx-log-out'></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="nav-icon-link" title="Login">
                    <i class='bx bx-user'></i>
                </a>
            @endauth
        </div>
    </nav>
    @endunless
    @yield('content')  
    @unless(Request::is('login') || Request::is('register'))
    <footer class="site-footer">
    <div class="footer-container">
        <div class="footer-about">
            <img class="logo" src="{{ asset('images/logo.svg') }}">
            <img class="logo-dark" src="{{ asset('images/logo-dark.svg') }}">
            <p>Fitness for everyone.</p>
        </div>
        <div class="footer-links">
            <h4>Quick Links</h4>
            <ul>
                <li><a href="{{ url('/gender/men') }}">Men</a></li>
                <li><a href="{{ url('/gender/women') }}">Women</a></li>
                <li><a href="#content">Featured</a></li>
                <li><a href="#collections">Collections</a></li>
                <li><a href="/about">About</a></li>
                <li><a href="/contact">Contact Us</a></li>
            </ul>
        </div>
        <div class="footer-social">
            <h4>Follow Us</h4>
            <a href="#"><i class='bx bxl-instagram'></i></a>
            <a href="#"><i class='bx bxl-facebook'></i></a>
            <a href="#"><i class='bx bxl-twitter'></i></a>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2026 ATHLETIQ. All rights reserved.</p>
    </div>
</footer>
@endunless
    <div class="chat-trigger" id="chat-trigger">
        <i class='bx bx-message-square-dots'></i>
    </div>
    <div class="chat-window" id="chat-window">
        <div class="chat-header">
            <img src="{{ asset('images/logo-dark.svg') }}" alt="Athletiq AI">
            <div class="chat-status-info">
                <h4>Athletiq AI</h4>
                <p>Online & Ready</p>
            </div>
        </div>
        <div class="chat-messages" id="chat-messages">
            <div class="message bot">
                Hello! I'm your Athletiq assistant. How can I help you today?
            </div>
        </div>
        <div class="chat-input-area">
            <input type="text" id="chat-input" placeholder="Type a message..." autocomplete="off">
            <button class="chat-send-btn" id="chat-send">
                <i class='bx bxs-send'></i>
            </button>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const trigger = document.getElementById('chat-trigger');
            const windowEl = document.getElementById('chat-window');
            const input = document.getElementById('chat-input');
            const sendBtn = document.getElementById('chat-send');
            const messagesContainer = document.getElementById('chat-messages');
            // Toggle window
            trigger.addEventListener('click', () => {
                windowEl.classList.toggle('active');
            });
            // Close on click outside
            document.addEventListener('click', (e) => {
                if (!windowEl.contains(e.target) && !trigger.contains(e.target)) {
                    windowEl.classList.remove('active');
                }
            });
            // Send message function
            async function sendMessage() {
                const text = input.value.trim();
                if (!text) return;
                // Add user message
                addMessage(text, 'user');
                input.value = '';
                try {
                    const response = await fetch("{{ route('chat.send') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ message: text })
                    });
                    const data = await response.json();
                    if (data.success) {
                        setTimeout(() => {
                            addMessage(data.response, 'bot');
                        }, 500);
                    }
                } catch (error) {
                    console.error('Chat Error:', error);
                }
            }
            function addMessage(text, type) {
                const msg = document.createElement('div');
                msg.className = `message ${type}`;
                msg.textContent = text;
                messagesContainer.appendChild(msg);
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }
            sendBtn.addEventListener('click', sendMessage);
            input.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') sendMessage();
            });
        });
    </script>
    <div id="toast-container"></div>
    <style>
        #toast-container {
            position: fixed;
            bottom: 28px;
            left: 28px;
            z-index: 10000;
            display: flex;
            flex-direction: column;
            gap: 10px;
            pointer-events: none;
        }
        .toast {
            pointer-events: auto;
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
            max-width: 360px;
        }
        .toast.success { background: rgba(34, 204, 98, 0.95); color: #111; }
        .toast.error   { background: rgba(220, 38, 38, 0.95); }
        .toast.info    { background: rgba(17, 17, 17, 0.92); }
        .toast i { font-size: 1.2rem; }
        .toast.removing {
            animation: toastOut 0.3s ease forwards;
        }
        @keyframes toastIn {
            from { transform: translateX(-100%); opacity: 0; }
            to   { transform: translateX(0); opacity: 1; }
        }
        @keyframes toastOut {
            from { transform: translateX(0); opacity: 1; }
            to   { transform: translateX(-100%); opacity: 0; }
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
                toast.classList.add('removing');
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
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>