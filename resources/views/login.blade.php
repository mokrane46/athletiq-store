@extends('layouts.app')
@section('title', 'LOG IN | Athletiq')
@section('styles')
<style>
    .auth-page {
        box-sizing: border-box;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        width: 100%;
        padding: 40px 20px;
        background: radial-gradient(circle at top right, rgba(50, 255, 126, 0.05), transparent 400px),
                    radial-gradient(circle at bottom left, rgba(50, 255, 126, 0.05), transparent 400px),
                    var(--bg-color);
        position: relative;
        overflow-x: hidden;
    }
    /* Decorative circles */
    .auth-bg-blob {
        position: absolute;
        width: 500px;
        height: 500px;
        background: var(--accent);
        filter: blur(120px);
        opacity: 0.03;
        border-radius: 50%;
        z-index: 0;
    }
    .blob-1 { top: -10%; right: -10%; }
    .blob-2 { bottom: -10%; left: -10%; }
    .auth-container {
        width: 100%;
        max-width: 460px;
        background: var(--bg-secondary);
        padding: 50px 40px;
        border-radius: 24px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(0, 0, 0, 0.05);
        text-align: center;
        position: relative;
        z-index: 1;
        backdrop-filter: blur(10px);
        transition: transform 0.3s ease;
    }
    body.dark-mode .auth-container {
        border-color: rgba(255, 255, 255, 0.05);
        background: rgba(26, 26, 26, 0.8);
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }
    .auth-logo {
        height: 48px;
        margin-bottom: 30px;
        transition: transform 0.3s ease;
    }
    .auth-logo:hover { transform: scale(1.05); }
    .auth-logo.logo-light { display: none; }
    .auth-logo.logo-dark  { display: block; margin-left: auto; margin-right: auto; }
    body.dark-mode .auth-logo.logo-light { display: block; margin-left: auto; margin-right: auto; }
    body.dark-mode .auth-logo.logo-dark  { display: none; }
    .auth-header {
        margin-bottom: 40px;
    }
    .auth-title {
        font-family: 'Sakana', 'Montserrat', sans-serif;
        font-size: 2.2rem;
        margin-bottom: 12px;
        color: var(--text-primary);
        letter-spacing: 1px;
    }
    .auth-sub {
        font-size: 0.95rem;
        color: var(--text-secondary);
    }
    .auth-form {
        max-width: 360px;
        margin: 0 auto;
        text-align: left;
    }
    .form-group {
        margin-bottom: 24px;
        position: relative;
    }
    .form-group label {
        display: block;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        margin-bottom: 8px;
        color: var(--text-muted);
        transition: color 0.3s ease;
    }
    .auth-form input[type="email"],
    .auth-form input[type="password"] {
        width: 100%;
        padding: 16px 20px;
        border-radius: 12px;
        border: 1px solid rgba(0, 0, 0, 0.08);
        background: var(--bg-color);
        color: var(--text-primary);
        font-family: inherit;
        font-size: 1rem;
        outline: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    body.dark-mode .auth-form input { border-color: rgba(255, 255, 255, 0.08); }
    .auth-form input:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 4px rgba(50, 255, 126, 0.1);
        transform: translateY(-2px);
    }
    .form-group:focus-within label {
        color: var(--accent);
    }
    .auth-options {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: -8px;
        margin-bottom: 32px;
        font-size: 0.9rem;
    }
    .remember-me {
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        color: var(--text-secondary);
        user-select: none;
    }
    .remember-me input {
        width: 18px;
        height: 18px;
        accent-color: var(--accent);
        cursor: pointer;
    }
    .forgot-link {
        color: var(--text-muted);
        text-decoration: none;
        transition: color 0.3s ease;
    }
    .forgot-link:hover { color: var(--accent); }
    .auth-submit {
        width: 100%;
        padding: 18px;
        font-size: 1rem;
        letter-spacing: 2px;
        text-transform: uppercase;
        margin-bottom: 30px;
    }
    .auth-footer {
        padding-top: 24px;
        border-top: 1px solid rgba(0, 0, 0, 0.05);
        font-size: 0.95rem;
        color: var(--text-secondary);
    }
    body.dark-mode .auth-footer { border-top-color: rgba(255, 255, 255, 0.05); }
    .auth-footer a {
        color: var(--accent-dark);
        font-weight: 700;
        text-decoration: none;
        margin-left: 5px;
        transition: all 0.3s ease;
    }
    .auth-footer a:hover { color: var(--accent); text-decoration: underline; }
    .premium-alert {
        background: rgba(255, 62, 62, 0.08);
        color: #ff3e3e;
        padding: 16px 20px;
        border-radius: 12px;
        font-size: 0.9rem;
        margin: 0 auto 30px;
        max-width: 360px;
        text-align: left;
        border: 1px solid rgba(255, 62, 62, 0.3);
        display: flex;
        align-items: center;
        gap: 12px;
        animation: alertSlideDown 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
        box-shadow: 0 8px 24px rgba(255, 62, 62, 0.1);
    }
    .premium-alert i {
        font-size: 1.4rem;
    }
    @keyframes alertSlideDown {
        from { transform: translateY(-15px) scale(0.95); opacity: 0; }
        to { transform: translateY(0) scale(1); opacity: 1; }
    }
    /* Back Button Customization */
    .auth-back-btn {
        position: fixed;
        top: 40px;
        left: 40px;
        width: 48px;
        height: 48px;
        background: var(--bg-secondary);
        border: 1px solid rgba(0, 0, 0, 0.05);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-primary);
        font-size: 1.5rem;
        text-decoration: none;
        z-index: 100;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    body.dark-mode .auth-back-btn { border-color: rgba(255,255,255,0.05); }
    .auth-back-btn:hover {
        background: var(--accent);
        color: #111;
        transform: translateX(-5px);
        box-shadow: 0 8px 20px rgba(50, 255, 126, 0.2);
    }
</style>
@endsection
@section('content')
<a href="{{ url('/') }}" class="auth-back-btn" title="Back to Home">
    <i class='bx bx-left-arrow-alt'></i>
</a>
<main class="auth-page">
    <div class="auth-bg-blob blob-1"></div>
    <div class="auth-bg-blob blob-2"></div>
    <div class="auth-container">
        <a href="{{ url('/') }}">
            <img src="{{ asset('images/logo-dark.svg') }}" alt="Athletiq" class="auth-logo logo-dark">
            <img src="{{ asset('images/logo.svg') }}" alt="Athletiq" class="auth-logo logo-light">
        </a>
        <div class="auth-header">
            <h2 class="auth-title">WELCOME BACK</h2>
            <p class="auth-sub">Enter your credentials to access the elite area.</p>
        </div>
        @if ($errors->any())
            <div class="premium-alert">
                <i class='bx bx-error-circle'></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif
        <form method="POST" action="{{ route('login.post') }}" class="auth-form">
            @csrf
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="e.g. champion@athletiq.com" required value="{{ old('email') }}">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="••••••••" required>
            </div>
            <div class="auth-options">
                <label class="remember-me">
                    <input type="checkbox" name="remember">
                    <span>Remember Me</span>
                </label>
                <a href="#" class="forgot-link">Forgot password?</a>
            </div>
            <button type="submit" class="premium-btn auth-submit">Log In</button>
        </form>
        <div class="auth-footer">
            <p>New to the team? <a href="{{ route('register') }}">Join the Elite</a></p>
        </div>
    </div>
</main>
@endsection
