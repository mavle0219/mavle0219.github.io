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
          $query = $conn->prepare("SELECT * FROM `beneficiary` WHERE `ben_name` LIKE '%$keyword%' or `ben_age` LIKE '%$keyword%' or
    `ben_address` LIKE '%$keyword%' or `ben_regdate` LIKE '%$keyword%' order by `ben_id`");
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
                <a href="#" onclick="confirmDelete(<?= $row['ben_id'] ?>)"><span class="badge bg-label-danger">Delete</span></a>
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

          $sql = "SELECT * FROM `beneficiary`";
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
                <a href="#" onclick="confirmDelete(<?= $row['ben_id'] ?>)"><span class="badge bg-label-danger">Delete</span></a>
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
  function confirmDelete(benId) {
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!',
      customClass: {
        confirmButton: 'btn btn-primary me-3',
        cancelButton: 'btn btn-label-secondary'
      },
      buttonsStyling: false
    }).then(function(result) {
      if (result.value) {
        window.location.href = "adelben.php?ben_id=" + benId;
        console.log('Item with ID ' + benId + ' deleted.');

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
</script>