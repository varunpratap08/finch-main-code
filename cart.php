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
                <div class="cart-items"></div>
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
// Cart logic for cart.php
(function() {
    'use strict';
    
    // Cart functions
    const cartFunctions = {
        getCart: function() {
            try {
                const cartData = localStorage.getItem('cart');
                if (!cartData) {
                    localStorage.setItem('cart', '[]');
                    return [];
                }
                const cart = JSON.parse(cartData);
                return Array.isArray(cart) ? cart : [];
            } catch (e) {
                localStorage.setItem('cart', '[]');
                return [];
            }
        },
        setCart: function(cart) {
            try {
                localStorage.setItem('cart', JSON.stringify(cart));
                this.renderCartItems();
                return true;
            } catch (e) {
                return false;
            }
        },
        updateQuantity: function(index, amount, newQty = null) {
            const cart = this.getCart();
            if (index < 0 || index >= cart.length) return;
            if (newQty !== null) {
                cart[index].qty = Math.max(1, parseInt(newQty) || 1);
            } else {
                cart[index].qty = Math.max(1, (parseInt(cart[index].qty) || 1) + amount);
            }
            localStorage.setItem('cart', JSON.stringify(cart));
            this.renderCartItems();
        },
        removeFromCart: function(index) {
            const cart = this.getCart();
            if (index < 0 || index >= cart.length) return;
            cart.splice(index, 1);
            localStorage.setItem('cart', JSON.stringify(cart));
            this.renderCartItems();
        },
        renderCartItems: function() {
            const cart = this.getCart();
            const cartItemsContainer = document.querySelector('.cart-items');
            if (!cartItemsContainer) return;
            cartItemsContainer.innerHTML = '';
            if (cart.length === 0) {
                cartItemsContainer.innerHTML = `
                    <div class="empty-cart text-center py-5">
                        <i class="bi bi-cart-x fs-1 text-muted"></i>
                        <h3 class="mt-3">Your cart is empty</h3>
                        <p class="text-muted">Add some items to your cart to get started.</p>
                        <a href="products.php" class="btn btn-primary">Continue Shopping</a>
                    </div>
                `;
                document.getElementById('subtotal').textContent = '₹0.00';
                document.getElementById('total').textContent = '₹0.00';
                document.getElementById('checkoutBtn').disabled = true;
                return;
            }
            let subtotal = 0;
            cart.forEach((item, index) => {
                const itemPrice = parseFloat(item.price) || 0;
                const itemQty = parseInt(item.qty) || 1;
                subtotal += itemPrice * itemQty;
                const cartItem = document.createElement('div');
                cartItem.className = 'cart-item';
                cartItem.innerHTML = `
                    <input type="checkbox" class="cart-item-checkbox" data-index="${index}" checked style="margin-right:10px; width:18px; height:18px;"> 
                    <div class="cart-item-img">
                        <img src="${item.image || 'assets/img/placeholder-product.jpg'}" alt="${item.name}" style="width: 100px; height: 100px; object-fit: contain;">
                    </div>
                    <div class="cart-item-details">
                        <h3 class="cart-item-title">${item.name}</h3>
                        <p class="cart-item-price">₹${itemPrice.toFixed(2)}</p>
                        <div class="quantity-selector">
                            <button class="quantity-btn" onclick="cartFunctions.updateQuantity(${index}, -1)">-</button>
                            <input type="number" class="quantity-input" value="${itemQty}" min="1" oninput="cartFunctions.updateQuantity(${index}, 0, this.value)">
                            <button class="quantity-btn" onclick="cartFunctions.updateQuantity(${index}, 1)">+</button>
                        </div>
                        <button class="remove-btn" onclick="cartFunctions.removeFromCart(${index})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                `;
                cartItemsContainer.appendChild(cartItem);
            });
            document.getElementById('subtotal').textContent = `₹${subtotal.toFixed(2)}`;
            document.getElementById('total').textContent = `₹${subtotal.toFixed(2)}`;
            document.getElementById('checkoutBtn').disabled = false;
        },
        init: function() {
            this.renderCartItems();
        }
    };
    window.cartFunctions = cartFunctions;
    document.addEventListener('DOMContentLoaded', function() {
        cartFunctions.init();
    });
})();
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
<script>
// Cart logic for cart.php
(function() {
    'use strict';
    
    // Cart functions
    const cartFunctions = {
        getCart: function() {
            try {
                const cartData = localStorage.getItem('cart');
                if (!cartData) {
                    localStorage.setItem('cart', '[]');
                    return [];
                }
                const cart = JSON.parse(cartData);
                return Array.isArray(cart) ? cart : [];
            } catch (e) {
                localStorage.setItem('cart', '[]');
                return [];
            }
        },
        setCart: function(cart) {
            try {
                localStorage.setItem('cart', JSON.stringify(cart));
                this.renderCartItems();
                return true;
            } catch (e) {
                return false;
            }
        },
        updateQuantity: function(index, amount, newQty = null) {
            const cart = this.getCart();
            if (index < 0 || index >= cart.length) return;
            if (newQty !== null) {
                cart[index].qty = Math.max(1, parseInt(newQty) || 1);
            } else {
                cart[index].qty = Math.max(1, (parseInt(cart[index].qty) || 1) + amount);
            }
            localStorage.setItem('cart', JSON.stringify(cart));
            this.renderCartItems();
        },
        removeFromCart: function(index) {
            const cart = this.getCart();
            if (index < 0 || index >= cart.length) return;
            cart.splice(index, 1);
            localStorage.setItem('cart', JSON.stringify(cart));
            this.renderCartItems();
        },
        renderCartItems: function() {
            const cart = this.getCart();
            const cartItemsContainer = document.querySelector('.cart-items');
            if (!cartItemsContainer) return;
            cartItemsContainer.innerHTML = '';
            if (cart.length === 0) {
                cartItemsContainer.innerHTML = `
                    <div class="empty-cart text-center py-5">
                        <i class="bi bi-cart-x fs-1 text-muted"></i>
                        <h3 class="mt-3">Your cart is empty</h3>
                        <p class="text-muted">Add some items to your cart to get started.</p>
                        <a href="products.php" class="btn btn-primary">Continue Shopping</a>
                    </div>
                `;
                document.getElementById('subtotal').textContent = '₹0.00';
                document.getElementById('total').textContent = '₹0.00';
                document.getElementById('checkoutBtn').disabled = true;
                return;
            }
            let subtotal = 0;
            cart.forEach((item, index) => {
                const itemPrice = parseFloat(item.price) || 0;
                const itemQty = parseInt(item.qty) || 1;
                subtotal += itemPrice * itemQty;
                const cartItem = document.createElement('div');
                cartItem.className = 'cart-item';
                cartItem.innerHTML = `
                    <input type="checkbox" class="cart-item-checkbox" data-index="${index}" checked style="margin-right:10px; width:18px; height:18px;"> 
                    <div class="cart-item-img">
                        <img src="${item.image || 'assets/img/placeholder-product.jpg'}" alt="${item.name}" style="width: 100px; height: 100px; object-fit: contain;">
                    </div>
                    <div class="cart-item-details">
                        <h3 class="cart-item-title">${item.name}</h3>
                        <p class="cart-item-price">₹${itemPrice.toFixed(2)}</p>
                        <div class="quantity-selector">
                            <button class="quantity-btn" onclick="cartFunctions.updateQuantity(${index}, -1)">-</button>
                            <input type="number" class="quantity-input" value="${itemQty}" min="1" oninput="cartFunctions.updateQuantity(${index}, 0, this.value)">
                            <button class="quantity-btn" onclick="cartFunctions.updateQuantity(${index}, 1)">+</button>
                        </div>
                        <button class="remove-btn" onclick="cartFunctions.removeFromCart(${index})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                `;
                cartItemsContainer.appendChild(cartItem);
            });
            document.getElementById('subtotal').textContent = `₹${subtotal.toFixed(2)}`;
            document.getElementById('total').textContent = `₹${subtotal.toFixed(2)}`;
            document.getElementById('checkoutBtn').disabled = false;
        },
        init: function() {
            this.renderCartItems();
        }
    };
    window.cartFunctions = cartFunctions;
    document.addEventListener('DOMContentLoaded', function() {
        cartFunctions.init();
    });
})();
</script>

