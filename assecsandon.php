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
                        <th>Donor ID</th>
                        <th>Full Name</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Availability</th>
                        <th>Year</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $keyword = $_POST['keyword'];
                    $query = $conn->prepare("SELECT * FROM `donor` WHERE `don_name` LIKE '%$keyword%' or `don_address` LIKE '%$keyword%' or
                    `don_phone` LIKE '%$keyword%' or `don_avail` LIKE '%$keyword%' or `don_year` LIKE '%$keyword%'");
                    $query->execute();
                    while ($row = $query->fetch()) {
                    ?>
                        <tr>
                            <td><?php echo $row['don_type']; ?></td>
                            <td><?php echo $row['don_name']; ?></td>
                            <td><?php echo $row['don_address']; ?></td>
                            <td><?php echo $row['don_phone']; ?></td>
                            <td><?php echo $row['don_avail']; ?></td>
                            <td><?php echo $row['don_year']; ?></td>
                            <td><a href="adonprof.php?don_type=<?= $row['don_type'] ?>"><span class="badge bg-label-info">View</span></a>
                            <a href="#" onclick="confirmDelete(<?= $row['don_id'] ?>)"><span class="badge bg-label-danger">Delete</span></a>
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
                        <th>Donor ID</th>
                        <th>Full Name</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Availability</th>
                        <th>Year</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php

                    $sql = "SELECT * FROM `donor`";
                    $result = $conn->prepare($sql);
                    $result->execute();
                    while ($row = $result->fetch()) {
                    ?>
                        <tr>
                            <td><?php echo $row['don_type']; ?></td>
                            <td><?php echo $row['don_name']; ?></td>
                            <td><?php echo $row['don_address']; ?></td>
                            <td><?php echo $row['don_phone']; ?></td>
                            <td><?php echo $row['don_avail']; ?></td>
                            <td><?php echo $row['don_year']; ?></td>
                            <td><a href="adonprof.php?don_type=<?= $row['don_type'] ?>"><span class="badge bg-label-info">View</span></a>
                            <a href="#" onclick="confirmDelete(<?= $row['don_id'] ?>)"><span class="badge bg-label-danger">Delete</span></a>
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
  function confirmDelete(donId) {
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
        window.location.href = "adeldon.php?don_id=" + donId;
        console.log('Item with ID ' + donId + ' deleted.');

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