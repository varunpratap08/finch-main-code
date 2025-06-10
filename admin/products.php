<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard </title>
  <meta content="" name="description">
  <meta content="" name="keywords">



  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">
  <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>


  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  <style>
    /* Modern Table Styling */
    .table-container {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .table {
        margin-bottom: 0;
    }

    .table thead th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #e9ecef;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        color: #6c757d;
        padding: 1rem 1.5rem;
    }

    .table tbody td {
        padding: 1rem 1.5rem;
        vertical-align: middle;
        border-color: #f1f3f7;
        font-size: 0.875rem;
        color: #4a4a4a;
    }

    .table tbody tr {
        transition: all 0.3s ease;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
    }

    /* Product Image */
    .product-img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 6px;
        border: 1px solid #eee;
        transition: transform 0.3s ease;
    }

    .product-img:hover {
        transform: scale(1.8);
        z-index: 10;
        position: relative;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    /* Action Buttons */
    .action-btns .btn {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin: 0 2px;
        border-radius: 6px;
        transition: all 0.2s;
    }

    .action-btns .btn i {
        font-size: 1.1rem;
    }

    .action-btns .btn-edit {
        background-color: rgba(59, 113, 202, 0.1);
        color: #3B71CA;
        border: none;
    }

    .action-btns .btn-delete {
        background-color: rgba(244, 67, 54, 0.1);
        color: #F44336;
        border: none;
    }

    .action-btns .btn-edit:hover {
        background-color: #3B71CA;
        color: #fff;
    }

    .action-btns .btn-delete:hover {
        background-color: #F44336;
        color: #fff;
    }

    /* Status Badge */
    .status-badge {
        padding: 0.35em 0.65em;
        font-size: 0.75em;
        font-weight: 600;
        border-radius: 6px;
    }

    /* Card Styling */
    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        margin-bottom: 2rem;
    }

    .card-header {
        background-color: #fff;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        padding: 1.5rem;
    }

    .card-title {
        margin-bottom: 0;
        font-weight: 600;
        color: #2c3e50;
    }

    /* Responsive Table */
    @media (max-width: 992px) {
        .table-responsive {
            display: block;
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        .table {
            min-width: 900px;
        }
        
        .action-btns {
            display: flex;
            flex-wrap: nowrap;
        }
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
    }
    
    .empty-state i {
        font-size: 4rem;
        color: #dee2e6;
        margin-bottom: 1rem;
    }
    
    .empty-state h5 {
        color: #6c757d;
        margin-bottom: 0.5rem;
    }
    
    .empty-state p {
        color: #adb5bd;
        margin-bottom: 1.5rem;
    }
    
    /* Loading State */
    .loading {
        position: relative;
        min-height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .loading-spinner {
        width: 3rem;
        height: 3rem;
        border: 0.25rem solid rgba(0, 0, 0, 0.1);
        border-radius: 50%;
        border-top-color: #3B71CA;
        animation: spin 1s ease-in-out infinite;
    }
    
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    
    /* Tooltips */
    [data-bs-toggle="tooltip"] {
        cursor: pointer;
    }
    
    /* Custom Scrollbar */
    ::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }
    
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }
    
    ::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 3px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }
  </style>
  

</head>

<body>




  <?php include('inc/admin_header.php'); ?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Products</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
   


   <?php
require '../inc/db.php'; // Include your database connection file

// Fetch categories
$categories = $pdo->query("SELECT id, category_name FROM category")->fetchAll(PDO::FETCH_ASSOC);

