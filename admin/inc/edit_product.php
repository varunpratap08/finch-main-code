
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - Admin Panel</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
    :root {
        --primary: #4361ee;
        --primary-light: #eef2ff;
        --secondary: #6c757d;
        --success: #28a745;
        --info: #17a2b8;
        --warning: #ffc107;
        --danger: #dc3545;
        --light: #f8f9fa;
        --dark: #343a40;
        --border-radius: 0.375rem;
        --box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        --transition: all 0.3s ease;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background-color: #f5f7fb;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        color: #333;
        line-height: 1.6;
        -webkit-font-smoothing: antialiased;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }

    .card {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        border: none;
        overflow: hidden;
        margin-bottom: 2rem;
        transition: var(--transition);
    }

    .card:hover {
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);
        color: white;
        padding: 1.25rem 1.5rem;
        border-bottom: none;
        border-radius: 12px 12px 0 0 !important;
    }

    .card-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .card-title i {
        font-size: 1.75rem;
    }

    .card-body {
        padding: 1.5rem;
    }

    .form-label {
        font-weight: 500;
        color: #495057;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
    }

    .form-control, .form-select, .form-check-input {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        font-size: 0.9375rem;
        transition: var(--transition);
        height: auto;
    }

    .form-control:focus, .form-select:focus, .form-check-input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.15);
    }

    .form-control::placeholder {
        color: #94a3b8;
        opacity: 1;
    }

    .form-check {
        margin-bottom: 0.5rem;
    }

    .form-check-input {
        width: 1.25rem;
        height: 1.25rem;
        margin-top: 0.15rem;
    }

    .form-check-input:checked {
        background-color: var(--primary);
        border-color: var(--primary);
    }

    .form-check-label {
        margin-left: 0.5rem;
        color: #4a5568;
    }

    .btn {
        font-weight: 500;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .btn i {
        font-size: 1.1em;
    }

    .btn-primary {
        background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);
        border: none;
        padding: 0.75rem 2rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.875rem;
        box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(67, 97, 238, 0.4);
    }

    .btn-danger {
        background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);
        border: none;
        color: white;
        box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
    }

    .btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
        color: white;
    }

    .btn-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border: none;
        color: white;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }

    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        color: white;
    }

    .btn-outline-secondary {
        border: 1px solid #e2e8f0;
        color: #64748b;
    }

    .btn-outline-secondary:hover {
        background-color: #f8fafc;
        color: #334155;
    }

    .table {
        width: 100%;
        margin-bottom: 1.5rem;
        background-color: #fff;
        border-collapse: separate;
        border-spacing: 0;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .table th {
        background-color: #f8fafc;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #e2e8f0;
    }

    .table td {
        padding: 1rem 1.25rem;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        background-color: #fff;
    }

    .table tbody tr:last-child td {
        border-bottom: none;
    }

    .table tbody tr:hover td {
        background-color: #f8fafc;
    }

    /* Custom file input */
    .custom-file-upload {
        display: inline-block;
        padding: 0.75rem 1.5rem;
        cursor: pointer;
        background-color: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: 8px;
        color: #64748b;
        transition: var(--transition);
        text-align: center;
        width: 100%;
    }

    .custom-file-upload:hover {
        background-color: #f1f5f9;
        border-color: #94a3b8;
    }

    .custom-file-upload i {
        display: block;
        font-size: 1.75rem;
        margin-bottom: 0.5rem;
        color: #94a3b8;
    }

    .custom-file-upload span {
        font-size: 0.875rem;
    }

    /* Image preview */
    .image-preview {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        margin-right: 1rem;
        margin-bottom: 1rem;
        transition: var(--transition);
    }

    .image-preview:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .card {
            border-radius: 0;
        }
        
        .card-body {
            padding: 1rem;
        }
        
        .btn {
            width: 100%;
            margin-bottom: 0.5rem;
        }
        
        .table-responsive {
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }
    }

    /* Animation */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .fade-in {
        animation: fadeIn 0.3s ease-out forwards;
    }

    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    /* Finish cards */
    .finish-card {
        transition: var(--transition);
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        overflow: hidden;
        height: 100%;
        background: #fff;
    }

    .finish-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        border-color: var(--primary);
    }

    .finish-card .card-img-top {
        height: 120px;
        object-fit: cover;
        background: #f8fafc;
        padding: 1rem;
    }

    .finish-card .card-body {
        padding: 1rem;
        text-align: center;
    }

    .finish-card .form-check {
        margin: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .finish-card .form-check-input {
        margin-right: 0.5rem;
    }

    /* Loading state */
    .loading {
        position: relative;
        pointer-events: none;
        opacity: 0.8;
    }

    .loading:after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.7);
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
    }

    </style>
