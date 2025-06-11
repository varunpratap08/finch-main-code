<?php
require_once 'inc/db.php';

// Check if product_id is set in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid product.");
}

$product_id = $_GET['id'];

try {
    // Fetch product details
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        die("Product not found.");
    }

    // Decode JSON pricing data
    $pricing = json_decode($product['pricing'], true);
    $sizeDetails = [];
    $finishDetails = [];

    if (is_array($pricing)) {
        foreach ($pricing as $entry) {
            $sizeDetails[] = $entry['size'];

            // Only show finishes where the price is greater than 0
            $finishes = [];
            if (!empty($entry['sn_price']) && $entry['sn_price'] > 0) {
                $finishes[] = "SN: &#8377;{$entry['sn_price']}";
            }
            if (!empty($entry['bk_price']) && $entry['bk_price'] > 0) {
                $finishes[] = "BK: &#8377;{$entry['bk_price']}";
            }
            if (!empty($entry['an_price']) && $entry['an_price'] > 0) {
                $finishes[] = "AN: &#8377;{$entry['an_price']}";
            }
            if (!empty($entry['gd_price']) && $entry['gd_price'] > 0) {
                $finishes[] = "GD: &#8377;{$entry['gd_price']}";
            }
            if (!empty($entry['rg_price']) && $entry['rg_price'] > 0) {
                $finishes[] = "RG: &#8377;{$entry['rg_price']}";
            }

            if (!empty($finishes)) {
                $finishDetails[] = implode(" | ", $finishes);
            }
        }
    }

    $sizeText = !empty($sizeDetails) ? implode(', ', $sizeDetails) : 'N/A';
    $finishText = !empty($finishDetails) ? implode('<br>', $finishDetails) : 'N/A';

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Finch Lock</title>
  <meta name="description" content="">
  <meta name="keywords" content="">



  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

  
  <style>
                /* Modal z-index fix */
                .modal-backdrop {
                    z-index: 1040 !important;
                }
                .modal {
                    z-index: 1050 !important;
                }
                #finishImageModal {
                    z-index: 1070 !important;
                }
                #buyNowModal {
                    z-index: 1060 !important;
                }
                
                /* Finish Options Styles */
                .finish-option {
            text-align: center;
            cursor: pointer;
            transition: all 0.2s ease;
            padding: 5px;
            border-radius: 4px;
            width: 80px;
        }
        .finish-option:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .finish-option.active {
            border: 2px solid #0d6efd;
        }
        .finish-option img {
            border: 1px solid #dee2e6;
            border-radius: 4px;
            transition: all 0.2s ease;
            width: 100%;
            height: auto;
            aspect-ratio: 1;
            object-fit: cover;
        }
        .finish-option:hover img {
            border-color: #0d6efd;
        }
        .finish-option .finish-label {
            font-size: 12px;
            margin-top: 4px;
            font-weight: 500;
        }
        
        .product-details {
            padding: 120px 0;
        }
        .finish-option {
            text-align: center;
            cursor: pointer;
            transition: transform 0.2s;
        }
        .finish-option:hover {
            transform: scale(1.05);
        }
        .finish-option.active {
            border: 2px solid #0d6efd;
            border-radius: 4px;
        }
        .finish-option img {
            border: 1px solid #dee2e6;
            border-radius: 4px;
        }
        .product-image img {
            width: 520px;
            height: 400px;
            border-radius: 10px;
            object-fit: cover;
        }
        .product-title {
            font-size: 28px;
            font-weight: bold;
        }
        .product-price {
            font-size: 22px;
            color: #28a745;
            font-weight: bold;
        }
        .product-description {
            font-size: 16px;
            color: #6c757d;
        }
        .btn-custom {
            padding: 10px 20px;
            font-size: 16px;
        }
    </style>
</head>

<body class="index-page">

  <?php include ('inc/header.php'); ?>

  <main class="main">

   



  <!-- Product Details Section -->