// Fetch subcategories based on category selection
$subcategories = [];
if (isset($_POST['category']) && !empty($_POST['category'])) {
    $stmt = $pdo->prepare("SELECT id, subcategory_name FROM subcategory WHERE category_id = ?");
    // $stmt->execute([$_POST['category']]);
    $subcategories = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = $_POST['product_name'];
    $category_id = $_POST['category']; // This is the category id from the select
    $sub_category_id = $_POST['sub_category']; // This is the subcategory id from the select
    $description = $_POST['description'];
    $sizes = $_POST['sizes'];
    $sn_prices = $_POST['sn_price'];
    $bk_prices = $_POST['bk_price'];
    $an_prices = $_POST['an_price'];
    $gd_prices = $_POST['gd_price'];
    $rg_prices = $_POST['rg_price'];
    $ch_prices = $_POST['ch_price'];
    $gl_prices = $_POST['gl_price'];
    $pricing_data = [];
    foreach ($sizes as $key => $size) {
        $pricing_data[] = [
            'size' => $size,
            'sn_price' => $sn_prices[$key],
            'bk_price' => $bk_prices[$key],
            'an_price' => $an_prices[$key],
            'gd_price' => $gd_prices[$key],
            'rg_price' => $rg_prices[$key],
            'ch_price' => $ch_prices[$key],
            'gl_price' => $gl_prices[$key]
        ];
    }
    $pricing_json = json_encode($pricing_data);

    // Function to handle file uploads
    function uploadImage($file, $target_dir, $prefix = '') {
        if (!empty($file['name'])) {
            $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $new_filename = $prefix . uniqid() . '.' . $file_extension;
            $target_file = $target_dir . $new_filename;
            
            if (move_uploaded_file($file['tmp_name'], $target_file)) {
                return 'uploads/' . $new_filename; // Return relative path
            }
        }
        return '';
    }
    
    // Handle image uploads
    $target_dir = "../uploads/"; // Make sure this directory exists and is writable
    
    // Upload main image (required)
    $main_image = uploadImage($_FILES["product_image"], $target_dir, 'main_');
    
    // Upload additional images (optional)
    $image2 = !empty($_FILES["product_image2"]['name']) ? 
              uploadImage($_FILES["product_image2"], $target_dir, 'img2_') : '';
    $image3 = !empty($_FILES["product_image3"]['name']) ? 
              uploadImage($_FILES["product_image3"], $target_dir, 'img3_') : '';
    
    // Upload dimension image (optional)
    $dimension_image = !empty($_FILES["dimension_image"]['name']) ? 
                     uploadImage($_FILES["dimension_image"], $target_dir, 'dim_') : '';
    
    // Upload finish images (optional)
    $sn_image = !empty($_FILES["sn_image"]['name']) ? 
               uploadImage($_FILES["sn_image"], $target_dir, 'sn_') : '';
    $bk_image = !empty($_FILES["bk_image"]['name']) ? 
               uploadImage($_FILES["bk_image"], $target_dir, 'bk_') : '';
    $an_image = !empty($_FILES["an_image"]['name']) ? 
               uploadImage($_FILES["an_image"], $target_dir, 'an_') : '';
    $gd_image = !empty($_FILES["gd_image"]['name']) ? 
               uploadImage($_FILES["gd_image"], $target_dir, 'gd_') : '';
    $rg_image = !empty($_FILES["rg_image"]['name']) ? 
               uploadImage($_FILES["rg_image"], $target_dir, 'rg_') : '';
    

    try {
        // First, check if the dimension_image column exists, if not, add it
        try {
            $pdo->query("ALTER TABLE products ADD COLUMN IF NOT EXISTS dimension_image VARCHAR(255) DEFAULT NULL AFTER image3");
        } catch (PDOException $e) {
            // Column might already exist, ignore the error
        }

        // First, check if the finish image columns exist, if not, add them
        try {
            $pdo->query("ALTER TABLE products 
                ADD COLUMN IF NOT EXISTS sn_image VARCHAR(255) NULL DEFAULT NULL,
                ADD COLUMN IF NOT EXISTS bk_image VARCHAR(255) NULL DEFAULT NULL,
                ADD COLUMN IF NOT EXISTS an_image VARCHAR(255) NULL DEFAULT NULL,
                ADD COLUMN IF NOT EXISTS gd_image VARCHAR(255) NULL DEFAULT NULL,
                ADD COLUMN IF NOT EXISTS rg_image VARCHAR(255) NULL DEFAULT NULL");
        } catch (PDOException $e) {
            // Columns might already exist, ignore the error
        }

        $stmt = $pdo->prepare("INSERT INTO products 
            (product_name, category, sub_category, description, pricing, product_image, 
             image2, image3, dimension_image,
             sn_image, bk_image, an_image, gd_image, rg_image) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $product_name, 
            $category_id, 
            $sub_category_id, 
            $description, 
            $pricing_json, 
            $main_image,
            $image2,
            $image3,
            $dimension_image,
            $sn_image,
            $bk_image,
            $an_image,
            $gd_image,
            $rg_image
        ]);
        if ($stmt->rowCount() > 0) {
            echo "<div style='color: green; font-weight: bold;'>Product added successfully!</div>";
        } else {
            echo "<div style='color: red; font-weight: bold;'>Failed to add product. Please try again.</div>";
        }
    } catch (PDOException $e) {
        echo "<div style='color: red; font-weight: bold;'>Error: " . $e->getMessage() . "</div>";
    }
}
?>

