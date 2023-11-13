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
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Action</th>
                        <th>Timestamp</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $keyword = $_POST['keyword'];
                    $query = $conn->prepare("SELECT * FROM `audit` WHERE `username` LIKE '%$keyword%' or `role` LIKE '%$keyword%' or
    `action` LIKE '%$keyword%' or `timestamp` LIKE '%$keyword%' order by `audit_id` desc");
                    $query->execute();
                    while ($row = $query->fetch()) {
                    ?>
                        <tr>
                            <td><?php echo $row['username']; ?></td>
                            <td><?php echo $row['role']; ?></td>
                            <td><?php echo $row['action']; ?></td>
                            <td><?php echo $row['timestamp']; ?></td>
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
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Action</th>
                        <th>Timestamp</th>
                    </tr>
                </thead>
                <tbody>

                    <?php

                    $sql = "SELECT * FROM `audit` order by `audit_id` desc";
                    $result = $conn->prepare($sql);
                    $result->execute();

                    while ($row = $result->fetch()) {
                    ?>
                        <tr>
                            <td><?php echo $row['username']; ?></td>
                            <td><?php echo $row['role']; ?></td>
                            <td><?php echo $row['action']; ?></td>
                            <td><?php echo $row['timestamp']; ?></td>
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