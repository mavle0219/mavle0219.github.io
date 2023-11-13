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

  // Function to calculate age from date of birth
  function calculateAge($dob)
  {
    $today = new DateTime('today');
    $birthdate = new DateTime($dob);
    $age = $birthdate->diff($today)->y;
    return $age;
  }

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submit"])) {
  // Retrieve form data
  $ben_type = $_POST["ben_type"];
  $sch_name = $_POST["sch_name"];
  $sch_dob = $_POST["sch_dob"];
  $sch_gender = $_POST["sch_gender"];
  $sch_address = $_POST["sch_address"];
  $sch_school = $_POST["sch_school"];
  $sch_course = $_POST['sch_course'];
  $sch_year = $_POST['sch_year'];
  $sch_email = $_POST["sch_email"];
  $sch_phone = $_POST["sch_phone"];

  $sch_age = calculateAge($sch_dob);

  // Prepare SQL statement for inserting data into the database
  $insertQuery = $conn->prepare("INSERT INTO scholar (ben_type, sch_name, sch_dob, sch_gender, sch_address, sch_school, sch_course, sch_year, sch_email, sch_phone, sch_age) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
  $insertQuery->execute([$ben_type, $sch_name, $sch_dob, $sch_gender, $sch_address, $sch_school, $sch_course, $sch_year, $sch_email, $sch_phone, $sch_age]);

  $auditlogin = $conn->prepare("INSERT INTO `audit`(role, username, action) VALUES(?,?,?)");
  $auditlogin->execute(["admin", $fetch_profile['username'], "add scholar"]);

  if ($insertQuery) {
    echo "<script>
      document.addEventListener('DOMContentLoaded', (event) => {
      Swal.fire({
          icon: 'success',
          title: 'Success',
          text: 'New Scholar Added!',
          showConfirmButton: false,
          timer: 1500
      }).then(function () {
          window.location.href = 'ascholist.php';
      });
  });
</script>";
  } else {
    header('location: ascholist.php');
  }
}

?>

<!DOCTYPE html>

<html lang="en" class="dark-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>Scholars List</title>

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
          <li class="menu-item active open">
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
              <li class="menu-item open">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                  <div class="text-truncate" data-i18n="Scholars">Scholars</div>
                </a>
                <ul class="menu-sub">
                  <li class="menu-item active">
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
                    <a href="ascholist.php" type="button" class="btn btn-label-info">Clear</a>
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
            <h4 class="py-3 mb-4"><span class="text-muted fw-light">Scholars /</span> Scholars List</h4>
            <div class="row g-4 mb-4">
                <div class="col-sm-6 col-xl-3">
                  <div class="card card-border-shadow-success h-100">
                    <div class="card-body">
                      <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                          <span>Scholars</span>
                          <div class="d-flex align-items-end mt-2">
                            <h4 class="mb-0 me-2"><?php $numbef = $conn->query('SELECT COUNT(*) from `scholar`')->fetchColumn(); echo $numbef; ?></h4>
                          </div>
                        </div>
                        <div class="avatar">
                          <span class="avatar-initial rounded bg-label-success">
                          <i class="bx bxs-graduation"></i>
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
          </div>
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
              <button type="button" class="btn btn-label-success" data-bs-toggle="modal" data-bs-target="#modalCenteras"><i class='bx bx-plus'>&nbsp</i> Add Scholar
              </button>
              <button class="btn btn-label-primary" type="button" onclick="printTable()" style="margin-left: 10px;"><span><i class="bx bx-printer me-1"></i>Print</span></button>
              <button class="btn btn-label-primary" type="button" onclick="downloadCSV()" style="margin-left: 10px;"><span><i class="bx bx-file me-1"></i>Export to Excel</span>
              </button>
            </ul>
            <div class="card">
              <?php
              include 'asscholist.php';
              ?>
            </div>
            <form action="" method="post">
              <!-- Modal -->
              <div class="modal fade" id="modalCenteras" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="modalCenterTitle">New Scholar</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" required></button>
                    </div>
                    <div class="modal-body">
                      <div class="row">
                        <div class="col mb-3">
                          <label for="nameWithTitle" class="form-label">Scholar ID</label>
                          <input type="text" class="form-control" placeholder="" value="<?= $fetch_id['ben_type'] + 1; ?>" id="ben_type" name="ben_type" readonly />
                        </div>
                      </div>
                      <div class="row">
                        <div class="col mb-3">
                          <label for="nameWithTitle" class="form-label">Full Name</label>
                          <input type="text" class="form-control" placeholder="" name="sch_name" required autocomplete="off" />
                        </div>
                      </div>
                      <div class="row">
                      <div class="col mb-3">
                          <label for="dobExLarge" class="form-label">Date of Birth</label>
                          <input type="date" class="form-control" placeholder="YYYY-MM-DD" id="dobExLarge" name="sch_dob" required />
                        </div>
                        <div class="col mb-3">
                          <label for="nameWithTitle" class="form-label">Gender</label>
                          <select id="ben_gen" class="select2 form-select" name="sch_gender" required autocomplete="off">
                            <option>Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Would Rather Not Say">Would Rather Not Say</option>
                          </select>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col mb-3">
                          <label for="nameWithTitle" class="form-label">Address</label>
                          <input type="text" class="form-control" name="sch_address" required autocomplete="off" />
                        </div>
                      </div>
                      <div class="row">
                        <div class="col mb-3">
                          <label for="nameWithTitle" class="form-label">School</label>
                          <input type="text" class="form-control" name="sch_school" required autocomplete="off" />
                        </div>
                      </div>
                      <div class="row">
                        <div class="col mb-3">
                          <label for="nameWithTitle" class="form-label">Course</label>
                          <input type="text" class="form-control" name="sch_course" required autocomplete="off" />
                        </div>
                        <div class="col mb-3">
                          <label for="nameWithTitle" class="form-label">Year</label>
                          <input type="text" class="form-control" name="sch_year" required autocomplete="off" />
                        </div>
                      </div>
                      <div class="row">
                        <div class="col mb-3">
                          <label for="nameWithTitle" class="form-label">Email</label>
                          <input type="email" class="form-control" name="sch_email" required autocomplete="off" />
                        </div>
                        <div class="col mb-3">
                          <label for="nameWithTitle" class="form-label">Phone Number</label>
                          <input type="text" id="phone" class="form-control" placeholder="09#########" name="sch_phone" required autocomplete="off" />
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                      </button>
                      <button type="submit" value="Add User" class="btn btn-primary" name="submit">Add Scholar</button>
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

</body>

</html>