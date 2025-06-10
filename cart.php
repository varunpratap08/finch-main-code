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
                    <button class="btn-checkout w-100" id="checkoutBtn" type="button" onclick="proceedToCheckout()" disabled>
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
    let continueShoppingBtn = document.querySelector('.continue-shopping-btn');

    // Clear the container first
    cartItemsContainer.innerHTML = '';

    if (cart.length === 0) {
        cartItemsContainer.innerHTML = `
            <div class="empty-cart">
                <div class="empty-cart-icon">
                    <i class="bi bi-cart-x"></i>
                </div>
                <h3>Your cart is empty</h3>
                <p class="mb-4">Looks like you haven't added any products to your cart yet.</p>
                <a href="products.php" class="btn btn-primary">
                    <i class="bi bi-arrow-left"></i> Continue Shopping
                </a>
            </div>`;
        
        // Remove any existing continue shopping button
        if (continueShoppingBtn) {
            continueShoppingBtn.remove();
        }
        
        subtotalElement.textContent = '₹0.00';
        totalElement.textContent = '₹0.00';
        if (checkoutBtn) checkoutBtn.disabled = true;
        
        // Update the cart count in the header
        if (window.cartFunctions && typeof window.cartFunctions.updateCartUI === 'function') {
            window.cartFunctions.updateCartUI();
        }
        return;
    }

    let subtotal = 0;
    const cartItemsHTML = cart.map((item, idx) => {
        return `
            <div class="cart-item" data-index="${idx}">
                <input type="checkbox" class="item-checkbox" data-index="${idx}" checked style="margin-right: 10px; width: 18px; height: 18px;">
                <img src="${item.image || 'assets/img/placeholder-product.jpg'}" alt="${item.name}" class="cart-item-img">
                <div class="cart-item-details">
                    <h3 class="cart-item-title">${item.name}</h3>
                    <p class="cart-item-price">₹${parseFloat(item.price).toFixed(2)}</p>
                    <div class="quantity-selector">
                        <button type="button" class="quantity-btn minus" data-action="decrease" data-index="${idx}">-</button>
                        <input type="number" class="quantity-input" 
                               value="${item.qty || item.quantity || 1}" 
                               min="1" 
                               data-index="${idx}">
                        <button type="button" class="quantity-btn plus" data-action="increase" data-index="${idx}">+</button>
                    </div>
                    <p class="cart-item-subtotal">Subtotal: ₹${(item.price * (item.qty || item.quantity || 1)).toFixed(2)}</p>
                </div>
                <button class="remove-btn" data-action="remove" data-index="${idx}" title="Remove item">
                    <i class="bi bi-trash"></i>
                </button>
            </div>`;
    }).join('');

    cartItemsContainer.innerHTML = cartItemsHTML;
    
    if (subtotalElement) subtotalElement.textContent = `₹${subtotal.toFixed(2)}`;
    if (totalElement) totalElement.textContent = `₹${subtotal.toFixed(2)}`;
    if (checkoutBtn) checkoutBtn.disabled = false;
    
    // Add or update "Continue Shopping" button
    if (!continueShoppingBtn) {
        continueShoppingBtn = document.createElement('div');
        continueShoppingBtn.className = 'text-end mt-4 continue-shopping-btn';
        continueShoppingBtn.innerHTML = `
            <a href="products.php" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Continue Shopping
            </a>
        `;
        cartItemsContainer.after(continueShoppingBtn);
    }
    
    // Update the cart count in the header
    if (window.cartFunctions && typeof window.cartFunctions.updateCartUI === 'function') {
        window.cartFunctions.updateCartUI();
    }
}

// Handle cart actions with event delegation
function handleCartAction(e) {
    const target = e.target.closest('[data-action]');
    if (!target) return;

    const action = target.getAttribute('data-action');
    const index = parseInt(target.getAttribute('data-index'));
    const cart = getCart();
    
    if (isNaN(index) || index < 0 || index >= cart.length) return;

    switch (action) {
        case 'increase':
            updateQuantity(index, 1);
            break;
        case 'decrease':
            updateQuantity(index, -1);
            break;
        case 'remove':
            removeFromCart(index);
            break;
    }
}

// Handle quantity input changes
function handleQuantityInput(e) {
    if (!e.target.classList.contains('quantity-input')) return;
    
    const index = parseInt(e.target.getAttribute('data-index'));
    const value = parseInt(e.target.value) || 1;
    
    if (!isNaN(index) && index >= 0) {
        updateQuantityInput(index, value);
    }
}

