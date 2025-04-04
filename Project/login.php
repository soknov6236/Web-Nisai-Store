<?php
session_start();

// Redirect if already logged in
if (isset($_SESSION['USERID']) && isset($_SESSION['ROLE'])) {
    // Sanitize the role value
    $role = strtolower(trim($_SESSION['ROLE']));
    
    // Validate role before redirecting
    if (in_array($role, ['admin', 'employee'])) {
        // Determine base URL dynamically
        $base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
        $script_path = dirname($_SERVER['SCRIPT_NAME']);
        $redirect_path = ($role === 'admin') ? 'Admin/' : 'Employee/';
        
        // Build complete URL and ensure no relative path tricks
        $redirect_url = $base_url . rtrim($script_path, '/') . '/' . ltrim($redirect_path, '/');
        $redirect_url = filter_var($redirect_url, FILTER_SANITIZE_URL);
        
        // Perform the redirect
        header("Location: " . $redirect_url);
        exit();
    } else {
        // Invalid role - destroy session and redirect to login
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Login</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

</head>

<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="card mb-3">
                <div class="card-body">
                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                    <p id="loginError" class="text-center small text-danger mb-0 d-none"></p>
                  </div>

                  <form id="loginForm" class="row g-3">
                    <div class="col-12">
                      <label for="txtuser" class="form-label">Username</label>
                      <div class="input-group">
                        <span class="input-group-text" id="inputGroupPrepend"><i class="bi bi-person"></i></span>
                        <input type="text" name="txtuser" class="form-control" id="txtuser" required>
                        <div class="invalid-feedback">Please enter your username.</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="txtpass" class="form-label">Password</label>
                      <div class="input-group">
                        <span class="input-group-text" id="inputGroupPrepend"><i class="bi bi-lock"></i></span>
                        <input type="password" name="txtpass" class="form-control" id="txtpass" required>
                        <div class="invalid-feedback">Please enter your password!</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit" id="btnlogin">Login</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">Don't have account? <a href="pages-register.php">Create an account</a></p>
                    </div>
                  </form>

                </div>
              </div>

            </div>
          </div>
        </div>
      </section>

    </div>
  </main><!-- End #main -->

  <!-- Custom CSS for Background Image -->
  <style>
    body {
      background-image: url('assets/img/bg_clothing4.jpg');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      background-attachment: fixed;
    }

    .card {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 10px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    }

    .card-body {
      padding: 2rem;
    }

    .input-group-text {
      background-color: #f8f9fa;
    }
  </style>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Login Script -->
  <script>
    $(document).ready(function() {
        // Form submission
        $('#loginForm').submit(function(e) {
            e.preventDefault();
            
            // Reset error message
            $('#loginError').addClass('d-none').text('');
            
            // Get form values
            var username = $('#txtuser').val().trim();
            var password = $('#txtpass').val().trim();
            
            // Basic validation
            if (username === '' || password === '') {
                $('#loginError').text('Please fill in all fields').removeClass('d-none');
                return;
            }
            
            // Show loading state
            $('#btnlogin').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Logging in...').prop('disabled', true);
            
            // AJAX request
            $.ajax({
                url: 'checkuser.php',
                type: 'POST',
                data: {
                    txtuser: username,
                    txtpass: password
                },
                success: function(response) {
                    if(response === "0") {
                        // Login failed
                        $('#loginError').text('Invalid username or password').removeClass('d-none');
                        $('#btnlogin').html('Login').prop('disabled', false);
                    } else if(response === "admin") {
                        // Redirect to admin backend
                        window.location.href = 'Admin/';
                    } else if(response === "employee") {
                        // Redirect to employee dashboard
                        window.location.href = 'Employee/';
                    } else {
                        // Unexpected response
                        $('#loginError').text('An unexpected error occurred').removeClass('d-none');
                        $('#btnlogin').html('Login').prop('disabled', false);
                    }
                },
                error: function(xhr, status, error) {
                    $('#loginError').text('Server error: ' + error).removeClass('d-none');
                    $('#btnlogin').html('Login').prop('disabled', false);
                }
            });
        });
        
        // Clear error when typing
        $('#txtuser, #txtpass').on('input', function() {
            $('#loginError').addClass('d-none');
        });
    });
  </script>

</body>
</html>