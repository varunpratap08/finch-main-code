<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

require_once '../inc/db.php';

// Handle delete action
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    
    try {
        // First, get the image path to delete the file
        $stmt = $pdo->prepare("SELECT image FROM finishes WHERE id = ?");
        $stmt->execute([$id]);
        $finish = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($finish && !empty($finish['image']) && file_exists("../" . $finish['image'])) {
            unlink("../" . $finish['image']); // Delete the image file
        }
        
        // Then delete the record from the database
        $stmt = $pdo->prepare("DELETE FROM finishes WHERE id = ?");
        $stmt->execute([$id]);
        
        $_SESSION['success_message'] = "Finish deleted successfully!";
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Error deleting finish: " . $e->getMessage();
    }
    
    header('Location: finishes.php');
    exit();
}

// Fetch all finishes
$stmt = $pdo->query("SELECT * FROM finishes ORDER BY created_at DESC");
$finishes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Manage Finishes - Admin Dashboard</title>
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

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  
  <style>
    .finish-img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 6px;
        border: 1px solid #eee;
        transition: transform 0.3s ease;
    }
    .finish-img:hover {
        transform: scale(2);
        z-index: 10;
        position: relative;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
    .action-btns .btn {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin: 0 2px;
    }
  </style>
</head>

<body>
  <?php include 'inc/admin_header.php'; ?>

  <main id="main" class="main">
    <div class="pagetitle">
      <h1>Manage Finishes</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item active">Finishes</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Finishes Management</h5>
              <a href="#addFinishForm" class="btn btn-primary" data-bs-toggle="modal">
                <i class="bi bi-plus-circle me-2"></i>Add New Finish
              </a>
            </div>
            
            <?php if (isset($_SESSION['success_message'])): ?>
              <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                <?= $_SESSION['success_message'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              <?php unset($_SESSION['success_message']); ?>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['error_message'])): ?>
              <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                <?= $_SESSION['error_message'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              <?php unset($_SESSION['error_message']); ?>
            <?php endif; ?>

            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Image</th>
                      <th>Name</th>
                      <th>Created At</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (!empty($finishes)): ?>
                      <?php foreach ($finishes as $index => $finish): ?>
                        <tr>
                          <td><?= $index + 1 ?></td>
                          <td>
                            <?php if (!empty($finish['image'])): ?>
                              <img src="../<?= htmlspecialchars($finish['image']) ?>" alt="<?= htmlspecialchars($finish['name']) ?>" class="finish-img">
                            <?php else: ?>
                              <span class="text-muted">No image</span>
                            <?php endif; ?>
                          </td>
                          <td><?= htmlspecialchars($finish['name']) ?></td>
                          <td><?= date('M d, Y', strtotime($finish['created_at'])) ?></td>
                          <td class="action-btns">
                            <a href="#editFinishForm" class="btn btn-sm btn-warning" data-bs-toggle="modal" 
                               data-id="<?= $finish['id'] ?>" 
                               data-name="<?= htmlspecialchars($finish['name']) ?>"
                               data-image="<?= htmlspecialchars($finish['image']) ?>">
                              <i class="bi bi-pencil"></i>
                            </a>
                            <a href="#" class="btn btn-sm btn-danger" 
                               onclick="return confirm('Are you sure you want to delete this finish?')" 
                               data-bs-toggle="modal" 
                               data-bs-target="#deleteFinishModal"
                               data-id="<?= $finish['id'] ?>">
                              <i class="bi bi-trash"></i>
                            </a>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <tr>
                        <td colspan="5" class="text-center py-4">
                          <div class="empty-state">
                            <i class="bi bi-inbox" style="font-size: 3rem; color: #6c757d;"></i>
                            <h5>No Finishes Found</h5>
                            <p>You haven't added any finishes yet.</p>
                          </div>
                        </td>
                      </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <!-- Add Finish Modal -->
  <div class="modal fade" id="addFinishForm" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add New Finish</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="inc/add_finish.php" method="POST" enctype="multipart/form-data">
          <div class="modal-body">
            <div class="mb-3">
              <label for="name" class="form-label">Finish Name</label>
              <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
              <label for="image" class="form-label">Image</label>
              <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
              <small class="text-muted">Recommended size: 500x500px</small>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Add Finish</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Edit Finish Modal -->
  <div class="modal fade" id="editFinishForm" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Finish</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="inc/edit_finish.php" method="POST" enctype="multipart/form-data">
          <input type="hidden" id="edit_id" name="id">
          <div class="modal-body">
            <div class="mb-3">
              <label for="edit_name" class="form-label">Finish Name</label>
              <input type="text" class="form-control" id="edit_name" name="name" required>
            </div>
            <div class="mb-3">
              <label for="edit_image" class="form-label">Image</label>
              <input type="file" class="form-control" id="edit_image" name="image" accept="image/*">
              <small class="text-muted">Leave blank to keep current image</small>
              <div id="current-image-container" class="mt-2"></div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Save Changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Delete Confirmation Modal -->
  <div class="modal fade" id="deleteFinishModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirm Delete</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete this finish? This action cannot be undone.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <a href="#" id="confirmDeleteBtn" class="btn btn-danger">Delete</a>
        </div>
      </div>
    </div>
  </div>

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

  <script>
    // Handle edit button click
    document.addEventListener('DOMContentLoaded', function() {
      const editFinishForm = document.getElementById('editFinishForm');
      
      if (editFinishForm) {
        editFinishForm.addEventListener('show.bs.modal', function(event) {
          const button = event.relatedTarget;
          const id = button.getAttribute('data-id');
          const name = button.getAttribute('data-name');
          const image = button.getAttribute('data-image');
          
          const modal = this;
          modal.querySelector('#edit_id').value = id;
          modal.querySelector('#edit_name').value = name;
          
          const imageContainer = modal.querySelector('#current-image-container');
          if (image) {
            imageContainer.innerHTML = `
              <p class="mb-1">Current Image:</p>
              <img src="../${image}" alt="${name}" style="max-width: 100px; max-height: 100px; border-radius: 4px;">
            `;
          } else {
            imageContainer.innerHTML = '<p class="text-muted">No image uploaded</p>';
          }
        });
      }
      
      // Handle delete button click
      const deleteModal = document.getElementById('deleteFinishModal');
      if (deleteModal) {
        deleteModal.addEventListener('show.bs.modal', function(event) {
          const button = event.relatedTarget;
          const id = button.getAttribute('data-id');
          const confirmBtn = this.querySelector('#confirmDeleteBtn');
          confirmBtn.href = `finishes.php?action=delete&id=${id}`;
        });
      }
    });
  </script>
</body>
</html>
