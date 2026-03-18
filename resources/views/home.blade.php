@extends('layouts.app')
@section('title', 'ATHLETIQ – Gear Up. Train Harder.')
@section('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
<style>
    /* =========================================
       STATS / OFFER BANNER (THE STRIPE FIX)
       ========================================= */
    .stats-banner {
        background-color: #f8f9fa !important;
        border-top: 1px solid #eaeaea !important;
        border-bottom: 1px solid #eaeaea !important;
        width: 100% !important;
        height: 200px !important; 
        min-height: 80px !important;
        overflow: hidden !important; 
        padding: 20px 0 !important; 
        position: relative !important;
        display: flex !important;
        align-items: center !important;
    }
    .marquee-track {
        display: flex !important;
        width: fit-content !important;
    }
    .marquee-content {
        display: flex !important;
        align-items: center !important;
        gap: 40px !important; 
        padding-right: 40px !important; 
        animation: marqueeScroll 25s linear infinite !important;
        white-space: nowrap !important;
    }
    .stats-banner:hover .marquee-content {
        animation-play-state: paused !important;
    }
    .stat-item {
        display: flex !important;
        align-items: center !important;
        gap: 12px !important;
    }
    .stat-icon {
        font-size: 1.8rem !important;
    }
    .stat-item div {
        display: flex !important;
        flex-direction: column !important;
        justify-content: center !important;
    }
    .stat-item strong {
        font-size: 0.95rem !important;
        color: #111 !important;
        font-weight: 700 !important;
        line-height: 1.2 !important;
        margin: 0 !important;
    }
    .stat-item span:not(.stat-icon) {
        font-size: 0.8rem !important;
        color: #666 !important;
        line-height: 1.2 !important;
        margin-top: 2px !important;
    }
    .stat-divider {
        width: 1px !important;
        height: 35px !important;
        background-color: #ddd !important;
    }
    @keyframes marqueeScroll {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }
    /* =========================================
       FEATURED PRODUCTS SLIDER (THE SCROLL FIX)
       ========================================= */
    .product-scroll-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        width: 100%;
        padding: 20px 60px;
    }
    #product-scroll {
        display: flex !important;
        flex-wrap: nowrap !important;
        overflow-x: auto !important;
        gap: 24px;
        padding: 10px 0;
        scroll-behavior: smooth;
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    #product-scroll::-webkit-scrollbar {
        display: none;
    }
    #product-scroll .product-card {
        flex: 0 0 300px !important; 
        width: 300px !important;
    }
    /* Premium Pill Arrow Styling */
    .scroll-arrow {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: var(--text-primary);
        border: none;
        border-radius: 50px;
        width: 44px;
        height: 44px;
        cursor: pointer;
        z-index: 100;
        box-shadow: 0 4px 16px rgba(0,0,0,0.12);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--bg-color);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        opacity: 0.9;
    }
    .scroll-arrow svg {
        width: 20px;
        height: 20px;
        stroke: currentColor;
        fill: none;
        stroke-width: 2.5;
        stroke-linecap: round;
        stroke-linejoin: round;
    }
    .scroll-arrow:hover {
        background: var(--accent);
        color: #111;
        transform: translateY(-50%) scale(1.08);
        box-shadow: 0 8px 24px rgba(50,255,126,0.3);
        opacity: 1;
    }
    .scroll-arrow-left { left: 8px; }
    .scroll-arrow-right { right: 8px; }
    @media (max-width: 768px) {
        .scroll-arrow { display: none !important; }
        .product-scroll-wrapper { padding: 0 20px; }
        #product-scroll { padding-left: 0; padding-right: 0; }
    }
</style>
@endsection
@section('content')
<header>
    <div class="hero-overlay"></div>
    <div class="header-content">
        <p class="hero-eyebrow">NEW SEASON COLLECTION</p>
        <h1>ELEVATE YOUR<br><span class="highlight">PERFORMANCE</span></h1>
        <p class="hero-sub">Discover athletic wear and gear designed for champions.<br>Built to push your limits, every session.</p>
        <div class="hero-buttons">
            <a href="#featured-products" class="cta-btn">
                <span class="btn-text">Shop Now</span>
            </a>
            <a href="#collections" class="cta-btn cta-outline">
                <span class="btn-text">Explore Collections</span>
            </a>
            <a href="{{ url('/about') }}" class="cta-btn cta-outline">
                <span class="btn-text">About Us</span>
            </a>
        </div>
    </div>
