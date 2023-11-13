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

  <title>Ministry on Service Dashboard</title>

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
  <link rel="stylesheet" href="../assets/vendor/libs/animate-css/animate.css" />
  <link rel="stylesheet" href="../assets/vendor/libs/sweetalert2/sweetalert2.css" />

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
          <li class="menu-item active open">
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
          <li class="menu-item">
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
          <!-- Content -->

          <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
              <div class="col-lg-8 mb-4 order-0">
                <div class="card card-border-shadow-primary h-100">
                  <div class="d-flex align-items row">
                    <div class="col-sm-7">
                      <div class="card-body">
                        <h2 class="card-title text-primary">The Good Shepherd Parish Management Information System</h2>
                        <p class="mb-4">Welcome, <?= $fetch_profile['fullname']; ?>! <br></br>

                          <span class="text-warning fw-medium">
                            <?php

                            if ($fetch_profile['username'] === $fetch_profile['password']) {
                              echo "Please change your password!";
                            }
                            ?>
                          </span>
                        </p>

                        <a class="btn btn-primary" href="auserprof.php?id=<?= $fetch_profile['id']; ?>">Go to My Profile</a>
                      </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                      <div class="card-body pb-0 px-0 px-md-4">
                        <img src="../assets/img/illustrations/gsplogo.png" height="250" data-app-dark-img="illustrations/gsplogo.png" data-app-light-img="illustrations/gsplogo.png" />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 order-1">
                <div class="row">
                  <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card card-border-shadow-primary h-100">
                      <div class="card-body">
                        <span class="d-block fw-medium mb-1">Number of <a href="abenlist.php"><span>Beneficiaries</span></a>:</span>
                        <h3 class="card-title mb-1"><?php $numbef = $conn->query('SELECT COUNT(*) from `beneficiary`')->fetchColumn();
                                                    echo $numbef ?></h3>
                        <small class="text-success fw-medium">
                          <?php
                          try {
                            // Set PDO to throw exceptions on error
                            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            // Get the current year
                            $currentYear = date('Y');

                            // Calculate the year for the previous year
                            $previousYear = $currentYear - 1;

                            // SQL query to get the count of rows added within the past year
                            $sql = "SELECT COUNT(*) AS rows_added_last_year FROM beneficiary WHERE ben_regdate >= DATE_SUB(NOW(), INTERVAL 1 YEAR)";

                            // Prepare and execute the query
                            $stmt = $conn->query($sql);

                            // Fetch the result
                            $result = $stmt->fetch(PDO::FETCH_ASSOC);

                            if ($result) {
                              $rowsAddedLastYear = $result['rows_added_last_year'];

                              echo "+ $rowsAddedLastYear from $previousYear's total";
                            } else {
                              echo "No results found";
                            }
                          } catch (PDOException $e) {
                            echo "Connection failed: " . $e->getMessage();
                          }
                          ?>

                        </small>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card card-border-shadow-success h-100">
                      <div class="card-body">
                        <span class="d-block fw-medium mb-1">Number of <a href="ascholist.php"><span> Active Scholars</span></a>:</span>
                        <h3 class="card-title mb-1"><?php $numbef = $conn->query('SELECT COUNT(*) from `scholar`')->fetchColumn();
                                                    echo $numbef; ?></h3>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card card-border-shadow-warning h-100">
                      <div class="card-body">
                        <span class="d-block fw-medium mb-1">Medical Assistance <a href="amedass.php"><span>Recipients</span></a>:</span>
                        <h3 class="card-title mb-1"><?php $numbef = $conn->query("SELECT COUNT(*) FROM `beneficiary` WHERE ben_ma = 'Yes'")->fetchColumn();
                                                    echo $numbef; ?></h3>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card card-border-shadow-info h-100">
                      <div class="card-body">
                        <span class="d-block fw-medium mb-1">Secret Santa <a href="asecsandon.php"><span> Active Donors</span></a>:</span>
                        <h3 class="card-title mb-1"><?php $numbef = $conn->query("SELECT COUNT(*) FROM `donor` WHERE don_avail = 'Yes' and don_year = YEAR(CURDATE())")->fetchColumn();
                                                    echo $numbef; ?></h3>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Activity Timeline -->
              <div class="col-md-12 col-lg-6 order-4 order-lg-3">
                <div class="card card-border-shadow-primary h-100">
                  <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">Upcoming Events</h5>
                  </div>
                  <div class="card-body">
                    <!-- Activity Timeline -->
                    <ul class="timeline">
                      <li class="timeline-item timeline-item-transparent">
                        <span class="timeline-point-wrapper"><span class="timeline-point timeline-point-primary"></span></span>
                        <div class="timeline-event">
                          <div class="timeline-header mb-1">
                            <h6 class="mb-0">October 10, 2023</h6>
                            <small class="text-muted"></small>
                          </div>
                          <p class="mb-2">Feast of The Marky</p>
                          <div class="d-flex">
                            <a href="javascript:void(0)" class="d-flex align-items-center me-3">
                            </a>
                          </div>
                        </div>
                      </li>
                      <li class="timeline-item timeline-item-transparent">
                        <span class="timeline-point-wrapper"><span class="timeline-point timeline-point-warning"></span></span>
                        <div class="timeline-event">
                          <div class="timeline-header mb-1">
                            <h6 class="mb-0">November 1, 2023</h6>
                            <small class="text-muted"></small>
                          </div>
                          <p class="mb-2">All Saints' Day</p>
                          <div class="d-flex flex-wrap">
                            <div class="avatar me-3">
                            </div>
                          </div>
                        </div>
                      </li>
                      <li class="timeline-item timeline-item-transparent">
                        <span class="timeline-point-wrapper"><span class="timeline-point timeline-point-info"></span></span>
                        <div class="timeline-event pb-0">
                          <div class="timeline-header mb-1">
                            <h6 class="mb-0">November 2, 2023</h6>
                            <small class="text-muted"></small>
                          </div>
                          <p class="mb-2">All Souls' Day</p>
                        </div>
                      </li>
                      <a href="acal.php" class="btn btn-primary">Go to Calendar</a>
                    </ul>
                    <!-- /Activity Timeline -->
                  </div>
                </div>
              </div>
              <!--/ Activity Timeline -->
              <!-- pill table -->
              <div class="col-md-6 order-3 order-lg-4 mb-4 mb-lg-0">
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                  <div class="card card-border-shadow-danger h-100">
                    <div class="card-body">
                      <span class="d-block fw-medium mb-1">Go to <a href="respassreq.php"><span>Password Reset</span></a> Requests:</span>
                      <h3 class="card-title mb-1"><?php $numbef = $conn->query("SELECT COUNT(*) FROM `reset` WHERE req_reset = 'Yes'")->fetchColumn();
                                                  echo $numbef; ?></h3>
                    </div>
                  </div>
                </div>
              </div>
              <!--/ pill table -->
            </div>
          </div>
          <!-- / Content -->

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

</body>

</html>