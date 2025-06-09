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
            <h1 class="cart-title"><i class="bi bi-cart3"></i> You Shopping Cart</h1>
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
                    <button class="btn-checkout" id="checkoutBtn" onclick="proceedToCheckout()" disabled>
                        <i class="bi bi-lock-fill"></i> Proceed to Checkout
                    </button>
                </div>
            </div>
        </div>
    </div>
<script>
// Cart functions
function getCart() {
    return JSON.parse(localStorage.getItem('cart')) || [];
}

function setCart(cart) {
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartUI();
}

function updateQuantity(idx, amount) {
    const cart = getCart();
    if (cart[idx]) {
        cart[idx].quantity = Math.max(1, cart[idx].quantity + amount);
        setCart(cart);
    }
}

function updateQuantityInput(idx, value) {
    const cart = getCart();
    if (cart[idx]) {
        cart[idx].quantity = Math.max(1, parseInt(value) || 1);
        setCart(cart);
    }
}

function removeFromCart(idx) {
    const cart = getCart();
    cart.splice(idx, 1);
    setCart(cart);
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
        const itemTotal = item.price * item.quantity;
        subtotal += itemTotal;
        
        return `
            <div class="cart-item" data-index="${idx}">
                <img src="${item.image}" alt="${item.name}" class="cart-item-img">
                <div class="cart-item-details">
                    <h3 class="cart-item-title">${item.name}</h3>
                    <p class="cart-item-price">₹${item.price.toFixed(2)}</p>
                    <div class="quantity-selector">
                        <button class="quantity-btn minus" onclick="updateQuantity(${idx}, -1)">-</button>
                        <input type="number" class="quantity-input" 
                               value="${item.quantity}" 
                               min="1" 
                               onchange="updateQuantityInput(${idx}, this.value)">
                        <button class="quantity-btn plus" onclick="updateQuantity(${idx}, 1)">+</button>
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
}

document.addEventListener('DOMContentLoaded', updateCartUI);
</script>
<?php include('inc/footer.php'); ?>
</body>
</html>
