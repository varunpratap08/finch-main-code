<header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid position-relative d-flex align-items-center justify-content-between">

      <a href="index.php" class="logo d-flex align-items-center me-auto me-xl-0">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <img src="assets/img/logo.png" alt="">
        <span class="company-name-gradient" style="font-weight: bold; font-size: 1.4rem; margin-left: 22px; background: linear-gradient(90deg, #ffb347 0%, #ffcc33 40%, #ffe259 70%, #ffa751 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; text-fill-color: transparent; letter-spacing: 1px;">Pali Industries</span>
      </a>
      <style>
      .company-name-gradient {
  font-family: 'Poppins', 'Nunito', Arial, sans-serif;
  font-weight: 800;
  font-size: 1.4rem;
  margin-left: 22px;
  background: linear-gradient(90deg, #ffb347 0%, #ffcc33 40%, #ffe259 70%, #ffa751 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  text-fill-color: transparent;
  letter-spacing: 1px;
  transition: font-size 0.2s, margin-left 0.2s;
}

@media only screen and (max-width: 700px) {
.header{
    padding: 0px !important;
}
.btn-getstarted{
    display: none;
}

.company-name-gradient {
    font-size: 1rem;
    margin-left: 12px;
  }
}
@media (max-width: 400px) {
  .company-name-gradient {
    font-size: 0.85rem;
    margin-left: 7px;
  }
}

/* Active navigation item styles */
.navmenu > ul > li.active > a {
  color: #DEB462 !important;
  font-weight: 600;
  position: relative;
}

.navmenu > ul > li.active > a:after {
  content: '';
  position: absolute;
  width: 100%;
  height: 2px;
  left: 0;
  bottom: -5px;
  background-color: #DEB462;
  transition: all 0.3s ease-in-out;
}

.navmenu > ul > li:not(.active):hover > a {
  color: #DEB462 !important;
}
          
      </style>

      <nav id="navmenu" class="navmenu">
        <ul>
          <?php 
          $currentPage = basename($_SERVER['PHP_SELF']); 
          $isCartPage = ($currentPage === 'cart.php');
          ?>
          <li class="<?php echo ($currentPage === 'index.php') ? 'active' : ''; ?>">
            <a href="index.php">Home</a>
          </li>
          <li class="<?php echo ($currentPage === 'about.php') ? 'active' : ''; ?>">
            <a href="about.php">About Us</a>
          </li>
          <li class="<?php echo (in_array($currentPage, ['products.php', 'product-details.php'])) ? 'active' : ''; ?>">
            <a href="products.php">Products</a>
          </li>
          <li class="d-none d-lg-flex align-items-center">
            <a href="cart.php" class="cart-link position-relative" style="color: #222; text-decoration: none;">
              <i class="bi bi-cart" style="font-size: 1.5rem;"></i>
              <span class="cart-count position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.8rem; padding: 0.3em 0.5em;">0</span>
              <span class="cart-total ms-2" style="font-weight: 600; color: #DEB462; font-size: 1.1rem;">₹0</span>
            </a>
          </li>
        </ul>
        
        <div class="d-flex align-items-center d-lg-none">
          <a href="cart.php" class="cart-link position-relative me-4" style="color: #222; text-decoration: none;">
            <i class="bi bi-cart" style="font-size: 1.8rem;"></i>
            <span class="cart-count position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.8rem; padding: 0.3em 0.5em;">0</span>
          </a>
          <i class="mobile-nav-toggle bi bi-list"></i>
        </div>
      </nav>

      <a class="btn-getstarted d-none d-lg-inline-flex" href="contact.php">Contact Us</a>

    </div>
  </header>
  <script>
// Ensure cart is initialized in localStorage
if (!localStorage.getItem('cart')) {
    localStorage.setItem('cart', '[]');
}

// Cart functions available globally
window.cartFunctions = {
    getCart: function() {
        const cart = JSON.parse(localStorage.getItem('cart') || '[]');
        console.log('Getting cart:', cart);
        return cart;
    },
    updateCartUI: function() {
        const cart = this.getCart();
        let total = 0;
        
        // Count unique products and calculate total price
        const uniqueProducts = new Set();
        cart.forEach(item => {
            uniqueProducts.add(item.id || item.name); // Use product ID or name as unique identifier
            total += (parseFloat(item.price) || 0) * (parseInt(item.qty) || 0);
        });
        
        // Update all cart count and total elements
        document.querySelectorAll('.cart-count').forEach(el => {
            const uniqueCount = uniqueProducts.size;
            el.textContent = uniqueCount;
            el.style.display = uniqueCount > 0 ? 'inline-flex' : 'none';
        });
        
        document.querySelectorAll('.cart-total').forEach(el => {
            el.textContent = '₹' + total.toFixed(2);
        });
        
        // Dispatch event for other scripts to listen to
        document.dispatchEvent(new CustomEvent('cartUpdated', { 
            detail: { 
                count: uniqueProducts.size, 
                total: total 
            } 
        }));
    },
    addToCart: function(product) {
        const cart = this.getCart();
        const existingItem = cart.find(item => item.id === product.id);
        
        if (existingItem) {
            existingItem.qty = (parseInt(existingItem.qty) || 0) + (parseInt(product.qty) || 1);
        } else {
            cart.push({
                id: product.id,
                name: product.name,
                price: parseFloat(product.price),
                qty: parseInt(product.qty) || 1,
                image: product.image || ''
            });
        }
        
        localStorage.setItem('cart', JSON.stringify(cart));
        this.updateCartUI();
        return cart;
    },
    removeFromCart: function(productId) {
        let cart = this.getCart();
        cart = cart.filter(item => item.id !== productId);
        localStorage.setItem('cart', JSON.stringify(cart));
        this.updateCartUI();
        return cart;
    },
    updateQuantity: function(productId, newQty) {
        const cart = this.getCart();
        const item = cart.find(item => item.id === productId);
        
        if (item) {
            item.qty = parseInt(newQty) || 1;
            if (item.qty <= 0) {
                return this.removeFromCart(productId);
            }
            localStorage.setItem('cart', JSON.stringify(cart));
            this.updateCartUI();
        }
        return cart;
    }
};

// Initialize cart UI when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.cartFunctions.updateCartUI();
});

// Also update cart when the page becomes visible again (in case of back/forward navigation)
document.addEventListener('visibilitychange', function() {
    if (!document.hidden) {
        window.cartFunctions.updateCartUI();
    }
});
</script>