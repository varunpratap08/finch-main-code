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
// Wait for the DOM to be fully loaded before initializing the cart
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM fully loaded, initializing cart...');
    
    // Initialize cart functions
    const cartFunctions = {
        getCart: function() {
            try {
                const cart = JSON.parse(localStorage.getItem('cart')) || [];
                console.log('Getting cart:', cart);
                return Array.isArray(cart) ? cart : [];
            } catch (e) {
                console.error('Error parsing cart from localStorage:', e);
                return [];
            }
        },
        
        updateCartUI: function() {
            const cart = this.getCart();
            const cartCount = document.querySelector('.cart-count');
            if (cartCount) {
                const itemCount = cart.reduce((total, item) => total + (parseInt(item.qty) || parseInt(item.quantity) || 1), 0);
                cartCount.textContent = itemCount > 0 ? itemCount : '';
                cartCount.style.display = itemCount > 0 ? 'flex' : 'none';
            }
            
            // Update the cart items display
            this.renderCartItems();
        },
        
        renderCartItems: function() {
            const cart = this.getCart();
            const cartItemsContainer = document.getElementById('cartItems');
            const subtotalElement = document.getElementById('subtotal');
            const totalElement = document.getElementById('total');
            
            if (!cartItemsContainer) return;
            
            // Clear the container first
            cartItemsContainer.innerHTML = '';
            
            console.log('Rendering cart items:', cart);
            
            if (!cart || cart.length === 0) {
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
                
                if (subtotalElement) subtotalElement.textContent = '₹0.00';
                if (totalElement) totalElement.textContent = '₹0.00';
                
                // Disable checkout button
                const checkoutBtn = document.getElementById('checkoutBtn');
                if (checkoutBtn) checkoutBtn.disabled = true;
                
                return;
            }
            
            // Calculate subtotal and render items
            let subtotal = 0;
            const cartItemsHTML = cart.map((item, idx) => {
                const quantity = parseInt(item.qty || item.quantity || 1);
                const price = parseFloat(item.price || 0);
                const itemTotal = quantity * price;
                subtotal += itemTotal;
                
                const imageSrc = item.image && item.image !== 'undefined' ? item.image : 'assets/img/placeholder-product.jpg';
                
                return `
                    <div class="cart-item" data-index="${idx}">
                        <input type="checkbox" class="item-checkbox" data-index="${idx}" checked style="margin-right: 10px; width: 18px; height: 18px;">
                        <img src="${imageSrc}" alt="${item.name || 'Product'}" class="cart-item-img" onerror="this.src='assets/img/placeholder-product.jpg'">
                        <div class="cart-item-details">
                            <h3 class="cart-item-title">${item.name || 'Product'}</h3>
                            <p class="cart-item-price">₹${price.toFixed(2)}</p>
                            <div class="quantity-selector">
                                <button type="button" class="quantity-btn minus" data-action="decrease" data-index="${idx}">-</button>
                                <input type="number" class="quantity-input" 
                                       value="${quantity}" 
                                       min="1" 
                                       data-index="${idx}">
                                <button type="button" class="quantity-btn plus" data-action="increase" data-index="${idx}">+</button>
                            </div>
                            <p class="cart-item-subtotal">Subtotal: ₹${itemTotal.toFixed(2)}</p>
                        </div>
                        <button class="remove-btn" data-action="remove" data-index="${idx}" title="Remove item">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>`;
            }).join('');
            
            cartItemsContainer.innerHTML = cartItemsHTML;
            
            // Update subtotal and total
            if (subtotalElement) subtotalElement.textContent = `₹${subtotal.toFixed(2)}`;
            if (totalElement) totalElement.textContent = `₹${subtotal.toFixed(2)}`;
            
            // Update checkout button state
            this.updateCheckoutButton();
        },
        
        updateQuantity: function(idx, amount) {
            const cart = this.getCart();
            if (cart[idx]) {
                const currentQty = parseInt(cart[idx].qty || cart[idx].quantity || 1);
                const newQty = Math.max(1, currentQty + amount);
                cart[idx].qty = newQty;
                this.saveCart(cart);
                
                // Update the input field
                const input = document.querySelector(`.quantity-input[data-index="${idx}"]`);
                if (input) input.value = newQty;
            }
        },
        
        updateQuantityInput: function(idx, value) {
            const cart = this.getCart();
            if (cart[idx]) {
                const newQty = Math.max(1, parseInt(value) || 1);
                cart[idx].qty = newQty;
                this.saveCart(cart);
            }
        },
        
        removeFromCart: function(idx) {
            const cart = this.getCart();
            if (cart[idx]) {
                cart.splice(idx, 1);
                this.saveCart(cart);
            }
        },
        
        saveCart: function(cart) {
            try {
                localStorage.setItem('cart', JSON.stringify(cart));
                this.updateCartUI();
            } catch (e) {
                console.error('Error saving cart:', e);
            }
        },
        
        updateCheckoutButton: function() {
            const checkoutBtn = document.getElementById('checkoutBtn');
            if (checkoutBtn) {
                const checked = document.querySelectorAll('.item-checkbox:checked').length > 0;
                checkoutBtn.disabled = !checked;
            }
        },
        
        handleCartAction: function(e) {
            const target = e.target.closest('[data-action]');
            if (!target) return;
            
            const action = target.getAttribute('data-action');
            const index = parseInt(target.getAttribute('data-index'));
            
            if (isNaN(index)) return;
            
            e.preventDefault();
            
            switch (action) {
                case 'increase':
                    this.updateQuantity(index, 1);
                    break;
                case 'decrease':
                    this.updateQuantity(index, -1);
                    break;
                case 'remove':
                    this.removeFromCart(index);
                    break;
            }
        }
    };
    
    // Make cartFunctions available globally
    window.cartFunctions = cartFunctions;
    
    // Initialize the cart UI
    cartFunctions.updateCartUI();
    
    // Set up event delegation for cart actions
    document.addEventListener('click', function(e) {
        cartFunctions.handleCartAction(e);
    });
    
    // Handle quantity input changes
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('quantity-input')) {
            const index = parseInt(e.target.getAttribute('data-index'));
            if (!isNaN(index)) {
                cartFunctions.updateQuantityInput(index, e.target.value);
            }
        }
    });
    
    // Handle checkbox changes
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('item-checkbox')) {
            cartFunctions.updateCheckoutButton();
        }
    });
    
    // Initialize checkout modal if it exists
    const checkoutModal = document.getElementById('checkoutModal');
    if (checkoutModal && typeof bootstrap !== 'undefined') {
        new bootstrap.Modal(checkoutModal, {
            backdrop: 'static',
            keyboard: false
        });
    }
    
    // Handle checkout button click
    const checkoutBtn = document.getElementById('checkoutBtn');
    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', function() {
            const checkoutModal = new bootstrap.Modal(document.getElementById('checkoutModal'));
            checkoutModal.show();
        });
    }
});