<div class="container product-details">
    <div class="row align-items-center">
        <!-- Product Images Carousel -->
        <div class="col-md-6">
            <div id="productCarousel" class="carousel slide carousel-fade mb-4" data-bs-ride="carousel" data-bs-interval="3000">
                <div class="carousel-inner rounded-3 overflow-hidden shadow-sm" id="carouselContainer">
                    <!-- Main Image -->
                <div class="carousel-item active">
                    <img src="<?php echo htmlspecialchars($product['product_image']); ?>" 
                         class="d-block w-100" 
                         alt="<?php echo htmlspecialchars($product['product_name']); ?>"
                         id="mainProductImage">
                </div>
                    
                    <!-- Additional Image 2 -->
                    <?php if (!empty($product['image2'])): ?>
                    <div class="carousel-item">
                        <img src="<?php echo htmlspecialchars($product['image2']); ?>" 
                             class="d-block w-100" 
                             alt="<?php echo htmlspecialchars($product['product_name']); ?> - 2">
                    </div>
                    <?php endif; ?>
                    
                    <!-- Additional Image 3 -->
                    <?php if (!empty($product['image3'])): ?>
                    <div class="carousel-item">
                        <img src="<?php echo htmlspecialchars($product['image3']); ?>" 
                             class="d-block w-100" 
                             alt="<?php echo htmlspecialchars($product['product_name']); ?> - 3">
                    </div>
                    <?php endif; ?>
                </div>
                
                <!-- Carousel Indicators -->
                <?php 
                $imageCount = 1 + (!empty($product['image2']) ? 1 : 0) + (!empty($product['image3']) ? 1 : 0);
                if ($imageCount > 1): 
                ?>
                <div class="carousel-indicators position-static mt-3">
                    <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="0" class="active" aria-current="true"></button>
                    <?php if (!empty($product['image2'])): ?>
                    <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="1"></button>
                    <?php endif; ?>
                    <?php if (!empty($product['image3'])): ?>
                    <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="<?php echo 1 + (!empty($product['image2']) ? 1 : 0); ?>"></button>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
                
                <script>
                // Add touch/swipe functionality
                document.addEventListener('DOMContentLoaded', function() {
                    const carousel = document.getElementById('carouselContainer');
                    let touchStartX = 0;
                    let touchEndX = 0;
                    
                    carousel.addEventListener('touchstart', function(e) {
                        touchStartX = e.changedTouches[0].screenX;
                    }, false);
                    
                    carousel.addEventListener('touchend', function(e) {
                        touchEndX = e.changedTouches[0].screenX;
                        handleSwipe();
                    }, false);
                    
                    // For mouse drag support
                    let isDown = false;
                    let startX;
                    let scrollLeft;
                    
                    carousel.addEventListener('mousedown', (e) => {
                        isDown = true;
                        startX = e.pageX - carousel.offsetLeft;
                        scrollLeft = carousel.scrollLeft;
                        carousel.style.cursor = 'grabbing';
                        carousel.style.userSelect = 'none';
                    });
                    
                    carousel.addEventListener('mouseleave', () => {
                        isDown = false;
                        carousel.style.cursor = 'grab';
                    });
                    
                    carousel.addEventListener('mouseup', () => {
                        isDown = false;
                        carousel.style.cursor = 'grab';
                    });
                    
                    carousel.addEventListener('mousemove', (e) => {
                        if (!isDown) return;
                        e.preventDefault();
                        const x = e.pageX - carousel.offsetLeft;
                        const walk = (x - startX) * 2; // Scroll faster
                        carousel.scrollLeft = scrollLeft - walk;
                    });
                    
                    function handleSwipe() {
                        const threshold = 50; // Minimum distance for a swipe
                        const difference = touchStartX - touchEndX;
                        
                        if (Math.abs(difference) > threshold) {
                            const carousel = new bootstrap.Carousel(document.getElementById('productCarousel'));
                            if (difference > 0) {
                                carousel.next(); // Swipe left
                            } else {
                                carousel.prev(); // Swipe right
                            }
                        }
                    }
                });
                </script>
            </div>
            
            <style>
                /* Ensure modals stack properly */
                .modal-backdrop.show {
                    opacity: 0.5;
                }
                
                /* Custom carousel styles */
                #productCarousel {
                    border: 1px solid #f1c40f;
                    border-radius: 12px;
                    overflow: hidden;
                }
                #productCarousel .carousel-inner {
                    height: 400px; /* Fixed height for consistency */
                    background-color: #f9f9f9;
                }
                #productCarousel .carousel-item {
                    height: 100%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    background: white;
                }
                #productCarousel .carousel-item img {
                    max-height: 100%;
                    max-width: 100%;
                    object-fit: contain;
                    padding: 20px;
                }
                #productCarousel .carousel-control-prev,
                #productCarousel .carousel-control-next {
                    width: 8%;
                    opacity: 0;
                    transition: opacity 0.3s;
                    background: rgba(0,0,0,0.1);
                }
                #productCarousel:hover .carousel-control-prev,
                #productCarousel:hover .carousel-control-next {
                    opacity: 1;
                }
                #productCarousel .carousel-indicators {
                    margin: 0;
                    padding: 10px 0;
                    justify-content: center;
                }
                #productCarousel .carousel-indicators button {
                    width: 10px;
                    height: 10px;
                    border-radius: 50%;
                    margin: 0 5px;
                    background-color: #ddd;
                    border: none;
                    opacity: 0.7;
                }
                #productCarousel .carousel-indicators button.active {
                    background-color: #f1c40f;
                }
            </style>
            
            <!-- Finish Options -->
            <div class="finish-options mt-4">
                <h5 class="mb-3">Available Finishes</h5>
                <div class="d-flex flex-wrap gap-3">
                    <?php 
                    $finishImages = [
                        'SN' => $product['sn_image'] ?? '',
                        'BK' => $product['bk_image'] ?? '',
                        'AN' => $product['an_image'] ?? '',
                        'GD' => $product['gd_image'] ?? '',
                        'RG' => $product['rg_image'] ?? ''
                    ];
                    
                    foreach ($finishImages as $finishCode => $imagePath): 
                        if (!empty($imagePath)): 
                    ?>
                        <div class="finish-option" data-finish="<?php echo $finishCode; ?>" 
                             data-image="<?php echo htmlspecialchars($imagePath); ?>">
                            <img src="<?php echo htmlspecialchars($imagePath); ?>" 
                                 alt="<?php echo $finishCode; ?> Finish"
                                 class="img-thumbnail"
                                 style="width: 60px; height: 60px; object-fit: cover; cursor: pointer;">
                            <div class="finish-label"><?php echo $finishCode; ?></div>
                        </div>
                    <?php 
                        endif;
                    endforeach; 
                    ?>
                </div>
            </div>
        </div>
        
        <!-- Product Details -->
        <div class="col-md-6">
            <div class="product-details-container mb-4">
                <h2 class="product-title mb-3"><?php echo htmlspecialchars($product['product_name']); ?></h2>
                <div class="product-description mb-4">
                    <?php 
                    $description = html_entity_decode($product['description']);
                    
                    // Format key details with bold text
                    $keywords = array(
                        'Material:' => '<strong class="detail-label">Material:</strong>',
                        'Suitable for:' => '<strong class="detail-label">Suitable for:</strong>',
                        'Features:' => '<strong class="detail-label">Features:</strong>',
                        'Dimensions:' => '<strong class="detail-label">Dimensions:</strong>',
                        'Weight:' => '<strong class="detail-label">Weight:</strong>',
                        'Color:' => '<strong class="detail-label">Color:</strong>',
                        'Finish:' => '<strong class="detail-label">Finish:</strong>',
                        'Installation:' => '<strong class="detail-label">Installation:</strong>',
                        'Warranty:' => '<strong class="detail-label">Warranty:</strong>',
                        'Package Includes:' => '<strong class="detail-label">Package Includes:</strong>'
                    );
                    
                    // Replace keywords with bold formatting
                    foreach ($keywords as $keyword => $replacement) {
                        $description = str_replace($keyword, $replacement, $description);
                    }
                    
                    // Split by newlines to process each line
                    $lines = explode("\n", $description);
                    $formattedDescription = '';
                    
                    foreach ($lines as $line) {
                        // Check if line contains a detail label
                        if (strpos($line, 'detail-label') !== false) {
                            // This is a new detail section, add a div wrapper
                            $formattedDescription .= '<div class="product-detail-item">' . $line;
                        } else if (trim($line) !== '') {
                            // This is content, possibly belonging to a detail section
                            $formattedDescription .= '<span class="detail-content">' . $line . '</span>';
                        }
                        
                        // Add closing div if needed
                        if (strpos($line, 'detail-label') !== false) {
                            $formattedDescription .= '</div>';
                        }
                    }
                    
                    echo $formattedDescription;
                    ?>
                </div>
            </div>
            
            <style>
                .product-title {
                    font-weight: 600;
                    color: #333;
                    border-bottom: 2px solid #f0f0f0;
                    padding-bottom: 10px;
                }
                .product-description {
                    line-height: 1.8;
                    color: #555;
                    font-size: 1.05rem;
                    background-color: #f9f9f9;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
                }
                .product-detail-item {
                    margin-bottom: 12px;
                    padding-bottom: 12px;
                    border-bottom: 1px dashed #e0e0e0;
                }
                .product-detail-item:last-child {
                    border-bottom: none;
                    margin-bottom: 0;
                    padding-bottom: 0;
                }
                .detail-label {
                    color: #222;
                    font-weight: 700;
                    font-size: 1.1rem;
                    display: block;
                    margin-bottom: 5px;
                    text-transform: uppercase;
                    letter-spacing: 0.5px;
                }
                .detail-content {
                    display: block;
                    padding-left: 10px;
                    font-weight: 500;
                    color: #444;
                }
                .form-label.fw-bold {
                    font-size: 0.9rem;
                    text-transform: uppercase;
                    letter-spacing: 0.5px;
                    color: #555;
                }
                #mainSelectedPrice {
                    font-size: 1.5rem;
                    font-weight: 600;
                }
                /* Decrease font size for dropdown placeholders */
                .form-select option[value=""] {
                    font-size: 0.9rem;
                    color: #6c757d;
                }
                /* Ensure consistent styling for all dropdowns */
                .form-select {
                    font-size: 0.95rem;
                }
                .product-image-container {
                    padding: 15px;
                    background-color: #fff;
                    border-radius: 8px;
                }
                .product-img {
                    max-height: 400px;
                    width: auto;
                    object-fit: contain;
                }
            </style>

            <!-- Size and Finish Selection -->
            <div class="product-options-container p-4 bg-light rounded shadow-sm mb-4">
                <h4 class="mb-3">Product Options</h4>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="mainSizeSelect" class="form-label fw-bold">Size</label>
                        <select id="mainSizeSelect" class="form-select form-select-lg">
                            <option value="">Choose Size</option>
                            <?php foreach ($pricing as $entry) { ?>
                                <option value="<?php echo htmlspecialchars($entry['size']); ?>" 
                                    data-sn="<?php echo $entry['sn_price']; ?>" 
                                    data-bk="<?php echo $entry['bk_price']; ?>" 
                                    data-an="<?php echo $entry['an_price']; ?>" 
                                    data-gd="<?php echo $entry['gd_price']; ?>" 
                                    data-rg="<?php echo $entry['rg_price']; ?>"
                                    data-ch="<?php echo $entry['ch_price']; ?>"
                                    data-gl="<?php echo $entry['gl_price']; ?>">
                                    <?php echo htmlspecialchars($entry['size']); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="mainFinishSelect" class="form-label fw-bold">Finish</label>
                        <select id="mainFinishSelect" class="form-select form-select-lg">
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
                    <div class="col-md-4">
                        <label for="mainQuantity" class="form-label fw-bold">Quantity</label>
                        <div class="input-group product-quantity" style="height: 38px;">
                            <button type="button" class="btn btn-outline-secondary quantity-btn product-quantity-decrease">-</button>
                            <input type="number" id="mainQuantity" class="form-control text-center product-quantity-input" value="1" min="1" style="height: 38px; padding: 0.375rem 0.5rem;">
                            <button type="button" class="btn btn-outline-secondary quantity-btn product-quantity-increase">+</button>
                        </div>
                    </div>
                    <style>
                        .quantity-btn {
                            width: 38px;
                            height: 38px;
                            padding: 0;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                        }
                        .product-quantity-input {
                            -moz-appearance: textfield;
                            max-width: 60px;
                            text-align: center;
                        }
                        .product-quantity-input::-webkit-outer-spin-button,
                        .product-quantity-input::-webkit-inner-spin-button {
                            -webkit-appearance: none;
                            margin: 0;
                        }
                    </style>
                    <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        // Handle quantity increase
                        document.querySelectorAll('.product-quantity-increase').forEach(btn => {
                            btn.addEventListener('click', function(e) {
                                e.stopPropagation();
                                const input = this.closest('.product-quantity').querySelector('.product-quantity-input');
                                if (input) input.stepUp();
                            });
                        });

                        // Handle quantity decrease
                        document.querySelectorAll('.product-quantity-decrease').forEach(btn => {
                            btn.addEventListener('click', function(e) {
                                e.stopPropagation();
                                const input = this.closest('.product-quantity').querySelector('.product-quantity-input');
                                if (input && input.value > 1) {
                                    input.stepDown();
                                }
                            });
                        });
                    });
                    </script>
                </div>
                
                <!-- Price display removed as requested -->
            </div>

            <!-- Dimension Chart Image -->
            <?php if (!empty($product['dimension_image'])): ?>
            <div class="dimension-image-container mt-4 mb-4 text-center">
                <h5 class="mb-3">Product Dimensions</h5>
                <img src="../<?php echo htmlspecialchars($product['dimension_image']); ?>" 
                     alt="<?php echo htmlspecialchars($product['product_name']); ?> Dimensions" 
                     class="img-fluid rounded shadow-sm"
                     style="max-height: 300px; width: auto;">
            </div>
            <style>
                .dimension-image-container {
                    background: #f8f9fa;
                    padding: 20px;
                    border-radius: 8px;
                    border: 1px solid #e9ecef;
                }
                .dimension-image-container h5 {
                    color: #333;
                    font-weight: 600;
                }
            </style>
            <?php endif; ?>

            <!-- Buttons -->
            <div class="action-buttons d-flex gap-3 mt-3">
                <button class="btn btn-custom btn-lg px-4 py-2" id="buyNowBtn">
                    <i class="bi bi-bag-check me-2"></i>Buy Now
                </button>
                <!-- <button class="btn btn-dark btn-lg px-4 py-2" id="addToCartBtn">
                    <i class="bi bi-cart-plus me-2"></i>Add To Cart
                </button> -->
            </div>
        </div>
    </div>
