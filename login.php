<?php
include 'connect.php';
session_start();

if (isset($_POST['username']) && isset($_POST['password'])) {
  $username = $_POST['username'];
  $username = filter_var($username, FILTER_SANITIZE_STRING);
  $password = $_POST['password'];
  $password = filter_var($password, FILTER_SANITIZE_STRING);

  $select = $conn->prepare("SELECT * FROM `users` WHERE username = ? AND password = ?");
  $select->execute([$username, $password]);
  $row = $select->fetch(PDO::FETCH_ASSOC);

  if ($select->rowCount() > 0) {
    if ($row['role'] == 'admin') {
      $_SESSION['admin'] = $row['id'];
      $auditlogin = $conn->prepare("INSERT INTO `audit` (role, username, action) VALUES(?,?,?)");
      $auditlogin->execute(["admin", $row['username'], "login"]);

      echo "<script>
      document.addEventListener('DOMContentLoaded', (event) => {
      Swal.fire({
          icon: 'success',
          title: 'Success',
          text: 'Welcome!',
          showConfirmButton: false,
          timer: 1500
      }).then(function () {
          window.location.href = 'adboard.php';
      });
  });
</script>";
    } elseif ($row['role'] == 'user') {
      $_SESSION['user'] = $row['id'];
      $auditlogin = $conn->prepare("INSERT INTO `audit` (role, username, action) VALUES(?,?,?)");
      $auditlogin->execute(["user", $row['username'], "login"]);
      
      echo "<script>
      document.addEventListener('DOMContentLoaded', (event) => {
      Swal.fire({
          icon: 'success',
          title: 'Success',
          text: 'Welcome!',
          showConfirmButton: false,
          timer: 1500
      }).then(function () {
          window.location.href = 'udboard.php';
      });
  });
</script>";
    }
  } else {
    echo "<script>
    document.addEventListener('DOMContentLoaded', (event) => {
    Swal.fire({
        icon: 'error',
        title: 'Stop!',
        text: 'Unauthorized Login Attempt!',
        showConfirmButton: false,
        timer: 1500
    }).then(function () {
        window.location.href = 'login.php';
    });
});
</script>";
  }
}
?>


<!DOCTYPE html>

<html lang="en" class="dark-style layout-wide customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>Good Shepherd Parish Outreach Program Information Management System</title>

  <meta name="description" content="" />

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

  <!-- Icons -->
  <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />
  <link rel="stylesheet" href="../assets/vendor/fonts/fontawesome.css" />
  <link rel="stylesheet" href="../assets/vendor/fonts/flag-icons.css" />

  <!-- Core CSS -->
  <link rel="stylesheet" href="../assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
  <link rel="stylesheet" href="../assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="../assets/css/demo.css" />

  <!-- Vendors CSS -->
  <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
  <link rel="stylesheet" href="../assets/vendor/libs/typeahead-js/typeahead.css" />
  <link rel="stylesheet" href="../assets/vendor/libs/animate-css/animate.css" />
  <link rel="stylesheet" href="../assets/vendor/libs/sweetalert2/sweetalert2.css" />

  <!-- Vendor -->
  <link rel="stylesheet" href="../assets/vendor/libs/@form-validation/umd/styles/index.min.css" />

  <!-- Page CSS -->
  <!-- Page -->
  <link rel="stylesheet" href="../assets/vendor/css/pages/page-auth.css" />

  <!-- Helpers -->
  <script src="../assets/vendor/js/helpers.js"></script>
  <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
  <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
  <script src="../assets/vendor/js/template-customizer.js"></script>
  <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
  <script src="../assets/js/config.js"></script>
</head>

<body>
  <!-- Content -->

  <div class="authentication-wrapper authentication-cover">
    <div class="authentication-inner row m-0">
      <!-- /Left Text -->
      <div class="d-none d-lg-flex col-lg-7 col-xl-8 align-items-center p-5">
        <div class="w-100 d-flex justify-content-center">
          <img src="../assets/img/illustrations/good-shepherd.png" class="img-fluid" alt="Login image" width="850" />
        </div>
      </div>
      <!-- /Left Text -->

      <!-- Login -->
      <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg p-sm-5 p-4">
        <div class="w-px-410 mx-auto">
          <div class="card-body pb-0 px-0 px-md-4">
            <img src="../assets/img/illustrations/gsplogo.png" height="350" alt="View Badge User" data-app-dark-img="illustrations/gsplogo.png" data-app-light-img="illustrations/gsplogo.png" />
          </div>
          <br></br>
          <!-- Logo -->
          <div class="app-brand mb-5">
            <a href="login.php" class="app-brand-link gap-2">
              <span class="app-brand-text demo text-body fw-bold" style="text-transform: uppercase">The Good Shepherd Parish</span>
            </a>
          </div>
          <!-- /Logo -->
          <h4 class="mb-2">Information Management System</h4>
          <p class="mb-4">for Outreach Programs</p>

          <form id="formAuthentication" class="mb-3" action="" method="POST">
            <div class="mb-3">
              <label for="email" class="form-label">Username</label>
              <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" autofocus required autocomplete="off" />
            </div>
            <div class="mb-3 form-password-toggle">
              <div class="d-flex justify-content-between">
                <label class="form-label" for="password">Password</label>
              </div>
              <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" required />
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
              <a href="resetpassword.php">
                <small>Forgot Password?</small>
              </a>
            </div>
            <button class="btn btn-primary d-grid w-100">Sign in</button>
          </form>
        </div>
      </div>
      <!-- /Login -->
    </div>
  </div>

  <!-- / Content -->

  <!-- Core JS -->
  <!-- build:js assets/vendor/js/core.js -->

  <script src="../assets/vendor/libs/jquery/jquery.js"></script>
  <script src="../assets/vendor/libs/popper/popper.js"></script>
  <script src="../assets/vendor/js/bootstrap.js"></script>
  <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
  <script src="../assets/vendor/libs/hammer/hammer.js"></script>
  <script src="../assets/vendor/libs/i18n/i18n.js"></script>
  <script src="../assets/vendor/libs/typeahead-js/typeahead.js"></script>
  <script src="../assets/vendor/js/menu.js"></script>

  <!-- endbuild -->

  <!-- Vendors JS -->
  <script src="../assets/vendor/libs/@form-validation/umd/bundle/popular.min.js"></script>
  <script src="../assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js"></script>
  <script src="../assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js"></script>
  <script src="../assets/vendor/libs/sweetalert2/sweetalert2.js"></script>

  <!-- Main JS -->
  <script src="../assets/js/main.js"></script>

  <!-- Page JS -->
  <script src="../assets/js/pages-auth.js"></script>
  <script src="../assets/js/extended-ui-sweetalert2.js"></script>

</body>

</html>