@extends('layouts.app')
@section('title', 'Secure Checkout | Athletiq')
@section('styles')
<style>
    .checkout-page {
        padding-top: 140px;
        padding-bottom: 100px;
        background: #f8f9fa;
        min-height: 100vh;
    }
    /* --- Progress Bar --- */
    .checkout-progress {
        max-width: 800px;
        margin: 0 auto 60px;
        display: flex;
        justify-content: space-between;
        position: relative;
    }
    .progress-line {
        position: absolute;
        top: 20px;
        left: 5%;
        right: 5%;
        height: 2px;
        background: #ddd;
        z-index: 1;
    }
    .progress-line-fill {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        background: var(--accent, #111);
        width: 33%; /* Updated by JS */
        transition: width 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .progress-step {
        position: relative;
        z-index: 2;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
        width: 20%;
    }
    .step-node {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #fff;
        border: 2px solid #ddd;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        transition: all 0.3s ease;
        color: #999;
    }
    .progress-step.completed .step-node {
        background: var(--accent, #111);
        border-color: var(--accent, #111);
        color: #fff;
    }
    .progress-step.active .step-node {
        border-color: var(--accent, #111);
        color: var(--accent, #111);
        box-shadow: 0 0 0 4px rgba(17,17,17,0.1);
    }
    .step-label {
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #999;
    }
    .progress-step.active .step-label, 
    .progress-step.completed .step-label {
        color: #111;
    }
    /* --- Forms Layout --- */
    .checkout-grid {
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 40px;
        max-width: 1200px;
        margin: 0 auto;
    }
    .form-card {
        background: #fff;
        border-radius: 12px;
        padding: 40px;
        border: 1px solid rgba(0,0,0,0.08);
        box-shadow: 0 4px 20px rgba(0,0,0,0.02);
    }
    .step-content {
        display: none;
    }
    .step-content.active {
        display: block;
        animation: fadeIn 0.4s ease;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .form-title {
        font-family: 'Sakana', sans-serif;
        font-size: 1.8rem;
        margin-bottom: 30px;
        color: #111;
    }
    .form-group { margin-bottom: 20px; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .form-label {
        display: block;
        font-size: 0.85rem;
        font-weight: 700;
        margin-bottom: 8px;
        color: #444;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .form-input {
        width: 100%;
        padding: 14px 18px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 1rem;
        transition: border-color 0.2s;
    }
    .form-input:focus {
        border-color: var(--accent, #111);
        outline: none;
    }
    /* --- Payment Methods --- */
    .payment-options {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    .payment-option {
        padding: 20px;
        border: 2px solid #eee;
        border-radius: 12px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 15px;
        transition: all 0.2s;
    }
    .payment-option:hover { border-color: #ddd; }
    .payment-option.selected {
        border-color: var(--accent, #111);
        background: rgba(17,17,17,0.02);
    }
    .payment-option i { font-size: 1.5rem; }
    /* --- Order Summary --- */
    .summary-sidebar {
        position: sticky;
        top: 140px;
    }
    .summary-card {
        background: #fff;
        border-radius: 12px;
        padding: 30px;
        border: 1px solid rgba(0,0,0,0.08);
    }
    .summary-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
        font-size: 0.95rem;
        color: #555;
    }
    .summary-total {
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1.5px solid #eee;
        display: flex;
        justify-content: space-between;
        font-weight: 800;
        font-size: 1.2rem;
        color: #111;
    }
    .nav-buttons {
        display: flex;
        justify-content: space-between;
        margin-top: 40px;
    }
    .btn-next, .btn-place {
        background: var(--accent, #111);
        color: #fff;
        border: none;
        padding: 16px 32px;
        border-radius: 50px;
        font-weight: 700;
        cursor: pointer;
        transition: transform 0.2s;
    }
    .btn-prev {
        background: transparent;
        color: #111;
        border: 1px solid #111;
        padding: 16px 32px;
        border-radius: 50px;
        font-weight: 700;
        cursor: pointer;
    }
    .btn-next:hover, .btn-place:hover { transform: translateY(-2px); }
    /* Processing Overlay */
    #processing-overlay {
        position: fixed;
        inset: 0;
        background: rgba(255,255,255,0.9);
        display: none;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        z-index: 2000;
        text-align: center;
    }
    .spinner {
        width: 50px;
        height: 50px;
        border: 4px solid #f3f3f3;
        border-top: 4px solid var(--accent, #111);
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-bottom: 20px;
    }
    @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
</style>
@endsection
@section('content')
<div class="checkout-page">
    <div class="container">
        <div class="checkout-progress">
            <div class="progress-line"><div class="progress-line-fill" id="progress-fill"></div></div>
            <div class="progress-step completed">
                <div class="step-node"><i class='bx bx-check'></i></div>
                <span class="step-label">Cart</span>
            </div>
            <div class="progress-step active" id="step-node-1">
                <div class="step-node">2</div>
                <span class="step-label">Delivery</span>
            </div>
            <div class="progress-step" id="step-node-2">
                <div class="step-node">3</div>
                <span class="step-label">Payment</span>
            </div>
            <div class="progress-step" id="step-node-3">
                <div class="step-node">4</div>
                <span class="step-label">Review</span>
            </div>
        </div>
        <form id="checkout-form-master" action="{{ route('orders.place') }}" method="POST">
            @csrf
            <div class="checkout-grid">
                <div class="form-card">
                    <div class="step-content active" id="step-1">
                        <h2 class="form-title">Delivery Details</h2>
                        <div class="form-group">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="customer_name" class="form-input" placeholder="John Doe" required value="{{ auth()->user() ? auth()->user()->name : '' }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Street Address</label>
                            <input type="text" name="address_line_1" class="form-input" id="address_line_1" placeholder="123 Performance Way" required>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">City</label>
                                <input type="text" name="city" class="form-input" id="city" placeholder="London" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Postcode</label>
                                <input type="text" name="postcode" class="form-input" id="postcode" placeholder="SW1A 1AA" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Country</label>
                            <select name="country" class="form-input" id="country">
                                <option value="United Kingdom">United Kingdom</option>
                                <option value="United States">United States</option>
                                <option value="Europe">Europe</option>
                            </select>
                        </div>
                        <div class="nav-buttons">
                            <div></div>
                            <button type="button" class="btn-next" onclick="nextStep(2)">Continue to Payment</button>
                        </div>
                    </div>
                    <div class="step-content" id="step-2">
                        <h2 class="form-title">Payment Method</h2>
                        <div class="payment-options">
                            <div class="payment-option selected">
                                <i class='bx bxl-visa'></i>
                                <div>
                                    <div style="font-weight: 700;">Credit / Debit Card</div>
                                    <div style="font-size: 0.8rem; color: #666;">Secure payment with encrypted processing</div>
                                </div>
                            </div>
                            <div class="payment-option">
                                <i class='bx bxl-paypal'></i>
                                <div>
                                    <div style="font-weight: 700;">PayPal</div>
                                    <div style="font-size: 0.8rem; color: #666;">Faster checkout with your PayPal account</div>
                                </div>
                            </div>
                        </div>
                        <div style="margin-top: 30px;">
                            <div class="form-group">
                                <label class="form-label">Card Number</label>
                                <input type="text" class="form-input" id="card-number" placeholder="•••• •••• •••• ••••" maxlength="19" required>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Expiry Date</label>
                                    <input type="text" class="form-input" id="card-expiry" placeholder="MM / YY" maxlength="7" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">CVV</label>
                                    <input type="text" class="form-input" id="card-cvv" placeholder="•••" maxlength="4" required>
                                </div>
                            </div>
                            <p id="card-error" style="color: #ff3e3e; font-size: 0.85rem; font-weight: 600; margin-top: -8px; display: none;"></p>
                        </div>
                        <div class="nav-buttons">
                            <button type="button" class="btn-prev" onclick="prevStep(1)">Back</button>
                            <button type="button" class="btn-next" onclick="nextStep(3)">Review Order</button>
                        </div>
                    </div>
                    <div class="step-content" id="step-3">
                        <h2 class="form-title">Order Review</h2>
                        <div style="margin-bottom: 30px; padding: 20px; background: #f9f9f9; border-radius: 8px;">
                            <h4 style="margin-bottom: 10px;">Ship to:</h4>
                            <p id="review-name" style="font-weight: 700;"></p>
                            <p id="review-address"></p>
                        </div>
                        <div class="summary-card" style="border: none; padding: 0;">
                            <h4 style="margin-bottom: 20px;">Items in your order:</h4>
                            @foreach($cart->products as $product)
                            <div class="summary-item" style="margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid #eee;">
                                <span>{{ $product->Product_name }} (x{{ $product->pivot->Product_quantity }})</span>
                                <span>£{{ number_format($product->Price * $product->pivot->Product_quantity, 2) }}</span>
                            </div>
                            @endforeach
                        </div>
                        <div class="nav-buttons">
                            <button type="button" class="btn-prev" onclick="prevStep(2)">Back</button>
                            <button type="submit" class="btn-place">Complete Purchase</button>
                        </div>
                    </div>
                </div>
                <div class="summary-sidebar">
                    <div class="summary-card">
                        <h2 style="font-size: 1.2rem; font-weight: 800; margin-bottom: 20px;">Order Summary</h2>
                        <div class="summary-item">
                            <span>Subtotal</span>
                            <span>£{{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="summary-item">
                            <span>Shipping</span>
                            <span style="color: var(--accent-dark);">FREE</span>
                        </div>
                        <div class="summary-item">
                            <span>Tax (20%)</span>
                            <span>£{{ number_format($subtotal * 0.2, 2) }}</span>
                        </div>
                        <div class="summary-total">
                            <span>Total</span>
                            <span>£{{ number_format($subtotal, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div id="processing-overlay">
    <div class="spinner"></div>
    <h2 style="font-family: 'Sakana', sans-serif;">AUTHORIZING PAYMENT</h2>
    <p>Please do not refresh the page...</p>
</div>
<script>
    function nextStep(step) {
        // Validation check for Step 1 (Delivery)
        if (step === 2) {
            const name = document.querySelector('input[name="customer_name"]').value.trim();
            const addr = document.getElementById('address_line_1').value.trim();
            const city = document.getElementById('city').value.trim();
            const post = document.getElementById('postcode').value.trim();
            if (!name || !addr || !city || !post) {
                if(typeof showToast === 'function') showToast('Please fill in all delivery details', 'error');
                else alert('Please fill in all delivery details');
                return;
            }
        }
        // Validation check for Step 2 (Payment)
        if (step === 3) {
            const cardNum = document.getElementById('card-number').value.replace(/\s/g, '');
            const cardExp = document.getElementById('card-expiry').value.trim();
            const cardCvv = document.getElementById('card-cvv').value.trim();
            const errEl   = document.getElementById('card-error');
            // Must have all fields
            if (!cardNum || !cardExp || !cardCvv) {
                errEl.textContent = 'Please fill in all card details.';
                errEl.style.display = 'block';
                return;
            }
            // Card number: only digits, 13–19 chars
            if (!/^\d{13,19}$/.test(cardNum)) {
                errEl.textContent = 'Please enter a valid card number (13–19 digits).';
                errEl.style.display = 'block';
                return;
            }
            // Expiry: MM/YY
            if (!/^(0[1-9]|1[0-2])\s*\/\s*\d{2}$/.test(cardExp)) {
                errEl.textContent = 'Please enter a valid expiry date (MM / YY).';
                errEl.style.display = 'block';
                return;
            }
            // CVV: 3–4 digits
            if (!/^\d{3,4}$/.test(cardCvv)) {
                errEl.textContent = 'Please enter a valid CVV (3-4 digits).';
                errEl.style.display = 'block';
                return;
            }
            errEl.style.display = 'none';
            // Populate Review
            document.getElementById('review-name').innerText = document.querySelector('input[name="customer_name"]').value;
            document.getElementById('review-address').innerText = 
                document.getElementById('address_line_1').value + ', ' +
                document.getElementById('city').value + ', ' +
                document.getElementById('postcode').value;
        }
        // Switch Active Step
        document.querySelectorAll('.step-content').forEach(c => c.classList.remove('active'));
        document.getElementById('step-' + step).classList.add('active');
        // Update Progress Bar
        const fill = document.getElementById('progress-fill');
        if (step === 2) {
            fill.style.width = '66%';
            document.getElementById('step-node-1').classList.add('completed');
            document.getElementById('step-node-1').classList.remove('active');
            document.getElementById('step-node-2').classList.add('active');
        } else if (step === 3) {
            fill.style.width = '100.1%';
            document.getElementById('step-node-2').classList.add('completed');
            document.getElementById('step-node-2').classList.remove('active');
            document.getElementById('step-node-3').classList.add('active');
        }
        window.scrollTo({ top: 100, behavior: 'smooth' });
    }
    function prevStep(step) {
        document.querySelectorAll('.step-content').forEach(c => c.classList.remove('active'));
        document.getElementById('step-' + step).classList.add('active');
        const fill = document.getElementById('progress-fill');
        if (step === 1) {
            fill.style.width = '33%';
            document.getElementById('step-node-1').classList.add('active');
            document.getElementById('step-node-1').classList.remove('completed');
            document.getElementById('step-node-2').classList.remove('active');
        } else if (step === 2) {
            fill.style.width = '66%';
            document.getElementById('step-node-2').classList.add('active');
            document.getElementById('step-node-2').classList.remove('completed');
            document.getElementById('step-node-3').classList.remove('active');
        }
        window.scrollTo({ top: 100, behavior: 'smooth' });
    }
    document.getElementById('checkout-form-master').addEventListener('submit', function(e) {
        document.getElementById('processing-overlay').style.display = 'flex';
    });
</script>
@endsection
