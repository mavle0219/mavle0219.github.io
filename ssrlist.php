<?php
include 'connect.php';

$user = $_SESSION['user'];

if (!isset($user)) {
  header('location:login.php');
}

if(isset($ss_event)) {

if (isset($_POST['search'])) {

?>


    <!-- Hoverable Table rows -->
    <div class="card">
        <div class="table-responsive text-nowrap" style="max-height: 585px; overflow-y: auto;">
            <table id="data-table" class="table table-hover">
            <thead style="position: sticky; top: 0; background-color: #7e8a9b; z-index: 1;">
                    <tr>
                        <th>Event Date</th>
                        <th>Beneficiary ID</th>
                        <th>Full Name</th>
                        <th>Address</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $keyword = $_POST['keyword'];
                    $query = $conn->prepare("SELECT * FROM `secsanre` WHERE (`ssre_bentype` LIKE '%$keyword%' OR `ssre_name` LIKE '%$keyword%' OR `ssre_address` LIKE '%$keyword%') AND ss_event = '$ss_event'");
                    $query->execute();
                    while ($row = $query->fetch()) {
                    ?>
                        <tr>
                            <td><?php echo $row['ss_event']; ?></td>
                            <td><?php echo $row['ssre_bentype']; ?></td>
                            <td><?php echo $row['ssre_name']; ?></td>
                            <td><?php echo $row['ssre_address']; ?></td>
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
                        <th>Beneficiary ID</th>
                        <th>Full Name</th>
                        <th>Address</th>
                    </tr>
                </thead>
                <tbody>

                    <?php

                    $sql = "SELECT * FROM `secsanre` where ss_event = '$ss_event'";

                    $result = $conn->prepare($sql);
                    $result->execute();
                    while ($row = $result->fetch()) {
                    ?>
                        <tr>
                            <td><?php echo $row['ss_event']; ?></td>
                            <td><?php echo $row['ssre_bentype']; ?></td>
                            <td><?php echo $row['ssre_name']; ?></td>
                            <td><?php echo $row['ssre_address']; ?></td>
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

} else {
    echo "ss_event variable not set.";
}
?>