</head>
<body class="bg-light">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-12">
    <?php
require '../../inc/db.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$product) {
        echo "Product not found.";
        exit;
    }
} else {
    echo "Invalid request.";
    exit;
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = $_POST['product_name'];
    $description = $_POST['description'];

    // Handle pricing JSON update
    $pricing_data = [];
    foreach ($_POST['sizes'] as $key => $size) {
        $pricing_data[] = [
            'size' => $size,
            'sn_price' => $_POST['sn_price'][$key] ?? '',
            'bk_price' => $_POST['bk_price'][$key] ?? '',
            'an_price' => $_POST['an_price'][$key] ?? '',
            'gd_price' => $_POST['gd_price'][$key] ?? '',
            'rg_price' => $_POST['rg_price'][$key] ?? '',
            'ch_price' => $_POST['ch_price'][$key] ?? '',
            'gl_price' => $_POST['gl_price'][$key] ?? ''
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
        return null;
    }
    
    // Handle image uploads
    $target_dir = "../uploads/";
    
    // Update main image if provided
    if ($_FILES['product_image']['size'] > 0) {
        $main_image = uploadImage($_FILES["product_image"], $target_dir, 'main_');
        if ($main_image) {
            $stmt = $pdo->prepare("UPDATE products SET product_image = ? WHERE id = ?");
            $stmt->execute([$main_image, $_GET['id']]);
        }
    }
    
    // Update additional image 1 if provided
    if (!empty($_FILES['product_image2']['name'])) {
        $image2 = uploadImage($_FILES["product_image2"], $target_dir, 'img2_');
        if ($image2) {
            $stmt = $pdo->prepare("UPDATE products SET image2 = ? WHERE id = ?");
            $stmt->execute([$image2, $_GET['id']]);
        }
    }
    
    // Update additional image 2 if provided
    if (!empty($_FILES['product_image3']['name'])) {
        $image3 = uploadImage($_FILES["product_image3"], $target_dir, 'img3_');
        if ($image3) {
            $stmt = $pdo->prepare("UPDATE products SET image3 = ? WHERE id = ?");
            $stmt->execute([$image3, $_GET['id']]);
        }
    }
    
    // Update finish images if provided
    $finish_image_fields = [
        'sn_image' => 'SN',
        'bk_image' => 'BK',
        'an_image' => 'AN',
        'gd_image' => 'GD',
        'rg_image' => 'RG'
    ];
    
    foreach ($finish_image_fields as $field => $finish_code) {
        if (!empty($_FILES[$field]['name'])) {
            $finish_image = uploadImage($_FILES[$field], $target_dir, strtolower($finish_code) . '_finish_');
            if ($finish_image) {
                $stmt = $pdo->prepare("UPDATE products SET $field = ? WHERE id = ?");
                $stmt->execute([$finish_image, $_GET['id']]);
            }
        }
    }

    // Handle selected finishes
    $finish_ids = isset($_POST['finishes']) && is_array($_POST['finishes']) ? 
                 implode(',', array_map('intval', $_POST['finishes'])) : '';
    
    try {
        $stmt = $pdo->prepare("UPDATE products SET 
            product_name = ?, 
            description = ?, 
            pricing = ?, 
            finish_ids = ? 
            WHERE id = ?");
        $stmt->execute([
            $product_name, 
            $description, 
            $pricing_json, 
            $finish_ids,
            $_GET['id']
        ]);
        echo "Product updated successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<section class="section">
  <div class="card fade-in">
    <div class="card-header">
        <h5 class="card-title"><i class="bi bi-pencil-square"></i> Edit Product</h5>
    </div>
    <div class="card-body">
      <form method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
        <div class="row g-4">
          <div class="col-12">
            <div class="form-group">
              <label for="product_name" class="form-label">Product Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control form-control-lg" id="product_name" name="product_name" 
                     value="<?= htmlspecialchars($product['product_name']) ?>" required>
              <div class="invalid-feedback">
                Please provide a product name.
              </div>
            </div>
          </div>

          <!-- Finishes Section -->
          <div class="col-12">
            <div class="card mb-4">
              <div class="card-header bg-light">
                <h6 class="mb-0"><i class="bi bi-palette me-2"></i>Available Finishes</h6>
                <p class="text-muted small mb-0">Select the finishes available for this product</p>
              </div>
              <div class="card-body">
                <div class="row g-3">
                  <?php
                  // Fetch all finishes
                  $finishes = $pdo->query("SELECT * FROM finishes ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);
                  $selectedFinishes = !empty($product['finish_ids']) ? explode(',', $product['finish_ids']) : [];
                  
                  if (!empty($finishes)) {
                      foreach ($finishes as $finish) {
                          $finishId = $finish['id'];
                          $finishName = htmlspecialchars($finish['name']);
                          $finishImage = !empty($finish['image']) ? '../../' . $finish['image'] : 'assets/img/no-image.png';
                          $isChecked = in_array($finishId, $selectedFinishes) ? 'checked' : '';
                          ?>
                          <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="finish-card card h-100">
                              <div class="card-img-top d-flex align-items-center justify-content-center p-3">
                                <img src="<?= $finishImage ?>" alt="<?= $finishName ?>" class="img-fluid" style="max-height: 100px; width: auto; max-width: 100%;">
                              </div>
                              <div class="card-body text-center p-3">
                                <div class="form-check d-flex align-items-center justify-content-center">
                                  <input class="form-check-input me-2" type="checkbox" name="finishes[]" 
                                         value="<?= $finishId ?>" id="finish_<?= $finishId ?>" <?= $isChecked ?>>
                                  <label class="form-check-label fw-medium" for="finish_<?= $finishId ?>">
                                    <?= $finishName ?>
                                  </label>
                                </div>
                              </div>
                            </div>
                          </div>
                          <?php
                      }
                  } else {
                      echo '<div class="col-12 text-center py-4">
                              <div class="text-muted">
                                <i class="bi bi-palette display-6 d-block mb-2"></i>
                                <p class="mb-0">No finishes found. Please add finishes first.</p>
                                <a href="../finishes.php" class="btn btn-sm btn-outline-primary mt-3">
                                  <i class="bi bi-plus-lg me-1"></i> Add Finishes
                                </a>
                              </div>
                            </div>';
                  }
                  ?>
                </div>
              </div>
            </div>
          </div>

          <!-- Pricing Table -->
          <div class="col-12">
            <div class="card mb-4">
              <div class="card-header bg-light">
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    <h6 class="mb-0"><i class="bi bi-tags me-2"></i>Pricing</h6>
                    <p class="text-muted small mb-0">Add different sizes and their prices</p>
                  </div>
                  <button type="button" class="btn btn-sm btn-primary" id="addRow">
                    <i class="bi bi-plus-lg me-1"></i> Add Row
                  </button>
                </div>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-hover align-middle mb-0" id="priceTable">
                    <thead class="table-light">
                      <tr>
                        <th>Size <span class="text-danger">*</span></th>
                        <th>SN Price</th>
                        <th>BK Price</th>
                        <th>AN Price</th>
                        <th>GD Price</th>
                        <th>RG Price</th>
                        <th>CH Price</th>
                        <th>GL Price</th>
                        <th style="width: 50px;"></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $pricing = json_decode($product['pricing'] ?? '[]', true);
                      if (empty($pricing)) {
                          // Add one empty row by default
                          $pricing = [['size' => '', 'sn_price' => '', 'bk_price' => '', 'an_price' => '', 
                                    'gd_price' => '', 'rg_price' => '', 'ch_price' => '', 'gl_price' => '']];
                      }
                      
                      foreach ($pricing as $index => $price): 
                      ?>
                      <tr>
                        <td>
                          <input type="text" class="form-control form-control-sm" name="sizes[]" 
                                 value="<?= htmlspecialchars($price['size'] ?? '') ?>" required>
                        </td>
                        <td>
                          <div class="input-group input-group-sm">
                            <span class="input-group-text">₹</span>
                            <input type="number" class="form-control" name="sn_price[]" 
                                   value="<?= htmlspecialchars($price['sn_price'] ?? '') ?>" min="0" step="0.01">
                          </div>
                        </td>
                        <td>
                          <div class="input-group input-group-sm">
                            <span class="input-group-text">₹</span>
                            <input type="number" class="form-control" name="bk_price[]" 
                                   value="<?= htmlspecialchars($price['bk_price'] ?? '') ?>" min="0" step="0.01">
                          </div>
                        </td>
                        <td>
                          <div class="input-group input-group-sm">
                            <span class="input-group-text">₹</span>
                            <input type="number" class="form-control" name="an_price[]" 
                                   value="<?= htmlspecialchars($price['an_price'] ?? '') ?>" min="0" step="0.01">
                          </div>
                        </td>
                        <td>
                          <div class="input-group input-group-sm">
                            <span class="input-group-text">₹</span>
                            <input type="number" class="form-control" name="gd_price[]" 
                                   value="<?= htmlspecialchars($price['gd_price'] ?? '') ?>" min="0" step="0.01">
                          </div>
                        </td>
                        <td>
                          <div class="input-group input-group-sm">
                            <span class="input-group-text">₹</span>
                            <input type="number" class="form-control" name="rg_price[]" 
                                   value="<?= htmlspecialchars($price['rg_price'] ?? '') ?>" min="0" step="0.01">
                          </div>
                        </td>
                        <td>
                          <div class="input-group input-group-sm">
                            <span class="input-group-text">₹</span>
                            <input type="number" class="form-control" name="ch_price[]" 
                                   value="<?= htmlspecialchars($price['ch_price'] ?? '') ?>" min="0" step="0.01">
                          </div>
                        </td>
                        <td>
                          <div class="input-group input-group-sm">
                            <span class="input-group-text">₹</span>
                            <input type="number" class="form-control" name="gl_price[]" 
                                   value="<?= htmlspecialchars($price['gl_price'] ?? '') ?>" min="0" step="0.01">
                          </div>
                        </td>
                        <td class="text-center">
                          <button type="button" class="btn btn-sm btn-outline-danger removeRow" title="Remove row">
                            <i class="bi bi-trash"></i>
                          </button>
                        </td>
                      </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <!-- Product Description -->
          <div class="col-12">
            <div class="card mb-4">
              <div class="card-header bg-light">
                <h6 class="mb-0"><i class="bi bi-card-text me-2"></i>Product Description</h6>
              </div>
              <div class="card-body">
                <div class="form-group">
                  <textarea class="form-control" name="description" id="description" rows="6" 
                            placeholder="Enter detailed product description..."><?= htmlspecialchars($product['description']) ?></textarea>
                </div>
              </div>
            </div>
          </div>

          <!-- Product Images -->
          <div class="col-12">
            <div class="card mb-4">
              <div class="card-header bg-light">
                <h6 class="mb-0"><i class="bi bi-images me-2"></i>Product Images</h6>
                <p class="text-muted small mb-0">Upload product images (Max 5MB per image)</p>
              </div>
              <div class="card-body">
                <div class="row g-4">
                  <!-- Main Image -->
                  <div class="col-md-6">
                    <div class="border rounded-2 p-3 h-100">
                      <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0">Main Image <span class="text-danger">*</span></h6>
                        <span class="badge bg-primary">Required</span>
                      </div>
                      <div class="text-center mb-3">
                        <?php if (!empty($product['product_image'])): ?>
                          <img src="../../<?= ltrim($product['product_image'], '/') ?>" class="img-fluid rounded-2 mb-2" style="max-height: 150px;" id="mainImagePreview">
                        <?php else: ?>
                          <div class="bg-light rounded-2 d-flex align-items-center justify-content-center" style="height: 150px;">
                            <i class="bi bi-image text-muted" style="font-size: 3rem; opacity: 0.5;"></i>
                          </div>
                        <?php endif; ?>
                      </div>
                      <div class="custom-file-upload">
                        <input type="file" name="product_image" id="product_image" accept="image/*" class="d-none" onchange="previewImage(this, 'mainImagePreview')">
                        <label for="product_image" class="btn btn-outline-secondary w-100">
                          <i class="bi bi-cloud-arrow-up"></i>
                          <span>Choose Main Image</span>
                        </label>
                        <small class="text-muted d-block mt-1 text-center">Recommended: 800x800px, JPG/PNG</small>
                      </div>
                    </div>
                  </div>

                  <!-- Additional Images -->
                  <div class="col-md-6">
                    <div class="border rounded-2 p-3 h-100">
                      <h6 class="mb-3">Additional Images</h6>
                      
                      <!-- Image 2 -->
                      <div class="mb-3">
                        <label class="form-label small text-muted mb-1">Additional Image 1</label>
                        <div class="d-flex align-items-center gap-3">
                          <?php if (!empty($product['image2'])): ?>
                            <img src="../../<?= ltrim($product['image2'], '/') ?>" class="img-fluid rounded-2" style="width: 60px; height: 60px; object-fit: cover;" id="image2Preview">
                          <?php else: ?>
                            <div class="bg-light rounded-2 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                              <i class="bi bi-image text-muted"></i>
                            </div>
                          <?php endif; ?>
                          <div class="flex-grow-1">
                            <input type="file" name="product_image2" id="product_image2" accept="image/*" class="d-none" onchange="previewImage(this, 'image2Preview')">
                            <label for="product_image2" class="btn btn-sm btn-outline-secondary w-100">
                              <i class="bi bi-upload me-1"></i> Choose File
                            </label>
                          </div>
                        </div>
                      </div>

                      <!-- Image 3 -->
                      <div>
                        <label class="form-label small text-muted mb-1">Additional Image 2</label>
                        <div class="d-flex align-items-center gap-3">
                          <?php if (!empty($product['image3'])): ?>
                            <img src="../../<?= ltrim($product['image3'], '/') ?>" class="img-fluid rounded-2" style="width: 60px; height: 60px; object-fit: cover;" id="image3Preview">
                          <?php else: ?>
                            <div class="bg-light rounded-2 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                              <i class="bi bi-image text-muted"></i>
                            </div>
                          <?php endif; ?>
                          <div class="flex-grow-1">
                            <input type="file" name="product_image3" id="product_image3" accept="image/*" class="d-none" onchange="previewImage(this, 'image3Preview')">
                            <label for="product_image3" class="btn btn-sm btn-outline-secondary w-100">
                              <i class="bi bi-upload me-1"></i> Choose File
                            </label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

                  <!-- Finish Images -->
          <div class="col-12">
            <div class="card mb-4">
              <div class="card-header bg-light">
                <h6 class="mb-0"><i class="bi bi-palette me-2"></i>Finish Images</h6>
                <p class="text-muted small mb-0">Upload images for each finish type (Max 5MB per image)</p>
              </div>
              <div class="card-body">
                <div class="row g-4">
                  <?php 
                  $finish_images = [
                      'sn_image' => ['label' => 'Satin Nickel (SN)', 'current' => $product['sn_image'] ?? ''],
                      'bk_image' => ['label' => 'Black (BK)', 'current' => $product['bk_image'] ?? ''],
                      'an_image' => ['label' => 'Antique Nickel (AN)', 'current' => $product['an_image'] ?? ''],
                      'gd_image' => ['label' => 'Gold (GD)', 'current' => $product['gd_image'] ?? ''],
                      'rg_image' => ['label' => 'Rose Gold (RG)', 'current' => $product['rg_image'] ?? '']
                  ];
                  
                  foreach ($finish_images as $field => $finish): 
                      $preview_id = $field . 'Preview';
                  ?>
                  <div class="col-md-6 col-lg-4">
                    <div class="border rounded-2 p-3 h-100">
                      <label class="form-label small text-muted mb-1"><?= $finish['label'] ?></label>
                      <div class="d-flex align-items-center gap-3">
                        <?php if (!empty($finish['current'])): ?>
                          <img src="../../<?= ltrim($finish['current'], '/') ?>" class="img-fluid rounded-2" style="width: 60px; height: 60px; object-fit: cover;" id="<?= $preview_id ?>">
                        <?php else: ?>
                          <div class="bg-light rounded-2 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="bi bi-image text-muted"></i>
                          </div>
                        <?php endif; ?>
                        <div class="flex-grow-1">
                          <input type="file" name="<?= $field ?>" id="<?= $field ?>" accept="image/*" class="d-none" onchange="previewImage(this, '<?= $preview_id ?>')">
                          <label for="<?= $field ?>" class="btn btn-sm btn-outline-secondary w-100">
                            <i class="bi bi-upload me-1"></i> Upload
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          </div>

          <!-- Form Actions -->
          <div class="col-12">
            <div class="d-flex justify-content-between border-top pt-4">
              <a href="../products.php" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back to Products
              </a>
              <div class="d-flex gap-2">
                <a href="../products.php" class="btn btn-outline-danger">
                  <i class="bi bi-x-lg me-1"></i> Cancel
                </a>
                <button type="submit" class="btn btn-primary px-4">
                  <i class="bi bi-save me-1"></i> Update Product
                </button>
              </div>
            </div>
          </div>
        </div> <!-- End of row -->
      </form>
    </div>
</div>

<script>
// Image preview functionality
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    const file = input.files[0];
    const reader = new FileReader();
    
    reader.onload = function(e) {
        if (!preview) {
            // Create image preview if it doesn't exist
            const img = document.createElement('img');
            img.id = previewId;
            img.className = 'img-fluid rounded-2';
            img.style.maxHeight = '150px';
            input.parentNode.insertBefore(img, input);
            img.src = e.target.result;
        } else {
            // Update existing preview
            preview.src = e.target.result;
        }
        
        // Update the label text
        const label = input.nextElementSibling;
        if (label && label.tagName === 'LABEL') {
            const icon = label.querySelector('i');
            const text = label.querySelector('span');
            if (icon) icon.className = 'bi bi-arrow-repeat me-1';
            if (text) text.textContent = 'Change';
        }
    };
    
    if (file) {
        reader.readAsDataURL(file);
    }
}

// Add new pricing row
document.getElementById('addRow').addEventListener('click', function() {
    const tbody = document.querySelector('#priceTable tbody');
    const newRow = document.createElement('tr');
    
    newRow.innerHTML = `
        <td>
            <input type="text" class="form-control form-control-sm" name="sizes[]" required>
        </td>
        <td>
            <div class="input-group input-group-sm">
                <span class="input-group-text">₹</span>
                <input type="number" class="form-control" name="sn_price[]" min="0" step="0.01">
            </div>
        </td>
        <td>
            <div class="input-group input-group-sm">
                <span class="input-group-text">₹</span>
                <input type="number" class="form-control" name="bk_price[]" min="0" step="0.01">
            </div>
        </td>
        <td>
            <div class="input-group input-group-sm">
                <span class="input-group-text">₹</span>
                <input type="number" class="form-control" name="an_price[]" min="0" step="0.01">
            </div>
        </td>
        <td>
            <div class="input-group input-group-sm">
                <span class="input-group-text">₹</span>
                <input type="number" class="form-control" name="gd_price[]" min="0" step="0.01">
            </div>
        </td>
        <td>
            <div class="input-group input-group-sm">
                <span class="input-group-text">₹</span>
                <input type="number" class="form-control" name="rg_price[]" min="0" step="0.01">
            </div>
        </td>
        <td>
            <div class="input-group input-group-sm">
                <span class="input-group-text">₹</span>
                <input type="number" class="form-control" name="ch_price[]" min="0" step="0.01">
            </div>
        </td>
        <td>
            <div class="input-group input-group-sm">
                <span class="input-group-text">₹</span>
                <input type="number" class="form-control" name="gl_price[]" min="0" step="0.01">
            </div>
        </td>
        <td class="text-center">
            <button type="button" class="btn btn-sm btn-outline-danger removeRow" title="Remove row">
                <i class="bi bi-trash"></i>
            </button>
        </td>`;
    
    tbody.appendChild(newRow);
    
    // Add event listener to the new remove button
    newRow.querySelector('.removeRow').addEventListener('click', function() {
        removeRow(this);
    });
    
    // Scroll to the new row
    newRow.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
});

// Remove pricing row
function removeRow(button) {
    const row = button.closest('tr');
    const tbody = row.parentNode;
    
    // Don't remove the last row
    if (tbody.rows.length > 1) {
        row.remove();
    } else {
        // If it's the last row, just clear the inputs
        const inputs = row.querySelectorAll('input');
        inputs.forEach(input => {
            if (input.type === 'text') input.value = '';
            if (input.type === 'number') input.value = '';
        });
    }
}

// Initialize remove buttons
document.addEventListener('DOMContentLoaded', function() {
    // Add event listeners to existing remove buttons
    document.querySelectorAll('.removeRow').forEach(button => {
        button.addEventListener('click', function() {
            removeRow(this);
        });
    });
    
    // Form validation
    const forms = document.querySelectorAll('.needs-validation');
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
    
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>

<style>
/* Base Styles */
:root {
    --primary-color: #4e73df;
    --secondary-color: #858796;
    --success-color: #1cc88a;
    --light-color: #f8f9fc;
    --border-color: #e3e6f0;
    --text-color: #5a5c69;
    --card-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
}

/* Form Elements */
.form-control, .form-select {
    border: 1px solid var(--border-color);
    border-radius: 0.35rem;
    padding: 0.6rem 0.75rem;
    font-size: 0.85rem;
    color: var(--text-color);
}

.form-control:focus, .form-select:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
}

/* Card Styling */
.card {
    border: none;
    border-radius: 0.5rem;
    box-shadow: var(--card-shadow);
    margin-bottom: 1.5rem;
    overflow: hidden;
}

.card-header {
    background-color: #f8f9fc;
    border-bottom: 1px solid var(--border-color);
    padding: 1rem 1.5rem;
}

.card-header h6 {
    font-weight: 600;
    color: #4e73df;
    margin: 0;
    font-size: 1rem;
}

.card-body {
    padding: 1.5rem;
}

/* Finish Cards */
.finish-card {
    border: 1px solid var(--border-color);
    border-radius: 0.5rem;
    transition: all 0.3s ease;
    height: 100%;
    overflow: hidden;
}

.finish-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
}

.finish-card .card-img-top {
    height: 120px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #fff;
    padding: 1rem;
    border-bottom: 1px solid var(--border-color);
}

.finish-card .card-img-top img {
    max-height: 100%;
    max-width: 100%;
    object-fit: contain;
}

.finish-card .card-body {
    padding: 1rem;
    text-align: center;
}

/* Checkbox Styling */
.form-check-input {
    width: 1.25rem;
    height: 1.25rem;
    margin-top: 0;
    border: 1px solid #d1d3e2;
}

.form-check-input:checked {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}

/* Buttons */
.btn {
    padding: 0.5rem 1.1rem;
    font-size: 0.85rem;
    font-weight: 600;
    border-radius: 0.35rem;
    transition: all 0.2s;
}

.btn-primary {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}

.btn-primary:hover {
    background-color: #2e59d9;
    border-color: #2653d4;
}

.btn-outline-secondary {
    color: var(--secondary-color);
    border-color: var(--border-color);
}

.btn-outline-secondary:hover {
    background-color: #f8f9fc;
    border-color: #d1d3e2;
}

/* Table Styling */
.table {
    margin-bottom: 0;
}

.table thead th {
    background-color: #f8f9fc;
    color: #4e73df;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.7rem;
    letter-spacing: 0.5px;
    border-bottom: 1px solid var(--border-color);
    padding: 0.75rem 1rem;
}

.table td {
    padding: 1rem;
    vertical-align: middle;
    border-color: var(--border-color);
}

/* Image Upload */
.custom-file-upload {
    position: relative;
    display: block;
    cursor: pointer;
}

.custom-file-upload input[type="file"] {
    position: absolute;
    left: -9999px;
}

.custom-file-upload label {
    display: block;
    padding: 0.5rem 1rem;
    background: #f8f9fc;
    border: 1px dashed #d1d3e2;
    border-radius: 0.35rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s;
}

.custom-file-upload label:hover {
    background: #eaecf4;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .card-body {
        padding: 1.25rem;
    }
    
    .table-responsive {
        border: 1px solid var(--border-color);
        border-radius: 0.5rem;
        overflow-x: auto;
    }
    
    .btn {
        padding: 0.5rem 0.75rem;
    }
}

/* Form Validation */
.was-validated .form-control:invalid,
.form-control.is-invalid {
    border-color: #e74a3b;
    padding-right: calc(1.5em + 0.75rem);
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23e74a3b'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23e74a3b' stroke='none'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right calc(0.375em + 0.1875rem) center;
    background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
}

.invalid-feedback {
    font-size: 0.8rem;
    color: #e74a3b;
    margin-top: 0.25rem;
}

/* Custom Scrollbar */
::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb {
    background: #d1d3e2;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: #b7b9cc;
}
</style>

<?php include __DIR__ . '/../../inc/footer.php'; ?>

<script>
document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("category").addEventListener("change", function () {
        let category = this.value;
        fetch("fetch_subcategories.php?category=" + category)
            .then(response => response.json())
            .then(data => {
                let subCategorySelect = document.getElementById("sub_category");
                subCategorySelect.innerHTML = '<option value="">Select Subcategory</option>';
                data.forEach(sub => {
                    let option = document.createElement("option");
                    option.value = sub;
                    option.textContent = sub;
                    subCategorySelect.appendChild(option);
                });
            });
    });
});
</script>

</body>
</html>



