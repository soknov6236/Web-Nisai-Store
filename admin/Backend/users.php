<?php include('include/header.php') ?>
<?php include('include/sidebar.php'); ?>

<main id="main" class="main">
  

  <section>
    <div class="pagetitle">
      <h1>User page</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">User page</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
  </section>

  <section>
    <div class="container">
      <div align="right" style="margin: 10px;">
        <a href="#" class="btn btn-outline-primary" id="userAdd"><i class="bi bi-person-plus"></i></a>
      </div>
      <table class="table table-bordered" id="tbluser">
        <thead>
          <tr class="table-primary" align="center">
            <td>User ID</td>
            <td>Username</td>
            <td>Email</td>
            <td>Created User</td>
            <td>Status</td>
            <td width="200px">Action</td>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql = "SELECT * FROM users";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              echo "<tr>
                      <td>{$row['id']}</td>
                      <td>{$row['username']}</td>
                      <td>{$row['email']}</td>
                      <td>{$row['created_at']}</td>
                      <td>{$row['status']}</td>
                      <td>
                        <a href='#' class='edit btn btn-outline-info'><i class='bi bi-pencil-square'></i></a> | 
                        <a href='#' class='del btn btn-outline-danger'><i class='bi bi-trash'></i></a>
                      </td>
                    </tr>";
            }
          }
          ?>
        </tbody>
      </table>
    </div>
  </section>

  <!-- Add User Modal -->
  <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Add new user</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="row">
              <div class="col">
                Username:
                <input type="text" class="form-control" id="txtuser">
              </div>
            </div>
            <div class="row">
              <div class="col">
                Email:
                <input type="email" class="form-control" id="txtemail">
              </div>
            </div>
            <div class="row">
              <div class="col">
                Password:
                <input type="password" class="form-control" id="txtpass">
              </div>
            </div>
            <div class="row">
              <div class="col">
                Status:
                <input type="radio" name="rgstatus" class="stat" value="0" checked> Active
                <input type="radio" name="rgstatus" class="stat" value="1"> Inactive
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal"><i class="ri-close-fill"></i></button>
          <button type="button" class="btn btn-outline-primary" id="btnsave"><i class="ri-save-3-line"></i></button>
        </div>
      </div>
    </div>
  </div>

  <!-- Update User Modal -->
  <div class="modal fade" id="updateUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Edit User</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="row">
              <div class="col">
                User ID:
                <input type="text" class="form-control" id="txtuseridU" readonly>
              </div>
            </div>
            <div class="row">
              <div class="col">
                Username:
                <input type="text" class="form-control" id="txtuserU">
              </div>
            </div>
            <div class="row">
              <div class="col">
                Email:
                <input type="email" class="form-control" id="txtemailU">
              </div>
            </div>
            <div class="row">
              <div class="col">
                Status:
                <input type="radio" name="rgstatusU" value="0"> Active
                <input type="radio" name="rgstatusU" value="1"> Inactive
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal"><i class="ri-close-fill"></i></button>
          <button type="button" class="btn btn-outline-primary" id="btnsavechange"><i class="ri-save-3-line"></i></button>
        </div>
      </div>
    </div>
  </div>
  <!-- Alert Container -->
  <div id="alertContainer" class="position-fixed top-0 start-0 end-0 p-3" style="z-index: 1050;">
    <div id="alertMessage" class="alert alert-success alert-dismissible fade show d-none" role="alert">
      <span id="alertText"></span>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  </div>
</main><!-- End #main -->

<script>
$(function () {
  // Click on add user to show modal
  $("#userAdd").click(function () {
    $("#addUserModal").modal('show');
  });

  // Save 
  $("#btnsave").click(function () {
    var user = $("#txtuser").val();
    var email = $("#txtemail").val();
    var pass = $("#txtpass").val();
    var status = $('input[name="rgstatus"]:checked').val();

    if (user == "" || email == "" || pass == "") {
      showAlert("All fields are required!", "danger");
      return;
    }

    $.post("user/add_users.php", { user: user, email: email, pass: pass, status: status }, function (data) {
      if (data == "1") {
        showAlert("User added successfully!", "success");
        setTimeout(function () {
          window.location.href = "users.php";
        }, 1000); // Redirect after 1.5 seconds
      } else {
        showAlert("Error: " + data, "danger");
      }
    });
  });

  // Select data to show on Modal for updating ...
  $("#tbluser").on('click', '.edit', function () {
    var current_row = $(this).closest("tr");
    var id = current_row.find("td").eq(0).text();
    var user = current_row.find("td").eq(1).text();
    var email = current_row.find("td").eq(2).text();
    var status = current_row.find("td").eq(5).text();

    $("#txtuseridU").val(id);
    $("#txtuserU").val(user);
    $("#txtemailU").val(email);
    $("input[name=rgstatusU][value='" + status + "']").prop("checked", true);
    $("#updateUser").modal("show");
  });

  $("#btnsavechange").click(function () {
    var userid = $("#txtuseridU").val();
    var user = $("#txtuserU").val();
    var email = $("#txtemailU").val();
    var status = $('input[name="rgstatusU"]:checked').val();

    $.post("user/user_update.php", {
      userid: userid,
      user: user,
      email: email,
      status: status
    }, function (data) {
      if (data == "1") {
        showAlert("User updated successfully!", "success");
        setTimeout(function () {
          window.location.href = "users.php";
        }, 1000); // Redirect after 1.5 seconds
      } else {
        showAlert("Error: " + data, "danger");
      }
    });
  });

  // Delete 
  $("#tbluser").on("click", ".del", function () {
    var current_row = $(this).closest("tr");
    var id = current_row.find("td").eq(0).text();
    var conf = confirm("Do you want to delete?");
    if (conf == true) {
      $.post("user/user_delete.php", { userid: id }, function (data) {
        if (data == "1") {
          showAlert("User deleted successfully!", "success");
          setTimeout(function () {
            window.location.href = "users.php";
          }, 1000); // Redirect after 1.5 seconds
        }
      });
    }
  });

  // Function to show alert
  function showAlert(message, type) {
    // Set the alert message and type
    $("#alertText").text(message);
    $("#alertMessage").removeClass("  alert-primary alert-success alert-danger").addClass("alert-" + type);

    // Show the alert
    $("#alertMessage").removeClass("d-none").addClass("d-block");

    // Automatically hide the alert after 3 seconds
    setTimeout(function () {
      $("#alertMessage").addClass("d-none").removeClass("d-block");
    }, 3000);
  }
});
</script>

<!-- ======= Footer ======= -->
<?php include('include/footer.php') ?>