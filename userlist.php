<?php
include 'connect.php';

session_start();

$user = $_SESSION['user'];

if (!isset($user)) {
  header('location:login.php');
}

$select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
$select_profile->execute([$user]);
$fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);

$updateSuccess = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve form data
  $userId = $_POST["id"];
  $fullName = $_POST["modalEditUserFullName"];
  $address = $_POST["modalEditUserAddress"];
  $position = $_POST["modalEditUserPosition"];
  $phone = $_POST["modalEditUserPhone"];
  $email = $_POST["modalEditUserEmail"];
  $password = $_POST["modalEditUserPassword"];

  try {
    // Prepare SQL statement to update the user information
    $stmt = $conn->prepare("UPDATE users SET fullname=?, address=?, position=?, phone=?, email=? WHERE id=?");
    $stmt->execute([$fullName, $address, $position, $phone, $email, $userId]);

    // Check if a new password is provided and update it
    if (!empty($password)) {
      $stmtPassword = $conn->prepare("UPDATE users SET password=? WHERE id=?");
      $stmtPassword->execute([$password, $userId]);
    }

    $updateSuccess = true;
    $auditlogin = $conn->prepare("INSERT INTO `audit`(role, username, action) VALUES(?,?,?)");
    $auditlogin->execute(["user", $fetch_profile['username'], "update user information"]);

    echo "<script>
        document.addEventListener('DOMContentLoaded', (event) => {
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: 'User Information Updated!',
            showConfirmButton: false,
            timer: 1500
        }).then(function () {
            window.location.href = 'userlist.php';
        });
    });
  </script>";
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}
?>
<!DOCTYPE html>

