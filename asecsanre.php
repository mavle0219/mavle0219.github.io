<?php
include 'connect.php';

session_start();

$admin = $_SESSION['admin'];

if (!isset($admin)) {
    header('location:login.php');
}

$select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
$select_profile->execute([$admin]);
$fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);

// Handle Deletion
if (isset($_GET['ss_id'])) {
    // Fetch the details of the Secret Santa record
    $result = $conn->prepare('SELECT * FROM `secsan` WHERE ss_id = ?');
    $result->execute([$_GET['ss_id']]);
    $secretSanta = $result->fetch(PDO::FETCH_ASSOC);

    // Delete the Secret Santa record from the 'secsan' table
    $result = $conn->prepare('DELETE FROM `secsan` WHERE ss_id = ?');
    $result->execute([$_GET['ss_id']]);

    // Delete rows with the same date from 'secsanre' table
    $resultDeleteSecsanre = $conn->prepare('DELETE FROM `secsanre` WHERE ss_event = ?');
    $resultDeleteSecsanre->execute([$secretSanta['ss_event']]);

    $resultDeleteEvents = $conn->prepare('DELETE FROM `events` WHERE title = ?');
    $resultDeleteEvents->execute([$secretSanta['ss_eventname']]);

    $auditlogin = $conn->prepare("INSERT INTO `audit`(role, username, action) VALUES(?,?,?)");
    $auditlogin->execute(["admin", $fetch_profile['username'], "delete secret santa record"]);

    echo "<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: 'Secret Santa Record Deleted!',
            showConfirmButton: false,
            timer: 1000
        }).then(function () {
            window.location.href = 'asecsanre.php';
        });
    });
  </script>";
} else if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submit"])) {
    // Retrieve form data
    $ss_event = $_POST["ss_event"];
    $ss_eventname = $_POST["ss_eventname"];
    $ss_creator = $_POST["ss_creator"];

    // Get the year from ss_event
    $ss_year = date('Y', strtotime($ss_event));

    // Get the current timestamp for ss_date
    $ss_date = date('Y-m-d H:i:s');

    // Perform the insertion into the database
    try {
        // Assuming you have a table named "secsan"
        $sql = "INSERT INTO secsan (ss_event, ss_eventname, ss_creator, ss_date, ss_year, ssevent) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$ss_event, $ss_eventname, $ss_creator, $ss_date, $ss_year, 'Yes']);

        // Insert data into the 'events' table
        $eventTitle = $ss_eventname;
        $eventStart = "ALL";
        $eventEnd = "DAY"; // Assuming end time is end of the day

        $eventSql = "INSERT INTO events (title, start, end, date) VALUES (?, ?, ?, ?)";
        $eventStmt = $conn->prepare($eventSql);
        $eventStmt->execute([$eventTitle, $eventStart, $eventEnd, $ss_event]);

        $auditlogin = $conn->prepare("INSERT INTO `audit`(role, username, action) VALUES(?,?,?)");
        $auditlogin->execute(["admin", $fetch_profile['username'], "add secret santa event"]);

        echo "<script>
            document.addEventListener('DOMContentLoaded', (event) => {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Secret Santa Event Added Successfully!',
                showConfirmButton: false,
                timer: 1500
            }).then(function () {
                window.location.href = 'asecsanre.php';
            });
        });
        </script>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        header('location: asecsanre.php');
    }
}
?>



<!DOCTYPE html>

<html lang="en" class="dark-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Secret Santa Recipients</title>

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
</head>

<body>
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
                                    <li class="menu-item active">
                                        <a href="asecsanre.php" class="menu-link">
                                            <div class="text-truncate" data-i18n="Events">Events</div>
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
                                    <input type="text" class="form-control border-0 shadow-none" placeholder="Search..." aria-label="Search..." name="keyword" value="<?php echo isset($_POST['keyword']) ? $_POST['keyword'] : '' ?>" autocomplete="off" />
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-label-info" name="search">Search</button>
                                        <a href="asecsanre.php" type="button" class="btn btn-label-info">Clear</a>
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
                        <h4 class="py-3 mb-4"><span class="text-muted fw-light">Programs / Secret Santa / </span> Events</h4>
                        <ul class="nav nav-pills flex-column flex-md-row mb-3">
                            <button type="button" class="btn btn-label-success" data-bs-toggle="modal" data-bs-target="#modalCenterasse"><i class='bx bx-plus'>&nbsp</i> Add Secret Santa Event
                            </button>
                        </ul>
                        <div class="card">
                            <h4 class="card-header">Events</h4>
                            <?php
                            include 'asecsanlist.php';
                            ?>
                        </div>
                        <form action="" method="post">
                            <!-- Modal -->
                            <div class="modal fade" id="modalCenterasse" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalCenterTitle">New Secret Santa Event</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" required></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6 col-12 mb-4">
                                                    <label for="flatpickr-date" class="form-label">Event Date</label>
                                                    <input type="text" class="form-control" placeholder="YYYY-MM-DD" id="flatpickr-date" name="ss_event" />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col mb-3">
                                                    <label for="nameWithTitle" class="form-label">Event Name</label>
                                                    <input type="text" class="form-control" placeholder="" name="ss_eventname" value="Secret Santa" required autocomplete="off" readonly />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col mb-3">
                                                    <label for="nameWithTitle" class="form-label">Event Creator</label>
                                                    <input type="text" class="form-control" placeholder="" name="ss_creator" value="<?= $fetch_profile['fullname']; ?>" readonly required autocomplete="off" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                                Close
                                            </button>
                                            <button type="submit" value="Add Event" class="btn btn-primary" name="submit">Add Event</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Footer -->
                <footer class="content-footer footer bg-footer-theme">
                    <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                        <div class="mb-2 mb-md-0">
                            ©
                            <script>
                                document.write(new Date().getFullYear());
                            </script>
                            , made with ❤️ by
                            <a href="https://themeselection.com" target="_blank" class="footer-link fw-medium">ThemeSelection</a>
                        </div>
                        <div class="d-none d-lg-inline-block">
                            <a href="https://themeselection.com/license/" class="footer-link me-4" target="_blank">License</a>
                            <a href="https://themeselection.com/" target="_blank" class="footer-link me-4">More Themes</a>

                            <a href="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/documentation/" target="_blank" class="footer-link me-4">Documentation</a>

                            <a href="https://themeselection.com/support/" target="_blank" class="footer-link d-none d-sm-inline-block">Support</a>
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

</body>

</html>