</div>

<!-- Modal for Buy Now Form -->
<div class="modal fade" id="buyNowModal" tabindex="-1" aria-labelledby="buyNowModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="buyNowModalLabel">Buy Now - <?php echo htmlspecialchars($product['product_name']); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="buyNowForm" action="inc/order_api.php" method="POST">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    <input type="hidden" name="finish_image" id="buyNowFinishImage" value="">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control" name="customer_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-control" name="customer_email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" name="customer_phone" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Shipping Address</label>
                        <textarea class="form-control" name="customer_address" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Select Size, Finish & Quantity</label>
                        <div id="sizeFinishContainer">
                            <div class="input-group mb-2">
                                <select class="form-select size-option" name="sizes[]" required onchange="updateFinishOptions(this)">
                                    <option value="">Choose Size</option>
                                    <?php foreach ($pricing as $entry) { ?>
                                        <option value="<?php echo htmlspecialchars($entry['size']); ?>"
                                            data-sn="<?php echo $entry['sn_price']; ?>"
                                            data-bk="<?php echo $entry['bk_price']; ?>"
                                            data-an="<?php echo $entry['an_price']; ?>"
                                            data-gd="<?php echo $entry['gd_price']; ?>"
                                            data-rg="<?php echo $entry['rg_price']; ?>"
                                            data-ch="<?php echo $entry['ch_price']; ?>"
                                            data-gl="<?php echo $entry['gl_price']; ?>">
                                            <?php echo htmlspecialchars($entry['size']); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                <select class="form-select finish-option" name="finishes[]" required>
                                    <option value="">Choose Finish</option>
                                    <option value="sn">Satin Nickel</option>
                                    <option value="bk">Black</option>
                                    <option value="an">Antique Nickel</option>
                                    <option value="gd">Gold</option>
                                    <option value="rg">Rose Gold</option>
                                    <option value="ch">Chrome</option>
                                    <option value="gl">Glossy</option>
                                </select>
                                <input type="number" class="form-control quantity-option" name="quantities[]" placeholder="Qty" min="1" required>
                                <button type="button" class="btn btn-danger remove-option">✖</button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary btn-sm mt-2" id="addOption">+ Add More</button>
                    </div>
                    <div class="mb-3">
                        <h5>Total Price: ₹<span id="totalPrice">0</span></h5>
                        <input type="hidden" name="total_price" id="totalPriceInput">
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-success">Place Order</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Output available sizes as a JS array
const availableSizes = <?php echo json_encode($sizeDetails); ?>;

// Add/Remove size-finish-qty rows
const addOptionBtn = document.getElementById('addOption');
if (addOptionBtn) {
    addOptionBtn.addEventListener('click', function () {
        const container = document.getElementById('sizeFinishContainer');
        const newGroup = document.createElement('div');
        newGroup.classList.add('input-group', 'mb-2');
        newGroup.innerHTML = `
            <select class=\"form-select size-option\" name=\"sizes[]\" required onchange=\"updateFinishOptions(this)\">\n<option value=\"\">Choose Size</option><?php foreach ($pricing as $entry) { ?><option value=\"<?php echo htmlspecialchars($entry['size']); ?>\" data-sn=\"<?php echo $entry['sn_price']; ?>\" data-bk=\"<?php echo $entry['bk_price']; ?>\" data-an=\"<?php echo $entry['an_price']; ?>\" data-gd=\"<?php echo $entry['gd_price']; ?>\" data-rg=\"<?php echo $entry['rg_price']; ?>\" data-ch=\"<?php echo $entry['ch_price']; ?>\" data-gl=\"<?php echo $entry['gl_price']; ?>\"><?php echo htmlspecialchars($entry['size']); ?></option><?php } ?>\n</select>\n<select class=\"form-select finish-option\" name=\"finishes[]\" required>\n<option value=\"\">Choose Finish</option>\n<option value=\"sn\">Satin Nickel</option>\n<option value=\"bk\">Black</option>\n<option value=\"an\">Antique Nickel</option>\n<option value=\"gd\">Gold</option>\n<option value=\"rg\">Rose Gold</option>\n<option value=\"ch\">Chrome</option>\n<option value=\"gl\">Glossy</option>\n</select>\n<input type=\"number\" class=\"form-control quantity-option\" name=\"quantities[]\" placeholder=\"Qty\" min=\"1\" required>\n<button type=\"button\" class=\"btn btn-danger remove-option\">✖</button>\n`;
        container.appendChild(newGroup);
        updateTotalPrice();
    });
}

document.addEventListener('click', function (e) {
    if (e.target.classList.contains('remove-option')) {
        e.target.parentElement.remove();
        updateTotalPrice();
    }
});

document.addEventListener('input', function () {
    updateTotalPrice();
});

function updateTotalPrice() {
    let total = 0;
    document.querySelectorAll('.input-group').forEach(group => {
        const sizeOption = group.querySelector('.size-option');
        const finishOption = group.querySelector('.finish-option');
        const quantity = parseInt(group.querySelector('.quantity-option').value) || 0;
        if (sizeOption && finishOption && sizeOption.value && finishOption.value && quantity > 0) {
            const price = parseFloat(sizeOption.selectedOptions[0].dataset[finishOption.value]) || 0;
            total += price * quantity;
        }
    });
    document.getElementById('totalPrice').innerText = total.toFixed(2);
    document.getElementById('totalPriceInput').value = total.toFixed(2);
}

function updateFinishOptions(selectElement) {
    const finishSelect = selectElement.parentElement.querySelector('.finish-option');
    const selectedSize = selectElement.selectedOptions[0];
    if (!selectedSize || selectedSize.value === '') {
        finishSelect.querySelectorAll('option').forEach((option, index) => {
            option.disabled = index > 0;
        });
        finishSelect.value = '';
        return;
    }
    const finishNames = {
        'sn': 'Satin Nickel',
        'bk': 'Black',
        'an': 'Antique Nickel',
        'gd': 'Gold',
        'rg': 'Rose Gold',
        'ch': 'Chrome',
        'gl': 'Glossy'
    };
    finishSelect.querySelectorAll('option').forEach((option, index) => {
        if (index > 0) {
            option.textContent = finishNames[option.value];
            option.style.color = '';
            option.disabled = false;
        }
    });
    updateTotalPrice();
}

document.addEventListener('DOMContentLoaded', function() {
    const buyNowBtn = document.getElementById('buyNowBtn');
    const buyNowModal = new bootstrap.Modal(document.getElementById('buyNowModal'));
    const mainSizeSelect = document.getElementById('mainSizeSelect');
    const mainFinishSelect = document.getElementById('mainFinishSelect');
    const mainQuantityInput = document.getElementById('mainQuantity');
    if (buyNowBtn) {
        buyNowBtn.addEventListener('click', function() {
            const form = document.getElementById('buyNowForm');
            const modalSizeSelect = form.querySelector('select[name="sizes[]"]');
            const modalFinishSelect = form.querySelector('select[name="finishes[]"]');
            const modalQuantityInput = form.querySelector('input[name="quantities[]"]');
            if (mainSizeSelect && modalSizeSelect && mainSizeSelect.value) {
                for (let i = 0; i < modalSizeSelect.options.length; i++) {
                    if (modalSizeSelect.options[i].value === mainSizeSelect.value) {
                        modalSizeSelect.selectedIndex = i;
                        break;
                    }
                }
                modalSizeSelect.dispatchEvent(new Event('change'));
            } else if (modalSizeSelect) {
                modalSizeSelect.selectedIndex = 0;
                modalSizeSelect.dispatchEvent(new Event('change'));
            }
            setTimeout(() => {
                if (mainFinishSelect && modalFinishSelect && mainFinishSelect.value) {
                    for (let i = 0; i < modalFinishSelect.options.length; i++) {
                        if (modalFinishSelect.options[i].value === mainFinishSelect.value) {
                            modalFinishSelect.selectedIndex = i;
                            break;
                        }
                    }
                } else if (modalFinishSelect) {
                    modalFinishSelect.selectedIndex = 0;
                }
                if (mainQuantityInput && modalQuantityInput && mainQuantityInput.value) {
                    modalQuantityInput.value = mainQuantityInput.value;
                } else if (modalQuantityInput) {
                    modalQuantityInput.value = 1;
                }
                buyNowModal.show();
                updateTotalPrice();
            }, 100);
        });
    }
});
</script>





    

    

  </main>

  <?php include ('inc/footer.php'); ?>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

<script>
// Cart functionality
function getCart() {
    return JSON.parse(localStorage.getItem('cart') || '[]');
}

function setCart(cart) {
    localStorage.setItem('cart', JSON.stringify(cart));
}

function updateCartUI() {
    const cart = getCart();
    let count = 0, total = 0;
    cart.forEach(item => {
        count += item.qty;
        total += item.price * item.qty;
    });
    document.querySelectorAll('.cart-count').forEach(el => el.textContent = count);
    document.querySelectorAll('.cart-total').forEach(el => el.textContent = '₹' + total);
}

function showToast(message) {
    // Create toast container if it doesn't exist
    let toastContainer = document.getElementById('toast-container');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.id = 'toast-container';
        toastContainer.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999;';
        document.body.appendChild(toastContainer);
    }
    
    // Create toast element
    const toast = document.createElement('div');
    toast.className = 'toast show';
    toast.style.cssText = 'background-color: #333; color: white; padding: 15px; border-radius: 4px; margin-bottom: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.2); min-width: 250px;';
    toast.innerHTML = `
        <div class="d-flex align-items-center">
            <i class="bi bi-cart-check me-2" style="color: #DEB462;"></i>
            <div>${message}</div>
            <button type="button" class="btn-close btn-close-white ms-auto" onclick="this.parentElement.parentElement.remove();"></button>
        </div>
    `;
    
    // Add toast to container
    toastContainer.appendChild(toast);
    
    // Remove toast after 3 seconds
    setTimeout(() => {
        toast.remove();
    }, 3000);
}

