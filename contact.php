<?php
// Start output buffering at the very beginning
ob_start();

// Set default response
$response = [
    'status' => 'error',
    'message' => 'An unknown error occurred.'
];

// Process form if it's a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Get and sanitize input
        $name = isset($_POST['name']) ? trim($_POST['name']) : '';
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
        $message = isset($_POST['message']) ? trim($_POST['message']) : '';

        // Validate input fields
        if (empty($name) || empty($email) || empty($subject) || empty($message)) {
            throw new Exception('All fields are required!');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Invalid email format!');
        }

        // Include database connection
        require_once 'inc/db.php';

        // Prepare and execute the query
        $stmt = $pdo->prepare("
            INSERT INTO contact_messages (name, email, subject, message, created_at) 
            VALUES (:name, :email, :subject, :message, NOW())
        ");
        
        $result = $stmt->execute([
            ':name' => htmlspecialchars($name, ENT_QUOTES, 'UTF-8'),
            ':email' => filter_var($email, FILTER_SANITIZE_EMAIL),
            ':subject' => htmlspecialchars($subject, ENT_QUOTES, 'UTF-8'),
            ':message' => htmlspecialchars($message, ENT_QUOTES, 'UTF-8')
        ]);

        if ($result) {
            $response = [
                'status' => 'success',
                'message' => 'Your message has been sent. Thank you!'
            ];
        } else {
            throw new Exception('Failed to save your message. Please try again.');
        }
    } catch (PDOException $e) {
        error_log('Database Error: ' . $e->getMessage());
        $response['message'] = 'A database error occurred. Please try again later.';
    } catch (Exception $e) {
        $response['message'] = $e->getMessage();
    }
    
    // If it's an AJAX request, return JSON and exit
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        // Clear any previous output
        while (ob_get_level()) {
            ob_end_clean();
        }
        
        // Set JSON header and output response
        header('Content-Type: application/json');
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        
        echo json_encode($response);
        exit;
    }
}

// If we get here, it's a normal page load or a non-AJAX form submission
// Clear the output buffer
ob_end_clean();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Contact Us - Finch Lock</title>
  <meta name="description" content="Contact Finch Lock for inquiries and support">
  <meta name="keywords" content="contact, inquiry, support, finch lock">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

  <style>
      .alert {
        padding: 15px;
        border-radius: 8px;
        font-size: 16px;
        text-align: center;
        max-width: 500px;
        margin: 10px auto;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    #formResponse {
        display: none;
        margin: 15px 0;
    }
  </style>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
  $(document).ready(function() {
      const $form = $('#contactForm');
      const $submitBtn = $('#submitBtn');
      const $formResponse = $('#formResponse');
      
      // Function to show message
      function showMessage(message, type = 'error') {
          $formResponse.html('<div class="alert alert-' + type + '">' + message + '</div>');
          $formResponse.show().delay(5000).fadeOut();
      }
      
      // Form submission handler
      $form.on('submit', function(e) {
          e.preventDefault();
          
          // Reset previous messages
          $formResponse.html('').removeClass('alert-success alert-danger');
          
          // Disable submit button and show loading state
          const originalText = $submitBtn.html();
          $submitBtn.prop('disabled', true).html(
              '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Sending...'
          );
          
          // Submit form via AJAX
          $.ajax({
              type: 'POST',
              url: window.location.href, // Use current URL
              data: $form.serialize(),
              dataType: 'json',
              success: function(response) {
                  if (response && response.status) {
                      if (response.status === 'success') {
                          showMessage(response.message, 'success');
                          $form[0].reset();
                      } else {
                          showMessage(response.message || 'An error occurred. Please try again.');
                      }
                  } else {
                      showMessage('Invalid response from server. Please try again.');
                  }
              },
              error: function(xhr, status, error) {
                  let errorMsg = 'An error occurred while processing your request. ';
                  
                  // Try to parse the response if it's JSON
                  try {
                      const response = JSON.parse(xhr.responseText);
                      if (response && response.message) {
                          errorMsg = response.message;
                      }
                  } catch (e) {
                      // If not JSON, use default error message
                      console.error('AJAX Error:', status, error, xhr.responseText);
                  }
                  
                  showMessage(errorMsg);
              },
              complete: function() {
                  $submitBtn.prop('disabled', false).html(originalText);
              }
          });
      });
  });
  </script>
</head>

<body class="index-page">
  <?php include ('inc/header.php'); ?>
  <main class="main">


<section class="contact-section">
  <div class="contact-container">
    <div class="contact-image">
      <img src="assets/img/cont.png" alt="Lock Products">
    </div>
    <div class="contact-form-box">
      <h2>Get In Touch With Us</h2>
      <p>We’re here to assist with your needs. Contact us for inquiries, support, or product-related questions, and we’ll respond promptly.</p>
      
      <form method="POST" action="" id="contactForm">
        <input type="text" name="name" placeholder="Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="subject" placeholder="Subject" required>
        <textarea name="message" placeholder="Message" rows="4" required></textarea>
        <button type="submit" id="submitBtn">Submit</button>
      </form>
      <div id="formResponse"></div>
    </div>
  </div>
</section>


<style>
  .contact-section {
  padding: 60px 20px;
  background-color: #fff;
  font-family: 'Segoe UI', sans-serif;
}

.contact-container {
  display: flex;
  max-width: 1200px;
  margin: 0 auto;
  box-shadow: 0 0 10px rgba(0,0,0,0.05);
  border-radius: 4px;
  overflow: hidden;
  flex-wrap: wrap;
}

.contact-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}

.contact-image {
  flex: 1 1 50%;
  min-width: 300px;
}

.contact-form-box {
  flex: 1 1 50%;
  padding: 40px;
  border: 1px solid #f2e6c3;
  background: #fff;
  min-width: 300px;
}

.contact-form-box h2 {
  font-size: 24px;
  font-weight: 600;
  margin-bottom: 10px;
}

.contact-form-box p {
  font-size: 14px;
  color: #555;
  margin-bottom: 30px;
}

.contact-form-box form input,
.contact-form-box form textarea {
  width: 100%;
  padding: 12px 15px;
  margin-bottom: 15px;
  border: none;
  border-bottom: 1px solid #ccc;
  font-size: 14px;
  background-color: transparent;
  outline: none;
  transition: border-color 0.3s ease;
}

.contact-form-box form input:focus,
.contact-form-box form textarea:focus {
  border-color: #000;
}

.contact-form-box form button {
  background-color: transparent;
  border: 1px solid #e0b300;
  color: #000;
  padding: 10px 30px;
  font-size: 14px;
  cursor: pointer;
  transition: all 0.3s ease;
}

.contact-form-box form button:hover {
  background-color: #e0b300;
  color: #fff;
}

</style>

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

</body>

</html>