// Local cart functions for backward compatibility
function getCart() {
    return window.cartFunctions ? window.cartFunctions.getCart() : [];
}

function setCart(cart) {
    if (window.cartFunctions) {
        window.cartFunctions.saveCart(cart);
    }
}

function updateCartUI() {
    if (window.cartFunctions) {
        window.cartFunctions.updateCartUI();
    }
}

function updateQuantity(idx, amount) {
    if (window.cartFunctions) {
        window.cartFunctions.updateQuantity(idx, amount);
    }
}

function updateQuantityInput(idx, value) {
    if (window.cartFunctions) {
        window.cartFunctions.updateQuantityInput(idx, value);
    }
}

function removeFromCart(idx) {
    if (window.cartFunctions) {
        window.cartFunctions.removeFromCart(idx);
    }
}

function updateCheckoutButton() {
    if (window.cartFunctions) {
        window.cartFunctions.updateCheckoutButton();
    }
}

// Handle the proceed to checkout button
function proceedToCheckout() {
    const cart = getCart();
    if (cart.length === 0) {
        alert('Your cart is empty. Please add items to your cart before checking out.');
        return;
    }
    
    // Show the checkout modal
    const checkoutModal = new bootstrap.Modal(document.getElementById('checkoutModal'));
    checkoutModal.show();
    
    // Update the checkout modal with current cart items
    updateCheckoutModal();
    
    const checkoutBtn = document.getElementById('checkoutBtn');
    let continueShoppingBtn = document.querySelector('.continue-shopping-btn');

    // Clear the container first
    if (!cartItemsContainer) return;
    cartItemsContainer.innerHTML = '';
    
    console.log('Updating cart UI with items:', cart); // Debug log

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
    if (checkoutBtn) {
        // Enable if at least one item is checked
        const checked = document.querySelectorAll('.item-checkbox:checked').length > 0;
        checkoutBtn.disabled = !checked;
    }
    
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
    if (!window.cartFunctions) return;
    
    const target = e.target.closest('[data-action]');
    if (!target) return;

    const action = target.getAttribute('data-action');
    const index = parseInt(target.getAttribute('data-index'));
    
    if (isNaN(index)) return;
    
    e.preventDefault();
    
    const cart = window.cartFunctions.getCart();
    if (!cart[index]) return;
    
    switch (action) {
        case 'increase':
            window.cartFunctions.updateQuantity(cart[index].id, (cart[index].qty || 1) + 1);
            break;
        case 'decrease':
            window.cartFunctions.updateQuantity(cart[index].id, Math.max(1, (cart[index].qty || 1) - 1));
            break;
        case 'remove':
            window.cartFunctions.removeFromCart(cart[index].id);
            break;
    }
}

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
        // Add finish dropdown
        const finishSelect = clone.querySelector('.item-finish');
        if (finishSelect) {
            // Static finish options (customize as needed)
            const finishes = [
                { value: '', label: 'Choose Finish' },
                { value: 'sn', label: 'Satin Nickel' },
                { value: 'bk', label: 'Black' },
                { value: 'an', label: 'Antique Nickel' },
                { value: 'gd', label: 'Gold' },
                { value: 'rg', label: 'Rose Gold' },
                { value: 'ch', label: 'Chrome' },
                { value: 'gl', label: 'Glossy' }
            ];
            finishSelect.innerHTML = '';
            finishes.forEach(finish => {
                const option = document.createElement('option');
                option.value = finish.value;
                option.textContent = finish.label;
                if (item.finish && item.finish === finish.value) option.selected = true;
                finishSelect.appendChild(option);
            });
            if (item.finish) finishSelect.value = item.finish;
        }
        
        // Remove any old hidden inputs
        clone.querySelectorAll('input[type="hidden"]').forEach(input => input.remove());
        // Add hidden inputs for backend
        const hiddenFields = [
            { name: `items[${index}][product_id]`, value: item.id },
            { name: `items[${index}][size]`, value: item.size || '' },
            { name: `items[${index}][finish]`, value: item.finish || '' },
            { name: `items[${index}][quantity]`, value: item.qty || 1 },
            { name: `items[${index}][price]`, value: item.price }
        ];
        hiddenFields.forEach(field => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = field.name;
            input.value = field.value;
            clone.appendChild(input);
        });
        
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
    
    // Handle checkout form submission
    const checkoutForm = document.getElementById('checkoutForm');
    if (checkoutForm) {
        // Set form encoding type to support file uploads if needed
        checkoutForm.enctype = 'multipart/form-data';
        
        checkoutForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';
            
            try {
                // Get form data
                const formData = new FormData(this);
                
                // Add cart items as a JSON string
                const cartItems = [];
                const cartItemElements = document.querySelectorAll('#checkoutItemsList .cart-item-details');
                
                if (cartItemElements.length === 0) {
                    throw new Error('Your cart is empty');
                }
                
                // Process each cart item
                cartItemElements.forEach((item, index) => {
                    try {
                        const itemId = item.querySelector('.product-id')?.value;
                        const quantity = parseInt(item.querySelector('.quantity-input')?.value || 1);
                        const price = parseFloat(item.querySelector('.product-price-input')?.value || 0);
                        const name = item.querySelector('.product-name')?.textContent.trim() || `Product ${itemId}`;
                        const image = item.querySelector('img')?.src || '';
                        const size = item.querySelector('.item-size')?.value || 'Not specified';
                        const finish = item.querySelector('.item-finish')?.value || 'Not specified';

                        if (!itemId) {
                            throw new Error(`Missing product ID in item ${index + 1}`);
                        }
                        
                        if (isNaN(quantity) || quantity < 1) {
                            throw new Error(`Invalid quantity for item: ${name}`);
                        }
                        
                        cartItems.push({
                            id: parseInt(itemId),
                            product_id: parseInt(itemId),
                            name: name,
                            price: price,
                            qty: quantity,
                            image: image,
                            size: size,
                            finish: finish
                        });
                    } catch (error) {
                        console.error(`Error processing cart item ${index + 1}:`, error);
                        throw new Error(`Error with item ${index + 1}: ${error.message}`);
                    }
                });
                
                // Add cart items as JSON string
                formData.append('cart_items', JSON.stringify(cartItems));
                
                // Add total amount if not already in form
                if (!formData.has('total_amount')) {
                    const totalAmount = parseFloat(document.querySelector('.cart-total-amount')?.textContent?.replace(/[^0-9.]/g, '') || 0);
                    formData.append('total_amount', totalAmount);
                }
                
                // Log form data for debugging
                const formDataObj = {};
                formData.forEach((value, key) => {
                    formDataObj[key] = value;
                });
                console.log('Form data to submit:', formDataObj);
                
                // Submit the form data
                const response = await fetch('inc/process_checkout.php', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'same-origin'
                });
                
                // Handle response
                const responseText = await response.text();
                let data;
                
                try {
                    data = responseText ? JSON.parse(responseText) : {};
                } catch (e) {
                    console.error('Error parsing response:', e);
                    throw new Error('Invalid response from server');
                }
                
                if (!response.ok) {
                    throw new Error(data.message || `Server returned status ${response.status}`);
                }
                
                // Success - clear cart and redirect
                localStorage.removeItem('cart');
                
                // Show success message
                showToast('Order placed successfully!', 'success');
                
                // Close the modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('checkoutModal'));
                if (modal) {
                    modal.hide();
                }
                
                // Redirect to thank you page
                const orderId = data.order_id || (data.data && data.data.order_id) || '';
                window.location.href = 'thank-you.php?order_id=' + encodeURIComponent(orderId);
                
            } catch (error) {
                console.error('Checkout error:', error);
                showToast(error.message || 'An error occurred. Please try again.', 'error');
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
            }
        });
    }

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
        
        // Set product image - ensure the path is correct
        const imgEl = clone.querySelector('img');
        if (imgEl) {
            let imagePath = item.image || 'assets/img/placeholder-product.jpg';
            if (!imagePath.startsWith('http') && !imagePath.startsWith('/') && !imagePath.startsWith('assets/')) {
                imagePath = 'assets/img/' + imagePath;
            }
            imgEl.src = imagePath;
            imgEl.alt = item.name || 'Product Image';
            imgEl.style.display = 'block';
            imgEl.style.maxHeight = '80px';
            imgEl.style.width = 'auto';
            imgEl.classList.add('img-fluid', 'rounded');
        }
        // Set product info
        clone.querySelector('.product-name').textContent = item.name;
        clone.querySelector('.product-price').textContent = '₹' + (item.price * item.qty).toFixed(2);
        clone.querySelector('.product-quantity').textContent = item.qty;
        // Set hidden inputs
        const hiddenInputs = {
            'product-id': item.id,
            'product-quantity-input': item.qty,
            'product-price-input': item.price
        };
        Object.entries(hiddenInputs).forEach(([className, value]) => {
            const el = clone.querySelector(`.${className}`);
            if (el) el.value = value;
        });
        // Add size dropdown
        const sizeSelect = clone.querySelector('.item-size');
        if (sizeSelect) {
            while (sizeSelect.options.length > 1) sizeSelect.remove(1);
            if (Array.isArray(item.sizes) && item.sizes.length > 0) {
                item.sizes.forEach(size => {
                    const option = document.createElement('option');
                    option.value = size;
                    option.textContent = size;
                    if (item.size && item.size === size) option.selected = true;
                    sizeSelect.appendChild(option);
                });
            } else {
                const option = document.createElement('option');
                option.value = 'Standard';
                option.textContent = 'Standard';
                sizeSelect.appendChild(option);
            }
            if (item.size) {
                for (let i = 0; i < sizeSelect.options.length; i++) {
                    if (sizeSelect.options[i].value === item.size) {
                        sizeSelect.selectedIndex = i;
                        break;
                    }
                }
            }
        }
        // Add finish dropdown
        const finishSelect = clone.querySelector('.item-finish');
        if (finishSelect) {
            // Static finish options (customize as needed)
            const finishes = [
                { value: '', label: 'Choose Finish' },
                { value: 'sn', label: 'Satin Nickel' },
                { value: 'bk', label: 'Black' },
                { value: 'an', label: 'Antique Nickel' },
                { value: 'gd', label: 'Gold' },
                { value: 'rg', label: 'Rose Gold' },
                { value: 'ch', label: 'Chrome' },
                { value: 'gl', label: 'Glossy' }
            ];
            finishSelect.innerHTML = '';
            finishes.forEach(finish => {
                const option = document.createElement('option');
                option.value = finish.value;
                option.textContent = finish.label;
                if (item.finish && item.finish === finish.value) option.selected = true;
                finishSelect.appendChild(option);
            });
            if (item.finish) finishSelect.value = item.finish;
        }
        // Remove any old hidden inputs
        clone.querySelectorAll('input[type="hidden"]').forEach(input => input.remove());
        // Add hidden inputs for backend
        const hiddenFields = [
            { name: `items[${index}][product_id]`, value: item.id },
            { name: `items[${index}][size]`, value: item.size || '' },
            { name: `items[${index}][finish]`, value: item.finish || '' },
            { name: `items[${index}][quantity]`, value: item.qty || 1 },
            { name: `items[${index}][price]`, value: item.price }
        ];
        hiddenFields.forEach(field => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = field.name;
            input.value = field.value;
            clone.appendChild(input);
        });
        
        cartItemsList.appendChild(clone);
        total += item.price * item.qty;
    });
    
    // Update total
    totalPriceElement.textContent = total.toFixed(2);
    totalPriceInput.value = total.toFixed(2);
    
    // Initialize any tooltips or other UI elements
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        const tooltipTriggerList = [].slice.call(cartItemsList.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
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
const checkoutForm = document.getElementById('checkoutForm');
if (checkoutForm) {
    checkoutForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Validate form
        if (!this.checkValidity()) {
            e.stopPropagation();
            this.classList.add('was-validated');
            return;
        }
        
        // Get the form data
        const form = this;
        const formData = new FormData(form);
        const cartItems = [];
        
        // Get all cart items from the form
        document.querySelectorAll('#checkoutItemsList .cart-item-details').forEach((item, index) => {
            try {
                const itemId = item.querySelector('.product-id')?.value;
                const quantity = item.querySelector('.quantity-input')?.value || 1;
                const size = item.querySelector('.item-size')?.value || '';
                const finish = item.querySelector('.item-finish')?.value || '';
                const price = item.querySelector('.product-price-input')?.value || 0;
                const name = item.querySelector('.product-name')?.textContent.trim() || `Product ${itemId}`;
                const image = item.querySelector('img')?.src || '';
                
                if (itemId) {
                    const cartItem = {
                        id: parseInt(itemId),
                        qty: parseInt(quantity) || 1,
                        price: parseFloat(price) || 0,
                        name: name,
                        image: image,
                        size: size,
                        finish: finish,
                        product_id: parseInt(itemId)  // Add product_id as an alias for id
                    };
                    
                    console.log('Adding cart item:', cartItem);
                    cartItems.push(cartItem);
                } else {
                    console.error('Item ID is missing for cart item');
                }
            } catch (error) {
                console.error('Error processing cart item:', error);
            }
        });
        
        console.log('All cart items:', cartItems);
        
        if (cartItems.length === 0) {
            showToast('Please add items to your cart before checkout.', 'error');
            return;
        }
        
        // Show loading state
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';
        
        // Prepare the complete order data as JSON
        const orderData = {
            customer_name: formData.get('customer_name'),
            customer_email: formData.get('customer_email'),
            customer_phone: formData.get('customer_phone'),
            shipping_address: formData.get('shipping_address'),
            additional_notes: formData.get('additional_notes') || '',
            total_amount: parseFloat(document.getElementById('totalPriceInput')?.value) || 0,
            cart_items: cartItems
        };
        
        // Log the data being sent
        console.log('Sending order data:', orderData);
        
        console.log('Sending order data:', {
            ...Object.fromEntries(orderData),
            cart_items: cartItems
        });
        
        // Submit the form data as form data (not JSON)
        fetch('inc/process_checkout.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams(orderData),
            credentials: 'same-origin'
        })
        .then(async response => {
            const responseText = await response.text();
            console.log('Raw response:', responseText);
            
            try {
                const data = responseText ? JSON.parse(responseText) : {};
                
                if (!response.ok) {
                    // Handle HTTP error status codes
                    const errorMsg = data.message || `Server returned status ${response.status} ${response.statusText}`;
                    throw new Error(errorMsg);
                }
                
                return data;
            } catch (e) {
                console.error('Error parsing response:', e);
                // If we can't parse JSON, include the raw response in the error
                const error = new Error('Invalid server response');
                error.responseText = responseText;
                error.status = response.status;
                throw error;
            }
        })
        .then(data => {
            console.log('Parsed response data:', data);
            
            // Reset button state
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
            
            if (data.status === 'success') {
                // Clear the cart
                localStorage.removeItem('cart');
                
                // Show success message
                showToast('Order placed successfully!', 'success');
                
                // Close the modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('checkoutModal'));
                if (modal) {
                    modal.hide();
                }
                
                // Redirect to thank you page
                const orderId = data.order_id || (data.data && data.data.order_id) || '';
                window.location.href = 'thank-you.php?order_id=' + encodeURIComponent(orderId);
            } else {
                // Show error message with more details if available
                const errorMsg = data.message || (data.data && data.data.error) || 'An error occurred. Please try again.';
                showToast(errorMsg, 'error');
                console.error('Server error:', data);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            
            // Reset button state
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
            
            // Show error message with more details
            let errorMsg = 'An error occurred. Please try again.';
            
            if (error.responseText) {
                try {
                    const errorData = JSON.parse(error.responseText);
                    errorMsg = errorData.message || error.responseText;
                } catch (e) {
                    errorMsg = error.responseText || error.message;
                }
            } else if (error.message) {
                errorMsg = error.message;
            }
            
            showToast(errorMsg, 'error');
            
            // Log additional error details
            if (error.status) {
                console.error('HTTP Status:', error.status);
            }
            if (error.responseText) {
                console.error('Response Text:', error.responseText);
            }
        });
    });
}