// Initialize cart UI and event listeners when page loads
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, checking cart...');
    console.log('Raw localStorage cart:', localStorage.getItem('cart'));
    console.log('Parsed cart:', JSON.parse(localStorage.getItem('cart') || '[]'));
    
    // Add event listeners
    document.addEventListener('click', handleCartAction);
    document.addEventListener('change', handleQuantityInput);
    
    // Initialize cart UI
    updateCartUI();
});

// Function to update checkout modal with cart items
function updateCheckoutModal() {
    const cart = getCart();
    const cartItemsList = document.getElementById('checkoutItemsList');
    const totalPriceElement = document.getElementById('totalPrice');
    const totalPriceInput = document.getElementById('totalPriceInput');
    
    if (!cartItemsList || !totalPriceElement || !totalPriceInput) return;
    
    // Clear the cart items list
    cartItemsList.innerHTML = '';
    
    if (cart.length === 0) {
        cartItemsList.innerHTML = '<div class="alert alert-info">Your cart is empty</div>';
        totalPriceElement.textContent = '0.00';
        totalPriceInput.value = '0.00';
        return;
    }
    
    let total = 0;
    
    // Get the cart item template
    const template = document.getElementById('cartItemTemplate');
    
    cart.forEach((item, index) => {
        const clone = template.content.cloneNode(true);
        
        // Set product details
        clone.querySelector('.product-name').textContent = item.name;
        clone.querySelector('.product-price').textContent = '₹' + (item.price * item.qty).toFixed(2);
        clone.querySelector('.product-quantity').textContent = item.qty;
        clone.querySelector('.product-id').value = item.id;
        clone.querySelector('.product-quantity-input').value = item.qty;
        clone.querySelector('.product-price-input').value = item.price;
        
        // Set product image if available
        if (item.image) {
            clone.querySelector('img').src = item.image;
            clone.querySelector('img').alt = item.name;
        }
        
        // Populate size dropdown from item.sizes (admin-provided)
        const sizeSelect = clone.querySelector('.item-size');
        if (sizeSelect && Array.isArray(item.sizes)) {
            // Remove all options except the first (placeholder)
            while (sizeSelect.options.length > 1) sizeSelect.remove(1);
            item.sizes.forEach(size => {
                const option = document.createElement('option');
                option.value = size;
                option.textContent = size;
                if (item.size && item.size === size) option.selected = true;
                sizeSelect.appendChild(option);
            });
        }
        // Set selected size if available (for fallback if not in sizes array)
        if (item.size && sizeSelect) {
            for (let i = 0; i < sizeSelect.options.length; i++) {
                if (sizeSelect.options[i].value === item.size) {
                    sizeSelect.selectedIndex = i;
                    break;
                }
            }
        }
        if (item.finish) {
            const finishSelect = clone.querySelector('.item-finish');
            if (finishSelect) {
                finishSelect.value = item.finish;
            }
        }
        
        cartItemsList.appendChild(clone);
        total += item.price * item.qty;
    });
    
    // Update total price
    totalPriceElement.textContent = total.toFixed(2);
    totalPriceInput.value = total.toFixed(2);
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Make sure Bootstrap is loaded
    if (typeof bootstrap === 'undefined') {
        console.error('Bootstrap JS not loaded');
        return;
    }
    
    // Initialize any other required components
    updateCartUI();
});

