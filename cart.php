<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Your Cart - Pali Industries</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="assets/css/main.css" rel="stylesheet">

    <style>
        :root {
            --primary: #f1c40f;
            --primary-light: #f9e79f;
            --secondary: #6c757d;
            --light: #f8f9fa;
            --dark: #343a40;
            --border-radius: 12px;
            --box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fb;
            color: #333;
            padding-top: 80px; /* Proper spacing for fixed header */
            margin: 0;
            min-height: 100vh; /* Ensures full viewport height */
        }

        .cart-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1rem 4rem; /* Added more bottom padding for footer */
            min-height: calc(100vh - 280px); /* Account for header and footer */
        }

        .cart-header {
            background: #ffffff;
            padding: 1rem 2rem;
            margin-bottom: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            position: relative;
            z-index: 1;
        }

        .cart-title {
            font-weight: 600;
            color: #32353a;
            margin: 0;
            font-size: 1.75rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-family: var(--heading-font, "Montserrat", sans-serif);
        }

        .cart-title i {
            color: var(--primary);
        }

        .cart-item {
            background: white;
            border-radius: var(--border-radius);
            padding: 1.5rem;
            margin-bottom: 1rem;
            box-shadow: var(--box-shadow);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }

        .cart-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }

        .cart-item-img {
            width: 100px;
            height: 100px;
            object-fit: contain;
            border-radius: 8px;
            background: var(--light);
            padding: 0.75rem;
            margin-right: 1.5rem;
            border: 1px solid #eee;
        }

        .cart-item-details {
            flex: 1;
        }

        .cart-item-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin: 0 0 0.5rem;
            color: var(--dark);
        }

        .cart-item-price {
            font-weight: 700;
            color: var(--dark);
            font-size: 1.1rem;
            margin: 0.5rem 0;
        }

        .quantity-selector {
            display: flex;
            align-items: center;
            margin: 0.75rem 0;
        }

        .quantity-btn {
            width: 32px;
            height: 32px;
            border: 1px solid #dee2e6;
            background: white;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 1rem;
        }

        .quantity-input {
            width: 50px;
            height: 32px;
            text-align: center;
            border: 1px solid #dee2e6;
            border-left: none;
            border-right: none;
            -moz-appearance: textfield;
            font-weight: 500;
        }

        .remove-btn {
            color: #dc3545;
            background: none;
            border: none;
            font-size: 1.25rem;
            cursor: pointer;
            padding: 0.5rem;
            margin-left: 1rem;
            opacity: 0.7;
        }

        .remove-btn:hover {
            opacity: 1;
            transform: scale(1.1);
        }

        .cart-summary {
            background: white;
            border-radius: var(--border-radius);
            padding: 1.75rem;
            box-shadow: var(--box-shadow);
            position: sticky;
            top: 1.5rem;
        }

        .summary-title {
            font-size: 1.35rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #eee;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.75rem;
            font-size: 0.95rem;
        }

        .summary-total {
            font-size: 1.25rem;
            font-weight: 700;
            margin: 1.5rem 0;
            padding-top: 1rem;
            border-top: 1px solid #eee;
        }

        .btn-checkout {
            background: var(--primary);
            color: var(--dark);
            border: none;
            padding: 0.85rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .btn-checkout:hover {
            background: #e6b800;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(241, 196, 15, 0.3);
        }

        .btn-checkout:disabled {
            background: #e9ecef;
            color: #adb5bd;
            cursor: not-allowed;
        }

        @media (max-width: 768px) {
            .cart-item {
                flex-direction: column;
                text-align: center;
                padding: 1.5rem 1rem;
            }

            .cart-item-img {
                margin: 0 auto 1.25rem;
                width: 150px;
                height: 150px;
            }

            .cart-item-details {
                width: 100%;
                margin-bottom: 1rem;
                text-align: center;
            }

            .quantity-selector {
                justify-content: center;
                margin: 1rem auto;
            }

            .remove-btn {
                position: static;
                margin: 0.5rem auto 0;
                display: inline-flex;
            }

            .cart-summary {
                margin-top: 2rem;
            }
        }
    </style>
</head>
<body>
<?php include('inc/header.php'); ?>

    <div class="cart-container">
        <div class="cart-header">
            <h1 class="cart-title"><i class="bi bi-cart3"></i> Your Shopping Cart</h1>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-8">
                <div id="cartItems"></div>
                <div class="text-end mt-4">
                    <a href="products.php" class="btn btn-outline-secondary">Continue Shopping</a>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="cart-summary">
                    <h3 class="summary-title">Order Summary</h3>
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span id="subtotal">₹0.00</span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping</span>
                        <span>Calculated at checkout</span>
                    </div>
                    <div class="summary-row">
                        <span>Tax</span>
                        <span>Calculated at checkout</span>
                    </div>
                    <div class="summary-row summary-total">
                        <span>Total</span>
                        <span id="total">₹0.00</span>
                    </div>
                    <button class="btn-checkout w-100" id="checkoutBtn" onclick="proceedToCheckout()" disabled>
                        <i class="bi bi-lock-fill"></i> Proceed to Checkout
                    </button>
                </div>
            </div>
        </div>
    </div>
<script>
// Use global cart functions from header.php
function getCart() {
    return window.cartFunctions.getCart();
}

function setCart(cart) {
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartUI();
}

function updateQuantity(idx, amount) {
    const cart = getCart();
    if (cart[idx]) {
        const currentQty = cart[idx].qty || cart[idx].quantity || 1;
        const newQty = Math.max(1, currentQty + amount);
        window.cartFunctions.updateQuantity(cart[idx].id, newQty);
        updateCartUI();
    }
}

function updateQuantityInput(idx, value) {
    const cart = getCart();
    if (cart[idx]) {
        const newQty = Math.max(1, parseInt(value) || 1);
        window.cartFunctions.updateQuantity(cart[idx].id, newQty);
        updateCartUI();
    }
}

function removeFromCart(idx) {
    const cart = getCart();
    if (cart[idx]) {
        window.cartFunctions.removeFromCart(cart[idx].id);
        updateCartUI();
    }
}

function updateCartUI() {
    const cart = getCart();
    const cartItemsContainer = document.getElementById('cartItems');
    const subtotalElement = document.getElementById('subtotal');
    const totalElement = document.getElementById('total');
    const checkoutBtn = document.getElementById('checkoutBtn');

    if (cart.length === 0) {
        cartItemsContainer.innerHTML = `
            <div class="empty-cart">
                <div class="empty-cart-icon">
                    <i class="bi bi-cart-x"></i>
                </div>
                <h3>Your cart is empty</h3>
                <p>Looks like you haven't added any products to your cart yet.</p>
                <a href="products.php" class="btn btn-primary">
                    <i class="bi bi-arrow-left"></i> Continue Shopping
                </a>
            </div>`;
        subtotalElement.textContent = '₹0.00';
        totalElement.textContent = '₹0.00';
        checkoutBtn.disabled = true;
        return;
    }

    let subtotal = 0;
    cartItemsContainer.innerHTML = cart.map((item, idx) => {
        const quantity = item.qty || item.quantity || 1;
        const itemTotal = item.price * quantity;
        subtotal += itemTotal;
        
        return `
            <div class="cart-item" data-index="${idx}">
                <img src="${item.image || 'assets/img/placeholder-product.jpg'}" alt="${item.name}" class="cart-item-img">
                <div class="cart-item-details">
                    <h3 class="cart-item-title">${item.name}</h3>
                    <p class="cart-item-price">₹${parseFloat(item.price).toFixed(2)}</p>
                    <div class="quantity-selector">
                        <button type="button" class="quantity-btn minus" onclick="updateQuantity(${idx}, -1)">-</button>
                        <input type="number" class="quantity-input" 
                               value="${quantity}" 
                               min="1" 
                               onchange="updateQuantityInput(${idx}, this.value)">
                        <button type="button" class="quantity-btn plus" onclick="updateQuantity(${idx}, 1)">+</button>
                    </div>
                    <p class="cart-item-subtotal">Subtotal: ₹${itemTotal.toFixed(2)}</p>
                </div>
                <button class="remove-btn" onclick="removeFromCart(${idx})" title="Remove item">
                    <i class="bi bi-trash"></i>
                </button>
            </div>`;
    }).join('');

    subtotalElement.textContent = `₹${subtotal.toFixed(2)}`;
    totalElement.textContent = `₹${subtotal.toFixed(2)}`; // In a real app, you'd add shipping and tax here
    checkoutBtn.disabled = false;
    
    // Update the cart count in the header
    window.cartFunctions.updateCartUI();
}

// Initialize cart UI when page loads
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, checking cart...');
    console.log('Raw localStorage cart:', localStorage.getItem('cart'));
    console.log('Parsed cart:', JSON.parse(localStorage.getItem('cart') || '[]'));
    updateCartUI();
});

