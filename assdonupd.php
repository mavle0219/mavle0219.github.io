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

    <title>Secret Santa Donors</title>

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
    <link rel="stylesheet" href="../assets/vendor/libs/apex-charts/apex-charts.css" />

    <!-- Page CSS -->

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
                                    <li class="menu-item">
                                        <a href="" class="menu-link">
                                            <div class="text-truncate" data-i18n="Beneficiaries Profiles">Beneficiaries Profiles</div>
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
                                    <li class="menu-item">
                                        <a href="" class="menu-link">
                                            <div class="text-truncate" data-i18n="Scholars Profiles">Scholars Profiles</div>
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
                                            <div class="text-truncate" data-i18n="Scholars">Recipients</div>
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
                                        <a href="" class="menu-link">
                                            <div class="text-truncate" data-i18n="Update Donor">Update Donor</div>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="asecsanre.php" class="menu-link">
                                            <div class="text-truncate" data-i18n="Recipients">Recipients</div>
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
                        <h4 class="py-3 mb-4"><span class="text-muted fw-light">Programs / Secret Santa / Donors</span> / Update Donor </h4>
                        <div class="card">
                            <?php

                            if (isset($_GET['don_id'])) {
                                $don_id = $_GET['don_id'];

                                // Retrieve user data from the database
                                $select_don = $conn->prepare("SELECT * FROM `donor` WHERE don_id = :don_id");
                                $select_don->bindParam(':don_id', $don_id);
                                if ($select_don->execute()) {
                                    $don = $select_don->fetch(PDO::FETCH_ASSOC);
                                    if ($don) {
                                        // User data found, proceed with displaying the edit form
                            ?>
                                        <div class="row">
                                            <div class="col-xl">
                                                    <div class="card-header d-flex justify-content-between align-items-center">
                                                        <h4 class="mb-0">Update Donor</h4>
                                                    </div>
                                                    <div class="card-body">
                                                        <form action="" method="post">
                                                            <div class="row">
                                                                <div class="col mb-3">
                                                                    <label for="nameWithTitle" class="form-label">Full Name</label>
                                                                    <input type="text" class="form-control" placeholder="" id="don_name" name="don_name" required autocomplete="off" value="<?php echo $don['don_name']; ?>" />
                                                                    <input type="hidden" name="id" value="<?php echo $don['don_id']; ?>" required>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col mb-3">
                                                                    <label for="nameWithTitle" class="form-label">Address</label>
                                                                    <input type="text" class="form-control" placeholder="" name="don_address" required autocomplete="off" value="<?php echo $don['don_address']; ?>" />
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col mb-3">
                                                                    <label for="nameWithTitle" class="form-label">Phone</label>
                                                                    <input type="text" class="form-control" name="don_phone" required autocomplete="off" value="<?php echo $don['don_phone']; ?>" />
                                                                </div>
                                                                <div class="col mb-3">
                                                                    <label for="nameWithTitle" class="form-label">Availability</label>
                                                                    <select id="don_avail" class="select2 form-select" name="don_avail" required autocomplete="off">
                                                                        <option><?php echo $don['don_avail']; ?></option>
                                                                        <option value="Yes">Yes</option>
                                                                        <option value="No">No</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col mb-3">
                                                                    <label for="nameWithTitle" class="form-label">Confirmed Year</label>
                                                                    <input type="text" id="don_year" class="form-control" placeholder="" name="don_year" required autocomplete="off" value="<?php echo $don['don_year']; ?>" />
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col mb-3">
                                                                    <label for="nameWithTitle" class="form-label">Amount Donated</label>
                                                                    <input type="text" id="don_amount" class="form-control" placeholder="" name="don_amount" required autocomplete="off" value="<?php echo $don['don_amount']; ?>" />
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <button type="submit" value="Update Donor" class="btn btn-primary" name="submit">Update Donor</button>
                                                                <a href="asecsandon.php" value="" class="btn btn-label-danger suspend-user">Back</a>
                                                            </div>
                                                        </form>
                                                    </div>
                                            </div>
                                            </div>
                                <?php
                                    } else {
                                        echo "Donor not found.";
                                    }
                                } else {
                                    echo "Error occurred while fetching user data.";
                                }
                            } else {
                                echo "Invalid Donor.";
                            }

                                ?>
                                        
                        </div>
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
                <script src="../assets/vendor/libs/apex-charts/apexcharts.js"></script>
                <script src="../assets/vendor/libs/sweetalert2/sweetalert2.js"></script>

                <!-- Main JS -->
                <script src="../assets/js/main.js"></script>

                <!-- Page JS -->
                <script src="../assets/js/dashboards-analytics.js"></script>
                <script src="../assets/js/extended-ui-sweetalert2.js"></script>

                <script>
                    function printTable() {
                        var printWindow = window.open('', '', 'width=600,height=600');
                        var tableHtml = document.getElementById('data-table').outerHTML;

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
                            cols.forEach(function(col) {
                                rowData.push(col.innerText);
                            });
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

</body>

</html>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $don_id = $_POST['id'];
    $don_name = $_POST['don_name'];
    $don_address = $_POST['don_address'];
    $don_phone = $_POST['don_phone'];
    $don_avail = $_POST['don_avail'];
    $don_year = $_POST['don_year'];
    $don_amount = $_POST['don_amount']; // Include the new field

    // Prepare SQL statement to update donor information
    $updateDonorSQL = "UPDATE `donor` 
                      SET 
                          `don_name` = :don_name, 
                          `don_address` = :don_address, 
                          `don_phone` = :don_phone, 
                          `don_avail` = :don_avail, 
                          `don_year` = :don_year,
                          `don_amount` = :don_amount
                      WHERE `don_id` = :don_id";

    // Prepare SQL statement to insert new row into donhis
    $insertDonhisSQL = "INSERT INTO `donhis` (`dh_name`, `dh_year`, `dh_amount`)
                        VALUES (:dh_name, :dh_year, :dh_amount)";

    try {
        $stmtDonor = $conn->prepare($updateDonorSQL);
        $stmtDonor->bindParam(':don_name', $don_name);
        $stmtDonor->bindParam(':don_address', $don_address);
        $stmtDonor->bindParam(':don_phone', $don_phone);
        $stmtDonor->bindParam(':don_avail', $don_avail); 
        $stmtDonor->bindParam(':don_year', $don_year);
        $stmtDonor->bindParam(':don_amount', $don_amount);
        $stmtDonor->bindParam(':don_id', $don_id);

        $stmtDonhis = $conn->prepare($insertDonhisSQL);
        $stmtDonhis->bindParam(':dh_name', $don_name);
        $stmtDonhis->bindParam(':dh_year', $don_year);
        $stmtDonhis->bindParam(':dh_amount', $don_amount);

        if ($stmtDonor->execute() && $stmtDonhis->execute()) {

            $auditlogin = $conn->prepare("INSERT INTO `audit`(role, username, action) VALUES(?,?,?)");
            $auditlogin->execute(["admin", $fetch_profile['username'], "update secret santa donor"]);

            echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Secret Santa Donor Updated!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(function () {
                    window.location.href = 'asecsandon.php';
                });
            </script>";
        } else {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to Update Donor',
                    showConfirmButton: false,
                    timer: 1500
                }).then(function () {
                    window.location.href = 'asecsandon.php';
                });
            </script>";
        }
    } catch (PDOException $e) {
        // Handle any errors in the database connection or query
        echo 'Error: ' . $e->getMessage();
    }
}
?>