// Update order summary when checkboxes change
document.addEventListener('change', function(e) {
    if (e.target.classList.contains('item-checkbox')) {
        updateOrderSummary();
        // Enable/disable checkout button based on selection
        const selectedItems = getSelectedCartItems();
        const checkoutBtn = document.getElementById('checkoutBtn');
        if (checkoutBtn) {
            checkoutBtn.disabled = selectedItems.length === 0;
        }
    }
});

// Handle size and finish changes in the checkout form
document.addEventListener('change', function(e) {
    const itemCard = e.target.closest('.cart-item-details');
    if (!itemCard) return;
    
    if (e.target.classList.contains('item-size')) {
        // Update the hidden input for form submission
        const sizeInput = itemCard.querySelector('input[name$="[size]"]');
        if (sizeInput) {
            sizeInput.value = e.target.value;
        }
        
        // You can add logic here to update price if different sizes have different prices
        // For example:
        // const selectedOption = e.target.options[e.target.selectedIndex];
        // if (selectedOption && selectedOption.dataset.price) {
        //     const price = parseFloat(selectedOption.dataset.price);
        //     // Update price in the cart and UI
        // }
    }
    
    // Update the order total when size or finish changes
    updateOrderTotal();
});

// Handle remove item button in checkout form
document.addEventListener('click', function(e) {
    if (e.target.closest('.remove-item')) {
        e.preventDefault();
        const itemCard = e.target.closest('.cart-item-details');
        if (itemCard) {
            // Find the corresponding cart item and remove it
            const index = parseInt(itemCard.dataset.index);
            if (!isNaN(index)) {
                const cart = getCart();
                cart.splice(index, 1);
                setCart(cart);
            }
            
            // Remove the item from the UI
            itemCard.remove();
            
            // Update the order summary
            updateOrderSummary();
            
            // Close the modal if no items left
            const cartItemsList = document.getElementById('checkoutItemsList');
            if (cartItemsList && cartItemsList.children.length === 0) {
                const modal = bootstrap.Modal.getInstance(document.getElementById('checkoutModal'));
                if (modal) modal.hide();
            }
        }
    }
});

