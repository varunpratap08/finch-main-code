
<?php
require '../inc/db.php';

// Set page title
$pageTitle = isset($_GET['edit_id']) ? 'Edit Product' : 'Add New Product';

// Fetch categories and subcategories
$categories = $pdo->query("SELECT DISTINCT category_name FROM category ORDER BY category_name")->fetchAll(PDO::FETCH_ASSOC);
$subcategories = $pdo->query("SELECT DISTINCT subcategory_name FROM subcategory ORDER BY subcategory_name")->fetchAll(PDO::FETCH_ASSOC);

// Initialize default product values
$product = [
    'product_name' => '',
    'category_name' => '',
    'subcategory_name' => '',
    'description' => '',
    'pricing' => '[]', // Default empty JSON
    'product_image' => ''
];

if (isset($_GET['edit_id'])) {
    $stmt = $pdo->prepare("SELECT * FROM product WHERE id = ?");
    $stmt->execute([$_GET['edit_id']]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = $_POST['product_name'];
    $category_name = $_POST['category'];
    $subcategory_name = $_POST['sub_category'];
    $description = $_POST['description'];

    // Convert pricing data to JSON
    $pricing_data = [];
    foreach ($_POST['size'] as $index => $size) {
        $pricing_data[] = [
            'size' => $size,
            'sn_price' => $_POST['sn_price'][$index] ?? '',
            'bk_price' => $_POST['bk_price'][$index] ?? '',
            'an_price' => $_POST['an_price'][$index] ?? '',
            'gd_price' => $_POST['gd_price'][$index] ?? '',
            'rg_price' => $_POST['rg_price'][$index] ?? '',
            'ch_price' => $_POST['ch_price'][$index] ?? '',
            'gl_price' => $_POST['gl_price'][$index] ?? ''
        ];
    }
    $pricing_json = json_encode($pricing_data);

    // Handle image upload
    if (!empty($_FILES['product_image']['name'])) {
        $image_name = time() . '_' . $_FILES['product_image']['name'];
        move_uploaded_file($_FILES['product_image']['tmp_name'], "uploads/$image_name");
    } else {
        $image_name = $product['product_image'] ?? ''; // Keep existing image if editing
    }

    if (isset($_POST['product_id'])) {
        // Update existing product
        $stmt = $pdo->prepare("UPDATE products SET product_name=?, category_name=?, subcategory_name=?, description=?, pricing=?, product_image=? WHERE id=?");
        $stmt->execute([$product_name, $category_name, $subcategory_name, $description, $pricing_json, $image_name, $_POST['product_id']]);
    } else {
        // Insert new product
        $stmt = $pdo->prepare("INSERT INTO products (product_name, category_name, subcategory_name, description, pricing, product_image) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$product_name, $category_name, $subcategory_name, $description, $pricing_json, $image_name]);
    }

    header("Location: product_list.php");
    exit();
}

$pricing = json_decode($product['pricing'] ?? '[]', true) ?: [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?> - Admin Panel</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --secondary: #6b7280;
            --light: #f9fafb;
            --lighter: #f3f4f6;
            --dark: #111827;
            --gray: #6b7280;
            --gray-light: #9ca3af;
            --gray-lighter: #e5e7eb;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --border-radius: 0.5rem;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --transition: all 0.2s ease-in-out;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background-color: #f3f4f6;
            color: var(--dark);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        
        .form-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
            background: white;
            min-height: 100vh;
        }
        
        @media (min-width: 1200px) {
            .form-container {
                padding: 3rem 4rem;
            }
        }
        
        .form-header {
            padding: 1.5rem 0;
            margin-bottom: 2rem;
            border-bottom: 1px solid var(--gray-lighter);
        }
        
        .form-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }
        
        .form-header p {
            color: var(--gray);
            margin-bottom: 0;
        }
        
        .form-section {
            background: white;
            border-radius: var(--border-radius);
            padding: 2rem;
            margin-bottom: 1.5rem;
            border: 1px solid var(--gray-lighter);
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
        }
        
        .form-section:hover {
            box-shadow: var(--shadow);
        }
        
        .form-section h5 {
            color: var(--primary);
            margin-bottom: 1.5rem;
            font-weight: 600;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .form-section h5 i {
            font-size: 1.25rem;
        }
        
        .form-label {
            font-weight: 500;
            color: var(--dark);
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }
        
        .form-control, .form-select, .form-control:focus, .form-select:focus {
            border-radius: var(--border-radius);
            padding: 0.625rem 0.875rem;
            border: 1px solid var(--gray-lighter);
            font-size: 0.9375rem;
            color: var(--dark);
            transition: var(--transition);
            height: calc(2.5rem + 2px);
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
        }
        
        textarea.form-control {
            min-height: 100px;
            height: auto;
            resize: vertical;
        }
        
        .btn {
            font-weight: 500;
            border-radius: var(--border-radius);
            padding: 0.625rem 1.25rem;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-size: 0.9375rem;
        }
        
        .btn i {
            font-size: 1.1em;
        }
        
        .btn-primary {
            background-color: var(--primary);
            border: none;
            color: white;
        }
        
        .btn-primary:hover, .btn-primary:focus {
            background-color: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: var(--shadow);
        }
        
        .btn-outline-secondary {
            border: 1px solid var(--gray-lighter);
            color: var(--gray);
            background: white;
        }
        
        .btn-outline-secondary:hover, .btn-outline-secondary:focus {
            background: var(--lighter);
            border-color: var(--gray-light);
            transform: translateY(-1px);
            box-shadow: var(--shadow);
        }
        
        .btn-light {
            background-color: var(--lighter);
            color: var(--gray);
        }
        
        .btn-light:hover {
            background-color: var(--gray-lighter);
        }
        
        .table {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
            background: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }
        
        .table th {
            background-color: var(--lighter);
            font-weight: 600;
            color: var(--dark);
            padding: 1rem 1.25rem;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            border: none;
        }
        
        .table td {
            padding: 1rem 1.25rem;
            vertical-align: middle;
            border-top: 1px solid var(--gray-lighter);
        }
        
        .table tr:last-child td {
            border-bottom: none;
        }
        
        .table tbody tr:hover {
            background-color: rgba(249, 250, 251, 0.5);
        }
        
        .action-buttons .btn {
            margin-left: 0.5rem;
        }
        
        /* Responsive styles */
        @media (max-width: 992px) {
            .form-container {
                padding: 1.5rem;
            }
            
            .form-section {
                padding: 1.5rem;
            }
        }
        
        @media (max-width: 768px) {
            .form-container {
                padding: 1rem;
            }
            
            .form-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
                padding: 1rem 0;
            }
            
            .form-header .btn-group {
                width: 100%;
            }
            
            .form-header .btn {
                width: 100%;
                justify-content: center;
            }
            
            .form-section {
                padding: 1.25rem;
            }
            
            .table-responsive {
                border-radius: var(--border-radius);
                border: 1px solid var(--gray-lighter);
                margin: 0 -1rem;
                width: calc(100% + 2rem);
            }
        }
        
        @media (max-width: 576px) {
            .form-container {
                padding: 0.75rem;
            }
            
            .form-header h1 {
                font-size: 1.5rem;
            }
            
            .form-section {
                padding: 1rem;
                margin-left: -0.75rem;
                margin-right: -0.75rem;
                width: calc(100% + 1.5rem);
                border-radius: 0;
                border-left: none;
                border-right: none;
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <header class="form-header">
            <div>
                <h1><?= $pageTitle ?></h1>
                <p><?= isset($_GET['edit_id']) ? 'Update the product details below' : 'Fill in the details to add a new product' ?></p>
            </div>
            <div class="d-flex gap-2 mt-3">
                <a href="products.php" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Back to Products
                </a>
                <a href="dashboard.php" class="btn btn-primary">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </div>
        </header>

        <form method="POST" action="" enctype="multipart/form-data" class="needs-validation" novalidate>
            <?php if (isset($_GET['edit_id'])): ?>
                <input type="hidden" name="product_id" value="<?= $_GET['edit_id'] ?>">
            <?php endif; ?>

            <div class="form-section">
                <h5><i class="bi bi-box-seam me-2"></i>Product Information</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="product_name" class="form-label">Product Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="product_name" name="product_name" 
                               value="<?= htmlspecialchars($product['product_name'] ?? '') ?>" required>
                        <div class="invalid-feedback">
                            Please provide a product name.
                        </div>
                    </div>
          </div>

          <div class="col-lg-6">
            <div class="mb-3 row">
              <label for="category" class="col-sm-4 col-form-label">Category</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="category" value="<?= $product['category_name'] ?>" required>
              </div>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="mb-3 row">
              <label for="sub_category" class="col-sm-4 col-form-label">Sub-Category</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="sub_category" value="<?= $product['subcategory_name'] ?>" required>
              </div>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="mb-3 row">
              <label for="product_image" class="col-sm-4 col-form-label">Product Image</label>
              <div class="col-sm-8">
                <input type="file" class="form-control" name="product_image" accept="image/*">
                <?php if (!empty($product['product_image'])): ?>
                  <img src="uploads/<?= $product['product_image'] ?>" class="img-thumbnail mt-2" width="100">
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>

        <div class="mb-3">
          <label for="description" class="form-label">Product Description</label>
          <textarea class="form-control" name="description"><?= $product['description'] ?></textarea>
        </div>

        <div class="table-responsive">
          <table class="table table-bordered">
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
            <tbody id="pricingTable">
              <?php foreach ($pricing as $p): ?>
                <tr>
                  <td><input type="text" class="form-control" name="size[]" value="<?= $p['size'] ?>"></td>
                  <td><input type="text" class="form-control" name="sn_price[]" value="<?= $p['sn_price'] ?>"></td>
                  <td><input type="text" class="form-control" name="bk_price[]" value="<?= $p['bk_price'] ?>"></td>
                  <td><input type="text" class="form-control" name="an_price[]" value="<?= $p['an_price'] ?>"></td>
                  <td><input type="text" class="form-control" name="gd_price[]" value="<?= $p['gd_price'] ?>"></td>
                  <td><input type="text" class="form-control" name="rg_price[]" value="<?= $p['rg_price'] ?>"></td>
                  <td><input type="text" class="form-control" name="ch_price[]" value="<?= $p['ch_price'] ?>"></td>
                  <td><input type="text" class="form-control" name="gl_price[]" value="<?= $p['gl_price'] ?>"></td>
                  <td><button type="button" class="btn btn-danger removeRow">X</button></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
          <button type="button" id="addRow" class="btn btn-primary">Add Row</button>
        </div>

        <div class="text-center mt-3">
          <button type="submit" class="btn btn-success"><?= isset($_GET['edit_id']) ? 'Update' : 'Add' ?> Product</button>
        </div>
                      </div>
            </div>

            <div class="d-flex justify-content-end gap-3 mt-5 pt-3 border-top">
            <button type="reset" class="btn btn-light">
                <i class="bi bi-arrow-counterclockwise"></i> Reset Form
            </button>
            <button type="submit" class="btn btn-primary px-4">
                <i class="bi bi-save"></i> <?= isset($_GET['edit_id']) ? 'Update Product' : 'Save Product' ?>
            </button>
        </div>
        </form>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Form validation
        (function () {
            'use strict'
            
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.querySelectorAll('.needs-validation')
            
            // Loop over them and prevent submission
            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
                        
                        form.classList.add('was-validated')
                    }, false)
                })
        })()
        
        // Add price row
        document.getElementById('addRow').addEventListener('click', function() {
            const tbody = document.getElementById('pricingTable').getElementsByTagName('tbody')[0];
            const newRow = tbody.insertRow();
            newRow.innerHTML = `
                <td><input type="text" class="form-control" name="size[]" required></td>
                <td><input type="number" step="0.01" class="form-control" name="sn_price[]" required></td>
                <td><input type="number" step="0.01" class="form-control" name="bk_price[]" required></td>
                <td><input type="number" step="0.01" class="form-control" name="an_price[]" required></td>
                <td><input type="number" step="0.01" class="form-control" name="gd_price[]" required></td>
                <td><input type="number" step="0.01" class="form-control" name="rg_price[]" required></td>
                <td><input type="number" step="0.01" class="form-control" name="ch_price[]" required></td>
                <td><input type="number" step="0.01" class="form-control" name="gl_price[]" required></td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-outline-danger remove-row">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>`;
                
            // Add event listener to the new remove button
            newRow.querySelector('.remove-row').addEventListener('click', function() {
                this.closest('tr').remove();
            });
        });
        
        // Add event delegation for remove buttons
        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-row')) {
                e.target.closest('tr').remove();
            }
        });
    </script>
