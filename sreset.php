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
        <div class="table-responsive text-nowrap" style="max-height: 600px; overflow-y: auto;">
            <table id="data-table" class="table table-hover">
            <thead style="position: sticky; top: 0; background-color: #7e8a9b; z-index: 1;">
                    <tr>
                        <th>Request ID</th>
                        <th>Username</th>
                        <th>Timestamp</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $keyword = $_POST['keyword'];
                    $query = $conn->prepare("SELECT * FROM `reset` WHERE `req_reset` = 'Yes' and `req_username` LIKE '%$keyword%' or `timestamp` LIKE '%$keyword%'");
                    $query->execute();
                    while ($row = $query->fetch()) {
                    ?>
                        <tr>
                        <td><?php echo $row['req_id']; ?></td>
                            <td><?php echo $row['req_username']; ?></td>
                            <td><?php echo $row['timestamp']; ?></td>
                            <td><a href="aresetpw.php?req_id=<?= $row['req_id'] ?>"><span class="badge bg-label-info">Reset Password</span></a>
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
        <div class="table-responsive text-nowrap" style="max-height: 600px; overflow-y: auto;">
            <table id="data-table" class="table table-hover">
            <thead style="position: sticky; top: 0; background-color: #7e8a9b; z-index: 1;">
                    <tr>
                        <th>Request ID</th>
                        <th>Username</th>
                        <th>Timestamp</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php

                    $sql = "SELECT * FROM `reset` where req_reset = 'Yes'";
                    $result = $conn->prepare($sql);
                    $result->execute();
                    while ($row = $result->fetch()) {
                    ?>
                        <tr>
                        <td><?php echo $row['req_id']; ?></td>
                            <td><?php echo $row['req_username']; ?></td>
                            <td><?php echo $row['timestamp']; ?></td>
                            <td><a href="aresetpw.php?req_id=<?= $row['req_id'] ?>"><span class="badge bg-label-info">Reset Password</span></a>
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