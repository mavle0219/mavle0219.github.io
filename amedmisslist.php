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
                        <th>Event Date</th>
                        <th>Event Name</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Creator</th>
                        <th>Creation Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $keyword = $_POST['keyword'];
                    $query = $conn->prepare("SELECT * FROM `medmiss` WHERE `mm_event` LIKE '%$keyword%' or `mm_eventname` LIKE '%$keyword%' or `mm_creator` LIKE '%$keyword%' or
    `mm_date` LIKE '%$keyword%' or `mm_start` LIKE '%$keyword%' or `mm_end` LIKE '%$keyword%'");
                    $query->execute();
                    while ($row = $query->fetch()) {
                    ?>
                        <tr>
                            <td><?php echo $row['mm_event']; ?></td>
                            <td><?php echo $row['mm_eventname']; ?></td>
                            <td><?php echo $row['mm_start']; ?></td>
                            <td><?php echo $row['mm_end']; ?></td>
                            <td><?php echo $row['mm_creator']; ?></td>
                            <td><?php echo $row['mm_date']; ?></td>
                            <td>
                                <a href="anewmedmissre.php?mm_id=<?= $row['mm_id'] ?>"><span class="badge bg-label-success">Add Recipients</span></a>
                                <a href="#" onclick="confirmDelete(<?= $row['mm_id'] ?>)"><span class="badge bg-label-danger">Delete</span></a>
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
                        <th>Event Date</th>
                        <th>Event Name</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Creator</th>
                        <th>Creation Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php

                    $sql = "SELECT * FROM `medmiss`";
                    $result = $conn->prepare($sql);
                    $result->execute();
                    while ($row = $result->fetch()) {
                    ?>
                        <tr>
                            <td><?php echo $row['mm_event']; ?></td>
                            <td><?php echo $row['mm_eventname']; ?></td>
                            <td><?php echo $row['mm_start']; ?></td>
                            <td><?php echo $row['mm_end']; ?></td>
                            <td><?php echo $row['mm_creator']; ?></td>
                            <td><?php echo $row['mm_date']; ?></td>
                            <td>
                                <a href="anewmedmissre.php?mm_id=<?= $row['mm_id'] ?>"><span class="badge bg-label-success">Add Recipients</span></a>
                                <a href="#" onclick="confirmDelete(<?= $row['mm_id'] ?>)"><span class="badge bg-label-danger">Delete</span></a>
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
  function confirmDelete(mmId) {
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
        window.location.href = "adelmedmiss.php?mm_id=" + mmId;
        console.log('Item with ID ' + mmId + ' deleted.');

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