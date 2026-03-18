@extends('layouts.app')
@section('title', 'About Us | Athletiq')
@section('styles')
<style>
    .about-page {
        padding-top: 120px;
    }
    .about-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: center;
        margin-bottom: 80px;
    }
    .about-image {
        width: 100%;
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-card);
    }
    .about-text h2 {
        font-family: 'Sakana', sans-serif;
        font-size: 2.2rem;
        margin-bottom: 24px;
        color: var(--text-primary);
    }
    .about-text p {
        font-size: 1.1rem;
        line-height: 1.7;
        color: var(--text-secondary);
        margin-bottom: 20px;
    }
    .values-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
        margin-top: 60px;
    }
    .value-card {
        text-align: center;
        padding: 40px 24px;
    }
    .value-card i {
        font-size: 2.5rem;
        color: var(--accent);
        margin-bottom: 20px;
    }
    .value-card h3 {
        font-family: 'Sakana', sans-serif;
        font-size: 1.3rem;
        margin-bottom: 12px;
    }
    @media (max-width: 900px) {
        .about-grid { grid-template-columns: 1fr; gap: 40px; }
        .values-grid { grid-template-columns: 1fr; }
    }
</style>
@endsection
@section('content')
<div class="premium-container about-page">
    <div class="premium-page-header">
        <span class="premium-eyebrow">THE ATHLETIQ STORY</span>
        <h1 class="premium-title">Beyond the Routine</h1>
    </div>
    <div class="about-grid">
        <div class="about-text">
            <h2>Our Origin</h2>
            <p>
                Founded by athletes and fitness enthusiasts, Athletiq was born from a simple idea:
                to make premium sportswear accessible to everyone. We started with a small lineup of gym
                essentials and have since grown into a trusted name across the global fitness community.
            </p>
            <p>
                Every product we design is tested for comfort, durability, and performance — because we
                know what it means to push limits and strive for more.
            </p>
        </div>
        <img src="{{ asset('images/hero-gym.jpg') }}" alt="Our Story" class="about-image">
    </div>
    <div class="premium-card" style="margin-bottom: 80px;">
        <div class="about-text" style="text-align: center; max-width: 800px; margin: 0 auto;">
            <h2>Our Mission</h2>
            <p>
                Our mission is to inspire confidence through movement. Athletiq blends style with
                performance, offering gear that empowers you to move freely and perform at your best —
                because true strength comes from persistence and passion.
            </p>
        </div>
    </div>
    <div class="premium-page-header">
        <span class="premium-eyebrow">WHAT WE STAND FOR</span>
        <h2 class="premium-title">Elite Values</h2>
    </div>
    <div class="values-grid">
        <div class="premium-card value-card">
            <i class='bx bxs-bolt'></i>
            <h3>Performance</h3>
            <p>Gear engineered to help you dominate every workout and exceed your goals.</p>
        </div>
        <div class="premium-card value-card">
            <i class='bx bxs-award'></i>
            <h3>Innovation</h3>
            <p>We constantly experiment with advanced fabrics and functional designs.</p>
        </div>
        <div class="premium-card value-card">
            <i class='bx bxs-group'></i>
            <h3>Community</h3>
            <p>From first-timers to pros, we’re here to support every fitness journey.</p>
        </div>
    </div>
    <div style="text-align: center; margin-top: 80px;">
        <a href="{{ url('/') }}" class="premium-btn" style="padding: 16px 40px; font-size: 1.1rem;">Explore the Collection</a>
    </div>
</div>
@endsection