<html lang="en" class="dark-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>User Profile</title>

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
  <link rel="stylesheet" href="../assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
  <link rel="stylesheet" href="../assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
  <link rel="stylesheet" href="../assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css" />
  <link rel="stylesheet" href="../assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
  <link rel="stylesheet" href="../assets/vendor/libs/flatpickr/flatpickr.css" />

  <!-- Page CSS -->
  <link rel="stylesheet" href="../assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css" />

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
                    <a href="benlist.php" class="menu-link">
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
                    <a href="scholist.php" class="menu-link">
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
            <a href="cal.php" class="menu-link">
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
                  <div class="text-truncate" data-i18n="Financial Aid">Financial Aid</div>
                </a>
                <ul class="menu-sub">
                  <li class="menu-item">
                    <a href="finaidre.php" class="menu-link">
                      <div class="text-truncate" data-i18n="Recipients">Recipients</div>
                    </a>
                  </li>
                  <li class="menu-item">
                    <a href="afinaiddocs.php" class="menu-link">
                      <div class="text-truncate" data-i18n="Documentations">Documentations</div>
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
                    <a href="schore.php" class="menu-link">
                      <div class="text-truncate" data-i18n="Scholars">Recipients</div>
                    </a>
                  </li>
                  <li class="menu-item">
                    <a href="aschodocs.php" class="menu-link">
                      <div class="text-truncate" data-i18n="Documentations">Documentations</div>
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
                  <li class="menu-item">
                    <a href="medmissdocs.php" class="menu-link">
                      <div class="text-truncate" data-i18n="MM Documentations">MM Documentations</div>
                    </a>
                  </li>
                  <li class="menu-item">
                    <a href="medassre.php" class="menu-link">
                      <div class="text-truncate" data-i18n="Medical Assistance">Medical Assistance</div>
                    </a>
                  </li>
                  <li class="menu-item">
                    <a href="medassdocs.php" class="menu-link">
                      <div class="text-truncate" data-i18n="MA Documentations">MA Documentations</div>
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
                      <div class="text-truncate" data-i18n="Recipients">Recipients</div>
                    </a>
                  </li>
                  <li class="menu-item">
                    <a href="secsandocs.php" class="menu-link">
                      <div class="text-truncate" data-i18n="Documentations">Documentations</div>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
          </li>
          <li class="menu-header small text-uppercase"><span class="menu-header-text">Users Management</span></li>
          <li class="menu-item active open">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
              <i class="menu-icon tf-icons bx bxs-user-rectangle"></i>
              <div class="text-truncate" data-i18n="Users">Users</div>
            </a>
            <ul class="menu-sub">
              <li class="menu-item active">
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
            <h4 class="py-3 mb-4"><span class="text-muted fw-light">User /</span> Profiles</h4>
            <div class="row">
              <!-- User Sidebar -->
              <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
                <!-- User Card -->
                <div class="card mb-4">
                  <div class="card-body">
                    <div class="user-avatar-section">
                      <div class="d-flex align-items-center flex-column">
                        <img class="img-fluid rounded my-4" src="../assets/img/avatars/user.png" height="110" width="110" alt="User avatar" />
                        <div class="user-info text-center">
                          <h4 class="mb-2"><?= $fetch_profile['fullname']; ?></h4>
                          <span class="badge bg-label-secondary"><?= $fetch_profile['username']; ?></span>
                        </div>
                      </div>
                    </div>
                    <div class="d-flex justify-content-around flex-wrap my-4 py-3">
                      <div class="d-flex align-items-start me-4 mt-3 gap-3">
                        <span class="badge bg-label-primary p-2 rounded"><i class='bx bx-user'></i></span>
                        <div>
                          <h5 class="mb-0">Position</h5>
                          <span><?= $fetch_profile['position']; ?></span>
                        </div>
                      </div>
                      <div class="d-flex align-items-start mt-3 gap-3">
                        <span class="badge bg-label-primary p-2 rounded"><i class='bx bxs-user-detail'></i></span>
                        <div>
                          <h5 class="mb-0">Role</h5>
                          <span><?= $fetch_profile['role']; ?></span>
                        </div>
                      </div>
                    </div>
                    <h5 class="pb-2 border-bottom mb-4">Details</h5>
                    <div class="info-container">
                      <ul class="list-unstyled">
                        <li class="mb-3">
                          <span class="fw-medium me-2">Phone:</span>
                          <span><?= $fetch_profile['phone']; ?></span>
                        </li>
                        <li class="mb-3">
                          <span class="fw-medium me-2">Address:</span>
                          <span><?= $fetch_profile['address']; ?></span>
                        </li>
                        <li class="mb-3">
                          <span class="fw-medium me-2">Email:</span>
                          <span><?= $fetch_profile['email']; ?></span>
                        </li>
                      </ul>
                      <div class="d-flex justify-content-center pt-3">
                        <a href="javascript:;" class="btn btn-primary me-3" data-bs-target="#editUser" data-bs-toggle="modal">Update</a>
                        <a href="udboard.php" class="btn btn-label-danger suspend-user">Back</a>
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
                          <button
                            type="button"
                            class="nav-link active"
                            role="tab"
                            data-bs-toggle="tab"
                            data-bs-target="#navs-pills-within-card-active"
                            aria-controls="navs-pills-within-card-active"
                            aria-selected="true">
                            Personal Log
                          </button>
                        </li>
                      </ul>
                    </div>
                    <div class="card-body">
                      <div class="tab-content p-0">
                        <div class="tab-pane fade show active" id="navs-pills-within-card-active" role="tabpanel">
                        <div class="table-responsive text-nowrap" style="max-height: 585px; overflow-y: auto;">
                          <table id="data-table" class="table table-hover">
                          <thead style="position: sticky; top: 0; background-color: #7e8a9b; z-index: 1;">
                              <tr>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Action</th>
                                <th>Timestamp</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              $username = $fetch_profile['username'];

                              $sql = "SELECT * FROM audit WHERE username = '$username' ORDER BY audit_id DESC";
                              $result = $conn->prepare($sql);
                              $result->execute();
                              while ($row = $result->fetch()) {
                              ?>
                                <tr>
                                  <td><?php echo $row['username']; ?></td>
                                  <td><?php echo $row['role']; ?></td>
                                  <td><?php echo $row['action']; ?></td>
                                  <td><?php echo $row['timestamp']; ?></td>
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

              <!-- Modal -->
              <!-- Edit User Modal -->
              <div class="modal fade" id="editUser" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-simple modal-edit-user">
                  <div class="modal-content p-3 p-md-5">
                    <div class="modal-body">
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      <div class="text-center mb-4">
                        <h3>Edit User Information</h3>
                      </div>
                      <form id="editUserForm" class="row g-3" action="" method="post">
                        <div class="col-12 col-md-6">
                          <label class="form-label" for="modalEditUserFullName">Full Name</label>
                          <input type="text" id="modalEditUserFullName" name="modalEditUserFullName" class="form-control" value="<?php echo $fetch_profile['fullname']; ?>" />
                          <input type="hidden" name="id" value="<?php echo $fetch_profile['id']; ?>" required>
                        </div>
                        <div class="col-12 col-md-6">
                          <label class="form-label" for="modalEditUserUsername">Username</label>
                          <input type="text" id="modalEditUserUsername" name="modalEditUserUsername" class="form-control" readonly value="<?php echo $fetch_profile['username']; ?>" />
                        </div>
                        <div class="col-sm-6 form-password-toggle">
                          <label class="form-label" for="modalEditUserPassword">Password</label>
                          <div class="input-group input-group-merge">
                            <input type="password" id="modalEditUserPassword" name="modalEditUserPassword" class="form-control" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="multiStepsPass2" />
                            <span class="input-group-text cursor-pointer" id="multiStepsPass2"><i class="bx bx-hide"></i></span>
                          </div>
                        </div>
                        <div class="col-sm-6 form-password-toggle">
                          <label class="form-label" for="modalEditUserPassword2">Confirm Password</label>
                          <div class="input-group input-group-merge">
                            <input type="password" id="modalEditUserPassword2" name="modalEditUserPassword2" class="form-control" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="multiStepsConfirmPass2" />
                            <span class="input-group-text cursor-pointer" id="multiStepsConfirmPass2"><i class="bx bx-hide"></i></span>
                          </div>
                        </div>
                        <div class="col-12">
                          <label class="form-label" for="modalEditUserAddress">Address</label>
                          <input type="text" id="modalEditUserAddress" name="modalEditUserAddress" class="form-control" value="<?php echo $fetch_profile['address']; ?>" />
                        </div>
                        <div class="col-12 col-md-6">
                          <label class="form-label" for="modalEditUserRole">Role</label>
                          <input type="text" id="modalEditUserRole" name="modalEditUserRole" class="form-control" readonly value="<?php echo $fetch_profile['role']; ?>" />
                        </div>
                        <div class="col-12 col-md-6">
                          <label class="form-label" for="modalEditUserPosition">Position</label>
                          <input type="text" id="modalEditUserPosition" name="modalEditUserPosition" class="form-control" value="<?php echo $fetch_profile['position']; ?>" />
                        </div>
                        <div class="col-12 col-md-6">
                          <label class="form-label" for="modalEditUserPhone">Phone</label>
                          <input type="text" id="modalEditUserPhone" name="modalEditUserPhone" class="form-control" value="<?php echo $fetch_profile['phone']; ?>" />
                        </div>
                        <div class="col-12 col-md-6">
                          <label class="form-label" for="modalEditUserEmail">Email</label>
                          <input type="email" id="modalEditUserEmail" name="modalEditUserEmail" class="form-control phone-number-mask" value="<?php echo $fetch_profile['email']; ?>" />
                        </div>
                        <div class="col-12 text-center">
                          <button type="submit" class="btn btn-primary me-sm-3 me-1" name="submit">Update</button>
                          <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">
                            Cancel
                          </button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <!--/ Edit User Modal -->

              <!-- /Modal -->
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
    <!-- Vendors JS -->
    <script src="../assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <!-- Flat Picker -->
    <script src="../assets/vendor/libs/moment/moment.js"></script>
    <script src="../assets/vendor/libs/flatpickr/flatpickr.js"></script>
    <script src="../assets/vendor/libs/sweetalert2/sweetalert2.js"></script>

    <!-- Main JS -->
    <script src="../assets/vendor/libs/@form-validation/umd/bundle/popular.min.js"></script>
    <script src="../assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js"></script>
    <script src="../assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js"></script>
    <script src="../assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="../assets/js/dashboards-analytics.js"></script>
    <script src="../assets/js/tables-datatables-basic.js"></script>
    <script src="../assets/js/extended-ui-sweetalert2.js"></script>

</body>

</html>