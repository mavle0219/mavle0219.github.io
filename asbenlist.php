<?php
include 'connect.php';

$admin = $_SESSION['admin'];

if (!isset($admin)) {
  header('location:login.php');
}

if (isset($_POST['search'])) {

?>
  <!-- Hoverable Table rows -->
  <div class="card">
    <div class="table-responsive text-nowrap" style="max-height: 585px; overflow-y: auto;">
      <table id="data-table" class="table table-hover">
      <thead style="position: sticky; top: 0; background-color: #7e8a9b; z-index: 1;">
          <tr>
            <th>Beneficiary ID</th>
            <th>Full Name</th>
            <th>Age</th>
            <th>Address</th>
            <th>Registration Date</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $keyword = $_POST['keyword'];
          $query = $conn->prepare("SELECT * FROM `beneficiary` WHERE (`ben_name` LIKE '%$keyword%' OR `ben_age` LIKE '%$keyword%' OR
          `ben_address` LIKE '%$keyword%' OR `ben_regdate` LIKE '%$keyword%') AND `ben_arch` = 0 ORDER BY `ben_id`");      
          $query->execute();
          while ($row = $query->fetch()) {
          ?>
            <tr>
              <td><?php echo $row['ben_type']; ?></td>
              <td><?php echo $row['ben_name']; ?></td>
              <td><?php echo $row['ben_age']; ?></td>
              <td><?php echo $row['ben_address']; ?></td>
              <td><?php echo $row['ben_regdate']; ?></td>
              <td><a href="abenprof.php?ben_id=<?= $row['ben_id'] ?>"><span class="badge bg-label-info">View</span></a>
                <a href="#" onclick="confirmArchive(<?= $row['ben_id'] ?>)"><span class="badge bg-label-danger">Archive</span></a>
              </td>
            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
<?php
} else {
?>
  <div class="card">
    <div class="table-responsive text-nowrap" style="max-height: 585px; overflow-y: auto;">
      <table id="data-table" class="table table-hover">
      <thead style="position: sticky; top: 0; background-color: #7e8a9b; z-index: 1;">
          <tr>
            <th>Beneficiary ID</th>
            <th>Full Name</th>
            <th>Age</th>
            <th>Address</th>
            <th>Registration Date</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>

          <?php

          $sql = "SELECT * FROM `beneficiary` where ben_arch = 0";
          $result = $conn->prepare($sql);
          $result->execute();
          
          while ($row = $result->fetch()) {
          ?>
            <tr>
              <td><?php echo $row['ben_type']; ?></td>
              <td><?php echo $row['ben_name']; ?></td>
              <td><?php echo $row['ben_age']; ?></td>
              <td><?php echo $row['ben_address']; ?></td>
              <td><?php echo $row['ben_regdate']; ?></td>
              <td><a href="abenprof.php?ben_id=<?= $row['ben_id'] ?>"><span class="badge bg-label-info">View</span></a>
                <a href="#" onclick="confirmArchive(<?= $row['ben_id'] ?>)"><span class="badge bg-label-danger">Archive</span></a>
              </td>
            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
  <!--/ Hoverable Table rows -->

<?php
}
?>

<script>
  function confirmArchive(benId) {
    Swal.fire({
      title: 'Are you sure?',
      text: "This will archive the beneficiary!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, archive it!',
      customClass: {
        confirmButton: 'btn btn-primary me-3',
        cancelButton: 'btn btn-label-secondary'
      },
      buttonsStyling: false
    }).then(function(result) {
      if (result.value) {
        // Handle archiving directly on the same page
        archiveBeneficiary(benId);
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        // User canceled, show cancellation message
        Swal.fire({
          title: 'Cancelled',
          text: 'No changes made!',
          icon: 'error',
          showConfirmButton: false,
          timer: 1500
        });
      }
    });
  }

  // Function to handle archiving
  function archiveBeneficiary(benId) {
    // You can use AJAX to send a request to the server for archiving
    // Alternatively, you can redirect to the archiving script on the server
    window.location.href = "abenlist.php?ben_id=" + benId;
  }
</script>