</header>
<section class="stats-banner">
    <div class="marquee-track">
        <div class="marquee-content">
            <div class="stat-item">
                <span class="stat-icon">🚚</span>
                <div>
                    <strong>Free UK Delivery</strong>
                    <span>On all orders over £50</span>
                </div>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <span class="stat-icon">🔄</span>
                <div>
                    <strong>30-Day Returns</strong>
                    <span>No questions asked</span>
                </div>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <span class="stat-icon">⭐</span>
                <div>
                    <strong>10,000+ Customers</strong>
                    <span>Rated 4.9 / 5 stars</span>
                </div>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <span class="stat-icon">🏆</span>
                <div>
                    <strong>Premium Quality</strong>
                    <span>Pro-grade gear only</span>
                </div>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <span class="stat-icon">🚚</span>
                <div>
                    <strong>Free UK Delivery</strong>
                    <span>On all orders over £50</span>
                </div>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <span class="stat-icon">🔄</span>
                <div>
                    <strong>30-Day Returns</strong>
                    <span>No questions asked</span>
                </div>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <span class="stat-icon">⭐</span>
                <div>
                    <strong>10,000+ Customers</strong>
                    <span>Rated 4.9 / 5 stars</span>
                </div>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <span class="stat-icon">🏆</span>
                <div>
                    <strong>Premium Quality</strong>
                    <span>Pro-grade gear only</span>
                </div>
            </div>
            <div class="stat-divider"></div>
        </div>
    </div>