// Initialize checkout modal when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    const checkoutModalElement = document.getElementById('checkoutModal');
    const checkoutModal = new bootstrap.Modal(checkoutModalElement, {
        backdrop: 'static',
        keyboard: false
    });
    
    const checkoutForm = document.getElementById('checkoutForm');
    const checkoutBtn = document.getElementById('checkoutBtn');

    // Handle checkout button click
    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', function() {
            const cart = getCart();
            if (cart.length === 0) {
                showToast('Your cart is empty. Please add some products before checkout.');
                return;
            }
            
            // Set the cart items in the modal
            const cartItemsList = document.getElementById('checkoutItems');
            if (cartItemsList) {
                cartItemsList.innerHTML = '';
                
                cart.forEach((item) => {
                    const li = document.createElement('li');
                    li.className = 'list-group-item d-flex justify-content-between align-items-center';
                    li.innerHTML = `
                        <div>
                            <h6 class="mb-1">${item.name}</h6>
                            <small class="text-muted">Qty: ${item.qty || 1}</small>
                        </div>
                        <span class="badge bg-primary rounded-pill">₹${(item.price * (item.qty || 1)).toFixed(2)}</span>
                    `;
                    cartItemsList.appendChild(li);
                });
                
                // Calculate and update total
                const total = cart.reduce((sum, item) => sum + (item.price * (item.qty || 1)), 0);
                const totalElement = document.getElementById('checkoutTotal');
                const totalInput = document.getElementById('checkoutTotalInput');
                
                if (totalElement) totalElement.textContent = `₹${total.toFixed(2)}`;
                if (totalInput) totalInput.value = total.toFixed(2);
                
                // Show the modal
                checkoutModal.show();
            }
        });
    }
});