function initializeModal() {
    const checkoutModalElement = document.getElementById('checkoutModal');
    if (!checkoutModalElement) return;
    
    const checkoutModal = new bootstrap.Modal(checkoutModalElement, {
        backdrop: 'static',
        keyboard: false
    });
    
    // Handle checkout button click
    const checkoutBtn = document.getElementById('checkoutBtn');
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
                const subtotalElement = document.getElementById('checkoutSubtotal');
                const totalInput = document.getElementById('checkoutTotalInput');
                
                if (totalElement) totalElement.textContent = `₹${total.toFixed(2)}`;
                if (subtotalElement) subtotalElement.textContent = `₹${total.toFixed(2)}`;
                if (totalInput) totalInput.value = total.toFixed(2);
                
                // Show the modal
                checkoutModal.show();
            }
        });
    }
    
    // Handle form submission
    const checkoutForm = document.getElementById('checkoutForm');
    if (checkoutForm) {
        checkoutForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            
            // Get all the form data
            const formData = new FormData(this);
            const cart = getCart();
            
            // Update cart items with size and finish from the form
            const sizes = formData.getAll('item_size[]');
            const finishes = formData.getAll('item_finish[]');
            
            cart.forEach((item, index) => {
                if (sizes[index]) item.size = sizes[index];
                if (finishes[index]) item.finish = finishes[index];
            });
            
            // Save the updated cart
            setCart(cart);
            
            // Prepare the order data
            const orderData = {
                customer_name: formData.get('customer_name'),
                customer_email: formData.get('customer_email'),
                customer_phone: formData.get('customer_phone'),
                shipping_address: formData.get('shipping_address'),
                total_amount: formData.get('total_amount'),
                cart_items: JSON.stringify(cart)
            };
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';
            
            // Log for debugging
            console.log('Submitting order data:', orderData);
            
            // Send data to server
            fetch('inc/process_checkout.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: new URLSearchParams(orderData)
            })
            .then(response => {
                // First, get the response as text
                return response.text().then(text => {
                    try {
                        // Try to parse as JSON
                        const data = JSON.parse(text);
                        
                        // If the response was not OK, throw an error with the message
                        if (!response.ok) {
                            throw new Error(data.message || 'Server error occurred');
                        }
                        
                        return data;
                    } catch (e) {
                        // If not valid JSON, handle as text error
                        console.error('Response was not JSON:', text);
                        
                        // If the response was OK but not JSON, something is wrong
                        if (response.ok) {
                            throw new Error('Invalid response from server');
                        }
                        
                        // If we have a non-JSON error response, use its text
                        throw new Error(text || 'Server error occurred');
                    }
                });
            })
            .then(data => {
                console.log('Response data:', data);
                
                if (data.status === 'success') {
                    // Clear cart on success
                    localStorage.setItem('cart', '[]');
                    updateCartUI();
                    
                    // Show success message
                    showToast(data.message || 'Order placed successfully!', 'success');
                    
                    // Close modal
                    if (typeof bootstrap !== 'undefined') {
                        const modal = bootstrap.Modal.getInstance(document.getElementById('checkoutModal'));
                        if (modal) modal.hide();
                    }
                    
                    // Redirect to thank you page with order ID
                    if (data.data && data.data.redirect) {
                        window.location.href = data.data.redirect;
                    } else {
                        // Fallback to default thank you page
                        window.location.href = 'thank-you.php' + (data.data && data.data.order_id ? '?order_id=' + data.data.order_id : '');
                    }
                } else {
                    throw new Error(data.message || 'Failed to place order');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                let errorMessage = 'An error occurred. Please try again.';
                
                // Try to extract a more specific error message
                if (error.message.includes('JSON')) {
                    errorMessage = 'Invalid response from server. Please try again.';
                } else if (error.message) {
                    errorMessage = error.message;
                }
                
                showToast(errorMessage, 'error');
            })
            .finally(() => {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText;
                }
            });
        });
    }
}

// Get selected cart items (checkboxes)
function getSelectedCartItems() {
    const checkboxes = document.querySelectorAll('.item-checkbox:checked');
    const cart = getCart();
    return Array.from(checkboxes).map(checkbox => {
        const index = parseInt(checkbox.getAttribute('data-index'));
        return cart[index];
    }).filter(Boolean);
}

// Update checkout modal with only selected items
function updateCheckoutModal() {
    const selectedItems = getSelectedCartItems();
    const cartItemsList = document.getElementById('checkoutItemsList');
    const totalPriceElement = document.getElementById('totalPrice');
    const totalPriceInput = document.getElementById('totalPriceInput');
    if (!cartItemsList || !totalPriceElement || !totalPriceInput) return;
    // Clear the cart items list
    cartItemsList.innerHTML = '';
    
    if (selectedItems.length === 0) {
        cartItemsList.innerHTML = '<div class="alert alert-info">No products selected for checkout.</div>';
        totalPriceElement.textContent = '0.00';
        totalPriceInput.value = '0.00';
        return;
    }
    
    let total = 0;
    const template = document.getElementById('cartItemTemplate');
    selectedItems.forEach((item, index) => {
        const clone = template.content.cloneNode(true);
        clone.querySelector('.product-name').textContent = item.name;
        clone.querySelector('.product-price').textContent = '₹' + (item.price * item.qty).toFixed(2);
        clone.querySelector('.product-quantity').textContent = item.qty;
        clone.querySelector('.product-id').value = item.id;
        clone.querySelector('.product-quantity-input').value = item.qty;
        clone.querySelector('.product-price-input').value = item.price;
        if (item.image) {
            clone.querySelector('img').src = item.image;
            clone.querySelector('img').alt = item.name;
        }
        // Populate size dropdown from item.sizes (admin-provided)
        const sizeSelect = clone.querySelector('.item-size');
        if (sizeSelect && Array.isArray(item.sizes)) {
            // Remove all options except the first (placeholder)
            while (sizeSelect.options.length > 1) sizeSelect.remove(1);
            item.sizes.forEach(size => {
                const option = document.createElement('option');
                option.value = size;
                option.textContent = size;
                if (item.size && item.size === size) option.selected = true;
                sizeSelect.appendChild(option);
            });
        }
        // Set selected size if available (for fallback if not in sizes array)
        if (item.size && sizeSelect) {
            for (let i = 0; i < sizeSelect.options.length; i++) {
                if (sizeSelect.options[i].value === item.size) {
                    sizeSelect.selectedIndex = i;
                    break;
                }
            }
        }
        if (item.finish) {
            const finishSelect = clone.querySelector('.item-finish');
            if (finishSelect) {
                finishSelect.value = item.finish;
            }
        }
        cartItemsList.appendChild(clone);
        total += item.price * item.qty;
    });
    totalPriceElement.textContent = total.toFixed(2);
    totalPriceInput.value = total.toFixed(2);
}