<section class="section">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Add Product</h5>
      <form method="POST" action="" enctype="multipart/form-data">
        <div class="row">
          <div class="col-lg-6">
            <div class="mb-3 row">
              <label for="product_name" class="col-sm-4 col-form-label">Product Name</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="product_name" required>
              </div>
            </div>
          </div>

          <!-- Category -->
          <div class="col-lg-6">
            <div class="mb-3 row">
              <label for="category" class="col-sm-4 col-form-label">Category</label>
              <div class="col-sm-8">
                <select name="category" class="form-select" id="category" required>
        <option value="">Select Category</option>
        <?php foreach ($categories as $category): ?>
            <option value="<?= $category['id'] ?>"><?= $category['category_name'] ?></option>
        <?php endforeach; ?>
    </select>
              </div>
            </div>
          </div>

          <!-- Sub-Category -->
         <div class="col-lg-6">
    <div class="mb-3 row">
        <label for="sub_category" class="col-sm-4 col-form-label">Sub-Category</label>
        <div class="col-sm-8">
            <select name="sub_category" class="form-select" id="sub_category">
        <option value="">Select Subcategory</option>
    </select>
        </div>
    </div>
</div>


        <div class="mb-3">
          <label for="description" class="form-label">Product Description</label>
          <textarea class="form-control" name="description" id="description"></textarea>
        </div>


        <!-- Product Images -->
        <div class="mb-3">
          <label class="form-label">Product Images</label>
          
          <!-- Main Image (Required) -->
          <div class="mb-3">
            <label for="product_image" class="form-label">Main Image *</label>
            <input type="file" class="form-control" name="product_image" id="product_image" accept="image/*" required>
            <small class="text-muted">This will be the primary image displayed</small>
          </div>
          
          <!-- Additional Image 1 (Optional) -->
          <div class="mb-3">
            <label for="product_image2" class="form-label">Additional Image 1</label>
            <input type="file" class="form-control" name="product_image2" id="product_image2" accept="image/*">
            <small class="text-muted">Optional second image</small>
          </div>
          
          <!-- Additional Image 2 (Optional) -->
          <div class="mb-3">
            <label for="product_image3" class="form-label">Additional Image 2</label>
            <input type="file" class="form-control" name="product_image3" id="product_image3" accept="image/*">
            <small class="text-muted">Optional third image</small>
          </div>
          
          <!-- Dimension Image (Optional) -->
          <div class="mb-3">
            <label for="dimension_image" class="form-label">Dimension Image</label>
            <input type="file" class="form-control" name="dimension_image" id="dimension_image" accept="image/*">
            <small class="text-muted">Image showing product dimensions (optional)</small>
          </div>
          
          <!-- Finish Images -->
          <div class="card mb-4">
            <div class="card-header bg-light">
              <h6 class="mb-0"><i class="bi bi-palette me-2"></i>Finish Images</h6>
              <p class="text-muted small mb-0">Upload images for each finish type (Max 5MB per image)</p>
            </div>
            <div class="card-body">
              <div class="row g-4">
                <?php 
                $finish_images = [
                    'sn_image' => ['label' => 'Satin Nickel (SN)'],
                    'bk_image' => ['label' => 'Black (BK)'],
                    'an_image' => ['label' => 'Antique Nickel (AN)'],
                    'gd_image' => ['label' => 'Gold (GD)'],
                    'rg_image' => ['label' => 'Rose Gold (RG)']
                ];
                
                foreach ($finish_images as $field => $finish): 
                    $preview_id = $field . 'Preview';
                ?>
                <div class="col-md-6 col-lg-4">
                  <div class="border rounded-2 p-3 h-100">
                    <label class="form-label small text-muted mb-1"><?= $finish['label'] ?></label>
                    <div class="d-flex align-items-center gap-3">
                      <div class="bg-light rounded-2 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="bi bi-image text-muted"></i>
                      </div>
                      <div class="flex-grow-1">
                        <input type="file" name="<?= $field ?>" id="<?= $field ?>" accept="image/*" class="d-none" onchange="previewImage(this, '<?= $preview_id ?>')">
                        <label for="<?= $field ?>" class="btn btn-sm btn-outline-secondary w-100">
                          <i class="bi bi-upload me-1"></i> Upload
                        </label>
                      </div>
                    </div>
                    <img src="" class="img-fluid rounded-2 mt-2 d-none" style="max-width: 100%; height: auto; max-height: 100px; object-fit: contain;" id="<?= $preview_id ?>">
                  </div>
                </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        </div>

        <div class="table-responsive">
          <table class="table table-bordered" id="priceTable">
            <thead>
              <tr>
                <th>Size</th>
                <th>SN</th>
                <th>BK</th>
                <th>AN</th>
                <th>GD</th>
                <th>RG</th>
                <th>CH</th>
                <th>GL</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><input type="text" class="form-control" name="sizes[]"></td>
                <td><input type="text" class="form-control" name="sn_price[]"></td>
                <td><input type="text" class="form-control" name="bk_price[]"></td>
                <td><input type="text" class="form-control" name="an_price[]"></td>
                <td><input type="text" class="form-control" name="gd_price[]"></td>
                <td><input type="text" class="form-control" name="rg_price[]"></td>
                <td><input type="text" class="form-control" name="ch_price[]"></td>
                <td><input type="text" class="form-control" name="gl_price[]"></td>
                <td><button type="button" class="btn btn-danger removeRow">X</button></td>
              </tr>
            </tbody>
          </table>
          <button type="button" class="btn btn-success" id="addRow">+ Add Row</button>
        </div>

        <div class="text-center">
          <button type="submit" class="btn btn-primary">Add Product</button>
      </form>
    </div>
  </div>
