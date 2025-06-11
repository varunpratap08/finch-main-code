
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
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --transition: all 0.3s ease;
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
        }

        .form-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 2.5rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .form-header {
            margin-bottom: 2.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--gray-lighter);
        }

        .form-header h1 {
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .form-header p {
            color: var(--gray);
            margin-bottom: 1.5rem;
        }
        
        .form-section {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 2rem;
            margin-bottom: 2rem;
            border: 1px solid #e9ecef;
        }

        .form-section h5 {
            color: var(--dark);
            font-weight: 600;
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid var(--primary);
            display: inline-block;
        }

        .form-section:hover {
            box-shadow: var(--shadow);
        }
        
        .form-label {
            font-weight: 500;
            color: #495057;
            margin-bottom: 0.5rem;
        }
        
        .form-control, .form-select, .form-control:focus, .form-select:focus {
            border-radius: 6px;
            padding: 0.65rem 1rem;
            border: 1px solid #dee2e6;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.15);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 500;
            padding: 0.65rem 1.5rem;
            border-radius: 6px;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .btn i {
            font-size: 1.1em;
            margin-right: 0.5rem;
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
            transform: translateY(-1px);
        }

        .btn-outline-secondary {
            color: var(--gray);
            border-color: var(--gray-light);
        }

        .btn-outline-secondary:hover {
            background-color: var(--gray-lighter);
            color: var(--dark);
        }
        
        .table {
            width: 100%;
            margin-bottom: 1.5rem;
            color: #212529;
            vertical-align: top;
            border-color: #e9ecef;
            background: white;
            border-radius: 8px;
            overflow: hidden;
        }
        
        .table th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #e9ecef;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            color: #6c757d;
            padding: 1rem;
        }
        
        .table td {
            padding: 1rem;
            vertical-align: middle;
            border-top: 1px solid #e9ecef;
            background: white;
        }

        .table input[type="text"],
        .table input[type="number"] {
            min-width: 80px;
            padding: 0.5rem;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            font-size: 0.9rem;
        }

        .table input[type="text"]:focus,
        .table input[type="number"]:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.15);
        }

        .remove-row {
            min-width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }

        .img-thumbnail {
            max-width: 120px;
            height: auto;
            border-radius: 6px;
            margin-top: 0.5rem;
            border: 1px solid #dee2e6;
            padding: 0.25rem;
            background: white;
        }

        /* Responsive adjustments */
        @media (max-width: 992px) {
            .form-container {
                padding: 1.5rem;
                margin: 1rem;
                border-radius: 8px;
            }
            
            .form-section {
                padding: 1.5rem;
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
                <h1><i class="bi bi-box-seam me-2"></i><?= $pageTitle ?></h1>
                <p class="text-muted"><?= isset($_GET['edit_id']) ? 'Update the product details below' : 'Fill in the details to add a new product' ?></p>
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
                <div class="row g-4">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="product_name" class="form-label">Product Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="product_name" name="product_name" 
                               value="<?= htmlspecialchars($product['product_name'] ?? '') ?>" required>
                        <div class="invalid-feedback">
                            Please provide a product name.
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="category" name="category" 
                               value="<?= htmlspecialchars($product['category_name'] ?? '') ?>" required>
                        <div class="invalid-feedback">
                            Please select a category.
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="sub_category" class="form-label">Sub-Category <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="sub_category" name="sub_category"
                               value="<?= htmlspecialchars($product['subcategory_name'] ?? '') ?>" required>
                        <div class="invalid-feedback">
                            Please select a sub-category.
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <label for="product_image" class="form-label">Product Image</label>
                        <div class="d-flex align-items-start gap-3">
                            <div class="flex-grow-1">
                                <input type="file" class="form-control" id="product_image" name="product_image" accept="image/*">
                                <div class="form-text">Recommended size: 800x800px. Max file size: 2MB</div>
                            </div>
                            <?php if (!empty($product['product_image'])): ?>
                            <div class="text-center">
                                <p class="small mb-1">Current Image:</p>
                                <img src="uploads/<?= $product['product_image'] ?>" class="img-thumbnail" style="max-width: 120px;">
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
        </div>

                <div class="col-12">
                    <div class="form-group">
                        <label for="description" class="form-label">Product Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4" 
                                  placeholder="Enter detailed product description..."><?= htmlspecialchars($product['description'] ?? '') ?></textarea>
                    </div>
                </div>

                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Pricing Information</h5>
                        <button type="button" id="addRow" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-lg"></i> Add Row
                        </button>
                    </div>
                    
                    <div class="table-responsive border rounded">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="15%">Size</th>
                                    <th>SN</th>
                                    <th>BK</th>
                                    <th>AN</th>
                                    <th>GD</th>
                                    <th>RG</th>
                                    <th>CH</th>
                                    <th>GL</th>
                                    <th width="80px">Action</th>
                                </tr>
                            </thead>
                            <tbody id="pricingTable">
                                <?php if (empty($pricing)): ?>
                                <tr>
                                    <td colspan="9" class="text-center py-4 text-muted">
                                        <i class="bi bi-info-circle me-2"></i>No pricing information added yet.
                                    </td>
                                </tr>
                                <?php else: ?>
                                    <?php foreach ($pricing as $index => $p): ?>
                                    <tr>
                                        <td>
                                            <input type="text" class="form-control form-control-sm" name="size[]" 
                                                   value="<?= htmlspecialchars($p['size'] ?? '') ?>" placeholder="e.g., S, M, L">
                                        </td>
                                        <td><input type="number" step="0.01" class="form-control form-control-sm" name="sn_price[]" 
                                               value="<?= htmlspecialchars($p['sn_price'] ?? '') ?>" placeholder="0.00"></td>
                                        <td><input type="number" step="0.01" class="form-control form-control-sm" name="bk_price[]" 
                                               value="<?= htmlspecialchars($p['bk_price'] ?? '') ?>" placeholder="0.00"></td>
                                        <td><input type="number" step="0.01" class="form-control form-control-sm" name="an_price[]" 
                                               value="<?= htmlspecialchars($p['an_price'] ?? '') ?>" placeholder="0.00"></td>
                                        <td><input type="number" step="0.01" class="form-control form-control-sm" name="gd_price[]" 
                                               value="<?= htmlspecialchars($p['gd_price'] ?? '') ?>" placeholder="0.00"></td>
                                        <td><input type="number" step="0.01" class="form-control form-control-sm" name="rg_price[]" 
                                               value="<?= htmlspecialchars($p['rg_price'] ?? '') ?>" placeholder="0.00"></td>
                                        <td><input type="number" step="0.01" class="form-control form-control-sm" name="ch_price[]" 
                                               value="<?= htmlspecialchars($p['ch_price'] ?? '') ?>" placeholder="0.00"></td>
                                        <td><input type="number" step="0.01" class="form-control form-control-sm" name="gl_price[]" 
                                               value="<?= htmlspecialchars($p['gl_price'] ?? '') ?>" placeholder="0.00"></td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-outline-danger remove-row" 
                                                    data-bs-toggle="tooltip" title="Remove row">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="form-text mt-2">
                        <i class="bi bi-info-circle me-1"></i> Enter pricing for different sizes and finishes. Leave blank if not applicable.
                    </div>
                </div>

        <div class="d-flex justify-content-between align-items-center mt-5 pt-4 border-top">
            <button type="reset" class="btn btn-light">
                <i class="bi bi-arrow-counterclockwise"></i> Reset Form
            </button>
            <div class="d-flex gap-3">
                <a href="products.php" class="btn btn-outline-secondary">
                    <i class="bi bi-x-lg"></i> Cancel
                </a>
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-save"></i> <?= isset($_GET['edit_id']) ? 'Update Product' : 'Save Product' ?>
                </button>
            </div>
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