</body>
</html>

<script>
document.getElementById('addRow').addEventListener('click', function() {
    document.getElementById('pricingTable').insertRow().innerHTML = '<td><input type="text" class="form-control" name="size[]"></td>' +
    '<td><input type="text" class="form-control" name="sn_price[]"></td>' +
    '<td><input type="text" class="form-control" name="bk_price[]"></td>' +
    '<td><input type="text" class="form-control" name="an_price[]"></td>' +
    '<td><input type="text" class="form-control" name="gd_price[]"></td>' +
    '<td><input type="text" class="form-control" name="rg_price[]"></td>' +
    '<td><input type="text" class="form-control" name="ch_price[]"></td>' +
    '<td><input type="text" class="form-control" name="gl_price[]"></td>' +
    '<td><button type="button" class="btn btn-danger removeRow">X</button></td>';
});
</script>


<script>
document.getElementById('category').addEventListener('change', function () {
    let categoryId = this.value;
    fetch('inc/fetch_subcategories.php?category_id=' + categoryId)
        .then(response => response.json())
        .then(data => {
            let subCategorySelect = document.getElementById('sub_category');
            subCategorySelect.innerHTML = '<option value="">Select Subcategory</option>';
            data.forEach(sub => {
                subCategorySelect.innerHTML += `<option value="${sub.id}">${sub.subcategory_name}</option>`;
            });
        });
});
</script>

