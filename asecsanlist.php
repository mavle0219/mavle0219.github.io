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
                        <th>Creator</th>
                        <th>Creation Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $keyword = $_POST['keyword'];
                    $query = $conn->prepare("SELECT * FROM `secsan` WHERE `ss_event` LIKE '%$keyword%' or `ss_eventname` LIKE '%$keyword%' or `ss_creator` LIKE '%$keyword%' or
    `ss_date` LIKE '%$keyword%' and order by ss_event asc");
                    $query->execute();
                    while ($row = $query->fetch()) {
                    ?>
                        <tr>
                            <td><?php echo $row['ss_event']; ?></td>
                            <td><?php echo $row['ss_eventname']; ?></td>
                            <td><?php echo $row['ss_creator']; ?></td>
                            <td><?php echo $row['ss_date']; ?></td>
                            <td>
                            <a href="anewsecsanre.php?ss_id=<?= $row['ss_id'] ?>"><span class="badge bg-label-success">Add Recipients</span></a>
                            <a href="#" onclick="confirmDelete(<?= $row['ss_id'] ?>)"><span class="badge bg-label-danger">Delete</span></a>
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
                        <th>Creator</th>
                        <th>Creation Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php

                    $sql = "SELECT * FROM `secsan` order by ss_event asc";
                    $result = $conn->prepare($sql);
                    $result->execute();
                    while ($row = $result->fetch()) {
                    ?>
                        <tr>
                            <td><?php echo $row['ss_event']; ?></td>
                            <td><?php echo $row['ss_eventname']; ?></td>
                            <td><?php echo $row['ss_creator']; ?></td>
                            <td><?php echo $row['ss_date']; ?></td>
                            <td>
                            <a href="anewsecsanre.php?ss_id=<?= $row['ss_id'] ?>"><span class="badge bg-label-success">Add Recipients</span></a>
                            <a href="#" onclick="confirmDelete(<?= $row['ss_id'] ?>)"><span class="badge bg-label-danger">Delete</span></a>
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
  function confirmDelete(ssId) {
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
        window.location.href = "adelsecsandon.php?ss_id=" + ssId;
        console.log('Item with ID ' + ssId + ' deleted.');

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