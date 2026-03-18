const modal = document.getElementById('checkoutModal');
const btn = document.getElementById('checkoutBtn');
const span = document.querySelector('.cart-page .close');
const sameAdrCheckbox = document.getElementById('sameAsBilling');
const shippingAddress = document.getElementById('shippingAddress');

btn.onclick = function() { modal.style.display = 'block'; }
span.onclick = function() { modal.style.display = 'none'; }
window.onclick = function(event) {
  if (event.target == modal) { modal.style.display = 'none'; }
}

// Toggle shipping address
sameAdrCheckbox.addEventListener('change', () => {
  shippingAddress.style.display = sameAdrCheckbox.checked ? 'none' : 'block';
});

// Place order
document.getElementById('place-order-btn').addEventListener('click', async function() {
    const customerName = document.getElementById('fname').value.trim();
    const deliveryAddress = document.getElementById('adr').value.trim();

    if (!customerName || !deliveryAddress) {
        alert("Please enter both name and delivery address.");
        return;
    }

    try {
        const response = await fetch("/orders/place", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ customer_name: customerName, delivery_address: deliveryAddress })
        });

        if (!response.ok) throw new Error("Failed to place order");

        let invoice = `Order Placed Successfully!\n\nName: ${customerName}\nAddress: ${deliveryAddress}\n\nProducts:\n`;

        const products = JSON.parse(document.getElementById('products-json').textContent);
        products.forEach(p => invoice += `- ${p.name} (${p.qty}) x £${p.price.toFixed(2)}\n`);

        invoice += `\nTotal: £${products.reduce((acc,p)=>acc+p.qty*p.price,0).toFixed(2)}`;

        alert(invoice);
        location.reload();
    } catch (err) { alert("Error placing order: " + err.message); }
});