</section>

<script>
// Image preview functionality
function previewImage(input, previewId) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const preview = document.getElementById(previewId);
            const container = preview.parentElement;
            const placeholder = container.querySelector('.bg-light');
            
            if (preview) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
                
                if (placeholder) {
                    placeholder.classList.add('d-none');
                }
            }
        };
        
        reader.readAsDataURL(input.files[0]);
    }
}

document.getElementById('addRow').addEventListener('click', function () {
    let table = document.getElementById('priceTable').getElementsByTagName('tbody')[0];
    let newRow = table.insertRow();
    newRow.innerHTML = `<td><input type='text' class='form-control' name='sizes[]' required></td>
                         <td><input type='text' class='form-control' name='sn_price[]'></td>
                         <td><input type='text' class='form-control' name='bk_price[]'></td>
                         <td><input type='text' class='form-control' name='an_price[]'></td>
                         <td><input type='text' class='form-control' name='gd_price[]'></td>
                         <td><input type='text' class='form-control' name='rg_price[]'></td>
                         <td><input type='text' class='form-control' name='ch_price[]'></td>
                         <td><input type='text' class='form-control' name='gl_price[]'></td>
                         <td><button type='button' class='btn btn-danger removeRow'>X</button></td>`;
});

document.addEventListener('click', function (e) {
    if (e.target.classList.contains('removeRow')) {
        e.target.closest('tr').remove();
    }
});


document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("category").addEventListener("change", function () {
        let categoryId = this.value;
        let subCategorySelect = document.getElementById("sub_category");

        // Clear previous subcategories
        subCategorySelect.innerHTML = '<option value="">Select Subcategory</option>';

        if (categoryId) {
            let formData = new FormData();
            formData.append("category_id", categoryId);

            fetch("inc/fetch_subcategories.php", {
                method: "POST",
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                data.forEach(subcategory => {
                    let option = document.createElement("option");
                    option.value = subcategory.id;
                    option.textContent = subcategory.subcategory_name;
                    subCategorySelect.appendChild(option);
                });
            })
            .catch(error => console.error("Error fetching subcategories:", error));
        }
    });
});

</script>





<!-- Include CKEditor -->

<?php

