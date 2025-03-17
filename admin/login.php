<?php
session_start();
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
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

</head>

<body >
  <script>
      $(function(){
          //alert("test");
          $("#btnlogin").click(function(){
              var user = $("#txtuser").val();
              var pass = $("#txtpass").val();
             // alert(user+" "+pass);
              if(user=="" || pass==""){
                //alert("Empty user or password");
                $("#msgError").html("Empty user or password!");
              }else{
                  //$("#msgError").html("");
                  $.post("checkuser.php",{txtuser:user,txtpass:pass},function(data){
                         // alert(data);
                         if(data==0){
                              $("#msgError").html("Invalid User or Password!");
                         }else{
                          window.location.href="Backend/index.php"
                         }
                  });
              }
          });
      });
    </script>
  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">


              <div class="card mb-3">

                <div class="card-body">
                
                  <div class="pt-4 pb-2">
                  <!-- <div class="d-flex justify-content-center">
                  <img style="width: 150px;" src="assets/img/logo_report1.png" alt="">
                </div>End Logo  -->
                    <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                    <p id="msgError" class="text-center small" style="color:red">
                      
                    </p>
                  </div>

                  <form class="row g-3 needs-validation" novalidate>

                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Username</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend"><i class="bi bi-person"></i></span>
                        <input type="text" name="txtuser" class="form-control" id="txtuser" required>
                        <div class="invalid-feedback">Please enter your username.</div>
                      </div>
                    </div>

                    <div class="col-12">
                      
                      <label for="yourPassword" class="form-label">Password</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend"><i class="bi bi-lock"></i></span> 
                      <input type="password" name="txtpass" class="form-control" id="txtpass" required>
                      <div class="invalid-feedback">Please enter your password!</div>
                    </div>
                    </div>

                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="button" id="btnlogin">Login</button>
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

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
   <!-- Custom CSS for Background Image -->
   <style>
    body {
      background-image: url('assets/img/bg_clothing4.jpg'); /* Path to your background image */
      background-size: cover; /* Cover the entire page */
      background-position: center; /* Center the image */
      background-repeat: no-repeat; /* Do not repeat the image */
      background-attachment: fixed; /* Fix the background while scrolling */
    }

    .card {
      background: rgba(255, 255, 255, 0.9); /* Semi-transparent white background for the card */
      border-radius: 10px; /* Rounded corners for the card */
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Add a shadow to the card */
    }

    .card-body {
      padding: 2rem; /* Add padding inside the card */
    }
  </style>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>