// Update order summary in the modal
function updateOrderSummary() {
    const cart = getCart();
    const checkoutItemsList = document.getElementById('checkoutItemsList');
    const template = document.getElementById('cartItemTemplate');
    
    if (!checkoutItemsList || !template) return;
    
    // Clear existing items
    checkoutItemsList.innerHTML = '';
    
    // Add each item to the summary
    cart.forEach((item, index) => {
        const clone = template.content.cloneNode(true);
        const itemElement = clone.querySelector('.cart-item-details');
        
        // Set item data
        itemElement.querySelector('img').src = item.image || 'assets/img/placeholder.jpg';
        itemElement.querySelector('.product-name').textContent = item.name;
        itemElement.querySelector('.product-price').textContent = '₹' + (item.price * (item.qty || 1)).toFixed(2);
        itemElement.querySelector('.product-quantity').textContent = item.qty || 1;
        
        // Set hidden inputs
        const inputs = clone.querySelectorAll('input[type="hidden"]');
        inputs.forEach(input => {
            if (input.className.includes('product-id')) input.value = item.id;
            if (input.className.includes('product-quantity-input')) input.value = item.qty || 1;
            if (input.className.includes('product-price-input')) input.value = item.price * (item.qty || 1);
        });
        
        checkoutItemsList.appendChild(clone);
    });
    
    // Update total
    const total = cart.reduce((sum, item) => sum + (item.price * (item.qty || 1)), 0);
    const totalElement = document.getElementById('totalPrice');
    const totalInput = document.getElementById('totalPriceInput');
    
    if (totalElement) totalElement.textContent = total.toFixed(2);
    if (totalInput) totalInput.value = total.toFixed(2);
}

