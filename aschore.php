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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
  $scholarName = $_POST['c_name'];
  $schoolYear = $_POST['c_sy'];
  $month = $_POST['c_month'];
  $claimed = $_POST['c_claim'];

  // Add validation and sanitation as needed

  // Check if a scholar is selected
  if ($scholarName === 'Select Scholar') {
    echo "<script>
        document.addEventListener('DOMContentLoaded', (event) => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Please select a Scholar!',
            showConfirmButton: false,
            timer: 1500
        }).then(function () {
            window.location.href = 'aschore.php';
        });
    });
    </script>";
  } elseif (!in_array($claimed, ['Yes', 'No'])) {
    // Check if the claimed value is either 'Yes' or 'No'
    echo "<script>
        document.addEventListener('DOMContentLoaded', (event) => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Please select a valid claim status (Yes or No)!',
            showConfirmButton: false,
            timer: 1500
        }).then(function () {
            window.location.href = 'aschore.php';
        });
    });
    </script>";
  } else {
    // Check for duplicate records before inserting
    $duplicateCheckQuery = $conn->prepare("SELECT * FROM claim WHERE c_name = ? AND c_sy = ? AND c_month = ?");
    $duplicateCheckQuery->execute([$scholarName, $schoolYear, $month]);

    if ($duplicateCheckQuery->rowCount() > 0) {
      // Duplicate record found
      echo "<script>
            document.addEventListener('DOMContentLoaded', (event) => {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Duplicate record! This claim already exists for the selected scholar, month, and school year.',
                showConfirmButton: false,
                timer: 1500
            }).then(function () {
                window.location.href = 'aschore.php';
            });
        });
        </script>";
    } else {
      // Insert the record if no duplicate is found
      $insertQuery = $conn->prepare("INSERT INTO claim (c_name, c_sy, c_month, c_claim) VALUES (?, ?, ?, ?)");
      $insertQuery->execute([$scholarName, $schoolYear, $month, $claimed]);

      if ($insertQuery) {
        echo "<script>
                document.addEventListener('DOMContentLoaded', (event) => {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Scholarship Monthly Claim added!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(function () {
                    window.location.href = 'aschore.php';
                });
            });
            </script>";
      } else {
        echo "<script>
                    alert('Error adding claim.');
                </script>";
      }
    }
  }

  $auditlogin = $conn->prepare("INSERT INTO `audit`(role, username, action) VALUES(?,?,?)");
  $auditlogin->execute(["admin", $fetch_profile['username'], "add scholarship claim"]);
}
?>

<!DOCTYPE html>