// Handle checkout button click
function proceedToCheckout() {
    const cart = getCart();
    if (cart.length === 0) {
        showToast('Your cart is empty');
        return;
    }
    
    // Initialize Bootstrap modal if not already done
    if (typeof bootstrap !== 'undefined') {
        const checkoutModal = new bootstrap.Modal(document.getElementById('checkoutModal'));
        checkoutModal.show();
    } else {
        // Fallback in case Bootstrap JS is not loaded
        document.getElementById('checkoutModal').style.display = 'block';
        document.body.classList.add('modal-open');
    }
}

// Show toast notification
function showToast(message) {
    const toast = document.createElement('div');
    toast.className = 'position-fixed bottom-0 end-0 m-3 p-3 bg-dark text-white rounded shadow';
    toast.style.zIndex = '1100';
    toast.textContent = message;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.remove();
    }, 3000);
    
    return toast;
}

// Handle checkout form submission
if (checkoutForm) {
    checkoutForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';
        
        const formData = new FormData(this);
        const cart = getCart();
        
        // Add cart items to form data
        cart.forEach((item) => {
            formData.append('product_ids[]', item.id);
            formData.append('quantities[]', item.qty || 1);
            formData.append('prices[]', item.price);
        });
        
        // Submit the form data
        fetch('inc/process_checkout.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Clear the cart and show success message
                localStorage.removeItem('cart');
                checkoutModal.hide();
                showToast('Order placed successfully!');
                
                // Update cart UI
                updateCartUI();
                
                // Redirect to thank you page after a short delay
                setTimeout(() => {
                    window.location.href = 'thank-you.php';
                }, 1500);
            } else {
                showToast(data.message || 'Error placing order. Please try again.');
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('An error occurred. Please try again.');
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
        });
    });
}
</script>

<!-- Checkout Modal -->
<div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="checkoutModalLabel">Complete Your Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-7">
                        <form id="checkoutForm">
                            <h6 class="mb-3">Contact Information</h6>
                            <div class="mb-3">
                                <label for="customer_name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" name="customer_name" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="customer_email" class="form-label">Email</label>
                                    <input type="email" class="form-control" name="customer_email" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="customer_phone" class="form-label">Phone</label>
                                    <input type="tel" class="form-control" name="customer_phone" required>
                                </div>
                            </div>
                            
                            <h6 class="mt-4 mb-3">Shipping Address</h6>
                            <div class="mb-3">
                                <label for="shipping_address" class="form-label">Address</label>
                                <textarea class="form-control" name="shipping_address" rows="3" required></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="city" class="form-label">City</label>
                                    <input type="text" class="form-control" name="city" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="state" class="form-label">State</label>
                                    <input type="text" class="form-control" name="state" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="pincode" class="form-label">Pincode</label>
                                    <input type="text" class="form-control" name="pincode" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="country" class="form-label">Country</label>
                                    <input type="text" class="form-control" name="country" value="India" required>
                                </div>
                            </div>
                            
                            <h6 class="mt-4 mb-3">Order Notes (Optional)</h6>
                            <div class="mb-3">
                                <textarea class="form-control" name="order_notes" rows="2" placeholder="Notes about your order, e.g. special delivery instructions"></textarea>
                            </div>
                            
                            <input type="hidden" name="total_amount" id="checkoutTotalInput">
                            <button type="submit" class="btn btn-primary w-100 py-2">Place Order</button>
                        </form>
                    </div>
                    <div class="col-md-5">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">Order Summary</h5>
                            </div>
                            <div class="card-body p-0">
                                <ul class="list-group list-group-flush" id="checkoutItems">
                                    <!-- Cart items will be added here -->
                                </ul>
                                <div class="p-3 border-top">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span>Subtotal</span>
                                        <span id="checkoutSubtotal">₹0.00</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span>Shipping</span>
                                        <span>Free</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center fw-bold fs-5 mt-3">
                                        <span>Total</span>
                                        <span id="checkoutTotal">₹0.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('inc/footer.php'); ?>
</body>
</html>
