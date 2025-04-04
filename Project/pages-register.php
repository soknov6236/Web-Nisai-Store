<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Register</title>
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
                    <h5 class="card-title text-center pb-0 fs-4">Create an Account</h5>
                    <p id="msgError" class="text-center small text-danger mb-0"></p>
                  </div>

                  <form id="registerForm" class="row g-3">
                    <div class="col-12">
                      <label for="txtuser" class="form-label">Username</label>
                      <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" name="txtuser" class="form-control" id="txtuser" required minlength="4" maxlength="20">
                        <div class="invalid-feedback">Please enter a username (4-20 characters).</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="txtemail" class="form-label">Email</label>
                      <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="txtemail" class="form-control" id="txtemail" required>
                        <div class="invalid-feedback">Please enter a valid email address.</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="txtpass" class="form-label">Password</label>
                      <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" name="txtpass" class="form-control" id="txtpass" required minlength="8">
                        <div class="invalid-feedback">Password must be at least 8 characters.</div>
                      </div>
                      <div class="form-text">Minimum 8 characters with at least one number</div>
                    </div>

                    <div class="col-12">
                      <label for="txtconfirmpass" class="form-label">Confirm Password</label>
                      <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" name="txtconfirmpass" class="form-control" id="txtconfirmpass" required>
                        <div class="invalid-feedback">Passwords must match.</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit" id="btnregister">
                        <span id="registerText">Register</span>
                        <span id="registerSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                      </button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">Already have an account? <a href="login.php">Login here</a></p>
                    </div>
                  </form>

                </div>
              </div>

            </div>
          </div>
        </div>
      </section>

    </div>
  </main>

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
      backdrop-filter: blur(5px);
    }

    .card-body {
      padding: 2rem;
    }

    .input-group-text {
      background-color: #f8f9fa;
    }

    #registerSpinner {
      margin-left: 8px;
    }
  </style>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <script>
    $(document).ready(function() {
        // Form submission handler
        $('#registerForm').submit(function(e) {
            e.preventDefault();
            
            // Reset error message
            $('#msgError').text('');
            
            // Get form values
            const user = $('#txtuser').val().trim();
            const email = $('#txtemail').val().trim();
            const pass = $('#txtpass').val();
            const confirmPass = $('#txtconfirmpass').val();
            
            // Validate inputs
            if (!user || !email || !pass || !confirmPass) {
                $('#msgError').text('All fields are required!');
                return;
            }
            
            if (user.length < 4 || user.length > 20) {
                $('#msgError').text('Username must be 4-20 characters');
                return;
            }
            
            if (!validateEmail(email)) {
                $('#msgError').text('Please enter a valid email address');
                return;
            }
            
            if (pass.length < 8) {
                $('#msgError').text('Password must be at least 8 characters');
                return;
            }
            
            if (!/\d/.test(pass)) {
                $('#msgError').text('Password must contain at least one number');
                return;
            }
            
            if (pass !== confirmPass) {
                $('#msgError').text('Passwords do not match!');
                return;
            }
            
            // Show loading state
            $('#btnregister').prop('disabled', true);
            $('#registerText').text('Registering...');
            $('#registerSpinner').removeClass('d-none');
            
            // Submit data
            $.ajax({
                url: 'register.php',
                type: 'POST',
                data: {
                    txtuser: user,
                    txtemail: email,
                    txtpass: pass
                },
                success: function(response) {
                    if (response === "1") {
                        // Registration successful
                        window.location.href = "login.php?registered=1";
                    } else {
                        // Registration failed
                        $('#msgError').text(response || 'Registration failed. Please try again.');
                        $('#btnregister').prop('disabled', false);
                        $('#registerText').text('Register');
                        $('#registerSpinner').addClass('d-none');
                    }
                },
                error: function(xhr) {
                    $('#msgError').text('Server error: ' + xhr.statusText);
                    $('#btnregister').prop('disabled', false);
                    $('#registerText').text('Register');
                    $('#registerSpinner').addClass('d-none');
                }
            });
        });
        
        // Email validation function
        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }
        
        // Clear error when typing
        $('input').on('input', function() {
            $('#msgError').text('');
        });
    });
  </script>

</body>
</html>