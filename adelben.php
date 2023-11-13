<?php
include 'connect.php';

session_start();

$admin = $_SESSION['admin'];

$select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
$select_profile->execute([$admin]);
$fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);

if (!isset($admin)) {
  header('location:login.php');
}

if (isset($_GET['ben_id'])) {
  $result = $conn->prepare('SELECT * FROM `beneficiary` WHERE ben_id = ?');
  $result->execute([$_GET['ben_id']]);
  $user = $result->fetch(PDO::FETCH_ASSOC);

  $result = $conn->prepare('DELETE FROM `beneficiary` WHERE ben_id  = ?');
  $result->execute([$_GET['ben_id']]);

  $auditlogin = $conn->prepare("INSERT INTO `audit`(role, username, action) VALUES(?,?,?)");
  $auditlogin->execute(["admin", $fetch_profile['username'], "delete beneficiary"]);

  echo "<script>
  document.addEventListener('DOMContentLoaded', (event) => {
  Swal.fire({
      icon: 'success',
      title: 'Success',
      text: 'Beneficiary Deleted!',
      showConfirmButton: false,
      timer: 1000
  }).then(function () {
      window.location.href = 'abenlist.php';
  });
});
</script>";

} else {
  header('location: abenlist.php');
}

?>

<!DOCTYPE html>

<html lang="en" class="dark-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title>Deleted!</title>
  <link rel="stylesheet" href="../assets/vendor/libs/animate-css/animate.css" />
  <link rel="stylesheet" href="../assets/vendor/libs/sweetalert2/sweetalert2.css" />

</head>

<body>
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
    <div class="layout-page">
    <div class="content-backdrop fade"></div>
</div>
</div>
</div>
  <script src="../assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
  <script src="../assets/js/extended-ui-sweetalert2.js"></script>
</body>

</html>