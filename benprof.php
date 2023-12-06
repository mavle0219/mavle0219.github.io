<?php
include 'connect.php'; // Include your database connection

session_start();

$user = $_SESSION['user'];

if (!isset($user)) {
  header('location:login.php');
}

?>
<!DOCTYPE html>

<html lang="en" class="dark-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>Beneficiaries Profile</title>

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
  <link rel="stylesheet" href="../assets/vendor/libs/dropzone/dropzone.css" />
  <link rel="stylesheet" href="../assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
  <link rel="stylesheet" href="../assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
  <link rel="stylesheet" href="../assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css" />
  <link rel="stylesheet" href="../assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
  <link rel="stylesheet" href="../assets/vendor/libs/flatpickr/flatpickr.css" />

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
  <?php

  if (isset($_GET['ben_id'])) {
    $ben_id = $_GET['ben_id'];

    // Retrieve user data from the database
    $select_ben = $conn->prepare("SELECT * FROM `beneficiary` WHERE ben_id = :ben_id");
    $select_ben->bindParam(':ben_id', $ben_id);
    if ($select_ben->execute()) {
      $ben = $select_ben->fetch(PDO::FETCH_ASSOC);
      if ($ben) {
        // User data found, proceed with displaying the edit form
  ?>
        <!-- Layout wrapper -->
        <div class="layout-wrapper layout-content-navbar">
          <div class="layout-container">
            <!-- Menu -->

            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
              <div class="app-brand demo">
                <a href="udboard.php" class="app-brand-link">
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
                  <a href="udboard.php" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-dashboard"></i>
                    <div class="text-truncate" data-i18n="Dashboard">Dashboard</div>
                  </a>
                </li>
                <li class="menu-header small text-uppercase">
                  <span class="menu-header-text">Beneficiaries Management</span>
                </li>
                <li class="menu-item active open">
                  <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx bx-list-check"></i>
                    <div class="text-truncate" data-i18n="Beneficiaries">Beneficiaries</div>
                  </a>
                  <ul class="menu-sub">
                    <li class="menu-item open">
                      <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div class="text-truncate" data-i18n="Beneficiaries">Beneficiaries</div>
                      </a>
                      <ul class="menu-sub">
                        <li class="menu-item">
                          <a href="benlist.php" class="menu-link">
                            <div class="text-truncate" data-i18n="Beneficiaries List">Beneficiaries List</div>
                          </a>
                        </li>
                        <li class="menu-item active">
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
                          <a href="scholist.php" class="menu-link">
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
                          <a href="medass.php" class="menu-link">
                            <div class="text-truncate" data-i18n="Medical Assistance Recipients">Medical Assistance Recipients</div>
                          </a>
                        </li>
                      </ul>
                    </li>
                  </ul>
                </li>
                <li class="menu-header small text-uppercase"><span class="menu-header-text">Program Management</span></li>
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
                          <a href="schore.php" class="menu-link">
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
                          <a href="medmissre.php" class="menu-link">
                            <div class="text-truncate" data-i18n="Medical Mission">Medical Mission</div>
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
                          <a href="secsandon.php" class="menu-link">
                            <div class="text-truncate" data-i18n="Donors">Donors</div>
                          </a>
                        </li>
                        <li class="menu-item">
                          <a href="secsanre.php" class="menu-link">
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
                      <a href="userlist.php" class="menu-link">
                        <div class="text-truncate" data-i18n="Profile">Profile</div>
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
                          <img src="../assets/img/avatars/user.png" alt class="w-px-40 h-auto rounded-circle" />
                        </div>
                      </a>
                      <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                          <a class="dropdown-item" href="">
                            <div class="d-flex">
                              <div class="flex-shrink-0 me-3">
                                <div class="avatar avatar-online">
                                  <img src="../assets/img/avatars/user.png" alt class="w-px-40 h-auto rounded-circle" />
                                </div>
                              </div>
                              <?php
                              $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
                              $select_profile->execute([$user]);
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
                  <h4 class="py-3 mb-4"><span class="text-muted fw-light">Beneficiaries /</span> Profiles</h4>
                  <div class="row">
                    <!-- User Sidebar -->
                    <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
                      <!-- User Card -->
                      <div class="card mb-4">
                        <div class="card-body">
                          <div class="user-avatar-section">
                            <div class="d-flex align-items-center flex-column">
                              <img class="img-fluid rounded my-4" src="../assets/img/avatars/blank.png" height="110" width="110" alt="User avatar" />
                              <div class="user-info text-center">
                                <h4 class="mb-2"><?= $ben['ben_name'] ?></h4>
                                <span class="badge bg-label-secondary"><?= $ben['ben_type'] ?></span>
                              </div>
                            </div>
                          </div>
                          <div class="d-flex justify-content-around flex-wrap my-4 py-3">
                            <div class="d-flex align-items-start me-4 mt-3 gap-3">
                              <span class="badge bg-label-primary p-2 rounded"><i class='bx bx-user'></i></span>
                              <div>
                                <h5 class="mb-0">Age</h5>
                                <span><?= $ben['ben_age'] ?></span>
                              </div>
                            </div>
                            <div class="d-flex align-items-start mt-3 gap-3">
                              <span class="badge bg-label-primary p-2 rounded"><i class="bx bx-money"></i></span>
                              <div>
                                <h5 class="mb-0">Employment</h5>
                                <span><?= $ben['ben_emptype'] ?></span>
                              </div>
                            </div>
                          </div>
                          <h5 class="pb-2 border-bottom mb-4">Details</h5>
                          <div class="info-container">
                            <ul class="list-unstyled">
                              <li class="mb-3">
                                <span class="fw-medium me-2">Date of Birth:</span>
                                <span><?= $ben['ben_dob'] ?></span>
                              </li>
                              <li class="mb-3">
                                <span class="fw-medium me-2">Gender:</span>
                                <span><?= $ben['ben_gen'] ?></span>
                              </li>
                              <li class="mb-3">
                                <span class="fw-medium me-2">Address:</span>
                                <span><?= $ben['ben_address'] ?></span>
                              </li>
                              <li class="mb-3">
                                <span class="fw-medium me-2">Phone:</span>
                                <span><?= $ben['ben_phone'] ?></span>
                              </li>
                              <li class="mb-3">
                                <span class="fw-medium me-2">Educational Attainment:</span>
                                <span><?= $ben['ben_educ'] ?></span>
                              </li>
                              <li class="mb-3">
                                <span class="fw-medium me-2">Medical Assistance:</span>
                                <span><?= $ben['ben_ma'] ?></span>
                              </li>
                            </ul>
                            <div class="d-flex justify-content-center pt-3">
                              <a hrebenlist.php" class="btn btn-label-danger suspend-user">Back</a>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- /User Card -->
                    </div>
                    <!--/ User Sidebar -->

                    <!-- User Content -->
                    <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">

                      <!-- Project table -->
                      <div class="card">
                        <div class="card text-center">
                          <div class="card-header">
                            <ul class="nav nav-pills card-header-pills" role="tablist">
                              <li class="nav-item">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-within-card-active" aria-controls="navs-pills-within-card-active" aria-selected="true">
                                  Beneficiary History
                                </button>
                              </li>
                            </ul>
                          </div>
                          <div class="card-body">
                            <div class="tab-content p-0">
                              <div class="tab-pane fade show active" id="navs-pills-within-card-active" role="tabpanel">
                                <div class="card-datatable table-responsive">
                                  <table class="datatables-basic table border-top">
                                    <thead style="position: sticky; top: 0; background-color: #7e8a9b; z-index: 1;">
                                      <tr>
                                        <th>Beneficiary ID</th>
                                        <th>Event Date</th>
                                        <th>Event Name</th>
                                        <th>Registered</th>
                                      </tr>
                                    </thead>
                                    <tbody>

                                      <?php

                                      $ben_type = $ben['ben_type'];

                                      // SQL query with a parameter for the condition
                                      $sql = "SELECT ssre_bentype AS bentype, ss_event AS event_date, ss_eventname AS event_name, ssre_attend AS registered FROM secsanre WHERE ssre_bentype = :ben_type
                                UNION
                                SELECT mmre_bentype AS bentype, mm_event AS event_date, mm_eventname AS event_name, mmre_attend AS registered FROM medmissre WHERE mmre_bentype = :ben_type
                                ORDER BY event_date DESC";

                                      // Prepare the SQL statement
                                      $result = $conn->prepare($sql);

                                      // Bind the parameter
                                      $result->bindParam(':ben_type', $ben_type, PDO::PARAM_STR);

                                      // Execute the query
                                      $result->execute();
                                      while ($row = $result->fetch()) {
                                      ?>
                                        <tr>
                                          <td><?php echo $row['bentype']; ?></td>
                                          <td><?php echo $row['event_date']; ?></td>
                                          <td><?php echo $row['event_name']; ?></td>
                                          <td><?php echo $row['registered']; ?></td>
                                        </tr>
                                      <?php
                                      }
                                      ?>
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
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
    <?php
      } else {
        echo "User not found.";
      }
    } else {
      echo "Error occurred while fetching user data.";
    }
  } else {
    echo "Invalid username.";
  }

    ?>
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
    <script src="../assets/vendor/libs/dropzone/dropzone.js"></script>
    <script src="../assets/vendor/libs/moment/moment.js"></script>
    <script src="../assets/vendor/libs/flatpickr/flatpickr.js"></script>
    <script src="../assets/vendor/libs/sweetalert2/sweetalert2.js"></script>

    <!-- Main JS -->
    <script src="../assets/js/main.js"></script>
    <script src="../assets/vendor/libs/@form-validation/umd/bundle/popular.min.js"></script>
    <script src="../assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js"></script>
    <script src="../assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js"></script>

    <!-- Page JS -->
    <script src="../assets/js/dashboards-analytics.js"></script>
    <script src="../assets/js/forms-file-upload.js"></script>
    <script src="../assets/js/tables-datatables-basic.js"></script>
    <script src="../assets/js/extended-ui-sweetalert2.js"></script>

</body>

</html>