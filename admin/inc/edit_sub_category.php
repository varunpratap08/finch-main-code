<?php
require '../../inc/db.php'; // Database connection

// Fetch categories for dropdown
$stmt = $pdo->prepare("SELECT * FROM category ORDER BY category_name ASC");
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch subcategory data based on ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM subcategory WHERE id = ?");
    $stmt->execute([$id]);
    $subcategory = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$subcategory) {
        die("Subcategory not found!");
    }
} else {
    die("Invalid request!");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = trim($_POST['name']);
    $category_id = $_POST['category_id']; // Selected category

    if (!empty($name) && !empty($category_id)) {
        // Update subcategory details
        $stmt = $pdo->prepare("UPDATE subcategory SET subcategory_name = :name, category_id = :category_id WHERE id = :id");
        $stmt->execute([
            ':name' => $name,
            ':category_id' => $category_id,
            ':id' => $id
        ]);

        header("Location: ../sub-category.php?message=Subcategory updated successfully!");
        exit();
    } else {
        $error = "Subcategory name and category must be selected!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Subcategory - Admin Panel</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            color: #333;
            line-height: 1.6;
            padding: 20px 0;
        }

        .form-container {
            max-width: 800px;
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
            border-bottom: 1px solid #e9ecef;
        }

        .form-header h1 {
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.5rem;
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

        .error-message {
            color: var(--danger);
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .form-container {
                padding: 1.5rem;
                margin: 1rem;
                border-radius: 8px;
            }
            
            .form-section {
                padding: 1.5rem;
            }
            
            .d-flex {
                flex-direction: column;
                gap: 0.75rem !important;
            }
            
            .d-flex.justify-content-between {
                flex-direction: column-reverse;
                align-items: stretch;
            }
            
            .d-flex.gap-3 {
                width: 100%;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <header class="form-header">
            <div>
                <h1><i class="bi bi-tags-fill me-2"></i>Edit Subcategory</h1>
                <p class="text-muted">Update the subcategory details below</p>
            </div>
            <div class="d-flex gap-2 mt-3">
                <a href="../sub-category.php" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Back to Subcategories
                </a>
                <a href="../dashboard.php" class="btn btn-primary">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </div>
        </header>

        <?php if (isset($error)) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <?php echo htmlspecialchars($error); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form action="" method="POST" class="needs-validation" novalidate>
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($subcategory['id']); ?>">
            
            <div class="form-section">
                <h5><i class="bi bi-info-circle me-2"></i>Subcategory Information</h5>
                
                <div class="row g-4">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name" class="form-label">Subcategory Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="<?php echo htmlspecialchars($subcategory['subcategory_name']); ?>" required>
                            <div class="invalid-feedback">
                                Please provide a subcategory name.
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="category" class="form-label">Parent Category <span class="text-danger">*</span></label>
                            <select class="form-select" id="category" name="category_id" required>
                                <option value="">Select a category...</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo $category['id']; ?>" 
                                        <?php echo ($subcategory['category_id'] == $category['id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($category['category_name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">
                                Please select a parent category.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-5 pt-4 border-top">
                <button type="reset" class="btn btn-light">
                    <i class="bi bi-arrow-counterclockwise"></i> Reset Form
                </button>
                <div class="d-flex gap-3">
                    <a href="../sub-category.php" class="btn btn-outline-secondary">
                        <i class="bi bi-x-lg"></i> Cancel
                    </a>
                    <button type="submit" name="update" class="btn btn-primary px-4">
                        <i class="bi bi-save"></i> Update Subcategory
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
    </script>
</body>
</html>