<!-- Back to top button -->
<a href="#" class="btn btn-primary btn-lg rounded-circle back-to-top" style="position: fixed; bottom: 30px; right: 30px; display: none;">
    <i class="bi bi-arrow-up"></i>
</a>

<!-- Vendor JS Files -->
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/aos/aos.js"></script>
<script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
<script>
// Remove any PureCounter initialization
document.addEventListener('DOMContentLoaded', function() {
    const pureCounterScript = document.querySelector('script[src*="purecounter"]');
    if (pureCounterScript) pureCounterScript.remove();
    
    // Initialize cart if it exists
    if (window.cartFunctions && typeof window.cartFunctions.init === 'function') {

<!-- Main JS File -->
<script src="assets/js/main.js"></script>

<script>
// Make cart functions globally accessible with null check
window.cartFunctions = window.cartFunctions || cartFunctions;

// Proceed to Checkout function
function proceedToCheckout() {
    const cart = window.cartFunctions.getCart();
    if (!cart || cart.length === 0) {
        alert('Your cart is empty. Please add items to your cart before checking out.');
        return;
    }
    // Get selected items
    const checkedIndexes = Array.from(document.querySelectorAll('.cart-item-checkbox:checked')).map(cb => parseInt(cb.getAttribute('data-index')));
    if (checkedIndexes.length === 0) {
        alert('Please select at least one product to checkout.');
        return;
    }
    const selectedItems = checkedIndexes.map(idx => cart[idx]);
    // Show the checkout modal
    if (window.bootstrap && typeof bootstrap.Modal !== 'undefined') {
        const modalEl = document.getElementById('checkoutModal');
        if (modalEl) {
            const modal = new bootstrap.Modal(modalEl);
            modal.show();
        }
    }
    // Populate checkout modal with selected items
    updateCheckoutModal(selectedItems);
}

// Update checkout modal with selected items
function updateCheckoutModal(selectedItems) {
    const cartItemsList = document.getElementById('checkoutItemsList');
    if (!cartItemsList) return;
    cartItemsList.innerHTML = '';
    let total = 0;
    const template = document.getElementById('cartItemTemplate');
    selectedItems.forEach((item, index) => {
        const clone = template.content.cloneNode(true);
        clone.querySelector('.product-name').textContent = item.name;
        clone.querySelector('.product-price').textContent = '₹' + (item.price * item.qty).toFixed(2);
        clone.querySelector('.product-id').value = item.id;
        clone.querySelector('.product-quantity-input').value = item.qty;
        clone.querySelector('.product-price-input').value = item.price;
        if (item.image) {
            clone.querySelector('img').src = item.image;
            clone.querySelector('img').alt = item.name;
        }
        total += item.price * item.qty;
        cartItemsList.appendChild(clone);
    });
    // Update total price in modal if you have such an element
    // Example: document.getElementById('totalPrice').textContent = total.toFixed(2);
}
</script>

</body>
</html>