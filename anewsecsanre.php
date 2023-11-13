<?php
include 'connect.php';

session_start();

$admin = $_SESSION['admin'];

if (!isset($admin)) {
    header('location:login.php');
}

?>

<!DOCTYPE html>

<html lang="en" class="dark-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Secret Santa Add Recipients</title>

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
    <link rel="stylesheet" href="../assets/vendor/libs/apex-charts/apex-charts.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/flatpickr/flatpickr.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/jquery-timepicker/jquery-timepicker.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/pickr/pickr-themes.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/animate-css/animate.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/sweetalert2/sweetalert2.css" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="../assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/@form-validation/umd/styles/index.min.css" />
    <!-- Helpers -->
    <script src="../assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="../assets/vendor/js/template-customizer.js"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../assets/js/config.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>

<body>
    <?php

    if (isset($_GET['ss_id'])) {
        $ss_id = $_GET['ss_id'];

        // Retrieve user data from the database
        $select_ss = $conn->prepare("SELECT * FROM `secsan` WHERE ss_id = :ss_id");
        $select_ss->bindParam(':ss_id', $ss_id);
        if ($select_ss->execute()) {
            $ss = $select_ss->fetch(PDO::FETCH_ASSOC);
            if ($ss) {
                // User data found, proceed with displaying the edit form
    ?>
                <!-- Layout wrapper -->
                <div class="layout-wrapper layout-content-navbar">
                    <div class="layout-container">
                        <!-- Menu -->

                        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                            <div class="app-brand demo">
                                <a href="adboard.php" class="app-brand-link">
                                    <span class="app-brand-logo demo">
                                        <span class="app-brand-text demo menu-text fw-bold ms-2" style="text-transform: uppercase;">GSP MIS</span>
                                </a>

                                <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                                    <i class="bx bx-chevron-left bx-sm align-middle"></i>
                                </a>
                            </div>

                            <div class="menu-inner-shadow"></div>

                            <ul class="menu-inner py-1">
                                <!-- Dashboards -->
                                <li class="menu-item">
                                    <a href="adboard.php" class="menu-link">
                                        <i class="menu-icon tf-icons bx bxs-dashboard"></i>
                                        <div class="text-truncate" data-i18n="Dashboard">Dashboard</div>
                                    </a>
                                </li>
                                <li class="menu-header small text-uppercase">
                                    <span class="menu-header-text">Beneficiaries Management</span>
                                </li>
                                <li class="menu-item">
                                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                                        <i class="menu-icon tf-icons bx bx bx-list-check"></i>
                                        <div class="text-truncate" data-i18n="Beneficiaries">Beneficiaries</div>
                                    </a>
                                    <ul class="menu-sub">
                                        <li class="menu-item">
                                            <a href="javascript:void(0);" class="menu-link menu-toggle">
                                                <div class="text-truncate" data-i18n="Beneficiaries">Beneficiaries</div>
                                            </a>
                                            <ul class="menu-sub">
                                                <li class="menu-item">
                                                    <a href="abenlist.php" class="menu-link">
                                                        <div class="text-truncate" data-i18n="Beneficiaries List">Beneficiaries List</div>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="menu-item">
                                            <a href="javascript:void(0);" class="menu-link menu-toggle">
                                                <div class="text-truncate" data-i18n="Scholars">Scholars</div>
                                            </a>
                                            <ul class="menu-sub">
                                                <li class="menu-item">
                                                    <a href="ascholist.php" class="menu-link">
                                                        <div class="text-truncate" data-i18n="Scholars List">Scholars List</div>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="menu-item">
                                            <a href="javascript:void(0);" class="menu-link menu-toggle">
                                                <div class="text-truncate" data-i18n="Medical Assistance">Medical Assistance</div>
                                            </a>
                                            <ul class="menu-sub">
                                                <li class="menu-item">
                                                    <a href="amedass.php" class="menu-link">
                                                        <div class="text-truncate" data-i18n="Medical Assistance Recipients">Medical Assistance Recipients</div>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li class="menu-header small text-uppercase"><span class="menu-header-text">Program Management</span></li>
                                <li class="menu-item">
                                    <a href="acal.php" class="menu-link">
                                        <i class="menu-icon tf-icons bx bx bxs-calendar"></i>
                                        <div class="text-truncate" data-i18n="Calendar">Calendar</div>
                                    </a>
                                </li>
                                <li class="menu-item active open">
                                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                                        <i class="menu-icon tf-icons bx bxs-donate-heart"></i>
                                        <div class="text-truncate" data-i18n="Programs">Programs</div>
                                    </a>
                                    <ul class="menu-sub">
                                        <li class="menu-item">
                                            <a href="javascript:void(0);" class="menu-link menu-toggle">
                                                <div class="text-truncate" data-i18n="Scholars">Scholars</div>
                                            </a>
                                            <ul class="menu-sub">
                                                <li class="menu-item">
                                                    <a href="aschore.php" class="menu-link">
                                                        <div class="text-truncate" data-i18n="Scholarship Claim">Scholarship Claim</div>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="menu-item">
                                            <a href="javascript:void(0);" class="menu-link menu-toggle">
                                                <div class="text-truncate" data-i18n="Medical Programs">Medical Programs</div>
                                            </a>
                                            <ul class="menu-sub">
                                                <li class="menu-item">
                                                    <a href="amedmissre.php" class="menu-link">
                                                        <div class="text-truncate" data-i18n="Medical Mission">Medical Mission</div>
                                                    </a>
                                                </li>
                                                <li class="menu-item">
                                                    <a href="amedassre.php" class="menu-link">
                                                        <div class="text-truncate" data-i18n="Medical Assistance">Medical Assistance</div>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="menu-item open">
                                            <a href="javascript:void(0);" class="menu-link menu-toggle">
                                                <div class="text-truncate" data-i18n="Secret Santa">Secret Santa</div>
                                            </a>
                                            <ul class="menu-sub">
                                                <li class="menu-item">
                                                    <a href="asecsandon.php" class="menu-link">
                                                        <div class="text-truncate" data-i18n="Donors">Donors</div>
                                                    </a>
                                                </li>
                                                <li class="menu-item">
                                                    <a href="asecsanre.php" class="menu-link">
                                                        <div class="text-truncate" data-i18n="Events">Events</div>
                                                    </a>
                                                </li>
                                                <li class="menu-item active">
                                                    <a href="" class="menu-link">
                                                        <div class="text-truncate" data-i18n="Add Recipients">Add Recipients</div>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li class="menu-header small text-uppercase"><span class="menu-header-text">Users Management</span></li>
                                <li class="menu-item">
                                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                                        <i class="menu-icon tf-icons bx bxs-user-rectangle"></i>
                                        <div class="text-truncate" data-i18n="Users">Users</div>
                                    </a>
                                    <ul class="menu-sub">
                                        <li class="menu-item">
                                            <a href="auserlist.php" class="menu-link">
                                                <div class="text-truncate" data-i18n="Users">Users</div>
                                            </a>
                                        </li>
                                        <li class="menu-item">
                                            <a href="register.php" class="menu-link">
                                                <div class="text-truncate" data-i18n="Register">Register</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            <div class="card-body pb-0 px-0 px-md-4">
                                <img src="../assets/img/illustrations/gsplogo.png" height="175" data-app-dark-img="illustrations/gsplogo.png" data-app-light-img="illustrations/gsplogo.png" />
                            </div>
                        </aside>
                        <!-- / Menu -->

                        <!-- Layout container -->
                        <div class="layout-page">
                            <!-- Navbar -->

                            <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
                                <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                                    <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                                        <i class="bx bx-menu bx-sm"></i>
                                    </a>
                                </div>

                                <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                                    <div class="navbar-nav align-items-center">
                                        <form method="POST" action="">
                                            <div class="nav-item d-flex align-items-center">
                                                <input type="text" id="myTextField" class="form-control border-0 shadow-none" placeholder="Search..." aria-label="Search..." name="keyword" value="<?php echo isset($_POST['keyword']) ? $_POST['keyword'] : '' ?>" autocomplete="off" />
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-label-info" name="search">Search</button>
                                                    <a href="asecsanre.php" type="button" class="btn btn-label-info">Back</a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <ul class="navbar-nav flex-row align-items-center ms-auto">

                                        <!-- Style Switcher -->
                                        <li class="nav-item dropdown-style-switcher dropdown me-2 me-xl-0">
                                            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                                                <i class="bx bx-sm"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end dropdown-styles">
                                                <li>
                                                    <a class="dropdown-item" href="javascript:void(0);" data-theme="light">
                                                        <span class="align-middle"><i class="bx bx-sun me-2"></i>Light</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:void(0);" data-theme="dark">
                                                        <span class="align-middle"><i class="bx bx-moon me-2"></i>Dark</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:void(0);" data-theme="system">
                                                        <span class="align-middle"><i class="bx bx-desktop me-2"></i>System</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <!-- / Style Switcher-->
                                        <!-- User -->
                                        <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                                                <div class="avatar avatar-online">
                                                    <img src="../assets/img/avatars/admin.png" alt class="w-px-40 h-auto rounded-circle" />
                                                </div>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a class="dropdown-item" href="">
                                                        <div class="d-flex">
                                                            <div class="flex-shrink-0 me-3">
                                                                <div class="avatar avatar-online">
                                                                    <img src="../assets/img/avatars/admin.png" alt class="w-px-40 h-auto rounded-circle" />
                                                                </div>
                                                            </div>
                                                            <?php
                                                            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
                                                            $select_profile->execute([$admin]);
                                                            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);

                                                            $select_id = $conn->prepare("SELECT * FROM `beneficiary` ORDER BY `ben_type` DESC LIMIT 1");
                                                            $select_id->execute();
                                                            $fetch_id = $select_id->fetch(PDO::FETCH_ASSOC);
                                                            ?>
                                                            <div class="flex-grow-1">
                                                                <span class="fw-medium d-block"><?= $fetch_profile['fullname']; ?></span>
                                                                <small class="text-muted"><?= $fetch_profile['role']; ?></small>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <div class="dropdown-divider"></div>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="logout.php" target="">
                                                        <i class="bx bx-power-off me-2"></i>
                                                        <span class="align-middle">Log Out</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <!--/ User -->
                                    </ul>
                                </div>
                            </nav>

                            <!-- / Navbar -->

                            <!-- Content wrapper -->
                            <div class="content-wrapper">
                                <div class="container-xxl flex-grow-1 container-p-y">
                                    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Programs / Secret Santa / </span> Add Recipients</h4>
                                    <div class="card mb-4">
                                        <div class="card-widget-separator-wrapper">
                                            <div class="card-body card-widget-separator">
                                                <div class="row gy-4 gy-sm-1">
                                                    <div class="col-sm-6 col-lg-3">
                                                        <div class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-3 pb-sm-0">
                                                            <div>
                                                                <h3 class="mb-2"><?php echo $ss['ss_event']; ?></h3>
                                                                <p class="mb-0"><?php echo $ss['ss_eventname']; ?></p>
                                                            </div>
                                                            <div class="avatar me-sm-4">
                                                                <span class="avatar-initial rounded bg-label-secondary">
                                                                    <i class='bx bxs-calendar'></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <hr class="d-none d-sm-block d-lg-none me-4" />
                                                    </div>
                                                    <div class="col-sm-6 col-lg-3">
                                                        <div class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-3 pb-sm-0">
                                                            <div>
                                                                <h3 class="mb-2">₱ <?php
                                                                                    // Assuming $ss is an array with the required information
                                                                                    $ss_year = $ss['ss_year'];

                                                                                    // Get the current year
                                                                                    $current_year = date('Y');

                                                                                    if ($ss_year == $current_year) {
                                                                                        // If $ss_year is equal to the current year, fetch data from the donor table
                                                                                        $numbef = $conn->query("SELECT SUM(don_amount) FROM donor WHERE don_year = '$ss_year';")->fetchColumn();
                                                                                    } elseif ($ss_year < $current_year) {
                                                                                        // If $ss_year is before the current year, fetch data from the donhis table
                                                                                        $numbef = $conn->query("SELECT SUM(dh_amount) FROM donhis WHERE dh_year = '$ss_year';")->fetchColumn();
                                                                                    } else {
                                                                                        // Handle the case where $ss_year is in the future (if needed)
                                                                                        $numbef = 0; // Set a default value or handle accordingly
                                                                                    }

                                                                                    // Echo the result
                                                                                    echo $numbef;
                                                                                    ?>
                                                                </h3>
                                                                <p class="mb-0">Budget <small class="text-info fw-medium">(<?php
                                                                                                                            echo $ss_year;
                                                                                                                            ?>)</small></p>
                                                            </div>
                                                            <div class="avatar me-lg-4">
                                                                <span class="avatar-initial rounded bg-label-success">
                                                                    <i class='bx bx-money'></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <hr class="d-none d-sm-block d-lg-none" />
                                                    </div>
                                                    <div class="col-sm-6 col-lg-3">
                                                        <div class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-3 pb-sm-0">
                                                            <div>
                                                                <h3 class="mb-2"><?php
                                                                                    $result = $numbef / 1000;

                                                                                    // Round off the result
                                                                                    $result = round($result);
                                                                                    
                                                                                    // Echo the rounded result
                                                                                    echo $result;
                                                                                    ?></h3>
                                                                <p class="mb-0">Ideal # of Beneficiaries</p>
                                                            </div>
                                                            <div class="avatar me-lg-4">
                                                                <span class="avatar-initial rounded bg-label-warning">
                                                                    <i class='bx bxs-user-account'></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <hr class="d-none d-sm-block d-lg-none" />
                                                    </div>
                                                    <div class="col-sm-6 col-lg-3">
                                                        <div class="d-flex justify-content-between align-items-start card-widget-2 pb-3 pb-sm-0">
                                                            <div>
                                                                <h3 class="mb-2"><?php $ss_event = $ss['ss_event'];
                                                                                    $numben = $conn->query("SELECT count(*) FROM secsanre WHERE ss_event = '$ss_event'")->fetchColumn();
                                                                                    echo $numben;
                                                                                    ?></h3>
                                                                <p class="mb-0">Actual # of Beneficiaries</p>
                                                            </div>
                                                            <div class="avatar me-lg-4">
                                                                <span class="avatar-initial rounded bg-label-info">
                                                                    <i class='bx bxs-user-account'></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <hr class="d-none d-sm-block d-lg-none" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="nav nav-pills flex-column flex-md-row mb-3">
                                        <button type="button" class="btn btn-label-success" data-bs-toggle="modal" data-bs-target="#modalCenterass"><i class='bx bx-plus'>&nbsp</i> Add Beneficiaries
                                        </button>
                                        <button class="btn btn-label-primary" type="button" onclick="printTable()" style="margin-left: 10px;"><span><i class="bx bx-printer me-1"></i>Print</span></button>
                                        <button class="btn btn-label-primary" type="button" onclick="downloadCSV()" style="margin-left: 10px;"><span><i class="bx bx-file me-1"></i>Export to Excel</span></button>
                                    </ul>
                                    <div class="card">
                                        <?php
                                        // Set the ss_event as a PHP variable
                                        $ss_event = $ss['ss_event'];
                                        $ss_eventname = $ss['ss_eventname'];
                                        include "assrlist.php";  // Include the script
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <form action="" method="post" onsubmit="submitForm(event)">
                                <!-- Modal -->
                                <div class="modal fade" id="modalCenterass" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalCenterTitle">Add Secret Santa Beneficiaries</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" required></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col mb-3">
                                                        <label for="nameWithTitle" class="form-label">Event Date</label>
                                                        <input type="text" class="form-control" placeholder="" id="ss_event" name="ss_event" value="<?= $ss['ss_event']; ?>" required readonly />
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col mb-3">
                                                        <label for="nameWithTitle" class="form-label">Event Name</label>
                                                        <input type="text" class="form-control" placeholder="" id="ss_eventname" name="ss_eventname" value="<?= $ss['ss_eventname']; ?>" required readonly />
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col mb-3">
                                                        <label for="nameWithTitle" class="form-label">Number of Beneficiaries to be Added</label>
                                                        <input type="text" class="form-control" placeholder="Please do not go over the Ideal Number of Beneficiaries" name="ss_numberofben" id="ss_numberofben" required autocomplete="off" />
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                                    Close
                                                </button>
                                                <!-- Call addBeneficiaries function when submitting the form -->
                                                <button type="submit" class="btn btn-primary" name="submit">Add Beneficiaries</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!-- Footer -->
                            <footer class="content-footer footer bg-footer-theme">
                                <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                                    <div class="mb-2 mb-md-0">
                                        ©
                                        <script>
                                            document.write(new Date().getFullYear());
                                        </script>
                                        , made with ❤️ by Mavle (IT-05)
                                    </div>
                                    <div class="d-none d-lg-inline-block">The Good Shepherd Parish Web-Based Management Information System
                                    </div>
                                </div>
                            </footer>
                            <!-- / Footer -->

                            <div class="content-backdrop fade"></div>
                        </div>
                        <!-- Content wrapper -->
                    </div>
                    <!-- / Layout page -->
                </div>


                <!-- Overlay -->
                <div class="layout-overlay layout-menu-toggle"></div>

                <!-- Drag Target Area To SlideIn Menu On Small Screens -->
                <div class="drag-target"></div>
                </div>
                <!-- / Layout wrapper -->
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
                <script src="../assets/vendor/libs/moment/moment.js"></script>
                <script src="../assets/vendor/libs/flatpickr/flatpickr.js"></script>
                <script src="../assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
                <script src="../assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js"></script>
                <script src="../assets/vendor/libs/jquery-timepicker/jquery-timepicker.js"></script>
                <script src="../assets/vendor/libs/pickr/pickr.js"></script>
                <script src="../assets/vendor/libs/apex-charts/apexcharts.js"></script>
                <script src="../assets/vendor/libs/@form-validation/umd/bundle/popular.min.js"></script>
                <script src="../assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js"></script>
                <script src="../assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js"></script>
                <script src="../assets/vendor/libs/sweetalert2/sweetalert2.js"></script>

                <!-- Main JS -->
                <script src="../assets/js/main.js"></script>

                <!-- Page JS -->
                <script src="../assets/js/dashboards-analytics.js"></script>
                <script src="../assets/js/forms-pickers.js"></script>
                <script src="../assets/js/tables-datatables-basic.js"></script>
                <script src="../assets/js/extended-ui-sweetalert2.js"></script>

                <script>
                    function printTable() {
                        var printWindow = window.open('', '', 'width=600,height=600');
                        var table = document.getElementById('data-table');

                        // Clone the table to avoid modifying the original table
                        var clonedTable = table.cloneNode(true);

                        // Check if the last column is "Action" and remove it
                        var headerRow = clonedTable.querySelector('tr');
                        var headerCells = headerRow.getElementsByTagName('th');
                        if (headerCells[headerCells.length - 1].innerText.trim().toLowerCase() === 'action') {
                            var rows = clonedTable.getElementsByTagName('tr');
                            for (var i = 0; i < rows.length; i++) {
                                var cells = rows[i].getElementsByTagName('td');
                                if (cells.length > 0) {
                                    // Remove the last cell in each row
                                    cells[cells.length - 1].remove();
                                }
                            }
                            // Remove the last header cell
                            headerCells[headerCells.length - 1].remove();
                        }

                        var tableHtml = clonedTable.outerHTML;

                        printWindow.document.write('<html><head><title>Print</title></head><body>');
                        printWindow.document.write('<style>@media print{body{margin:0;}</style>');
                        printWindow.document.write('<div style="overflow: hidden;">');
                        printWindow.document.write(tableHtml);
                        printWindow.document.write('</div></body></html>');
                        printWindow.document.close();
                        printWindow.print();
                    }
                </script>

                <script>
                    function downloadCSV() {
                        var table = document.getElementById('data-table');
                        var rows = table.querySelectorAll('tr');
                        var csvContent = "data:text/csv;charset=utf-8,";

                        rows.forEach(function(row) {
                            var rowData = [];
                            var cols = row.querySelectorAll('td, th');

                            // Exclude the last column ("Action")
                            for (var i = 0; i < cols.length - 1; i++) {
                                // Escape double quotes by replacing them with two double quotes
                                var cellData = cols[i].innerText.replace(/"/g, '""');
                                // Enclose the cell data in double quotes
                                rowData.push('"' + cellData + '"');
                            }

                            csvContent += rowData.join(',') + '\r\n';
                        });

                        var encodedUri = encodeURI(csvContent);
                        var link = document.createElement("a");
                        link.setAttribute("href", encodedUri);
                        link.setAttribute("download", "data.csv");
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                    }
                </script>

                <script>
                    // Function to handle form submission
                    function submitForm(event) {
                        event.preventDefault(); // Prevent the default form submission

                        // Get values from the form
                        var ss_event = $('#ss_event').val();
                        var ss_eventname = $('#ss_eventname').val();
                        var ss_numberofben = $('#ss_numberofben').val();

                        // Call the addBeneficiaries function with the form values
                        addBeneficiaries(ss_event, ss_eventname, ss_numberofben);
                    }

                    // Function to add beneficiaries using AJAX
                    function addBeneficiaries(ss_event, ss_eventname) {
                        // Retrieve the numberofben value from the form input
                        var ss_numberofben = $('#ss_numberofben').val();

                        $.ajax({
                            url: 'assraddall.php',
                            type: 'POST',
                            data: {
                                ss_event: ss_event,
                                ss_eventname: ss_eventname,
                                ss_numberofben: ss_numberofben
                            },
                            success: function(response) {
                                console.log('Data insertion successful:', response);

                                // Close the modal after adding beneficiaries
                                $('#modalCenterass').modal('hide');
                                // Show SweetAlert2 success message
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: 'Beneficiaries added successfully.',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(function() {
                                    // Refresh the page after hiding the modal
                                    location.reload();
                                });
                            },
                            error: function(xhr, status, error) {
                                console.error('Error:', error);
                            }
                        });
                    }
                </script>
    <?php
            } else {
                echo "Event not found.";
            }
        } else {
            echo "Error occurred while fetching user data.";
        }
    } else {
        echo "Invalid Event.";
    }

    ?>
</body>

</html>