</section>
<main>
    <section id="featured-products" class="featured-products">
        <div class="section-header">
            <div>
                <p class="section-eyebrow">HAND-PICKED FOR YOU</p>
                <h2>Featured Products</h2>
            </div>
            <a href="{{ route('products.index') }}" class="view-all-link">View All →</a>
        </div>
        <div class="product-scroll-wrapper">
            <button class="scroll-arrow scroll-arrow-left" id="prod-left" aria-label="Scroll left"><svg viewBox="0 0 24 24"><path d="M15 18l-6-6 6-6"/></svg></button>
            <div class="product-grid" id="product-scroll">
                @foreach($featuredProducts as $product)
                <div class="product-card">
                    <a href="{{ route('product.show', $product->Product_ID) }}" style="text-decoration: none; color: inherit; display: flex; flex-direction: column; flex: 1;">
                        <div class="product-img-wrapper">
                            <img src="{{ asset('images/' . $product->Product_image) }}" alt="{{ $product->Product_name }}">
                            <div class="product-badge">New</div>
                        </div>
                        <div class="product-info" style="flex: 1; display: flex; flex-direction: column;">
                            <h3>{{ $product->Product_name }}</h3>
                            <p class="product-desc" style="font-size: 0.85rem; color: #777; margin: 8px 0 0 0; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                @if($product->specifications && $product->specifications->count() > 0)
                                    {{ implode(' • ', $product->specifications->map(function($spec) {
                                        return $spec->pivot->Spec_value;
                                    })->toArray()) }}
                                @else
                                    Premium athletic gear for maximum performance.
                                @endif
                            </p>
                            <span class="product-price" style="margin-top: auto; padding-top: 12px;">£{{ number_format($product->Price, 2) }}</span>
                        </div>
                    </a>
                    <div class="product-actions-hover">
                        <form method="POST" action="{{ route('cart.add') }}" style="flex: 1; display: flex;">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->Product_ID }}">
                            <button type="submit" class="btn-full"><i class='bx bx-cart'></i> Add</button>
                        </form>
                        <form method="POST" action="{{ route('wishlist.add') }}" class="wishlist-form-hover">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->Product_ID }}">
                            <button type="submit" class="btn-icon" title="Add to Wishlist"><i class='bx bx-heart'></i></button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
            <button class="scroll-arrow scroll-arrow-right" id="prod-right" aria-label="Scroll right"><svg viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg></button>
        </div>
    </section>
    <section id="collections" class="collections">
        <div class="section-header">
            <div>
                <p class="section-eyebrow">SHOP BY CATEGORY</p>
                <h2>Collections</h2>
            </div>
        </div>
        <div class="collections-grid">
            @foreach($categories as $index => $category)
            <a href="{{ route('category.subcategories', $category->Category_ID) }}"
               class="collection-card {{ $index === 0 ? 'collection-card--featured' : '' }}">
                @if($category->image)
                    <img src="{{ asset('images/categories/' . $category->image) }}" alt="{{ $category->Category_name }}">
                @else
                    <div class="collection-placeholder"></div>
                @endif
                <div class="collection-overlay">
                    <h3>{{ $category->Category_name }}</h3>
                    <span class="collection-cta">Shop Now →</span>
                </div>
            </a>
            @endforeach
        </div>
    </section>
    <section class="why-athletiq">
        <div class="section-header centered">
            <div>
                <p class="section-eyebrow">OUR PROMISE</p>
                <h2>Why Athletiq?</h2>
            </div>
        </div>
        <div class="why-grid">
            <div class="why-card">
                <div class="why-icon">⚡</div>
                <h4>Performance First</h4>
                <p>Every product is tested for real athletes in real conditions. No compromises.</p>
            </div>
            <div class="why-card">
                <div class="why-icon">🌿</div>
                <h4>Sustainably Made</h4>
                <p>Eco-friendly materials and responsible manufacturing with every range.</p>
            </div>
            <div class="why-card">
                <div class="why-icon">💳</div>
                <h4>Easy Checkout</h4>
                <p>Secure payments, multiple options, and one-click reordering for members.</p>
            </div>
            <div class="why-card">
                <div class="why-icon">🎯</div>
                <h4>Expert Curated</h4>
                <p>Products chosen by fitness professionals for every level and discipline.</p>
            </div>
        </div>
    </section>
    <section class="testimonials">
        <div class="section-header centered">
            <div>
                <p class="section-eyebrow">REAL ATHLETES, REAL RESULTS</p>
                <h2>What Our Customers Say</h2>
            </div>
        </div>
        <div class="testimonials-track-wrapper">
            <div class="testimonials-track" id="testimonials-track">
                <div class="testimonial-card">
                    <div class="testimonial-stars">★★★★★</div>
                    <p class="testimonial-quote">"Best gym gear I've ever owned. The compression fit is perfect and the material keeps me dry even during the hardest HIIT sessions."</p>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar">JT</div>
                        <div>
                            <strong>James T.</strong>
                            <span>CrossFit Athlete</span>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <div class="testimonial-stars">★★★★★</div>
                    <p class="testimonial-quote">"I replaced my entire workout wardrobe with Athletiq. The quality is incredible for the price, and the designs actually look good outside the gym too."</p>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar">SR</div>
                        <div>
                            <strong>Sarah R.</strong>
                            <span>Marathon Runner</span>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <div class="testimonial-stars">★★★★★</div>
                    <p class="testimonial-quote">"Lightning-fast delivery and the packaging felt premium. The joggers are insanely comfortable — I wear them everywhere now."</p>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar">MK</div>
                        <div>
                            <strong>Michael K.</strong>
                            <span>Personal Trainer</span>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <div class="testimonial-stars">★★★★★</div>
                    <p class="testimonial-quote">"Finally found a brand that caters to women who actually lift. The supportive fit and stylish colours make these my go-to training tops."</p>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar">LP</div>
                        <div>
                            <strong>Lisa P.</strong>
                            <span>Powerlifter</span>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <div class="testimonial-stars">★★★★★</div>
                    <p class="testimonial-quote">"Ordered for my rugby team — everyone was impressed. Great bulk pricing and the quality held up after dozens of washes."</p>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar">DB</div>
                        <div>
                            <strong>Daniel B.</strong>
                            <span>Rugby Coach</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="faq-section">
        <div class="section-header centered">
            <div>
                <p class="section-eyebrow">GOT QUESTIONS?</p>
                <h2>Frequently Asked Questions</h2>
            </div>
        </div>
        <div class="faq-container">
            <div class="faq-item">
                <button class="faq-question" aria-expanded="false">
                    <span>How long does delivery take?</span>
                    <i class='bx bx-plus faq-icon'></i>
                </button>
                <div class="faq-answer">
                    <p>Standard UK delivery takes 3-5 business days. Express delivery is available for next-day arrival on orders placed before 2pm. International orders typically arrive within 7-14 business days.</p>
                </div>
            </div>
            <div class="faq-item">
                <button class="faq-question" aria-expanded="false">
                    <span>What is your returns policy?</span>
                    <i class='bx bx-plus faq-icon'></i>
                </button>
                <div class="faq-answer">
                    <p>We offer a 30-day no-questions-asked return policy. Items must be unworn with original tags attached. Simply request a return from your account and we'll send you a prepaid label.</p>
                </div>
            </div>
            <div class="faq-item">
                <button class="faq-question" aria-expanded="false">
                    <span>How do I find the right size?</span>
                    <i class='bx bx-plus faq-icon'></i>
                </button>
                <div class="faq-answer">
                    <p>Each product page includes a detailed size guide with measurements. Our athletic fit is designed to be snug but flexible. When in doubt, we recommend sizing up for a more relaxed feel.</p>
                </div>
            </div>
            <div class="faq-item">
                <button class="faq-question" aria-expanded="false">
                    <span>Do you offer student discounts?</span>
                    <i class='bx bx-plus faq-icon'></i>
                </button>
                <div class="faq-answer">
                    <p>Yes! We offer 15% off for verified students. Simply sign up with your university email and the discount will be applied automatically at checkout.</p>
                </div>
            </div>
            <div class="faq-item">
                <button class="faq-question" aria-expanded="false">
                    <span>Are your products sustainable?</span>
                    <i class='bx bx-plus faq-icon'></i>
                </button>
                <div class="faq-answer">
                    <p>Absolutely. We use recycled polyester and organic cotton in over 70% of our range. Our packaging is 100% recyclable, and we're committed to carbon-neutral shipping by 2027.</p>
                </div>
            </div>
            <div class="faq-item">
                <button class="faq-question" aria-expanded="false">
                    <span>Can I track my order?</span>
                    <i class='bx bx-plus faq-icon'></i>
                </button>
                <div class="faq-answer">
                    <p>Yes! Once your order ships, you'll receive an email with a tracking link. You can also check your order status anytime by logging into your account.</p>
                </div>
            </div>
        </div>
    </section>
    <section class="newsletter">
        <div class="newsletter-content" id="newsletter-content">
            <h2>Join the Athletiq Elite</h2>
            <p>Get early access to new drops, exclusive offers, and fitness tips straight to your inbox.</p>
            <form class="newsletter-form" id="newsletter-form">
                <input type="email" placeholder="Enter your email" required>
                <button type="submit">Subscribe</button>
            </form>
        </div>
    </section>
