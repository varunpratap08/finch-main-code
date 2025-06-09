<?php
require 'db.php';

// Use category_id for filtering
$category_id = isset($_GET['category_id']) ? (int)$_GET['category_id'] : null;
$subcategory = isset($_GET['subcategory']) ? trim($_GET['subcategory']) : null;
$products = [];
$subcategories = [];

if ($category_id) {
    // Fetch subcategories
    $stmt = $pdo->prepare("SELECT * FROM subcategory WHERE category_id = ?");
    $stmt->execute([$category_id]);
    $subcategories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // If subcategory is selected, filter by both
    if ($subcategory) {
        $stmt = $pdo->prepare("SELECT * FROM products WHERE category = ? AND subcategory = ?");
        $stmt->execute([$category_id, $subcategory]);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        // Only category selected
        $stmt = $pdo->prepare("SELECT * FROM products WHERE category = ?");
        $stmt->execute([$category_id]);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} elseif ($subcategory) {
    // If only subcategory is selected (no category param)
    $stmt = $pdo->prepare("SELECT * FROM products WHERE subcategory = ?");
    $stmt->execute([$subcategory]);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // No filter, show all products
    $stmt = $pdo->query("SELECT * FROM products");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!-- Subcategory Section -->
<div class="row mt-2 g-2 mb-2" id="subcategory-container">
    <?php foreach ($subcategories as $sub): 
        $subName = htmlspecialchars($sub['subcategory_name'], ENT_QUOTES);
    ?>
        <div class="col-md-6 col-12 text-center p-2 borderhover subcategory-item" 
             data-subcategory="<?= $subName ?>" 
             onclick="fetchsubcateproducts('<?= $subName ?>', this)"
             style="border-bottom:2px solid #E0E8F0">
            <span class="mb-3"><?= $sub['subcategory_name'] ?></span>
        </div>
    <?php endforeach; ?>
</div>

<!-- Products Section -->
<div class="row" id="product-container">
    <?php if (count($products) > 0): ?>
        <?php foreach ($products as $index => $product): 
            $pricing_data = json_decode($product['pricing'], true);
            $sizes = [];
            $finishes = [];
            $finish_labels = [
                'Satin Nickel',
                'Black',
                'Antique Nickel',
                'Gold',
                'Rose Gold',
                'Chrome',
                'Glossy'
            ];
            if (!empty($pricing_data)) {
                foreach ($pricing_data as $price_row) {
                    if (!empty($price_row['size']) && !in_array($price_row['size'], $sizes)) {
                        $sizes[] = $price_row['size'];
                    }
                    foreach ($finish_labels as $label) {
                        if (!in_array($label, $finishes)) {
                            $finishes[] = $label;
                        }
                    }
                }
            }
        ?>
            <div class="col-md-4 col-sm-6 mb-4 d-flex">
                <div class="product-card shadow rounded-4 p-3 bg-white position-relative w-100 d-flex flex-column" style="border: 1px solid #f1c40f;">
                    <div class="product-image text-center mb-2" style="height: 200px; display: flex; align-items: center; justify-content: center;">
                        <img src="<?= htmlspecialchars($product['product_image']) ?>" alt="<?= htmlspecialchars($product['product_name']) ?>" class="img-fluid rounded-3" style="max-height: 100%; max-width: 100%; object-fit: contain;">
                    </div>
                    <div class="product-title-wrapper mt-2 mb-1">
                        <h2 class="product-title fs-5 fw-bold text-dark mb-1"><?= htmlspecialchars($product['product_name']) ?></h2>
                    </div>
                    <div class="product-description mb-3 text-secondary small flex-grow-1">
                        <?= isset($product['description']) ? htmlspecialchars($product['description']) : '' ?>
                    </div>
                    <div class="product-buttons d-flex gap-2 mt-auto">
                        <a href="product-details.php?id=<?= urlencode($product['id']) ?>" class="buy-now btn btn-sm btn-warning w-100 fw-semibold">View Details</a>
                        <button class="add-to-cart btn btn-sm btn-outline-dark w-100 fw-semibold"
                            data-id="<?= $product['id'] ?>"
                            data-name="<?= htmlspecialchars($product['product_name']) ?>"
                            data-image="<?= htmlspecialchars($product['product_image']) ?>"
                        >Add to Cart</button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No products found.</p>
    <?php endif; ?>
</div>

 <script>
function fetchsubcateproducts(subcategoryName, element) {
    const xhr = new XMLHttpRequest();
    const subcatcontainer =  document.getElementById('subcategory-container').innerHTML;
    xhr.open("GET", "inc/fetch_product_subcat.php?subcategory=" + encodeURIComponent(subcategoryName), true);
    xhr.onload = function () {
        alert(subcatcontainer);
        if (xhr.status === 200) {
            document.getElementById("product-container").innerHTML = xhr.responseText;
            document.getElementById("subcatcontiner2").innerHTML = subcatcontainer;

            // Highlight active subcategory
            document.querySelectorAll('.subcategory-item').forEach(item => {
                item.classList.remove('active-subcategory');
            });
            element.classList.add('active-subcategory');
        }
    };
    xhr.send();
}
</script>