// Add to Cart functionality
// Handle finish image selection
document.addEventListener('DOMContentLoaded', function() {
    const finishOptions = document.querySelectorAll('.finish-option');
    const finishTitle = document.getElementById('finishTitle');
    const modalFinishImage = document.getElementById('modalFinishImage');
    
    finishOptions.forEach(option => {
        option.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const finishImage = this.getAttribute('data-image');
            const finishCode = this.getAttribute('data-finish');
            
            console.log('Finish option clicked:', { finishImage, finishCode });
            
            // Update modal content
            if (finishTitle) {
                finishTitle.textContent = finishCode || 'Finish Preview';
            }
            
            if (modalFinishImage) {
                // Ensure we have a valid image path
                let imagePath = finishImage || '';
                // Remove any leading slashes or dots from the path
                imagePath = imagePath.replace(/^[.\/]+/, '');
                modalFinishImage.src = imagePath;
                
                // Add error handling for the image
                modalFinishImage.onerror = function() {
                    console.error('Failed to load finish image:', imagePath);
                    this.src = 'data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22300%22%20height%3D%22200%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Crect%20width%3D%22100%25%22%20height%3D%22100%25%22%20fill%3D%22%23f8f9fa%22%2F%3E%3Ctext%20x%3D%2250%25%22%20y%3D%2250%25%22%20font-family%3D%22Arial%2C%20sans-serif%22%20font-size%3D%2214%22%20text-anchor%3D%22middle%22%20alignment-baseline%3D%22middle%22%20fill%3D%22%236c757d%22%3EImage%20not%20found%3C%2Ftext%3E%3C%2Fsvg%3E';
                };
            }
            
            // Show the modal using Bootstrap's modal method
            const modalElement = document.getElementById('finishImageModal');
            if (modalElement) {
                const modal = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
                modal.show();
            } else {
                console.error('Finish image modal element not found');
            }
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    // Main product selection functionality
    const mainSizeSelect = document.getElementById('mainSizeSelect');
    const mainFinishSelect = document.getElementById('mainFinishSelect');
    const mainQuantityInput = document.getElementById('mainQuantity');
    const finishOptions = document.querySelectorAll('.finish-option');
    const selectedFinishImage = document.getElementById('selectedFinishImage');
    
    // Handle finish selection
    finishOptions.forEach(option => {
        option.addEventListener('click', function() {
            // Remove active class from all options
            finishOptions.forEach(opt => opt.classList.remove('active'));
            
            // Add active class to selected option
            this.classList.add('active');
            
            // Update the finish select dropdown
            const finish = this.getAttribute('data-finish');
            mainFinishSelect.value = finish;
            
            // Save the finish image path
            const imagePath = this.getAttribute('data-image');
            selectedFinishImage.value = imagePath;
            
            console.log('Selected finish:', finish, 'Image:', imagePath);
        });
    });
    
    // Handle size selection
    mainSizeSelect.addEventListener('change', function() {
        console.log('Size selected:', this.value);
    });
    
    // Handle quantity change
    mainQuantityInput.addEventListener('input', function() {
        console.log('Quantity updated:', this.value);
    });
    
    // Buy Now button handler
    const buyNowBtn = document.getElementById('buyNowBtn');
    const buyNowModal = new bootstrap.Modal(document.getElementById('buyNowModal'));
    
    if (buyNowBtn) {
        buyNowBtn.addEventListener('click', function() {
            // Check if a finish is selected
            const selectedFinish = document.querySelector('.finish-option.active');
            if (!selectedFinish) {
                alert('Please select a finish first');
                return;
            }
            
            // Get the finish image from the selected finish
            const finishImage = selectedFinish.getAttribute('data-image');
            if (!finishImage) {
                alert('Please select a valid finish with an image');
                return;
            }
            
            // Prefill modal form with main selection
            const form = document.getElementById('buyNowForm');
            const modalSizeSelect = form.querySelector('select[name="sizes[]"]');
            const modalFinishSelect = form.querySelector('select[name="finishes[]"]');
            const modalQuantityInput = form.querySelector('input[name="quantities[]"]');
            const buyNowFinishImage = document.getElementById('buyNowFinishImage');
            
            // Clear any existing finish image and set the new one
            buyNowFinishImage.value = '';
            
            // Store the relative path (remove any leading slashes or dots)
            const relativePath = finishImage.replace(/^[.\/]+/, '');
            buyNowFinishImage.value = relativePath;
            console.log('Setting finish image:', relativePath);

            // Set the values from the main dropdowns if available
            if (mainSizeSelect && modalSizeSelect) {
                for (let i = 0; i < modalSizeSelect.options.length; i++) {
                    if (modalSizeSelect.options[i].value === mainSizeSelect.value) {
                        modalSizeSelect.selectedIndex = i;
                        break;
                    }
                }
                modalSizeSelect.dispatchEvent(new Event('change'));
            }
            setTimeout(() => {
                if (mainFinishSelect && modalFinishSelect) {
                    for (let i = 0; i < modalFinishSelect.options.length; i++) {
                        if (modalFinishSelect.options[i].value === mainFinishSelect.value) {
                            modalFinishSelect.selectedIndex = i;
                            break;
                        }
                    }
                }
                if (mainQuantityInput && modalQuantityInput) {
                    modalQuantityInput.value = mainQuantityInput.value;
                }
                buyNowModal.show();
                updateTotalPrice();
            }, 100);
        });
    }
    
    const addToCartBtn = document.getElementById('addToCartBtn');
    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', function() {
            // Use the main dropdowns instead of the form
            const sizeSelect = document.getElementById('mainSizeSelect');
            const finishSelect = document.getElementById('mainFinishSelect');
            const quantityInput = document.getElementById('mainQuantity');
            
            if (!sizeSelect.value) {
                showToast('Please select a size');
                return;
            }
            
            if (!finishSelect.value) {
                showToast('Please select a finish');
                return;
            }
            
            const quantity = parseInt(quantityInput.value) || 1;
            
            // Get the selected size option to access price data
            const selectedOption = sizeSelect.options[sizeSelect.selectedIndex];
            const finishCode = finishSelect.value;
            const priceAttr = 'data-' + finishCode;
            const price = parseFloat(selectedOption.getAttribute(priceAttr)) || 0;
            
            if (price <= 0) {
                showToast('Selected combination is not available');
                return;
            }
            
            // Get the finish display name
            const finishNames = {
                'sn': 'Satin Nickel',
                'bk': 'Black',
                'an': 'Antique Nickel',
                'gd': 'Gold',
                'rg': 'Rose Gold',
                'ch': 'Chrome',
                'gl': 'Glossy'
            };
            const finishName = finishNames[finishCode] || finishCode;
            
            // Add to cart
            const product = {
                id: <?php echo json_encode($product['id']); ?>,
                name: <?php echo json_encode($product['product_name']); ?>,
                price: price,
                size: sizeSelect.value,
                finish: finishCode,
                finishName: finishName,
                image: <?php echo json_encode($product['product_image']); ?>,
                qty: 1,
                sizes: availableSizes // <-- Add this line
            };
            
            // Get current cart
            const cart = getCart();
            
            // Check if product already exists in cart
            const existingProductIndex = cart.findIndex(item => 
                item.id === product.id && 
                item.size === product.size && 
                item.finish === product.finish
            );
            
            if (existingProductIndex > -1) {
                // If product exists, increase quantity
                cart[existingProductIndex].qty += 1;
            } else {
                // If product doesn't exist, add it to cart
                cart.push(product);
            }
            
            // Save updated cart to localStorage
            setCart(cart);
            
            // Update cart UI
            updateCartUI();
            
            // Show success message
            const originalText = addToCartBtn.textContent;
            addToCartBtn.innerHTML = '<i class="bi bi-check-circle"></i> Added!';
            addToCartBtn.disabled = true;
            
            // Reset button after 2 seconds
            setTimeout(() => {
                addToCartBtn.innerHTML = originalText;
                addToCartBtn.disabled = false;
            }, 2000);
            
            // Show toast notification
            showToast(`${product.name} added to cart!`);
        });
    }
    
    // Initialize cart UI
    updateCartUI();
    
    // Initialize finish image modal
    const finishImageModalElement = document.getElementById('finishImageModal');
    if (finishImageModalElement) {
        window.finishImageModal = new bootstrap.Modal(finishImageModalElement);
    }
});
</script>

