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
                <th>Username</th>  
                <th>Full Name</th>
                <th>Position</th>
                <th>Role</th>
                <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
$keyword = $_POST['keyword'];
    $query = $conn->prepare("SELECT * FROM `users` WHERE `username` LIKE '%$keyword%' or `fullname` LIKE '%$keyword%' or `position` LIKE '%$keyword%' or
    `role` LIKE '%$keyword%' or `phone` LIKE '%$keyword%' or `address` LIKE '%$keyword%' or `email` LIKE '%$keyword%'");
    $query->execute();
    while ($row = $query->fetch()) {
        ?>
                <tr>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['fullname']; ?></td>
                <td><?php echo $row['position']; ?></td>
                <td><?php echo $row['role']; ?></td>
                <td><a href="auserprof.php?id=<?=$row['id']?>"><span class="badge bg-info">View</span></a>
                <a href="#" onclick="confirmDelete(<?= $row['id'] ?>)"><span class="badge bg-danger">Delete</span></td>
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
                <th>Username</th>  
                <th>Full Name</th>
                <th>Position</th>
                <th>Role</th>
                <th>Action</th>
                </tr>
            </thead>
            <tbody>

                <?php

    $sql = "SELECT * FROM `users`";
    $result = $conn->prepare($sql);
    $result->execute();
    while ($row = $result->fetch()) {
        ?>
                <tr>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['fullname']; ?></td>
                <td><?php echo $row['position']; ?></td>
                <td><?php echo $row['role']; ?></td>
                <td><a href="auserprof.php?id=<?=$row['id']?>"><span class="badge bg-info">View</span></a>
                <a href="#" onclick="confirmDelete(<?= $row['id'] ?>)"><span class="badge bg-danger">Delete</span></td>
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
  function confirmDelete(userId) {
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
        window.location.href = "adeluser.php?id=" + userId;
        console.log('Item with ID ' + userId + ' deleted.');

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