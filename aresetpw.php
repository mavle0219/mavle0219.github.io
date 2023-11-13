<?php
// Include the database connection file
include 'connect.php';

session_start();

$admin = $_SESSION['admin'];

if (!isset($admin)) {
    header('location:login.php');
}

$select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
$select_profile->execute([$admin]);
$fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['req_id'])) {
    $req_id = $_GET['req_id'];

    try {
        // Update the request status to "Done" in your requests table
        $stmt = $conn->prepare("UPDATE reset SET req_reset = 'Done' WHERE req_id = :req_id");
        $stmt->bindParam(':req_id', $req_id);
        $stmt->execute();

        // Fetch the username from the request
        $stmt = $conn->prepare("SELECT req_username FROM reset WHERE req_id = :req_id");
        $stmt->bindParam(':req_id', $req_id);
        $stmt->execute();
        $row = $stmt->fetch();

        if ($row) {
            $username = $row['req_username'];

            // Update the user's password with the username
            $stmt = $conn->prepare("UPDATE users SET password = :username WHERE username = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            $auditlogin = $conn->prepare("INSERT INTO `audit`(role, username, action) VALUES(?,?,?)");
            $auditlogin->execute(["admin", $fetch_profile['username'], "set user password to default"]);

            echo "<script>
            document.addEventListener('DOMContentLoaded', (event) => {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Password Set to Default!',
                showConfirmButton: false,
                timer: 1500
            }).then(function () {
                window.location.href = 'respassreq.php';
            });
        });
      </script>";

        } else {
            echo "Request not found.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

$conn = null;
?>

<!DOCTYPE html>

<html lang="en" class="dark-style layout-wide customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>Reset Password</title>

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