// Handle form submission
document.addEventListener('submit', function(e) {
    if (e.target.id === 'checkoutForm') {
        e.preventDefault();
        
        // Validate all required fields
        const form = e.target;
        const requiredFields = form.querySelectorAll('[required]');
        let isValid = true;
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });
        
        if (!isValid) {
            showToast('Please fill in all required fields.');
            return;
        }
        
        // Submit the form if validation passes
        form.submit();
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
                        <form id="checkoutForm" action="inc/process_checkout.php" method="POST" enctype="multipart/form-data">
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
                                                <div class="col-md-2 d-flex align-items-center justify-content-center" style="min-height: 120px;">
                                                    <img src="assets/img/placeholder-product.jpg" class="img-fluid rounded" alt="Product Image" style="max-height: 80px; width: auto; object-fit: contain;">
                                                </div>
                                                <div class="col-md-4">
                                                    <h6 class="mb-2 product-name">Product Name</h6>
                                                    <div class="mb-2">
                                                        <label class="form-label small mb-1">Size <span class="text-danger">*</span></label>
                                                        <select class="form-select form-select-sm item-size" name="item_size[]" required>
                                                            <option value="">-- Select Size --</option>
                                                            <!-- Sizes will be populated by JavaScript -->
                                                        </select>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label small mb-1">Finish <span class="text-danger">*</span></label>
                                                        <select class="form-select form-select-sm item-finish" name="item_finish[]" required>
                                                            <option value="">-- Select Finish --</option>
                                                            <option value="sn">Satin Nickel</option>
                                                            <option value="bk">Black</option>
                                                            <option value="an">Antique Nickel</option>
                                                            <option value="gd">Gold</option>
                                                            <option value="rg">Rose Gold</option>
                                                            <option value="ch">Chrome</option>
                                                            <option value="gl">Glossy</option>
                                                        </select>
                                                    </div>
                                                    <input type="hidden" class="product-id" name="product_id[]">
                                                    <input type="hidden" class="product-quantity-input" name="quantity[]">
                                                    <input type="hidden" class="product-price-input" name="price[]">
                                                </div>
                                                <div class="col-md-3 text-md-end">
                                                    <div class="input-group quantity-selector">
                                                        <button class="btn btn-outline-secondary btn-sm quantity-btn minus" type="button" data-action="decrease">
                                                            <i class="bi bi-dash"></i>
                                                        </button>
                                                        <input type="number" class="form-control form-control-sm quantity-input" value="1" min="1" aria-label="Quantity">
                                                        <button class="btn btn-outline-secondary btn-sm quantity-btn plus" type="button" data-action="increase">
                                                            <i class="bi bi-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 text-md-end">
                                                    <h6 class="mb-1 product-price">₹0.00</h6>
                                                    <input type="hidden" class="product-id" name="product_id[]" value="">
                                                    <input type="hidden" class="product-quantity-input" name="quantity[]" value="">
                                                    <input type="hidden" class="product-price-input" name="price[]" value="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Additional Notes (optional)</label>
                                <textarea class="form-control" name="additional_notes" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-check-circle"></i> Place Order
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Back to top button -->
<a href="#" class="btn btn-primary btn-lg rounded-circle back-to-top" style="position: fixed; bottom: 30px; right: 30px; display: none;">
    <i class="bi bi-arrow-up"></i>
</a>

<!-- Vendor JS Files -->
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/aos/aos.js"></script>
<script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

<!-- Main JS File -->
<script src="assets/js/main.js"></script>



<script>
// Initialize the cart when the DOM is fully loaded
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM fully loaded, initializing cart...');
    
    // Initialize the cart UI
    console.log('Current cart contents:', getCart());
    updateCartUI();
    
    // Add event delegation for cart actions
    document.addEventListener('click', handleCartAction);
    
    // Add event listener for quantity input changes
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('quantity-input')) {
            const index = parseInt(e.target.getAttribute('data-index'));
            if (!isNaN(index)) {
                updateQuantityInput(index, e.target.value);
            }
        }
    });
    
    // Add event listener for checkbox changes
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('item-checkbox')) {
            updateCheckoutButton();
        }
    });
    
    // Initialize the checkout modal
    if (window.bootstrap && typeof bootstrap.Modal !== 'undefined') {
        initializeModal();
    }
});

// Update the checkout button state based on selected items
function updateCheckoutButton() {
    const checkoutBtn = document.getElementById('checkoutBtn');
    if (checkoutBtn) {
        const checked = document.querySelectorAll('.item-checkbox:checked').length > 0;
        checkoutBtn.disabled = !checked;
    }
}
</script>

</body>
</html>