<!-- Finish Image Modal -->
<div class="modal fade" id="finishImageModal" tabindex="-1" aria-labelledby="finishImageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 500px; width: auto;">
        <div class="modal-content">
            <div class="modal-header py-1 px-3 bg-light">
                <h6 class="modal-title mb-0 small fw-bold" id="finishImageModalLabel">Finish: <span id="finishTitle"></span></h6>
                <button type="button" class="btn-close btn-close-sm m-0" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-2 d-flex justify-content-center align-items-center" style="min-height: 200px; max-height: 400px;">
                <img id="modalFinishImage" src="" alt="Finish Image" class="img-fluid shadow-sm" style="max-height: 350px; max-width: 100%; width: auto; object-fit: contain;">
            </div>
            <div class="modal-footer py-1 px-2 bg-light">
                <small class="text-muted small d-block text-center w-100">Click outside to close</small>
            </div>
        </div>
    </div>
</div>

<style>
/* Modal styling */
#finishImageModal .modal-dialog {
    margin: 1rem auto;
    max-width: 90%;
}

#finishImageModal .modal-content {
    border: none;
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    border-radius: 8px;
    overflow: hidden;
}

#finishImageModal .modal-header {
    border-bottom: 1px solid #e9ecef;
    padding: 0.5rem 0.75rem;
}

#finishImageModal .modal-footer {
    border-top: 1px solid #e9ecef;
    padding: 0.25rem 0.5rem;
}

#finishImageModal .btn-close {
    padding: 0.5rem;
    margin: -0.5rem -0.5rem -0.5rem auto;
    background-size: 0.7em;
}

/* Make sure the modal is properly sized on mobile */
@media (max-width: 576px) {
    #finishImageModal .modal-dialog {
        margin: 0.5rem auto;
        max-width: 95%;
    }
    
    #finishImageModal .modal-body {
        min-height: 150px;
        max-height: 60vh;
    }
    
    #finishImageModal img {
        max-height: 55vh;
    }
}
</style>

</body>

</html>