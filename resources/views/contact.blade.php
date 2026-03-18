@extends('layouts.app')
@section('title', 'Contact Us | Athletiq')
@section('styles')
<style>
    .contact-page {
        padding-top: 120px;
    }
    .contact-grid {
        display: grid;
        grid-template-columns: 1fr 1.2fr;
        gap: 60px;
        align-items: flex-start;
    }
    .contact-info-list {
        display: flex;
        flex-direction: column;
        gap: 32px;
    }
    .info-item {
        display: flex;
        gap: 20px;
        align-items: flex-start;
    }
    .info-icon {
        width: 48px;
        height: 48px;
        background: var(--bg-secondary);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: var(--accent);
        flex-shrink: 0;
        box-shadow: var(--shadow-card);
    }
    .info-content h3 {
        font-family: 'Sakana', sans-serif;
        font-size: 1.1rem;
        margin-bottom: 4px;
        color: var(--text-primary);
    }
    .info-content p, .info-content a {
        color: var(--text-secondary);
        text-decoration: none;
        font-size: 1rem;
    }
    .info-content a:hover { color: var(--accent-dark); }
    .social-links {
        display: flex;
        gap: 16px;
        margin-top: 40px;
    }
    .social-link {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: var(--bg-secondary);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-primary);
        font-size: 1.2rem;
        transition: all 0.3s;
        text-decoration: none;
    }
    .social-link:hover {
        background: var(--accent);
        color: #111;
        transform: translateY(-3px);
    }
    /* Form */
    .contact-form-card {
        padding: 48px;
    }
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    .premium-textarea {
        width: 100%;
        min-height: 150px;
        resize: vertical;
    }
    @media (max-width: 900px) {
        .contact-grid { grid-template-columns: 1fr; gap: 40px; }
        .contact-form-card { padding: 32px 24px; }
        .form-row { grid-template-columns: 1fr; }
    }
    /* Dark Mode Overrides */
    body.dark-mode .info-icon {
        background: var(--bg-secondary);
        box-shadow: 0 4px 20px rgba(0,0,0,0.3);
    }
    body.dark-mode .social-link {
        background: var(--bg-secondary);
    }
    body.dark-mode .social-link:hover {
        background: var(--accent);
        color: #111;
    }
</style>
@endsection
@section('content')
<div class="premium-container contact-page">
    <div class="premium-page-header">
        <span class="premium-eyebrow">GET IN TOUCH</span>
        <h1 class="premium-title">Elite Support</h1>
    </div>
    <div class="contact-grid">
        <div class="contact-info">
            <div class="about-text" style="margin-bottom: 48px;">
                <h2 style="font-family: 'Sakana', sans-serif; font-size: 2rem; margin-bottom: 16px; color: var(--text-primary);">We're Here to Help</h2>
                <p style="color: var(--text-secondary); line-height: 1.6;">
                    Whether you have a question about your order, need help finding the perfect gear, 
                    or just want to share feedback — our team is here to help.
                </p>
            </div>
            <div class="contact-info-list">
                <div class="info-item">
                    <div class="info-icon"><i class='bx bx-envelope'></i></div>
                    <div class="info-content">
                        <h3>Email Us</h3>
                        <a href="mailto:support@athletiq.com">support@athletiq.com</a>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-icon"><i class='bx bx-phone'></i></div>
                    <div class="info-content">
                        <h3>Call Support</h3>
                        <a href="tel:+441234567890">+44 1234 567 890</a>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-icon"><i class='bx bx-map-pin'></i></div>
                    <div class="info-content">
                        <h3>Headquarters</h3>
                        <p>123 Fitness Lane, London, UK</p>
                    </div>
                </div>
            </div>
            <div class="social-links">
                <a href="#" class="social-link"><i class='bx bxl-instagram'></i></a>
                <a href="#" class="social-link"><i class='bx bxl-facebook'></i></a>
                <a href="#" class="social-link"><i class='bx bxl-twitter'></i></a>
                <a href="#" class="social-link"><i class='bx bxl-tiktok'></i></a>
            </div>
        </div>
        <div class="premium-card contact-form-card">
            <h2 style="font-family: 'Sakana', sans-serif; font-size: 1.8rem; margin-bottom: 32px; color: var(--text-primary);">Send a Message</h2>
            <form action="{{ route('contact.submit') }}" method="POST">
                @csrf
                <div class="form-row">
                    <div class="premium-form-group">
                        <label class="premium-label">First Name</label>
                        <input type="text" name="name" class="premium-input" placeholder="Your Name" required>
                    </div>
                    <div class="premium-form-group">
                        <label class="premium-label">Email Address</label>
                        <input type="email" name="email" class="premium-input" placeholder="you@example.com" required>
                    </div>
                </div>
                <div class="premium-form-group">
                    <label class="premium-label">Subject</label>
                    <select class="premium-input">
                        <option>General Inquiry</option>
                        <option>Order Status</option>
                        <option>Returns & Exchanges</option>
                        <option>Partnership</option>
                    </select>
                </div>
                <div class="premium-form-group">
                    <label class="premium-label">Message</label>
                    <textarea name="message" class="premium-input premium-textarea" placeholder="How can we help?" required></textarea>
                </div>
                <button type="submit" class="premium-btn" style="width: 100%; padding: 16px;">Send Message</button>
            </form>
        </div>
    </div>
</div>
@endsection