<html lang="en" class="dark-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>Scholars Monthly Claim</title>

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
  <link rel="stylesheet" href="../assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
  <link rel="stylesheet" href="../assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
  <link rel="stylesheet" href="../assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
  <link rel="stylesheet" href="../assets/vendor/libs/select2/select2.css" />
  <link rel="stylesheet" href="../assets/vendor/libs/@form-validation/umd/styles/index.min.css" />

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
              <li class="menu-item open">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                  <div class="text-truncate" data-i18n="Scholars">Scholars</div>
                </a>
                <ul class="menu-sub">
                  <li class="menu-item active">
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
              <li class="menu-item">
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

                        $select_id = $conn->prepare("SELECT * FROM `scholar` ORDER BY `ben_type` DESC LIMIT 1");
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
            <h4 class="py-3 mb-4"><span class="text-muted fw-light">Programs / Scholars /</span> Scholarship Claim</h4>
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
              <button type="button" class="btn btn-label-success" data-bs-toggle="modal" data-bs-target="#modalCenteras"><i class='bx bx-plus'>&nbsp</i> Add Claim
              </button>
              <button class="btn btn-label-primary" type="button" onclick="printTable()" style="margin-left: 10px;"><span><i class="bx bx-printer me-1"></i>Print</span></button>
              <button class="btn btn-label-primary" type="button" onclick="downloadCSV()" style="margin-left: 10px;"><span><i class="bx bx-file me-1"></i>Export to Excel</span>
              </button>
            </ul>
            <div class="card">
              <div class="card-header border-bottom">
                <h5 class="card-title">Search Filter</h5>
                <form method=POST action="">
                  <div class="d-flex justify-content-between align-items-center row py-3 gap-3 gap-md-0">
                    <div class="col-md-4 s_sy">
                      <select id="c_sy" class="select2 form-select" name="c_sy" required autocomplete="off">
                        <option value="" selected>Select School Year</option>
                        <?php
                        // Assuming $conn is your database connection
                        $stmt = $conn->prepare("SELECT DISTINCT c_sy FROM claim ORDER BY c_sy DESC");
                        $stmt->execute();

                        // Fetch all unique school years from the claim table in descending order
                        $schoolYears = $stmt->fetchAll(PDO::FETCH_COLUMN);

                        // Get the current date
                        $currentDate = new DateTime('today');
                        $currentMonth = $currentDate->format('m');

                        // Check if the current month is before September (school year starts)
                        if ($currentMonth < 9) {
                          $startYear = $currentDate->format('Y') - 1;
                          $endYear = $currentDate->format('Y');
                        } else {
                          $startYear = $currentDate->format('Y');
                          $endYear = $currentDate->format('Y') + 1;
                        }

                        $currentSchoolYear = $startYear . '-' . $endYear;

                        // Output options for each school year
                        foreach ($schoolYears as $schoolYear) {
                          $selected = ($schoolYear === $currentSchoolYear) ? 'selected' : '';
                          echo "<option value=\"$schoolYear\" $selected>$schoolYear</option>";
                        }
                        ?>
                      </select>

                    </div>
                    <div class="col-md-4 s_month">
                      <select id="c_month" class="select2 form-select" name="c_month" required autocomplete="off">
                        <option value="" selected>Select Month</option>
                        <?php
                        // Generate months from September to June
                        $months = array(
                          'September', 'October', 'November', 'December',
                          'January', 'February', 'March', 'April', 'May', 'June'
                        );

                        // Get the current month
                        $currentMonth = date('F'); // 'F' format gives the full month name

                        // Output options for each month
                        foreach ($months as $month) {
                          $selected = ($month === $currentMonth) ? 'selected' : '';
                          echo "<option value=\"$month\" $selected>$month</option>";
                        }
                        ?>
                      </select>
                    </div>
                    <div class="col-md-4 s_filter">
                      <button id="filterButton" class="btn btn-label-info" name="filter">Filter</button>
                    </div>
                </form>
              </div>
            </div>
            <div class="card-datatable table-responsive">
              <table class="datatables-users table border-top">
              <thead style="position: sticky; top: 0; background-color: #7e8a9b; z-index: 1;">
                  <tr>
                    <th></th>
                    <th>Full Name</th>
                    <th>School Year</th>
                    <th>Month</th>
                    <th>Claimed</th>
                  </tr>
                </thead>
                <?php
                include 'aschorefil.php';
                ?>
              </table>
            </div>
            <form action="" method="post">
              <!-- Modal -->
              <div class="modal fade" id="modalCenteras" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="modalCenterTitle">Add Scholarship Claim</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" required></button>
                    </div>
                    <div class="modal-body">
                      <div class="row">
                        <div class="col mb-3">
                          <label for="nameWithTitle" class="form-label">Full Name</label>
                          <select id="c_name" class="select2 form-select" name="c_name" required autocomplete="off">
                            <option>Select Scholar</option>
                            <?php
                            // Assuming $conn is your database connection
                            $stmt = $conn->prepare("SELECT sch_name FROM scholar");
                            $stmt->execute();

                            // Fetch all names from the scholar table
                            $names = $stmt->fetchAll(PDO::FETCH_COLUMN);

                            // Output options for each name
                            foreach ($names as $name) {
                              echo "<option value=\"$name\">$name</option>";
                            }

                            $currentDate = new DateTime('today');
                            $currentMonth = $currentDate->format('m');

                            // Check if the current month is before September (school year starts)
                            if ($currentMonth < 9) {
                              $startYear = $currentDate->format('Y') - 1;
                              $endYear = $currentDate->format('Y');
                            } else {
                              $startYear = $currentDate->format('Y');
                              $endYear = $currentDate->format('Y') + 1;
                            }

                            $schoolYear = $startYear . '-' . $endYear;

                            $currentMonth = date('F'); // 'F' format gives the full month name
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col mb-3">
                          <label for="nameWithTitle" class="form-label">School Year</label>
                          <select id="c_sy" class="select2 form-select" name="c_sy" required autocomplete="off">
                            <?php
                            $currentYear = date("Y");
                            for ($year = 2020; $year <= $currentYear; $year++) {
                              $nextYear = $year + 1;
                              $schoolYear = $year . '-' . $nextYear;
                              $selected = ($year == $currentYear) ? 'selected' : '';
                              echo "<option value=\"$schoolYear\" $selected>$schoolYear</option>";
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col mb-3">
                          <label for="nameWithTitle" class="form-label">Month</label>
                          <select id="c_month" class="select2 form-select" name="c_month" required autocomplete="off">
                            <?php
                            // Generate months from September to June
                            $months = array(
                              'September', 'October', 'November', 'December',
                              'January', 'February', 'March', 'April', 'May', 'June'
                            );

                            // Output options for each month
                            foreach ($months as $month) {
                              $selected = ($month === $currentMonth) ? 'selected' : '';
                              echo "<option value=\"$month\" $selected>$month</option>";
                            }
                            ?>
                          </select>
                        </div>
                        <div class="col mb-3">
                          <label for="nameWithTitle" class="form-label">Claimed</label>
                          <select id="schclaim" class="select2 form-select" name="c_claim" required autocomplete="off">
                            <option>Select</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                      </button>
                      <button type="submit" value="Add User" class="btn btn-primary" name="submit">Add Claim</button>
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
  <script src="../assets/vendor/libs/moment/moment.js"></script>
  <script src="../assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
  <script src="../assets/vendor/libs/select2/select2.js"></script>
  <script src="../assets/vendor/libs/@form-validation/umd/bundle/popular.min.js"></script>
  <script src="../assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js"></script>
  <script src="../assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js"></script>
  <script src="../assets/vendor/libs/cleavejs/cleave.js"></script>
  <script src="../assets/vendor/libs/cleavejs/cleave-phone.js"></script>

  <!-- Main JS -->
  <script src="../assets/js/main.js"></script>

  <!-- Page JS -->
  <script src="../assets/js/dashboards-analytics.js"></script>
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
    function filterTable() {
      var c_sy = $("#c_sy").val();
      var c_month = $("#c_month").val();

      $.ajax({
        type: "POST",
        url: "aschorefil.php",
        data: {
          filter: true,
          c_sy: c_sy,
          c_month: c_month
        },
        success: function(data) {
          // Assuming your PHP script echoes the HTML table rows
          $(".datatables-users tbody").html(data);
        },
        error: function(xhr, status, error) {
          console.error("Error:", error);
        }
      });
    }
  </script>

</body>

</html>