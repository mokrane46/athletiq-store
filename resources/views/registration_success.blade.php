@extends('layouts.app')
@section('title', 'Registration Successful | Athletiq')
@section('styles')
<meta http-equiv="refresh" content="5;url={{ route('login') }}">
<style>
    .success-page {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 70vh;
        padding: 60px 20px;
    }
    .success-card {
        max-width: 500px;
        text-align: center;
        padding: 60px 40px;
    }
    .success-icon {
        font-size: 5rem;
        color: var(--accent);
        margin-bottom: 32px;
        animation: scaleIn 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .success-card h2 {
        font-family: 'Sakana', sans-serif;
        font-size: 2.5rem;
        margin-bottom: 16px;
        color: var(--text-primary);
    }
    .success-card p {
        color: var(--text-secondary);
        font-size: 1.1rem;
        line-height: 1.6;
        margin-bottom: 32px;
    }
    .redirect-hint {
        font-size: 0.9rem;
        color: var(--text-muted);
    }
    .redirect-hint a {
        color: var(--accent-dark);
        font-weight: 700;
        text-decoration: none;
    }
    @keyframes scaleIn {
        from { transform: scale(0); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }
</style>
@endsection
@section('content')
<div class="premium-container success-page">
    <div class="premium-card success-card">
        <i class='bx bxs-check-circle success-icon'></i>
        <h2>ELITE ACCESS GRANTED</h2>
        <p>Your Athletiq account has been successfully created. Prepare to dominate your training with exclusive access to premium gear.</p>
        <a href="{{ route('login') }}" class="premium-btn" style="padding: 14px 40px; margin-bottom: 24px;">Login Now</a>
        <p class="redirect-hint">
            You will be automatically redirected to the login page in <span id="timer">5</span> seconds...
        </p>
    </div>
</div>
<script>
    let seconds = 5;
    const timerEl = document.getElementById('timer');
    const interval = setInterval(() => {
        seconds--;
        timerEl.textContent = seconds;
        if (seconds <= 0) clearInterval(interval);
    }, 1000);
</script>
@endsection