// Handle checkout button click
function proceedToCheckout() {
    const selectedItems = getSelectedCartItems();
    if (selectedItems.length === 0) {
        showToast('Please select at least one product to checkout.');
        return;
    }
    const checkoutModalElement = document.getElementById('checkoutModal');
    if (!checkoutModalElement) return;
    // Update order summary before showing the modal
    updateCheckoutModal(); // This will now use only selected items
    // Initialize and show the modal
    const checkoutModal = new bootstrap.Modal(checkoutModalElement, {
        backdrop: 'static',
        keyboard: false
    });
    checkoutModal.show();
    // Set focus to the first input when modal is shown
    checkoutModalElement.addEventListener('shown.bs.modal', function() {
        const firstInput = checkoutModalElement.querySelector('input, textarea, select');
        if (firstInput) {
            firstInput.focus();
        }
    }, { once: true });
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

// Function to update finish options based on selected size
function updateFinishOptions(selectElement) {
    const finishSelect = selectElement.parentElement.parentElement.nextElementSibling.querySelector('.item-finish');
    const selectedSize = selectElement.selectedOptions[0];
    
    if (!selectedSize || selectedSize.value === '') {
        finishSelect.querySelectorAll('option').forEach((option, index) => {
            option.disabled = index > 0;
        });
        finishSelect.value = '';
        return;
    }
    
    // Enable all finish options
    finishSelect.querySelectorAll('option').forEach((option, index) => {
        if (index > 0) {
            option.disabled = false;
        }
    });
    
    // Update price if available
    updateTotalPrice();
}

// Function to update total price based on selected options
function updateTotalPrice() {
    let total = 0;
    document.querySelectorAll('.cart-item-details').forEach((item, index) => {
        const sizeSelect = item.querySelector('.item-size');
        const finishSelect = item.querySelector('.item-finish');
        const quantityInput = document.querySelectorAll('.product-quantity-input')[index];
        const priceElement = item.querySelector('.product-price');
        
        if (sizeSelect && finishSelect && quantityInput && priceElement) {
            const sizeOption = sizeSelect.selectedOptions[0];
            const finishValue = finishSelect.value;
            const quantity = parseInt(quantityInput.value) || 0;
            
            if (sizeOption && finishValue && quantity > 0) {
                const price = parseFloat(sizeOption.dataset[finishValue]) || 0;
                total += price * quantity;
                priceElement.textContent = '₹' + (price * quantity).toFixed(2);
            }
        }
    });
    
    const totalElement = document.getElementById('totalPrice');
    const totalInput = document.getElementById('totalPriceInput');
    
    if (totalElement) totalElement.textContent = total.toFixed(2);
    if (totalInput) totalInput.value = total.toFixed(2);
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
        
        // In the checkout form submission handler, use only selected items
        const selectedItems = getSelectedCartItems();
        if (selectedItems.length === 0) {
            showToast('Please select at least one product to checkout.');
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
            return;
        }
        // Add selected cart items to form data
        selectedItems.forEach((item, index) => {
            formData.append(`items[${index}][product_id]`, item.id);
            formData.append(`items[${index}][quantity]`, item.qty);
            formData.append(`items[${index}][size]`, item.size || '');
            formData.append(`items[${index}][finish]`, item.finish || '');
            formData.append(`items[${index}][price]`, item.price);
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

// Update order summary when checkboxes change
document.addEventListener('change', function(e) {
    if (e.target.classList.contains('item-checkbox')) {
        updateOrderSummary();
    }
});
</script>

<!-- Checkout Modal -->
<div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="checkoutModalLabel">Complete Your Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form id="checkoutForm" action="inc/process_checkout.php" method="POST">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Full Name</label>
                                        <input type="text" class="form-control" name="customer_name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Email Address</label>
                                        <input type="email" class="form-control" name="customer_email" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Phone Number</label>
                                        <input type="tel" class="form-control" name="customer_phone" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Shipping Address</label>
                                        <textarea class="form-control" name="shipping_address" rows="3" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <h5 class="mb-3">Order Summary</h5>
                                <div id="checkoutItemsList" class="mb-3">
                                    <!-- Cart items will be dynamically inserted here -->
                                </div>
                                
                                <!-- Hidden template for cart item with size and finish options -->
                                <template id="cartItemTemplate">
                                    <div class="card mb-3 cart-item-details">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-md-2">
                                                    <img src="" class="img-fluid rounded" alt="Product Image" style="max-height: 80px;">
                                                </div>
                                                <div class="col-md-4">
                                                    <h6 class="mb-1 product-name"></h6>
                                                    <p class="mb-1">Price: <span class="product-price"></span></p>
                                                    <p class="mb-1">Qty: <span class="product-quantity"></span></p>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-2">
                                                        <label class="form-label small mb-1">Size</label>
                                                        <select class="form-select form-select-sm item-size" name="item_size[]" required onchange="updateFinishOptions(this)">
                                                            <option value="">Choose Size</option>
                                                            <!-- Sizes will be populated by JavaScript -->
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-2">
                                                        <label class="form-label small mb-1">Finish</label>
                                                        <select class="form-select form-select-sm item-finish" name="item_finish[]" required>
                                                            <option value="">Choose Finish</option>
                                                            <option value="sn">Satin Nickel</option>
                                                            <option value="bk">Black</option>
                                                            <option value="an">Antique Nickel</option>
                                                            <option value="gd">Gold</option>
                                                            <option value="rg">Rose Gold</option>
                                                            <option value="ch">Chrome</option>
                                                            <option value="gl">Glossy</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="product_id[]" class="product-id">
                                    <input type="hidden" name="quantity[]" class="product-quantity-input">
                                    <input type="hidden" name="price[]" class="product-price-input">
                                </template>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="mb-0">Total:</h5>
                                <h4 class="mb-0">₹<span id="totalPrice">0</span></h4>
                                <input type="hidden" name="total_amount" id="totalPriceInput">
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-success btn-lg px-4">
                                    <i class="bi bi-credit-card me-2"></i>Place Order
                                </button>
                            </div>
                        </form>
                    </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include('inc/footer.php'); ?>

<!-- Vendor JS Files -->
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/aos/aos.js"></script>
<script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

<!-- Template Main JS File -->
<script src="assets/js/main.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