// Fetch products from the database
$products = $pdo->query("SELECT * FROM products ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>




<section class="section">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Products Management</h5>
                    <a href="#addProductForm" class="btn btn-primary" data-bs-toggle="modal">
                        <i class="bi bi-plus-circle me-2"></i>Add New Product
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-container">
                        <?php if (!empty($products)): ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Product</th>
                                            <th>Category</th>
                                            <th>Subcategory</th>
                                            <th>Pricing</th>
                                            <th>Finishes</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($products as $index => $product): 
                                            $pricing = json_decode($product['pricing'], true);
                                            $firstPrice = $pricing[0] ?? [];
                                            $imagePath = !empty($product['product_image']) ? 
                                                (strpos($product['product_image'], 'http') === 0 ? 
                                                    $product['product_image'] : 
                                                    '../' . ltrim($product['product_image'], '/')) : 
                                                '../assets/img/no-image.png';
                                        ?>
                                        <tr>
                                            <td><?= $index + 1 ?></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="<?= htmlspecialchars($imagePath) ?>" 
                                                         alt="<?= htmlspecialchars($product['product_name']) ?>" 
                                                         class="product-img me-3">
                                                    <div>
                                                        <h6 class="mb-0"><?= htmlspecialchars($product['product_name']) ?></h6>
                                                        <small class="text-muted">ID: <?= $product['id'] ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?= htmlspecialchars($product['category']) ?></td>
                                            <td><?= htmlspecialchars($product['sub_category'] ?? 'N/A') ?></td>
                                            <td>
                                                <?php if ($firstPrice && !empty($firstPrice['sn_price'])): 
                                                    $price = is_numeric($firstPrice['sn_price']) ? (float)$firstPrice['sn_price'] : 0;
                                                ?>
                                                    <div class="d-flex flex-column">
                                                        <span class="text-nowrap">From: ₹<?= number_format($price, 2) ?></span>
                                                        <small class="text-muted">Size: <?= htmlspecialchars($firstPrice['size'] ?? 'N/A') ?></small>
                                                    </div>
                                                <?php else: ?>
                                                    <span class="text-muted">N/A</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php 
                                                if (!empty($product['finish_ids'])) {
                                                    $finishIds = explode(',', $product['finish_ids']);
                                                    $finishStmt = $pdo->prepare("SELECT name FROM finishes WHERE id IN (" . 
                                                        str_repeat('?,', count($finishIds) - 1) . '?' . ")");
                                                    $finishStmt->execute($finishIds);
                                                    $finishNames = $finishStmt->fetchAll(PDO::FETCH_COLUMN);
                                                    echo '<div class="d-flex flex-wrap gap-1">';
                                                    foreach ($finishNames as $name) {
                                                        echo '<span class="badge bg-info">' . htmlspecialchars($name) . '</span>';
                                                    }
                                                    echo '</div>';
                                                } else {
                                                    echo '<span class="text-muted">None</span>';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <span class="badge bg-success">Active</span>
                                            </td>
                                            <td class="action-btns">
                                                <button class="btn btn-edit btn-sm" 
                                                        onclick="window.location.href='inc/edit_product.php?id=<?= $product['id'] ?>'"
                                                        data-bs-toggle="tooltip" 
                                                        title="Edit Product">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-delete btn-sm" 
                                                        onclick="deleteProduct(<?= $product['id'] ?>)"
                                                        data-bs-toggle="tooltip" 
                                                        title="Delete Product">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                                <button class="btn btn-info btn-sm" 
                                                        data-bs-toggle="tooltip" 
                                                        title="View Details">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="empty-state">
                                <i class="bi bi-inbox"></i>
                                <h5>No Products Found</h5>
                                <p>You haven't added any products yet.</p>
                                <a href="#addProductForm" class="btn btn-primary" data-bs-toggle="modal">
                                    <i class="bi bi-plus-circle me-2"></i>Add Your First Product
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if (!empty($products)): ?>
                <div class="card-footer bg-transparent">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted">
                            Showing <span>1</span> to <span><?= count($products) ?></span> of <span><?= count($products) ?></span> entries
                        </div>
                        <nav aria-label="Page navigation">
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
                </div>
            </div>
        </div>
    </div>
</section>

<script>

function deleteProduct(id) {
    if (confirm("Are you sure you want to delete this product?")) {
        window.location.href = 'inc/delete_product.php?id=' + id;
    }
}

</script>
<style>
 .icon-tooltip {
    position: relative;
    display: inline-block;
    font-size: 20px; /* Icon size */
    cursor: pointer;
    margin: 0 8px; /* Spacing between icons */
    transition: transform 0.2s, color 0.2s; /* Hover effects */
}

.icon-tooltip:hover {
    transform: scale(1.2); /* Zoom effect on hover */
    opacity: 0.9;
}

/* Tooltip styling */
.icon-tooltip::after {
    content: attr(title); /* Get tooltip text from the title attribute */
    position: absolute;
    bottom: 120%; /* Position above the icon */
    left: 50%;
    transform: translateX(-50%);
    background-color: #333;
    color: #fff;
    padding: 6px 10px;
    border-radius: 4px;
    white-space: nowrap;
    font-size: 12px;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s, transform 0.3s;
    z-index: 10;
}

/* Show tooltip on hover */
.icon-tooltip:hover::after {
    opacity: 1;
    visibility: visible;
    transform: translate(-50%, -5px); /* Slight upward movement */
}

.add-product-btn {
    background-color: #3B71CA;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
    float: right; /* Align to the right */
    margin-bottom: 15px;
    font-weight: bold;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    margin-top: 70px;
    margin-left: 20px;
}

.add-product-btn:hover {
    background-color: #2851a3;
    transform: translateY(-2px);
}

.add-product-btn:active {
    transform: translateY(0);
}

</style>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>Icon Furniture</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
     
      Designed by <a href="https://volvrit.com/">Volvrit</a>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
  <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>


</body>

</html>