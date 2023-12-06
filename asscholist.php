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
            <th>Scholar ID</th>
            <th>Full Name</th>
            <th>Age</th>
            <th>Address</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $keyword = $_POST['keyword'];
          $query = $conn->prepare("SELECT * FROM `scholar` WHERE `sch_name` LIKE '%$keyword%' or `sch_age` LIKE '%$keyword%' or `sch_address` LIKE '%$keyword%' and sch_arch = 0");
          $query->execute();
          while ($row = $query->fetch()) {
          ?>
            <tr>
              <td><?php echo $row['sch_type']; ?></td>
              <td><?php echo $row['sch_name']; ?></td>
              <td><?php echo $row['sch_age']; ?></td>
              <td><?php echo $row['sch_address']; ?></td>
              <td><a href="aschoprof.php?sch_id=<?= $row['sch_id'] ?>"><span class="badge bg-label-info">View</span></a>
                <a href="#" onclick="confirmArchive(<?= $row['sch_id'] ?>)"><span class="badge bg-label-danger">Archive</span></a>
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
            <th>Scholar ID</th>
            <th>Full Name</th>
            <th>Age</th>
            <th>Address</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>

          <?php

          $sql = "SELECT * FROM `scholar` where sch_arch = 0";
          $result = $conn->prepare($sql);
          $result->execute();
          while ($row = $result->fetch()) {
          ?>
            <tr>
              <td><?php echo $row['ben_type']; ?></td>
              <td><?php echo $row['sch_name']; ?></td>
              <td><?php echo $row['sch_age']; ?></td>
              <td><?php echo $row['sch_address']; ?></td>
              <td><a href="aschoprof.php?sch_id=<?= $row['sch_id'] ?>"><span class="badge bg-label-info">View</span></a>
                <a href="#" onclick="confirmArchive(<?= $row['sch_id'] ?>)"><span class="badge bg-label-danger">Archive</span></a>
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
  function confirmArchive(schId) {
    Swal.fire({
      title: 'Are you sure?',
      text: "This will archive the scholar!",
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
        // Handle deletion directly on the same page
        archiveScholar(schId);
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

  // Function to handle deletion
  function archiveScholar(schId) {
    // You can use AJAX to send a request to the server for deletion
    // Alternatively, you can redirect to the deletion script on the server
    window.location.href = "ascholist.php?sch_id=" + schId;
  }
</script>