</main>
<button id="scroll-top-btn" class="scroll-top-btn" aria-label="Scroll to top">↑</button>
<script>
// Scroll-to-top
const scrollTopBtn = document.getElementById('scroll-top-btn');
window.addEventListener('scroll', () => {
    scrollTopBtn.classList.toggle('visible', window.scrollY > 350);
});
scrollTopBtn.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
});
// Product row arrows — scroll 2 cards at a time
(function() {
    const grid   = document.getElementById('product-scroll');
    const btnL   = document.getElementById('prod-left');
    const btnR   = document.getElementById('prod-right');
    if (!grid || !btnL || !btnR) return;
    const scrollByAmount = 648; // 2 × (300px + 24px)
    btnL.addEventListener('click', () => grid.scrollBy({ left: -scrollByAmount, behavior: 'smooth' }));
    btnR.addEventListener('click', () => grid.scrollBy({ left:  scrollByAmount, behavior: 'smooth' }));
})();
// Wishlist AJAX — using toast instead of alert
document.querySelectorAll('.wishlist-form-hover').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        fetch(this.action, {
            method: 'POST',
            body: new FormData(this)
        }).then(response => response.json())
          .then(data => {
              if(!data.success && data.redirect) {
                  window.location.href = data.redirect;
              } else {
                  if(typeof showToast === 'function') {
                      showToast(data.message, data.success ? 'success' : 'error');
                  } else {
                      alert(data.message);
                  }
                  if (data.success && data.message.includes('Added')) {
                     setTimeout(() => window.location.reload(), 1200); 
                  }
              }
          });
    });
});
// FAQ Accordion
document.querySelectorAll('.faq-question').forEach(btn => {
    btn.addEventListener('click', () => {
        const item = btn.parentElement;
        const isOpen = item.classList.contains('active');
        // Close all others
        document.querySelectorAll('.faq-item.active').forEach(i => i.classList.remove('active'));
        if (!isOpen) item.classList.add('active');
    });
});
// Newsletter inline success
const nlForm = document.getElementById('newsletter-form');
if (nlForm) {
    nlForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const container = document.getElementById('newsletter-content');
        container.innerHTML = `
            <div class="nl-success-anim">
                <div class="nl-checkmark">✓</div>
                <h2>You're In!</h2>
                <p>Welcome to the Athletiq Elite. Watch your inbox for exclusive drops.</p>
            </div>
        `;
    });
}
// Testimonials auto-scroll
(function() {
    const track = document.getElementById('testimonials-track');
    if (!track) return;
    let scrollDir = 1;
    let isPaused = false;
    track.addEventListener('mouseenter', () => isPaused = true);
    track.addEventListener('mouseleave', () => isPaused = false);
    setInterval(() => {
        if (isPaused) return;
        const maxScroll = track.scrollWidth - track.clientWidth;
        if (track.scrollLeft >= maxScroll - 1) scrollDir = -1;
        if (track.scrollLeft <= 0) scrollDir = 1;
        track.scrollBy({ left: scrollDir * 1, behavior: 'auto' });
    }, 30);
})();
</script>
@endsection