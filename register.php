<?php
include 'connect.php';

session_start();

$admin = $_SESSION['admin'];

if (!isset($admin)) {
    header('location:login.php');
}
// Retrieve form data

$select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
$select_profile->execute([$admin]);
$fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {

    $username = $_POST["multiStepsUsername"];
    $fullName = $_POST["multiStepsFullName"];
    $password = $_POST["multiStepsPass"];
    $position = $_POST["multiStepsPosition"];
    $role = $_POST["multiStepsRole"];
    $phone = $_POST["multiStepsPhone"];
    $address = $_POST["multiStepsAddress"];
    $email = $_POST["multiStepsEmail"];

    // Check if the username is already in use
    $checkUsernameQuery = $conn->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
    $checkUsernameQuery->execute([$username]);
    $usernameExists = $checkUsernameQuery->fetchColumn();

    if ($usernameExists) {
        echo "Username is already in use. Please choose a different username.";
    } else {
        // Insert the data into the database
        $insertQuery = $conn->prepare("INSERT INTO users (username, fullname, password, position, role, phone, address, email) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $values = array($username, $fullName, $password, $position, $role, $phone, $address, $email);
        $insertQuery->execute($values);

        $auditlogin = $conn->prepare("INSERT INTO `audit`(role, username, action) VALUES(?,?,?)");
        $auditlogin->execute(["admin", $fetch_profile['username'], "register new user"]);

        echo "<script>
        document.addEventListener('DOMContentLoaded', (event) => {
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: 'New User Added!',
            showConfirmButton: false,
            timer: 1500
        }).then(function () {
            window.location.href = 'auserlist.php';
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

    <title>Register New User</title>

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
    <link rel="stylesheet" href="../assets/vendor/libs/animate-css/animate.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/sweetalert2/sweetalert2.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/typeahead-js/typeahead.css" />
    <!-- Vendor -->
    <link rel="stylesheet" href="../assets/vendor/libs/bs-stepper/bs-stepper.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/bootstrap-select/bootstrap-select.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/select2/select2.css" />
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
            <!-- Left Text -->
            <div class="d-none d-lg-flex col-lg-4 align-items-center justify-content-end p-5 pe-0">
                <div class="w-px-600">
                    <img src="../assets/img/illustrations/gsplogo.png" class="img-fluid" alt="multi-steps" width="600" data-app-dark-img="illustrations/gsplogo.png" data-app-light-img="illustrations/gsplogo.png" />
                </div>
            </div>
            <!-- /Left Text -->

            <!--  Multi Steps Registration -->
            <div class="d-flex col-lg-8 align-items-center justify-content-center authentication-bg p-sm-5 p-3">
                <div class="w-px-700">
                    <div id="multiStepsValidation" class="bs-stepper shadow-none">
                        <div class="bs-stepper-header border-bottom-0">
                            <div class="step" data-target="#accountDetailsValidation">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-circle"><i class='bx bxs-user-plus'></i></span>
                                    <span class="bs-stepper-label mt-1">
                                        <span class="bs-stepper-title">New Account</span>
                                    </span>
                                </button>
                            </div>
                        </div>
                        <div class="bs-stepper-content">
                            <form id="multiStepsForm" action="" method="POST">
                                <!-- Account Details -->
                                <div id="accountDetailsValidation" class="content">
                                    <div class="content-header mb-3">
                                        <h3 class="mb-1">Register</h3>
                                        <span>Enter Your Account Details</span>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-sm-6">
                                            <label class="form-label" for="multiStepsUsername">Username</label>
                                            <input type="text" name="multiStepsUsername" id="multiStepsUsername" class="form-control" placeholder="enter username" autocomplete="off" />
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label" for="multiStepsFullName">Full Name</label>
                                            <input type="text" name="multiStepsFullName" id="multiStepsFullName" class="form-control" placeholder="enter full name" aria-label="" autocomplete="off" />
                                        </div>
                                        <div class="col-sm-6 form-password-toggle">
                                            <label class="form-label" for="multiStepsPass">Password</label>
                                            <div class="input-group input-group-merge">
                                                <input type="password" id="multiStepsPass" name="multiStepsPass" class="form-control" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="multiStepsPass2" />
                                                <span class="input-group-text cursor-pointer" id="multiStepsPass2"><i class="bx bx-hide"></i></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 form-password-toggle">
                                            <label class="form-label" for="multiStepsConfirmPass">Confirm Password</label>
                                            <div class="input-group input-group-merge">
                                                <input type="password" id="multiStepsConfirmPass" name="multiStepsConfirmPass" class="form-control" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="multiStepsConfirmPass2" />
                                                <span class="input-group-text cursor-pointer" id="multiStepsConfirmPass2"><i class="bx bx-hide"></i></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label" for="multiStepsPosition">Position</label>
                                            <input type="text" name="multiStepsPosition" id="multiStepsPosition" class="form-control" placeholder="enter position" autocomplete="off" />
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label" for="multiStepsRole">Role</label>
                                            <input type="text" name="multiStepsRole" id="multiStepsRole" class="form-control" placeholder="admin/user" aria-label="" />
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label" for="multiStepsPhone">Phone</label>
                                            <input type="text" name="multiStepsPhone" id="multiStepsPhone" class="form-control" placeholder="09#########" autocomplete="off" />
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label" for="multiStepsAddress">Address</label>
                                            <input type="text" name="multiStepsAddress" id="multiStepsAddress" class="form-control" placeholder="enter address" aria-label="" autocomplete="off" />
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label" for="multiStepsEmail">Email</label>
                                            <input type="email" name="multiStepsEmail" id="multiStepsEmail" class="form-control" placeholder="enter email@email.com" autocomplete="off" />
                                        </div>
                                        <div class="col-12 d-flex justify-content-between">
                                            <button type="submit" class="btn btn-primary d-grid w-100" name="register">Register</button>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <p class="text-center">
                            <span>Back to <a href="auserlist.php"><span>Users List</span></a></span>
                        </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- / Multi Steps Registration -->
    </div>
    </div>

    <script>
        // Check selected custom option
        window.Helpers.CustomOptionCheck();
    </script>

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
    <script src="../assets/vendor/libs/cleavejs/cleave.js"></script>
    <script src="../assets/vendor/libs/cleavejs/cleave-phone.js"></script>
    <script src="../assets/vendor/libs/bs-stepper/bs-stepper.js"></script>
    <script src="../assets/vendor/libs/select2/select2.js"></script>
    <script src="../assets/vendor/libs/@form-validation/umd/bundle/popular.min.js"></script>
    <script src="../assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js"></script>
    <script src="../assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js"></script>
    <script src="../assets/vendor/libs/sweetalert2/sweetalert2.js"></script>

    <!-- Main JS -->
    <script src="../assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="../assets/js/pages-auth-multisteps.js"></script>
    <script src="../assets/js/extended-ui-sweetalert2.js"></script>

</body>

</html>