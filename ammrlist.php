<?php
include 'connect.php';

$admin = $_SESSION['admin'];

if (!isset($admin)) {
    header('location:login.php');
}

if(isset($mm_event) && isset($mm_eventname)) {

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
                    $query = $conn->prepare("SELECT * FROM `medmissre` WHERE (`mmre_bentype` LIKE '%$keyword%' OR `mmre_name` LIKE '%$keyword%' OR `mmre_address` LIKE '%$keyword%') AND `mm_event` = '$mm_event'");
                    $query->execute();
                    while ($row = $query->fetch()) {
                    ?>
                        <tr>
                            <td><?php echo $row['mm_event']; ?></td>
                            <td><?php echo $row['mmre_bentype']; ?></td>
                            <td><?php echo $row['mmre_name']; ?></td>
                            <td><?php echo $row['mmre_address']; ?></td>
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

                    $sql = "SELECT * FROM `medmissre` where mm_event = '$mm_event'";

                    $result = $conn->prepare($sql);
                    $result->execute();
                    while ($row = $result->fetch()) {
                    ?>
                        <tr>
                            <td><?php echo $row['mm_event']; ?></td>
                            <td><?php echo $row['mmre_bentype']; ?></td>
                            <td><?php echo $row['mmre_name']; ?></td>
                            <td><?php echo $row['mmre_address']; ?></td>
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
    echo "mm_event variable not set.";
}
?>
